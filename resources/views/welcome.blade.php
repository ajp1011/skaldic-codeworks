@extends('layouts.app')

@section('title', 'Welcome - ' . config('app.name'))

@push('body-start')
    <div id="snow-container"></div>
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
        </div>
    </div>
    <div id="app"></div>
@endsection