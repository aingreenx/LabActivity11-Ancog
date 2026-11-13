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
            {{ $post->published_at?->format('F j, Y') }} · Author #{{ $post->author_id }} · {{ $post->views }} views
        </p>

        <p class="whitespace-pre-line">{{ $post->body }}</p>
    </article>
@endsection
