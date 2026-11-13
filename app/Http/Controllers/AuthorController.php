<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\View\View;

class AuthorController extends Controller
{
    private const POSTS_PER_PAGE = 6;

    public function show(Author $author): View
    {
        $posts = $author->posts()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true)
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(self::POSTS_PER_PAGE);

        // hasManyThrough: counts comments on all of this author's posts
        // (authors -> posts -> comments) in a single query.
        $commentsReceived = $author->comments()->count();

        return view('authors.show', compact('author', 'posts', 'commentsReceived'));
    }
}
