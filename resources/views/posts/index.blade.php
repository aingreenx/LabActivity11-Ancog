@extends('layouts.app')

@section('title', 'Notices')

@section('content')
    <section class="grid gap-6 lg:grid-cols-[1fr_20rem] lg:items-center">
        <div>
            <p class="eyebrow">Barangay Matina Crossing · Davao City</p>
            <h1 class="mt-2 text-3xl font-semibold leading-tight sm:text-4xl">Notices for Purok Ancog residents</h1>
            <p class="mt-3 max-w-xl text-muted">
                Schedules, ayuda releases and urgent advisories, posted by barangay officials. Every notice shows who posted it.
                @guest Anyone can read them; sign in to comment. @endguest
                @auth Open any notice to read it and leave a comment. @endauth
            </p>
        </div>

        <x-access-panel />
    </section>

    <form method="GET" action="{{ route('posts.index') }}" class="card mt-8 p-3 sm:p-4" role="search">
        <div class="flex flex-col gap-3 md:flex-row">
            <label class="relative flex-1">
                <span class="sr-only">Search notice titles</span>
                <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-muted" />
                <input name="q" value="{{ request('q') }}" placeholder="Search notice titles" class="field min-h-11 pl-10">
            </label>

            <label class="md:w-56">
                <span class="sr-only">Category</span>
                <select name="category" class="field min-h-11">
                    <option value="">All categories</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c }}" @selected(request('category') === $c)>{{ $c }}</option>
                    @endforeach
                </select>
            </label>

            @if (request()->filled('tag'))
                <input type="hidden" name="tag" value="{{ request('tag') }}">
            @endif

            <button class="btn btn-primary">Search</button>
        </div>

        <div class="mt-3 flex flex-wrap items-center gap-2 border-t border-line pt-3">
            <span class="eyebrow mr-1">Tags</span>
            <a href="{{ route('posts.index', request()->only('q', 'category')) }}" @class(['chip', 'chip-active' => ! request()->filled('tag')])>All</a>
            @foreach ($tags as $t)
                <a href="{{ route('posts.index', [...request()->only('q', 'category'), 'tag' => $t->name]) }}"
                   @class(['chip', 'chip-active' => request('tag') === $t->name])>
                    #{{ $t->name }} <span class="opacity-70">{{ $t->posts_count }}</span>
                </a>
            @endforeach
        </div>
    </form>

    <div class="mt-6 flex flex-wrap items-baseline justify-between gap-2">
        <p class="text-sm text-muted">
            @if ($posts->total() > 0)
                Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of {{ $posts->total() }} {{ Str::plural('notice', $posts->total()) }}
            @else
                No notices found
            @endif
            @if (request()->filled('tag')) tagged <strong class="text-ink">#{{ request('tag') }}</strong>@endif
            @if (request()->filled('category')) in <strong class="text-ink">{{ request('category') }}</strong>@endif
            @if (request()->filled('q')) matching <strong class="text-ink">“{{ request('q') }}”</strong>@endif
        </p>

        @if (request()->anyFilled(['q', 'category', 'tag']))
            <a href="{{ route('posts.index') }}" class="link text-sm">Clear filters</a>
        @endif
    </div>

    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($posts as $post)
            <x-post-card :post="$post" />
        @empty
            <div class="card p-10 text-center sm:col-span-2 lg:col-span-3">
                <p class="font-display text-xl font-semibold">No notices match your search</p>
                <p class="mt-2 text-sm text-muted">Try another word, category or tag.</p>
                <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-5">Show all notices</a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $posts->links('vendor.pagination.bulletin') }}
    </div>
@endsection
