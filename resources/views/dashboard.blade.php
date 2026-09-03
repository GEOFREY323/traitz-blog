@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<main class="page">
    <div class="container">

    <div class="page-header">
        <div>
            <h1>My Dashboard</h1>
            <p>
                Welcome back,
                <strong>{{ Auth::user()->name }}</strong>.
                Here are your posts and stats.
            </p>
        </div>

        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            + Write a New Post
        </a>
    </div>


    {{-- Dashboard Statistics --}}
    <div class="dash-stats">

        <div class="stat-card">
            <span class="stat-number">
                {{ $myPosts->count() }}
            </span>
            <span class="stat-label">
                Total Posts
            </span>
        </div>

        <div class="stat-card">
            <span class="stat-number">
                {{ $myPosts->where('published', true)->count() }}
            </span>
            <span class="stat-label">
                Published
            </span>
        </div>

        <div class="stat-card">
            <span class="stat-number">
                {{ $myPosts->where('published', false)->count() }}
            </span>
            <span class="stat-label">
                Drafts
            </span>
        </div>

        <div class="stat-card">
            <span class="stat-number">
                {{ $commentsReceived }}
            </span>
            <span class="stat-label">
                Comments Received
            </span>
        </div>

    </div>


    {{-- My Posts --}}
    <div class="dash-section">

        <h2 class="dash-section-title">
            My Posts
        </h2>

        @forelse ($myPosts as $post)

            <div class="dash-post-row">

                <div class="dash-post-info">

                    <h3>
                        <a href="{{ route('posts.show', $post) }}">
                            {{ $post->title }}
                        </a>
                    </h3>

                    <p class="post-meta">

                        <span>
                            {{ $post->created_at->diffForHumans() }}
                        </span>

                        <span class="dot">
                            &bull;
                        </span>

                        @if ($post->published)

                            <span style="color: #1e7a4c; font-weight: 600; font-size: 12px;">
                                Published
                            </span>

                        @else

                            <span class="badge-draft">
                                Draft
                            </span>

                        @endif

                    </p>


                    {{-- Post Tags --}}
                    <div class="tag-list">

                        @foreach ($post->tags as $tag)

                            <a
                                href="{{ route('tags.show', $tag->slug) }}"
                                class="tag-pill"
                            >
                                #{{ $tag->name }}
                            </a>

                        @endforeach

                    </div>

                </div>


                {{-- Post Actions --}}
                <div class="dash-post-actions">

                    @can('update', $post)

                        <a
                            href="{{ route('posts.edit', $post) }}"
                            class="btn btn-ghost btn-sm"
                        >
                            Edit
                        </a>

                    @endcan


                    @can('delete', $post)

                        <form
                            action="{{ route('posts.destroy', $post) }}"
                            method="POST"
                            data-confirm-delete="Delete this post? This cannot be undone."
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                            >
                                Delete
                            </button>
                        </form>

                    @endcan

                </div>

            </div>

        @empty

            <div class="empty-state">

                <h2>No posts yet</h2>

                <p>
                    You haven't created any posts yet.
                </p>

                <a
                    href="{{ route('posts.create') }}"
                    class="btn btn-primary"
                >
                    + Write Your First Post
                </a>

            </div>

        @endforelse

    </div>


    {{-- Account Details --}}
    <div class="dash-section" style="margin-top: 40px;">

        <h2 class="dash-section-title">
            Account Details
        </h2>

        <div class="auth-card" style="max-width: 480px;">

            <div class="form-group">

                <label>Name</label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ Auth::user()->name }}"
                    disabled
                >

            </div>


            <div class="form-group">

                <label>Email Address</label>

                <input
                    type="email"
                    class="form-control"
                    value="{{ Auth::user()->email }}"
                    disabled
                >

            </div>


            <p style="font-size: 14px; color: var(--text-muted); margin: 0;">
                To change your password or email, use your
                profile settings in the Laravel Breeze panel.
            </p>

        </div>

    </div>

</div>

</main>

@endsection
