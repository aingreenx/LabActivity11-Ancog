@extends('layouts.app')

@section('title', 'New post')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-muted transition hover:text-brand">
            <x-icon name="arrow-left" /> All notices
        </a>

        <h1 class="mt-4 text-3xl font-semibold sm:text-4xl">Write a notice</h1>
        <p class="mt-2 text-muted">
            Posting as <strong class="text-ink">{{ auth()->user()->author->name }}</strong>, {{ auth()->user()->author->position }}.
            Published notices appear on the bulletin right away with your name on them.
        </p>

        <form method="POST" action="{{ route('posts.store') }}" class="card mt-6 flex flex-col gap-6 p-5 sm:p-8">
            @csrf

            @if ($errors->any())
                <div role="alert" class="rounded-lg border border-danger/30 bg-danger-soft p-4 text-sm text-danger">
                    <p class="flex items-center gap-2 font-semibold"><x-icon name="alert" /> Fix {{ $errors->count() === 1 ? 'this' : 'these' }} before saving:</p>
                    <ul class="mt-2 list-disc space-y-1 pl-6">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label for="title" class="label">Title</label>
                <input id="title" name="title" value="{{ old('title') }}" maxlength="120" placeholder="e.g. Free anti-rabies vaccination at the barangay hall"
                       @class(['field min-h-11', 'field-error' => $errors->has('title')])>
                @error('title') <p class="error-text">{{ $message }}</p> @enderror
                <p class="hint">Up to 120 characters.</p>
            </div>

            <div>
                <label for="category" class="label">Category</label>
                <select id="category" name="category" @class(['field min-h-11 sm:max-w-xs', 'field-error' => $errors->has('category')])>
                    <option value="">Choose a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                    @endforeach
                </select>
                @error('category') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="body" class="label">Notice</label>
                <textarea id="body" name="body" rows="8" placeholder="What, when, where, and who should come."
                          @class(['field leading-relaxed', 'field-error' => $errors->has('body')])>{{ old('body') }}</textarea>
                @error('body') <p class="error-text">{{ $message }}</p> @enderror
                <p class="hint">At least 20 characters.</p>
            </div>

            <fieldset>
                <legend class="label">Tags</legend>
                <p class="-mt-1 mb-3 text-xs text-muted">Pick at least one. Residents filter the bulletin by these.</p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($tags as $tag)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="peer sr-only"
                                   @checked(in_array($tag->id, old('tags', [])))>
                            <span class="chip min-h-11 px-4 text-sm peer-checked:border-brand peer-checked:bg-brand peer-checked:text-white peer-focus-visible:ring-2 peer-focus-visible:ring-brand peer-focus-visible:ring-offset-2">#{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('tags') <p class="error-text">{{ $message }}</p> @enderror
                @error('tags.*') <p class="error-text">{{ $message }}</p> @enderror
            </fieldset>

            <div class="rounded-lg border border-line bg-paper p-4">
                <label class="flex cursor-pointer items-start gap-3">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published'))
                           class="mt-0.5 h-5 w-5 rounded border-line text-brand accent-[rgb(var(--brand))] focus:ring-brand">
                    <span>
                        <span class="block text-sm font-semibold">Publish now</span>
                        <span class="block text-xs text-muted">Leave unticked to save a draft. Drafts are not shown on the bulletin.</span>
                    </span>
                </label>
                @error('is_published') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-line pt-6 sm:flex-row sm:justify-end">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
                <button class="btn btn-primary">Save notice</button>
            </div>
        </form>
    </div>
@endsection
