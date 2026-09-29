<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class RolePermission extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'rolePermission';
    protected $fillable = [
        'role_id',
        'permission_id',
    ];
}
