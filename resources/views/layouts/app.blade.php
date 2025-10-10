<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.ts'])
        
        @stack('styles')
    </head>
<body>
    @stack('body-start')
    
    @yield('content')

    @stack('scripts')
</body>
</html>
