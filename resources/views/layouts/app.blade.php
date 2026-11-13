<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barangay Bulletin – Purok Ancog')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <header class="bg-emerald-700 text-white">
        <div class="mx-auto flex max-w-5xl flex-col gap-3 px-4 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('posts.index') }}" class="text-xl font-bold sm:text-2xl">Barangay Bulletin – Purok Ancog</a>
                <p class="text-sm text-emerald-100">Barangay Matina Crossing, Davao City</p>
            </div>

            <nav class="flex items-center gap-4 text-sm">
                @auth
                    @if (auth()->user()->author)
                        <a href="{{ route('posts.create') }}" class="rounded bg-white px-3 py-1 font-medium text-emerald-700 hover:bg-emerald-50">New post</a>
                    @endif
                    <span>Hi, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="underline">Logout</button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="underline">Sign in</a>
                @endguest
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-6">
        @if (session('status'))
            <p class="mb-4 rounded border border-emerald-200 bg-emerald-50 px-3 py-2 text-emerald-800">{{ session('status') }}</p>
        @endif

        @yield('content')
    </main>
</body>
</html>
