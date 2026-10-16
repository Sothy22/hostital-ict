<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Permission extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'premision';
    protected $fillable = [
        'module',
        'permission_key',
        'description'
    ];

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class, 'permission_id');
    }

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_permissions',
            'permission_id',
            'role_id'
        );
    }
}
