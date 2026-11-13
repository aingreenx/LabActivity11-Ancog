@extends('layouts.app')

@section('title', 'Sign in')

@section('content')
<form method="POST" action="{{ route('login') }}" class="mx-auto mt-10 max-w-sm space-y-4 rounded-lg bg-white p-6 shadow">
    @csrf
    <h1 class="text-xl font-bold text-emerald-700">Barangay Bulletin Sign in</h1>

    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
           class="w-full rounded border p-2">
    @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

    <input type="password" name="password" placeholder="Password" class="w-full rounded border p-2">
    @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

    <button class="w-full rounded bg-emerald-600 p-2 text-white hover:bg-emerald-700">Sign in</button>
</form>
@endsection
