@extends('layouts.app')

@section('title', 'Sign in')

@section('content')
    <div class="mx-auto grid max-w-5xl gap-10 lg:grid-cols-2 lg:items-center lg:py-6">
        <div>
            <p class="eyebrow">Accounts</p>
            <h1 class="mt-2 text-3xl font-semibold leading-tight sm:text-4xl">Sign in to comment or post</h1>
            <p class="mt-3 max-w-md text-muted">You can read every notice without an account. Signing in adds what your role allows:</p>

            <dl class="mt-6 space-y-4">
                <div class="flex gap-3">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-brand-soft text-brand"><x-icon name="chat" class="h-5 w-5" /></span>
                    <div>
                        <dt class="font-semibold">Residents</dt>
                        <dd class="text-sm text-muted">Comment on any notice with your name.</dd>
                    </div>
                </div>
                <div class="flex gap-3">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-brand-soft text-brand"><x-icon name="pen" class="h-5 w-5" /></span>
                    <div>
                        <dt class="font-semibold">Barangay officials</dt>
                        <dd class="text-sm text-muted">Comment, and publish new notices from their author profile.</dd>
                    </div>
                </div>
            </dl>

            <a href="{{ route('posts.index') }}" class="link mt-8 inline-flex items-center gap-1.5 text-sm">
                Keep reading without an account <x-icon name="arrow-right" />
            </a>
        </div>

        <form method="POST" action="{{ route('login') }}" class="card flex flex-col gap-5 p-6 sm:p-8">
            @csrf

            <h2 class="text-2xl font-semibold">Sign in</h2>

            @if ($errors->any())
                <div role="alert" class="rounded-lg border border-danger/30 bg-danger-soft p-4 text-sm text-danger">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label for="email" class="label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus
                       placeholder="you@bulletin.test" @class(['field min-h-11', 'field-error' => $errors->has('email')])>
                @error('email') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="label">Password</label>
                <input id="password" type="password" name="password" autocomplete="current-password"
                       @class(['field min-h-11', 'field-error' => $errors->has('password')])>
                @error('password') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <button class="btn btn-primary w-full">Sign in</button>
        </form>
    </div>
@endsection
