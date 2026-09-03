@extends('layouts.app')

@section('title', '404 — Page Not Found')

@section('content')

<main class="page">
    <div class="container">

        <div class="error-page">

            <div class="error-code">404</div>

            <h1 class="error-title">
                Page Not Found
            </h1>

            <p class="error-message">
                Oops! The page you are looking for does not exist
                or may have been moved.
            </p>

            <div class="error-actions">

                <a
                    href="{{ route('posts.index') }}"
                    class="btn btn-primary"
                >
                    Go to Homepage
                </a>

                <a
                    href="{{ route('posts.index') }}"
                    class="btn btn-ghost"
                >
                    Browse All Posts
                </a>

            </div>

        </div>

    </div>
</main>

@endsection