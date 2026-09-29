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
}
