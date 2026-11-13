<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Bulletin – Purok Ancog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <header class="bg-emerald-700 text-white">
        <div class="mx-auto max-w-5xl px-4 py-5">
            <a href="{{ route('posts.index') }}" class="text-xl font-bold sm:text-2xl">Barangay Bulletin – Purok Ancog</a>
            <p class="text-sm text-emerald-100">Barangay Matina Crossing, Davao City</p>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-6">
        @yield('content')
    </main>
</body>
</html>
