<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ApplyUserTheme
{
    public function handle(Request $request, Closure $next): Response
    {
        $themeSlug = $request->cookie('theme', 'nordic-minimalism');

        View::share('currentTheme', $themeSlug);

        return $next($request);
    }
}
