<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'role';
    protected $fillable = [
        'name',
        'description',
        'status'
    ];

     public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class, 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions',
            'role_id',
            'permission_id'
        );
    }
}
