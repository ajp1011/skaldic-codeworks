<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'theme',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'user_type' => UserType::class,
            'theme' => \App\Enums\Theme::class,
        ];
    }

    /**
     * Check if the user is a super administrator.
     *
     * @return bool
     */
    public function isSuperAdministrator(): bool
    {
        return $this->user_type === UserType::SUPER_ADMINISTRATOR;
    }

    /**
     * Check if the user is an administrator.
     *
     * @return bool
     */
    public function isAdministrator(): bool
    {
        return $this->user_type === UserType::ADMINISTRATOR;
    }

    /**
     * Check if the user is a regular user.
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->user_type === UserType::USER;
    }

    /**
     * Check if the user is a guest.
     *
     * @return bool
     */
    public function isGuest(): bool
    {
        return $this->user_type === UserType::GUEST;
    }

    /**
     * Check if the user has admin privileges (super admin or admin).
     *
     * @return bool
     */
    public function hasAdminPrivileges(): bool
    {
        return in_array(
            $this->user_type,
            [UserType::SUPER_ADMINISTRATOR, UserType::ADMINISTRATOR]
        );
    }

    /**
     * Get the theme slug for the user.
     *
     * @return string
     */
    public function getThemeSlug(): string
    {
        return $this->theme->slug();
    }
}
