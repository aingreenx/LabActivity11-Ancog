<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Notices') · Barangay Bulletin – Purok Ancog</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:600,700|public-sans:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-surface focus:px-4 focus:py-2">Skip to content</a>

    <header class="sticky top-0 z-30 border-b border-line bg-surface/90 backdrop-blur">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center gap-x-6 gap-y-3 px-4 py-3 sm:px-6">
            <a href="{{ route('posts.index') }}" class="mr-auto flex items-center gap-3">
                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-brand font-display text-lg font-bold text-white">B</span>
                <span class="leading-tight">
                    <span class="block font-display text-base font-semibold sm:text-lg">Barangay Bulletin – Purok Ancog</span>
                    <span class="block text-xs text-muted">Barangay Matina Crossing, Davao City</span>
                </span>
            </a>

            <nav class="flex flex-wrap items-center gap-2 text-sm" aria-label="Account">
                @auth
                    @php $official = auth()->user()->author; @endphp

                    @if ($official)
                        <a href="{{ route('posts.create') }}" class="btn btn-primary">
                            <x-icon name="pen" /> New post
                        </a>
                    @endif

                    <span class="flex items-center gap-2 px-1" title="{{ auth()->user()->name }}">
                        <x-avatar :name="auth()->user()->name" size="sm" />
                        <span class="hidden leading-tight sm:block">
                            <span class="block max-w-40 truncate font-semibold">{{ auth()->user()->name }}</span>
                            @if ($official)
                                <span class="block text-xs font-medium text-brand">{{ $official->position }} · Author</span>
                            @else
                                <span class="block text-xs text-muted">Resident</span>
                            @endif
                        </span>
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-ghost">Log out</button>
                    </form>
                @endauth

                @guest
                    @unless (request()->routeIs('login'))
                        <a href="{{ route('login') }}" class="btn btn-primary">Sign in</a>
                    @endunless
                @endguest
            </nav>
        </div>
    </header>

    <main id="main" class="mx-auto w-full max-w-6xl flex-1 px-4 py-8 sm:px-6 sm:py-10">
        @if (session('status'))
            <div role="status" class="mb-6 flex items-center gap-3 rounded-xl border border-brand/20 bg-brand-soft px-4 py-3 text-sm font-medium text-brand">
                <x-icon name="check" class="h-5 w-5 shrink-0" />
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-line">
        <div class="mx-auto flex max-w-6xl flex-col gap-1 px-4 py-6 text-xs text-muted sm:flex-row sm:justify-between sm:px-6">
            <p>Barangay Bulletin – Purok Ancog · Barangay Matina Crossing, Davao City</p>
            <p>Lab Activity 11 · Greece Ancog</p>
        </div>
    </footer>
</body>
</html>
