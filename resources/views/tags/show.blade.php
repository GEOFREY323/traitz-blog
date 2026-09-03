@extends('layouts.app')

@section('title', '#' . $tag->name)

@section('content')

<main class="page">
    <div class="container">

        <div class="page-header">
            <div>
                <h1>#{{ $tag->name }}</h1>
                <p>Posts tagged with #{{ $tag->name }}</p>
            </div>
        </div>

        @if ($posts->count())
            <div class="post-list">

                @foreach ($posts as $post)
                    <article class="post-card">

                        <div class="post-card-content">

                            <h2 class="post-card-title">
                                <a href="{{ route('posts.show', $post) }}">
                                    {{ $post->title }}
                                </a>
                            </h2>

                            <div class="post-meta">
                                <span>
                                    By {{ $post->user->name }}
                                </span>

                                <span>
                                    {{ $post->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <p class="post-excerpt">
                                {{ \Illuminate\Support\Str::limit($post->body, 180) }}
                            </p>

                            <div class="post-tags">
                                @foreach ($post->tags as $postTag)
                                    <a
                                        href="{{ route('tags.show', $postTag->slug) }}"
                                        class="tag"
                                    >
                                        #{{ $postTag->name }}
                                    </a>
                                @endforeach
                            </div>

                        </div>

                    </article>
                @endforeach

            </div>
        @else
            <div class="empty-state">
                <h2>No posts found</h2>
                <p>
                    There are no published posts with this tag yet.
                </p>

                <a
                    href="{{ route('posts.index') }}"
                    class="btn btn-primary"
                >
                    Browse All Posts
                </a>
            </div>
        @endif

    </div>
</main>

@endsection