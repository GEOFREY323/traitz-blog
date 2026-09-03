@extends('layouts.app')

@section('title', 'Log In')

@section('content')

<main class="page">
    <div class="container auth-container">

    <div class="auth-card">

        <h1 class="auth-title">
            Welcome Back
        </h1>

        <p class="auth-subtitle">
            Log in to write posts and join the discussion.
        </p>


        {{-- Session status message --}}
        @if (session('status'))
            <div class="flash-message">
                {{ session('status') }}
            </div>
        @endif


        <form action="{{ route('login') }}" method="POST">

            @csrf


            {{-- Email --}}
            <div class="form-group">

                <label for="email">
                    Email Address
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="you@example.com"
                    value="{{ old('email') }}"
                    autofocus
                >

                @error('email')
                    <p class="field-error">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Password --}}
            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="••••••••"
                >

                @error('password')
                    <p class="field-error">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Remember + Forgot Password --}}
            <div class="auth-row">

                <label class="checkbox-row">

                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        value="1"
                    >

                    <span>
                        Remember me
                    </span>

                </label>


                @if (Route::has('password.request'))

                    <a
                        href="{{ route('password.request') }}"
                        class="auth-link"
                    >
                        Forgot your password?
                    </a>

                @endif

            </div>


            <button
                type="submit"
                class="btn btn-primary btn-block"
            >
                Log In
            </button>

        </form>


        <p class="auth-footer-text">

            Don't have an account?

            <a href="{{ route('register') }}">
                Register
            </a>

        </p>

    </div>

</div>

</main>

@endsection
