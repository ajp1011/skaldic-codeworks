<?php

declare(strict_types=1);

use App\Actions\Auth\{
    LoginUserAction,
    LogoutUserAction
};
use App\Http\Controllers\Auth\LoginController;

beforeEach(function () {
    $this->loginUserAction = mock(LoginUserAction::class);
    $this->logoutUserAction = mock(LogoutUserAction::class);

    $this->controller = new LoginController(
        $this->loginUserAction,
        $this->logoutUserAction
    );
});

test('controller is instantiated with actions via dependency injection', function () {
    expect($this->controller)->toBeInstanceOf(LoginController::class);
});
