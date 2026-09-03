<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>@yield('title', 'Traitz Blog')</title>

<link rel="stylesheet" href="{{ asset('css/style.css') }}">


</head>

<body>

<header class="site-header">


<div class="navbar">

    <a href="{{ route('posts.index') }}" class="brand">
        Traitz<span>Blog</span>
    </a>

    <button
        class="nav-toggle"
        data-nav-toggle
        aria-label="Toggle navigation"
    >
        &#9776;
    </button>

    <nav class="nav-links" data-nav-links>

        <a href="{{ route('posts.index') }}">
            All Posts
        </a>

        @auth

            <a href="{{ route('posts.create') }}">Write a Post</a>

            <a href="{{ route('dashboard') }}">
                Dashboard
            </a>

            <form
                method="POST"
                action="{{ route('logout') }}"
                style="display: inline;"
            >
                @csrf

                <button
                    type="submit"
                    class="btn btn-ghost btn-sm"
                >
                    Logout
                </button>
            </form>

        @else

            <a
                href="{{ route('login') }}"
                class="btn btn-outline btn-sm"
            >
                Log In
            </a>

            <a
                href="{{ route('register') }}"
                class="btn btn-primary btn-sm"
            >
                Register
            </a>

        @endauth

    </nav>

</div>


</header>

@yield('content')

<footer class="site-footer">
    <div class="container">
        Traitz Academy — Internship Learning Series
    </div>
</footer>

<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
