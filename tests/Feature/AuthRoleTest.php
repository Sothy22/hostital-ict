<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthRoleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        User::query()->delete();
    }

    public function test_admin_user_can_login_and_receive_admin_token(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertOk();
        $response->assertJsonPath('user.role', 'admin');
        $this->assertNotEmpty($response->json('token'));
    }

    public function test_regular_user_can_login_and_receive_user_token(): void
    {
        $user = User::factory()->create([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'role' => 'user',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        $response->assertOk();
        $response->assertJsonPath('user.role', 'user');
        $this->assertNotEmpty($response->json('token'));
    }
}
