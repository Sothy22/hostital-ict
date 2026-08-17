<?php

namespace App\Models;

use App\Models\PersonalAccessToken;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Auth\User as Authenticatable;

// #[Fillable(['name', 'email', 'password', 'role'])]
// #[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $connection = 'mongodb';

    protected $collection = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
        ];
    }

    public function tokens()
    {
        return $this->hasMany(PersonalAccessToken::class, 'tokenable_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    public function isAccountant(): bool
    {
        return $this->role === 'accountant';
    }

    public function isReceptionist(): bool
    {
        return $this->role === 'receptionist';
    }

    public function isPharmacy(): bool
    {
        return $this->role === 'pharmacy';
    }
}

