@extends('layouts.app')

@section('title', 'Register')

@section('content')

<main class="page">
    <div class="container auth-container">

        <div class="auth-card">

            <h1 class="auth-title">
                Create Your Account
            </h1>

            <p class="auth-subtitle">
                Join Traitz Blog to write posts and comment.
            </p>

            {{-- General validation errors --}}
            @if ($errors->any())
                <div class="flash-message">
                    <strong>Please fix the following errors:</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">

                @csrf

                {{-- Name --}}
                <div class="form-group">

                    <label for="name">
                        Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        placeholder="Jane Doe"
                        value="{{ old('name') }}"
                        autofocus
                    >

                    @error('name')
                        <p class="field-error">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


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

                    <p class="form-hint">
                        Must be at least 8 characters.
                    </p>

                    @error('password')
                        <p class="field-error">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Confirm Password --}}
                <div class="form-group">

                    <label for="password_confirmation">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="••••••••"
                    >

                    @error('password_confirmation')
                        <p class="field-error">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <button
                    type="submit"
                    class="btn btn-primary btn-block"
                >
                    Register
                </button>

            </form>


            <p class="auth-footer-text">
                Already have an account?

                <a href="{{ route('login') }}">
                    Log in
                </a>
            </p>

        </div>

    </div>
</main>

@endsection