@extends('layouts.app')

@section('title', 'Officials only')

@section('content')
    <div class="card mx-auto max-w-xl p-8 text-center sm:p-10">
        <span class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-accent-soft text-ink">
            <x-icon name="lock" class="h-6 w-6" />
        </span>
        <p class="eyebrow mt-5">403 · Not allowed</p>
        <h1 class="mt-2 text-2xl font-semibold sm:text-3xl">Only barangay officials can publish notices</h1>
        <p class="mt-3 text-muted">
            Your account can read every notice and comment on any of them. Writing new notices needs an account
            linked to an official's author profile.
        </p>
        <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('posts.index') }}" class="btn btn-primary">Go to the notices</a>
        </div>
    </div>
@endsection
