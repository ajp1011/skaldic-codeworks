<?php

declare(strict_types=1);

use App\Http\Middleware\ApplyUserTheme;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\{
    Exceptions,
    Middleware
};

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            ApplyUserTheme::class,
        ]);

        $middleware->redirectGuestsTo('/');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
