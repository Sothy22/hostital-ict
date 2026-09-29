<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::where('email', 'admin@email.com')->delete();

        Admin::updateOrCreate(
            ['email' => 'admin@email.com'],
            [
                'email' => 'admin@email.com',
                'name' => 'Admin User',
                'password' => bcrypt('12345678'),
                'permissions' => ['create', 'read', 'update', 'delete'],
            ]
        );
    }
}
