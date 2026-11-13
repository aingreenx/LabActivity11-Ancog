@extends('layouts.app')

@section('title', $author->name)

@section('content')
    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-muted transition hover:text-brand">
        <x-icon name="arrow-left" /> All notices
    </a>

    <section class="card mt-4 flex flex-col gap-5 p-5 sm:flex-row sm:items-center sm:p-8">
        <x-avatar :name="$author->name" size="lg" />

        <div class="flex-1">
            <p class="eyebrow">{{ $author->position }}</p>
            <h1 class="mt-1 text-3xl font-semibold sm:text-4xl">{{ $author->name }}</h1>
            <p class="mt-2 text-muted">
                <strong class="text-ink">{{ $posts->total() }} published {{ Str::plural('notice', $posts->total()) }}</strong>
                ·
                <strong class="text-ink">{{ $commentsReceived }} {{ Str::plural('comment', $commentsReceived) }} received</strong>
            </p>
        </div>

        @if (auth()->check() && auth()->id() === $author->user_id)
            <a href="{{ route('posts.create') }}" class="btn btn-primary self-start sm:self-center">
                <x-icon name="pen" /> New post
            </a>
        @endif
    </section>

    <h2 class="mt-10 text-2xl font-semibold">Notices by {{ $author->name }}</h2>

    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($posts as $post)
            <x-post-card :post="$post" />
        @empty
            <div class="card p-10 text-center sm:col-span-2 lg:col-span-3">
                <p class="font-display text-xl font-semibold">No published notices yet</p>
                <p class="mt-2 text-sm text-muted">Notices from {{ $author->name }} will show up here.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $posts->links('vendor.pagination.bulletin') }}
    </div>
@endsection
