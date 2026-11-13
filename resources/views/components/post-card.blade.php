@props(['post'])

<article @class([
    'card flex flex-col p-5 transition duration-200 hover:shadow-[0_10px_30px_-15px_rgb(var(--ink)/0.35)] motion-safe:hover:-translate-y-0.5',
    'border-accent/70 bg-accent-soft/50' => $post->is_pinned,
])>
    <div class="flex flex-wrap items-center gap-2">
        @if ($post->is_pinned)
            <span class="inline-flex items-center gap-1 rounded-full bg-accent px-2 py-0.5 text-xs font-semibold text-ink">
                <x-icon name="pin" class="h-3 w-3" /> Pinned
            </span>
        @endif
        <span class="eyebrow">{{ $post->category }}</span>
        <time datetime="{{ $post->published_at?->toDateString() }}" class="ml-auto text-xs text-muted">{{ $post->published_at?->format('M j, Y') }}</time>
    </div>

    <h2 class="mt-3 text-xl font-semibold leading-snug">
        <a href="{{ route('posts.show', $post->id) }}" class="transition hover:text-brand">{{ $post->title }}</a>
    </h2>

    <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-muted">{{ Str::limit($post->body, 240) }}</p>

    @if ($post->tags->isNotEmpty())
        <div class="mt-4 flex flex-wrap gap-1.5">
            @foreach ($post->tags as $tag)
                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="chip">#{{ $tag->name }}</a>
            @endforeach
        </div>
    @endif

    <div class="mt-auto pt-5">
        <div class="flex items-center gap-3 border-t border-line pt-4">
            <x-avatar :name="$post->author->name" size="sm" />
            <div class="min-w-0">
                <a href="{{ route('authors.show', $post->author) }}" class="block truncate text-sm font-semibold transition hover:text-brand">{{ $post->author->name }}</a>
                <span class="block truncate text-xs text-muted">{{ $post->author->position }}</span>
            </div>
            <div class="ml-auto flex shrink-0 items-center gap-3 text-xs text-muted">
                <span class="inline-flex items-center gap-1"><x-icon name="eye" class="h-3.5 w-3.5" />{{ $post->views }}<span class="sr-only">views</span></span>
                <span class="inline-flex items-center gap-1"><x-icon name="chat" class="h-3.5 w-3.5" />{{ $post->comments_count }}<span class="sr-only">{{ Str::plural('comment', $post->comments_count) }}</span></span>
            </div>
        </div>
    </div>
</article>
