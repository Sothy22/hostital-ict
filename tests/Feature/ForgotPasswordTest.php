<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    public function test_user_can_request_password_reset_email(): void
    {
        Mail::fake();

        User::query()->delete();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->from('/forgetpass')->post('/forget-password', [
            'email' => $user->email,
        ]);

        $response->assertRedirect('/forgetpass');
        $response->assertSessionHas('status', 'We have e-mailed your password reset link! :)');

        $tokenRecord = DB::table(config('auth.passwords.users.table'))
            ->where('email', $user->email)
            ->first();

        $this->assertNotNull($tokenRecord);
        $this->assertNotEmpty($tokenRecord->token);

        Mail::assertSentCount(1);
    }
}
