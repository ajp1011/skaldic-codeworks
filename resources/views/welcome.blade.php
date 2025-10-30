@extends('layouts.app')

@section('title', 'Welcome - ' . config('app.name'))

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
            <h1 class="company-name">Skaldic Codeworks</h1>
            <div class="accent-line"></div>
            <div id="carved-tagline"></div>
            <div class="auth-button-container">
                @auth
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="nordic-button">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nordic-button">Login</a>
                @endauth
            </div>
        </div>
    </div>
    <div id="app"></div>
@endsection