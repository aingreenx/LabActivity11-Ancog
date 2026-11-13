@extends('layouts.app')

@section('title', 'New post')

@section('content')
    <a href="{{ route('posts.index') }}" class="text-sm text-emerald-700 hover:underline">← Back to all posts</a>

    <form method="POST" action="{{ route('posts.store') }}" class="mt-4 flex flex-col gap-4 rounded-lg bg-white p-4 shadow sm:p-6">
        @csrf

        <h1 class="text-2xl font-bold">New post</h1>

        @if ($errors->any())
            <div class="rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <p class="font-medium">Please fix the following:</p>
                <ul class="mt-1 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label for="title" class="block text-sm font-medium">Title</label>
            <input id="title" name="title" value="{{ old('title') }}" maxlength="120"
                   class="mt-1 w-full rounded border px-3 py-2 @error('title') border-red-500 @else border-slate-300 @enderror">
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="category" class="block text-sm font-medium">Category</label>
            <select id="category" name="category"
                    class="mt-1 w-full rounded border px-3 py-2 @error('category') border-red-500 @else border-slate-300 @enderror">
                <option value="">Choose a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                @endforeach
            </select>
            @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="body" class="block text-sm font-medium">Body</label>
            <textarea id="body" name="body" rows="6"
                      class="mt-1 w-full rounded border px-3 py-2 @error('body') border-red-500 @else border-slate-300 @enderror">{{ old('body') }}</textarea>
            @error('body') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <fieldset>
            <legend class="text-sm font-medium">Tags</legend>
            <div class="mt-1 flex flex-wrap gap-3">
                @foreach ($tags as $tag)
                    <label class="flex items-center gap-1 text-sm">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                               @checked(in_array($tag->id, old('tags', [])))>
                        {{ $tag->name }}
                    </label>
                @endforeach
            </div>
            @error('tags') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            @error('tags.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </fieldset>

        <div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published'))>
                Publish now
            </label>
            @error('is_published') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <button class="self-start rounded bg-emerald-700 px-4 py-2 font-medium text-white hover:bg-emerald-800">Save post</button>
    </form>
@endsection
