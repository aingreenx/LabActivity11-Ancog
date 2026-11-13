{{-- Shows the current visitor which features their role unlocks. --}}
@php
    $user = auth()->user();
    $canPublish = $user?->canPublish() ?? false;
@endphp

<aside {{ $attributes->class(['card p-5']) }} aria-label="What you can do here">
    <p class="eyebrow">What you can do here</p>
    <p class="mt-1 text-sm">
        @if ($canPublish)
            Signed in as an <strong>official</strong>
        @elseif ($user)
            Signed in as a <strong>resident</strong>
        @else
            Browsing as a <strong>guest</strong>
        @endif
    </p>

    <ul class="mt-4 space-y-3 text-sm">
        <li class="flex gap-3">
            <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-brand-soft text-brand"><x-icon name="check" class="h-3.5 w-3.5" /></span>
            <div>
                <p class="font-semibold">Read notices and author pages</p>
                <p class="text-xs text-muted">Open to everyone, no account needed</p>
            </div>
        </li>

        <li class="flex gap-3">
            @if ($user)
                <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-brand-soft text-brand"><x-icon name="check" class="h-3.5 w-3.5" /></span>
                <div>
                    <p class="font-semibold">Comment on notices</p>
                    <p class="text-xs text-muted">Open any notice and reply below it</p>
                </div>
            @else
                <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-ink/5 text-muted"><x-icon name="lock" class="h-3.5 w-3.5" /></span>
                <div>
                    <p class="font-semibold text-muted">Comment on notices</p>
                    <a href="{{ route('login') }}" class="link text-xs">Sign in to comment</a>
                </div>
            @endif
        </li>

        <li class="flex gap-3">
            @if ($canPublish)
                <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-brand-soft text-brand"><x-icon name="check" class="h-3.5 w-3.5" /></span>
                <div>
                    <p class="font-semibold">Publish notices</p>
                    <a href="{{ route('posts.create') }}" class="link text-xs">Write a new notice</a>
                </div>
            @else
                <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-ink/5 text-muted"><x-icon name="lock" class="h-3.5 w-3.5" /></span>
                <div>
                    <p class="font-semibold text-muted">Publish notices</p>
                    <p class="text-xs text-muted">Barangay officials with an author profile only</p>
                </div>
            @endif
        </li>
    </ul>
</aside>
