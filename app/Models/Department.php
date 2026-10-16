<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Department extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'emergencyContact';
    protected $fillable = [
        'name',
        'description',
        'status',
    ];
    public function staff() {
        return $this->hasMany(User::class, 'department_id');
    }

    public function admin() {
        return $this->hasMany(Admin::class, 'department_id');
    }
}
