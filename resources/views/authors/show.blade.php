@extends('layouts.app')

@section('title', $author->name)

@section('content')
    <a href="{{ route('posts.index') }}" class="text-sm text-emerald-700 hover:underline">← Back to all posts</a>

    <section class="mt-4 rounded-lg bg-white p-4 shadow sm:p-6">
        <h1 class="text-2xl font-bold">{{ $author->name }}</h1>
        <p class="text-slate-600">{{ $author->position }}</p>
        <p class="mt-2 text-sm text-slate-500">
            {{ $posts->total() }} published {{ Str::plural('post', $posts->total()) }}
            · {{ $commentsReceived }} {{ Str::plural('comment', $commentsReceived) }} received
        </p>
    </section>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($posts as $post)
            <x-post-card :post="$post" />
        @empty
            <p class="sm:col-span-2 lg:col-span-3">This author has no published posts yet.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
@endsection
