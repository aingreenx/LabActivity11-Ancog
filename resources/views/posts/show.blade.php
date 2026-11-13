@extends('layouts.app')

@section('content')
    <a href="{{ route('posts.index') }}" class="text-sm text-emerald-700 hover:underline">← Back to all posts</a>

    <article class="mt-4 flex flex-col gap-3 rounded-lg bg-white p-4 shadow sm:p-6">
        <div class="flex flex-wrap gap-2 text-xs font-medium">
            @if ($post->is_pinned)
                <span class="rounded bg-amber-200 px-2 py-1 text-amber-900">Pinned</span>
            @endif
            <span class="rounded bg-emerald-100 px-2 py-1 text-emerald-800">{{ $post->category }}</span>
        </div>

        <h1 class="text-2xl font-bold">{{ $post->title }}</h1>

        <p class="text-sm text-slate-500">
            {{ $post->published_at?->format('F j, Y') }}
            · <a href="{{ route('authors.show', $post->author) }}" class="text-emerald-700 hover:underline">{{ $post->author->name }}</a>
            · {{ $post->views }} views
        </p>

        @if ($post->tags->isNotEmpty())
            <div class="flex flex-wrap gap-1 text-xs">
                @foreach ($post->tags as $tag)
                    <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="rounded-full bg-slate-100 px-2 py-0.5 text-slate-600 hover:bg-slate-200">#{{ $tag->name }}</a>
                @endforeach
            </div>
        @endif

        <p class="whitespace-pre-line">{{ $post->body }}</p>
    </article>

    <section class="mt-6 rounded-lg bg-white p-4 shadow sm:p-6">
        <h2 class="text-lg font-semibold">{{ $post->comments->count() }} {{ Str::plural('Comment', $post->comments->count()) }}</h2>

        <ul class="mt-4 divide-y divide-slate-100">
            @forelse ($post->comments as $comment)
                <li class="py-3">
                    <p class="text-sm font-medium">{{ $comment->user->name }}
                        <span class="font-normal text-slate-500">· {{ $comment->created_at->diffForHumans() }}</span>
                    </p>
                    <p class="mt-1">{{ $comment->body }}</p>
                </li>
            @empty
                <li class="py-3 text-slate-500">No comments yet.</li>
            @endforelse
        </ul>
    </section>
@endsection
