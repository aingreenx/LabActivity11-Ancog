@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-muted transition hover:text-brand">
        <x-icon name="arrow-left" /> All notices
    </a>

    <div class="mt-4 grid gap-6 lg:grid-cols-[1fr_18rem]">
        <article class="card p-5 sm:p-8 lg:col-start-1">
            <div class="flex flex-wrap items-center gap-2">
                @if ($post->is_pinned)
                    <span class="inline-flex items-center gap-1 rounded-full bg-accent px-2 py-0.5 text-xs font-semibold text-ink">
                        <x-icon name="pin" class="h-3 w-3" /> Pinned
                    </span>
                @endif
                <span class="eyebrow">{{ $post->category }}</span>
            </div>

            <h1 class="mt-3 text-3xl font-semibold leading-tight sm:text-4xl">{{ $post->title }}</h1>

            <p class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-muted">
                <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->format('F j, Y') }}</time>
                <span aria-hidden="true">·</span>
                <span class="inline-flex items-center gap-1"><x-icon name="eye" class="h-3.5 w-3.5" /> {{ $post->views }} {{ Str::plural('view', $post->views) }}</span>
                <span aria-hidden="true">·</span>
                <a href="#comments" class="inline-flex items-center gap-1 hover:text-brand"><x-icon name="chat" class="h-3.5 w-3.5" /> {{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}</a>
            </p>

            @if ($post->tags->isNotEmpty())
                <div class="mt-4 flex flex-wrap gap-1.5">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="chip">#{{ $tag->name }}</a>
                    @endforeach
                </div>
            @endif

            <div class="mt-6 max-w-prose whitespace-pre-line border-t border-line pt-6 text-[1.0625rem] leading-8">{{ $post->body }}</div>
        </article>

        <aside class="space-y-4 lg:col-start-2 lg:row-span-2 lg:row-start-1">
            <div class="card p-5 lg:sticky lg:top-24">
                <p class="eyebrow">Posted by</p>
                <div class="mt-3 flex items-center gap-3">
                    <x-avatar :name="$post->author->name" />
                    <div class="min-w-0">
                        <a href="{{ route('authors.show', $post->author) }}" class="block truncate font-semibold transition hover:text-brand">{{ $post->author->name }}</a>
                        <span class="block text-sm text-muted">{{ $post->author->position }}</span>
                    </div>
                </div>
                <a href="{{ route('authors.show', $post->author) }}" class="link mt-4 inline-block text-sm">See all their notices</a>
            </div>
        </aside>

        <section id="comments" class="card scroll-mt-24 p-5 sm:p-8 lg:col-start-1">
            <h2 class="text-2xl font-semibold">
                Comments <span class="ml-1 align-middle font-sans text-base font-medium text-muted">{{ $post->comments->count() }}</span>
            </h2>

            @auth
                <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-5 flex flex-col gap-3">
                    @csrf

                    @if ($errors->any())
                        <div role="alert" class="rounded-lg border border-danger/30 bg-danger-soft p-4 text-sm text-danger">
                            <p class="flex items-center gap-2 font-semibold"><x-icon name="alert" /> Your comment was not posted</p>
                            <ul class="mt-2 list-disc space-y-1 pl-6">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex items-start gap-3">
                        <x-avatar :name="auth()->user()->name" class="hidden sm:inline-grid" />
                        <div class="flex-1">
                            <label for="body" class="label">Comment as {{ auth()->user()->name }}</label>
                            <textarea id="body" name="body" rows="3" maxlength="1000" placeholder="Ask a question or add information for your neighbors"
                                      @class(['field', 'field-error' => $errors->has('body')])>{{ old('body') }}</textarea>
                            @error('body') <p class="error-text">{{ $message }}</p> @enderror
                            <p class="hint">3 to 1000 characters.</p>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button class="btn btn-primary">Post comment</button>
                    </div>
                </form>
            @endauth

            @guest
                <div class="mt-5 flex flex-col items-start gap-3 rounded-lg border border-dashed border-line bg-paper p-5 sm:flex-row sm:items-center sm:justify-between">
                    <p class="flex items-center gap-2 text-sm text-muted">
                        <x-icon name="lock" class="shrink-0" /> Anyone can read the comments. Residents sign in to reply.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-primary shrink-0">Sign in to comment</a>
                </div>
            @endguest

            <ul class="mt-6 divide-y divide-line">
                @forelse ($post->comments as $comment)
                    <li class="flex gap-3 py-4">
                        <x-avatar :name="$comment->user->name" size="sm" />
                        <div class="min-w-0 flex-1">
                            <p class="flex flex-wrap items-center gap-x-2 text-sm">
                                <span class="font-semibold">{{ $comment->user->name }}</span>
                                @if ($comment->user_id === $post->author->user_id)
                                    <span class="rounded-full bg-brand-soft px-2 py-0.5 text-xs font-semibold text-brand">Notice author</span>
                                @endif
                                <time datetime="{{ $comment->created_at->toIso8601String() }}" title="{{ $comment->created_at->format('F j, Y g:i A') }}" class="text-muted">{{ $comment->created_at->diffForHumans() }}</time>
                            </p>
                            <p class="mt-1 break-words leading-relaxed">{{ $comment->body }}</p>
                        </div>
                    </li>
                @empty
                    <li class="py-6 text-center text-sm text-muted">No comments yet.</li>
                @endforelse
            </ul>
        </section>
    </div>
@endsection
