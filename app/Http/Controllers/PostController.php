<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\IndexPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class PostController extends Controller
{
    private const POSTS_PER_PAGE = 6;

    public function index(IndexPostRequest $request): View
    {
        // Eager-load author and tags and count comments in the same handful of
        // queries, so the cards never trigger one query per post (no N+1).
        $posts = Post::query()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true)
            ->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%'.$request->input('q').'%'))
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->input('category')))
            ->when($request->filled('tag'), fn ($query) => $query->whereHas(
                'tags',
                fn ($tags) => $tags->where('name', $request->input('tag'))
            ))
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(self::POSTS_PER_PAGE)
            ->withQueryString();

        $categories = Post::query()->distinct()->orderBy('category')->pluck('category');
        // Tag -> posts (belongsToMany, the other direction) counts published posts per tag.
        $tags = Tag::query()
            ->withCount(['posts' => fn ($query) => $query->where('is_published', true)])
            ->orderBy('name')
            ->get();

        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    public function create(Request $request): View
    {
        // Same rule as StorePostRequest::authorize(): residents without an author profile get 403.
        abort_if($request->user()->author === null, 403);

        $categories = Post::CATEGORIES;
        $tags = Tag::query()->orderBy('name')->get();

        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Created through the author's posts relation, so author_id is set for us.
        $post = $request->user()->author->posts()->create([
            ...Arr::except($data, 'tags'),
            'published_at' => $data['is_published'] ? now() : null,
        ]);

        $post->tags()->sync($data['tags']);

        if (! $post->is_published) {
            return redirect()->route('posts.index')->with('status', 'Draft saved.');
        }

        return redirect()->route('posts.show', $post->id)->with('status', 'Post published.');
    }

    public function show(string $id): View
    {
        $post = Post::where('is_published', true)->findOrFail($id);

        $post->views = $post->views + 1;
        $post->save();

        // load() eager-loads on a model we already have; comments newest first,
        // each with its user, so the comment list runs no extra queries.
        $post->load([
            'author',
            'tags',
            // id breaks ties when several comments share the same created_at second.
            'comments' => fn ($query) => $query->latest()->latest('id'),
            'comments.user',
        ]);

        return view('posts.show', compact('post'));
    }
}
