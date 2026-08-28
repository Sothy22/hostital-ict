<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'email' => 'admin@email.com',
                'name' => 'Admin User',
                'password' => bcrypt('12345678'),
                'role' => 'admin',
                'permissions' => ['create', 'read', 'update', 'delete'],
            ]
        );
    }
}
