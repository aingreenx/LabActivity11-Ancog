<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    private const POSTS_PER_PAGE = 6;

    public function index(Request $request): View
    {
        $request->validate([
            'q' => ['nullable', 'string'],
            'category' => ['nullable', 'string'],
            'tag' => ['nullable', 'string'],
        ]);

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
        $tags = Tag::query()->orderBy('name')->pluck('name');

        return view('posts.index', compact('posts', 'categories', 'tags'));
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
