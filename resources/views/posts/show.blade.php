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

        @auth
            <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-4 flex flex-col gap-2">
                @csrf

                @if ($errors->any())
                    <div class="rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label for="body" class="text-sm font-medium">Add a comment</label>
                <textarea id="body" name="body" rows="3"
                          class="w-full rounded border px-3 py-2 @error('body') border-red-500 @else border-slate-300 @enderror">{{ old('body') }}</textarea>
                @error('body') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

                <button class="self-start rounded bg-emerald-700 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-800">Post comment</button>
            </form>
        @endauth

        @guest
            <p class="mt-4 text-sm">
                <a href="{{ route('login') }}" class="text-emerald-700 underline">Sign in to comment</a>
            </p>
        @endguest

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
