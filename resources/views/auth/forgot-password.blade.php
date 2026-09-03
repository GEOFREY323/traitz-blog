@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<main class="page">
    <div class="container auth-container">

        <div class="auth-card">

            <h1 class="auth-title">
                Forgot Your Password?
            </h1>

            <p class="auth-subtitle">
                Enter your email address and we'll send you a password reset link.
            </p>

            {{-- Session status --}}
            @if (session('status'))
                <div class="flash-message">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Validation errors --}}
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

            <form action="{{ route('password.email') }}" method="POST">

                @csrf

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

                <button
                    type="submit"
                    class="btn btn-primary btn-block"
                >
                    Email Password Reset Link
                </button>

            </form>

            <p class="auth-footer-text">
                Remember your password?

                <a href="{{ route('login') }}">
                    Log in
                </a>
            </p>

        </div>

    </div>
</main>

@endsection