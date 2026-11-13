@extends('layouts.app')

@section('content')
    <form method="GET" action="{{ route('posts.index') }}" class="mb-6 flex flex-col gap-2 sm:flex-row">
        <input name="q" value="{{ request('q') }}" placeholder="Search title" class="flex-1 rounded border border-slate-300 px-3 py-2">

        <select name="category" class="rounded border border-slate-300 px-3 py-2">
            <option value="">All categories</option>
            @foreach ($categories as $c)
                <option value="{{ $c }}" @selected(request('category') === $c)>{{ $c }}</option>
            @endforeach
        </select>

        <button class="rounded bg-emerald-700 px-4 py-2 font-medium text-white hover:bg-emerald-800">Filter</button>
    </form>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($posts as $post)
            <article class="flex flex-col gap-2 rounded-lg bg-white p-4 shadow">
                <div class="flex flex-wrap gap-2 text-xs font-medium">
                    @if ($post->is_pinned)
                        <span class="rounded bg-amber-200 px-2 py-1 text-amber-900">Pinned</span>
                    @endif
                    <span class="rounded bg-emerald-100 px-2 py-1 text-emerald-800">{{ $post->category }}</span>
                </div>

                <h2 class="font-semibold">
                    <a href="{{ route('posts.show', $post->id) }}" class="hover:underline">{{ $post->title }}</a>
                </h2>

                <p class="mt-auto text-sm text-slate-500">
                    {{ $post->published_at?->format('M j, Y') }} · Author #{{ $post->author_id }} · {{ $post->views }} views
                </p>
            </article>
        @empty
            <p class="sm:col-span-2 lg:col-span-3">No posts match your search.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>

    @if ($posts->total() > 0)
        <p class="mt-2 text-sm text-slate-500">Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of {{ $posts->total() }} posts</p>
    @endif
@endsection
