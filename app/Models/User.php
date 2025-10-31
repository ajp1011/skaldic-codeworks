<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\{Theme, UserType};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'theme',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'user_type' => UserType::class,
            'theme' => Theme::class,
        ];
    }

    public function isSuperAdministrator(): bool
    {
        return $this->user_type === UserType::SUPER_ADMINISTRATOR;
    }

    public function isAdministrator(): bool
    {
        return $this->user_type === UserType::ADMINISTRATOR;
    }

    public function isUser(): bool
    {
        return $this->user_type === UserType::USER;
    }

    public function isGuest(): bool
    {
        return $this->user_type === UserType::GUEST;
    }

    public function hasAdminPrivileges(): bool
    {
        return in_array(
            $this->user_type,
            [UserType::SUPER_ADMINISTRATOR, UserType::ADMINISTRATOR]
        );
    }

    public function getThemeSlug(): string
    {
        return $this->theme->slug();
    }
}
