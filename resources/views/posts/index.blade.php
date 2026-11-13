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

        <select name="tag" class="rounded border border-slate-300 px-3 py-2">
            <option value="">All tags</option>
            @foreach ($tags as $t)
                <option value="{{ $t }}" @selected(request('tag') === $t)>{{ $t }}</option>
            @endforeach
        </select>

        <button class="rounded bg-emerald-700 px-4 py-2 font-medium text-white hover:bg-emerald-800">Filter</button>
    </form>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($posts as $post)
            <x-post-card :post="$post" />
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
