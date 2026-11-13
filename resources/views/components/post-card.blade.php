@props(['post'])

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

    @if ($post->tags->isNotEmpty())
        <div class="flex flex-wrap gap-1 text-xs">
            @foreach ($post->tags as $tag)
                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="rounded-full bg-slate-100 px-2 py-0.5 text-slate-600 hover:bg-slate-200">#{{ $tag->name }}</a>
            @endforeach
        </div>
    @endif

    <p class="mt-auto text-sm text-slate-500">
        {{ $post->published_at?->format('M j, Y') }}
        · <a href="{{ route('authors.show', $post->author) }}" class="text-emerald-700 hover:underline">{{ $post->author->name }}</a>
        · {{ $post->views }} views
        · {{ $post->comments_count }} {{ Str::plural('comment', $post->comments_count) }}
    </p>
</article>
