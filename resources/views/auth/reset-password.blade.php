@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')

<main class="page">
    <div class="container auth-container">

        <div class="auth-card">

            <h1 class="auth-title">
                Reset Your Password
            </h1>

            <p class="auth-subtitle">
                Create a new password for your Traitz Blog account.
            </p>

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

            <form action="{{ route('password.store') }}" method="POST">

                @csrf

                {{-- Password reset token --}}
                <input
                    type="hidden"
                    name="token"
                    value="{{ $request->route('token') }}"
                >

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
                        value="{{ old('email', $request->email) }}"
                        required
                        autofocus
                    >

                    @error('email')
                        <p class="field-error">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- New Password --}}
                <div class="form-group">

                    <label for="password">
                        New Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="••••••••"
                        required
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
                        Confirm New Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="••••••••"
                        required
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
                    Reset Password
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