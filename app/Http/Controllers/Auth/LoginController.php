<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\{LoginUserAction, LogoutUserAction};
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param LoginUserAction $loginUserAction
     * @param LogoutUserAction $logoutUserAction
     */
    public function __construct(
        private readonly LoginUserAction $loginUserAction,
        private readonly LogoutUserAction $logoutUserAction
    ) {
    }

    /**
     * Display the login view.
     *
     * @return View
     */
    public function show(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $this->loginUserAction->execute(
            $request->only('email', 'password'),
            $request->boolean('remember')
        );

        return redirect()->intended(route('home'));
    }

    /**
     * Destroy an authenticated session.
     *
     * @return RedirectResponse
     */
    public function destroy(): RedirectResponse
    {
        $this->logoutUserAction->execute();

        return redirect()->route('home');
    }
}
