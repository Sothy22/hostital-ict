<?php

namespace App\Models;

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
        'image',
        'role',
        'permissions',
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
            'permissions' => 'array',
        ];
    }

    // public function tokens()
    // {
    //     return $this->hasMany(PersonalAccessToken::class, 'tokenable_id');
    // }

    public function hasPermission(string $permission): bool{
        return in_array($permission, $this->permissions ?? []);
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

    public function appointment ()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

     public function medical_record () {
        return $this->hasMany(MedicalRecord::class, 'staff_id');
    }

    public function medicalHistory () {
        return $this->hasMany(MedicalHistory::class, 'patient_id');
    }

    public function labTest () {
        return $this->hasMany(LabTest::class, 'staff_id');
    }

    public function vitalSign () {
        return $this->hasMany(VitalSign::class, 'staff_id');
    }
}

