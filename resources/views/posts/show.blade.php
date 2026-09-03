@extends('layouts.app')

@section('title', $post->title)

@section('content')

<main class="page">
    <div class="container" style="max-width: 760px;">

    <p style="margin-bottom: 20px;">
        <a href="{{ route('posts.index') }}">&larr; Back to all posts</a>
    </p>

    <article class="post-full">

        <p class="post-meta">
            <strong>{{ $post->user->name }}</strong>

            <span class="dot">&bull;</span>

            <span>Posted {{ $post->created_at->diffForHumans() }}</span>

            @if(!$post->published)
                <span class="badge-draft">Draft</span>
            @endif
        </p>

        <h1>{{ $post->title }}</h1>

        <div class="tag-list">
            @foreach($post->tags as $tag)
                <a href="{{ route('posts.index') }}" class="tag-pill">
                    #{{ $tag->name }}
                </a>
            @endforeach
        </div>

        <div class="post-body">
            <p>{{ $post->body }}</p>
        </div>

        @auth
            @can('update', $post)
                <div class="post-actions">

                    <a
                        href="{{ route('posts.edit', $post) }}"
                        class="btn btn-primary"
                    >
                        Edit Post
                    </a>

                    @can('delete', $post)
                        <form
                            action="{{ route('posts.destroy', $post) }}"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('Are you sure you want to delete this post?');"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-ghost"
                            >
                                Delete Post
                            </button>
                        </form>
                    @endcan

                </div>
            @endcan
        @endauth

    </article>

    <!-- ================= COMMENTS ================= -->

    <section class="comments-section">

        <h2>
            Comments
            <span style="color: var(--text-muted); font-weight: 400;">
                ({{ $post->comments->count() }})
            </span>
        </h2>

        @forelse($post->comments as $comment)

            <div class="comment">

                <div class="comment-avatar">
                    {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                </div>

                <div>

                    <span class="comment-author">
                        {{ $comment->user->name }}
                    </span>

                    <span class="comment-time">
                        {{ $comment->created_at->diffForHumans() }}
                    </span>

                    <p class="comment-body">
                        {{ $comment->body }}
                    </p>

                </div>

            </div>

        @empty

            <p style="color: var(--text-muted);">
                No comments yet — be the first to comment.
            </p>

        @endforelse


        <!-- ================= COMMENT FORM ================= -->

        @auth

            <form
                class="comment-form"
                style="margin-top: 24px;"
                action="{{ route('comments.store', $post) }}"
                method="POST"
            >

                @csrf

                <div class="form-group">

                    <label for="comment-body">
                        Add a comment
                    </label>

                    <textarea
                        id="comment-body"
                        name="body"
                        class="form-control"
                        placeholder="Share your thoughts..."
                    >{{ old('body') }}</textarea>

                    @error('body')
                        <p class="field-error">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <button type="submit" class="btn btn-primary">
                    Post Comment
                </button>

            </form>

        @endauth


        @guest

            <div class="login-prompt">
                <a href="#">Log in</a> to leave a comment.
            </div>

        @endguest

    </section>

</div>


</main>

@endsection
