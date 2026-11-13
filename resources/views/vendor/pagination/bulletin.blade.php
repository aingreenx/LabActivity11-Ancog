@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-between gap-3">
        @if ($paginator->onFirstPage())
            <span class="btn btn-secondary cursor-not-allowed opacity-50" aria-disabled="true">
                <x-icon name="arrow-left" /> Newer
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn btn-secondary">
                <x-icon name="arrow-left" /> Newer
            </a>
        @endif

        <p class="text-sm text-muted">Page <strong class="text-ink">{{ $paginator->currentPage() }}</strong> of {{ $paginator->lastPage() }}</p>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn btn-secondary">
                Older <x-icon name="arrow-right" />
            </a>
        @else
            <span class="btn btn-secondary cursor-not-allowed opacity-50" aria-disabled="true">
                Older <x-icon name="arrow-right" />
            </span>
        @endif
    </nav>
@endif
