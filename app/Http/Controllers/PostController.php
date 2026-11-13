<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
        ]);

        $posts = Post::query()
            ->where('is_published', true)
            ->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%'.$request->input('q').'%'))
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->input('category')))
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(self::POSTS_PER_PAGE)
            ->withQueryString();

        $categories = Post::query()->distinct()->orderBy('category')->pluck('category');

        return view('posts.index', compact('posts', 'categories'));
    }

    public function show(string $id): View
    {
        $post = Post::where('is_published', true)->findOrFail($id);

        $post->views = $post->views + 1;
        $post->save();

        return view('posts.show', compact('post'));
    }
}
