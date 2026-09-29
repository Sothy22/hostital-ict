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
}
