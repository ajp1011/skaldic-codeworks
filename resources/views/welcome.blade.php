<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles / Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.ts'])
    </head>
<body>
    <div class="container">
        <div class="card">
            <!-- Company Logo -->
            <div class="logo-container">
                <img src="{{ asset('images/skaldic-codeworks-logo-white.png') }}" alt="Skaldic Codeworks Logo">
                </div>

            <!-- Company Name -->
            <h1 class="company-name">Skaldic Codeworks</h1>

            <!-- Accent Line -->
            <div class="accent-line"></div>

            <!-- Company Tagline -->
            <p class="tagline">At Skaldic Codeworks, we turn ideas into secure, scalable web applications, guiding clients from concept to completion through clear communication, thoughtful architecture, and expert craftsmanship. If you have a story to tell, we can bring it to life.</p>
        </div>
    </div>

        <!-- Vue.js App -->
        <div id="app"></div>
    </body>
</html>