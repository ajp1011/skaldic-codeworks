@extends('layouts.app')

@section('title', 'Login - ' . config('app.name'))

@push('body-start')
    @if($currentTheme === 'forgecraft')
        <div id="spark-container"></div>
    @else
        <div id="snow-container"></div>
    @endif
@endpush

@section('content')
    <div class="container">
        <div class="card">
            <div class="logo-container">
                <img src="{{ asset('images/skaldic-codeworks-logo-white.png') }}" alt="Skaldic Codeworks Logo">
            </div>
            <h1 class="company-name">Login</h1>
            <div class="accent-line"></div>
            
            <form method="POST" action="{{ route('login.store') }}" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        class="form-input @error('email') input-error @enderror" 
                        required 
                        autofocus
                    >
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        class="form-input @error('password') input-error @enderror" 
                        required
                    >
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group-checkbox">
                    <label for="remember" class="checkbox-label">
                        <input 
                            id="remember" 
                            type="checkbox" 
                            name="remember" 
                            value="1"
                            class="form-checkbox"
                        >
                        <span>Remember me</span>
                    </label>
                </div>
                <div class="form-actions">
                    <button type="submit" class="nordic-button nordic-button-full">
                        Login
                    </button>
                </div>
                <div class="form-footer">
                    <a href="{{ route('home') }}" class="link-secondary">Back to Home</a>
                </div>
            </form>
        </div>
    </div>
    <div id="app"></div>
@endsection

