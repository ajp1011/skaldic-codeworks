<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name', 'Laravel'))</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        @if($currentTheme === 'forgecraft')
            @vite(['resources/css/themes/forgecraft.css', 'resources/js/app.ts'])
        @else
            @vite(['resources/css/themes/nordic-minimalism.css', 'resources/js/app.ts'])
        @endif
        @stack('styles')
    </head>
<body>
    @stack('body-start')
    @if($currentTheme === 'forgecraft')
        <div id="spark-container"></div>
    @else
        <div id="snow-container"></div>
    @endif
    
    <div class="dashboard-layout">
        <aside class="dashboard-sidebar">
            <div class="sidebar-header">
                <div class="logo-container-small">
                    <img src="{{ asset('images/skaldic-codeworks-logo-white.png') }}" alt="Skaldic Codeworks Logo">
                </div>
                <h1 class="sidebar-title">Skaldic Codeworks</h1>
                <div class="accent-line"></div>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" 
                   class="nav-item {{ request()->routeIs('dashboard') ? 'nav-item-active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <p class="user-name">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="user-email">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-button">
                        <svg class="logout-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>
        
        <div class="dashboard-content">
            <header class="content-header">
                <h2 class="page-title">
                    @yield('page-title', 'Dashboard')
                </h2>
            </header>
            
            <main class="main-content">
                @yield('content')
            </main>
            
            <footer class="content-footer">
                <p>&copy; {{ date('Y') }} Skaldic Codeworks, LLC. All rights reserved.</p>
            </footer>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
