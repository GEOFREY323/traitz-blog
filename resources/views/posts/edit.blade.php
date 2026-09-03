@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')

<main class="page">
    <div class="container">

        <div class="page-header">
            <div>
                <h1>Edit Post</h1>
                <p>Update your article and save your changes.</p>
            </div>
        </div>

        <form
            class="form-card"
            action="{{ route('posts.update', $post) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title *</label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $post->title) }}"
                    placeholder="e.g. Getting Started with Laravel Routing"
                >

                @error('title')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="body">Content *</label>

                <textarea
                    id="body"
                    name="body"
                    class="form-control @error('body') is-invalid @enderror"
                    data-char-counter-target="5000"
                    placeholder="Write your post here..."
                >{{ old('body', $post->body) }}</textarea>

                <div class="char-counter" data-char-counter>
                    {{ strlen(old('body', $post->body)) }} / 5000 characters
                </div>

                @error('body')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="tag-text-input">Tags</label>

                <div class="tag-input-box" data-tag-input>
                    <input
                        type="text"
                        id="tag-text-input"
                        placeholder="Type a tag and press Enter"
                    >
                </div>

                <input
                    type="hidden"
                    name="tags"
                    data-tag-hidden
                    value="{{ old('tags', $post->tags->pluck('name')->implode(',')) }}"
                >

                <p class="form-hint">
                    Press Enter or comma to add a tag.
                    Click the &times; to remove one.
                </p>

                @error('tags')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="checkbox-row">
                    <input
                        type="checkbox"
                        id="published"
                        name="published"
                        value="1"
                        {{ old('published', $post->published) ? 'checked' : '' }}
                    >

                    <span>
                        Publish immediately (uncheck to save as a draft)
                    </span>
                </label>
            </div>

            <div class="form-actions">

                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>

                <a
                    href="{{ route('posts.show', $post) }}"
                    class="btn btn-ghost"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>
</main>

@endsection