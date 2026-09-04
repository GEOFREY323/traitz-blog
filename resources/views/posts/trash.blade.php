@extends('layouts.app')

@section('title', 'Trash')

@section('content')

<main class="page">
    <div class="container">

        <div class="page-header">
            <div>
                <h1>Trash</h1>
                <p>Posts you have deleted are kept here until permanently removed.</p>
            </div>

            <a href="{{ route('dashboard') }}" class="btn btn-ghost">
                ← Back to Dashboard
            </a>
        </div>

        @if (session('success'))
            <div class="flash-message">
                {{ session('success') }}
            </div>
        @endif

        @if ($posts->count())

            <div class="post-list">

                @foreach ($posts as $post)

                    <article class="post-card">

                        <div class="post-card-content">

                            <div class="post-meta">
                                <span>
                                    Deleted {{ $post->deleted_at->diffForHumans() }}
                                </span>
                            </div>

                            <h2 class="post-title">
                                {{ $post->title }}
                            </h2>

                            <p class="post-excerpt">
                                {{ \Illuminate\Support\Str::limit($post->body, 180) }}
                            </p>

                            @if ($post->tags->count())
                                <div class="tags">
                                    @foreach ($post->tags as $tag)
                                        <span class="tag">
                                            #{{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="post-actions">

                                {{-- Restore --}}
                                <form
                                    action="{{ route('posts.restore', $post->id) }}"
                                    method="POST"
                                    style="display: inline;"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Restore
                                    </button>
                                </form>

                                {{-- Permanent Delete --}}
                                <form
                                    action="{{ route('posts.forceDelete', $post->id) }}"
                                    method="POST"
                                    style="display: inline;"
                                    data-confirm-delete="Permanently delete this post? This cannot be undone."
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-ghost"
                                    >
                                        Delete Permanently
                                    </button>
                                </form>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div class="empty-state">
                <h2>Your Trash is Empty</h2>
                <p>Deleted posts will appear here.</p>

                <a
                    href="{{ route('dashboard') }}"
                    class="btn btn-primary"
                >
                    Back to Dashboard
                </a>
            </div>

        @endif

    </div>
</main>

@endsection