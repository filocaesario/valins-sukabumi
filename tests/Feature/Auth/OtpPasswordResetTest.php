<?php

namespace Tests\Feature\Auth;

use App\Mail\OtpResetPasswordMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OtpPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_screen_renders_successfully(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Lupa Kata Sandi Akun?');
    }

    public function test_user_can_request_otp_using_email(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'teknisi.skb@telkomakses.co.id',
            'nik' => '9812443',
        ]);

        $response = $this->post('/forgot-password', [
            'identity' => 'teknisi.skb@telkomakses.co.id',
            'recovery_method' => 'email',
        ]);

        $response->assertRedirect(route('password.otp'));
        $this->assertTrue(session()->has('otp_reset_user_id'));

        Mail::assertSent(OtpResetPasswordMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_user_can_request_otp_using_nik(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'teknisi2@telkomakses.co.id',
            'nik' => '9876543',
        ]);

        $response = $this->post('/forgot-password', [
            'identity' => '9876543',
            'recovery_method' => 'email',
        ]);

        $response->assertRedirect(route('password.otp'));

        Mail::assertSent(OtpResetPasswordMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_otp_verification_screen_renders_successfully(): void
    {
        $user = User::factory()->create();

        $response = $this->withSession([
            'otp_reset_user_id' => $user->id,
            'otp_reset_email' => $user->email,
            'otp_reset_nik' => '9812443',
            'otp_reset_name' => 'Budi Santoso',
        ])->get('/verify-otp');

        $response->assertStatus(200);
        $response->assertSee('Verifikasi OTP');
    }

    public function test_user_can_reset_password_with_valid_otp(): void
    {
        $user = User::factory()->create([
            'email' => 'budi@telkomakses.co.id',
            'password' => Hash::make('OldPassword@123'),
        ]);

        $validOtp = '654321';
        Cache::put("password_otp_user_{$user->id}", [
            'otp' => $validOtp,
            'user_id' => $user->id,
            'email' => $user->email,
            'created_at' => now()->timestamp,
        ], now()->addMinutes(15));

        $response = $this->withSession([
            'otp_reset_user_id' => $user->id,
            'otp_reset_email' => $user->email,
        ])->post('/verify-otp', [
            'otp' => $validOtp,
            'password' => 'NewTelkom@2026',
            'password_confirmation' => 'NewTelkom@2026',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);

        $user->refresh();
        $this->assertTrue(Hash::check('NewTelkom@2026', $user->password));
    }

    public function test_user_cannot_reset_password_with_invalid_otp(): void
    {
        $user = User::factory()->create([
            'email' => 'budi@telkomakses.co.id',
        ]);

        Cache::put("password_otp_user_{$user->id}", [
            'otp' => '111222',
            'user_id' => $user->id,
            'email' => $user->email,
            'created_at' => now()->timestamp,
        ], now()->addMinutes(15));

        $response = $this->withSession([
            'otp_reset_user_id' => $user->id,
            'otp_reset_email' => $user->email,
        ])->from('/verify-otp')->post('/verify-otp', [
            'otp' => '999999', // wrong OTP
            'password' => 'NewTelkom@2026',
            'password_confirmation' => 'NewTelkom@2026',
        ]);

        $response->assertRedirect('/verify-otp');
        $response->assertSessionHasErrors('otp');
        $this->assertGuest();
    }
}
