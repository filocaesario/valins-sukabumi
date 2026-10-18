<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'email_verified_at',
    'password',
    'nik',
    'emp_type',
    'wa_phone',
    'divisi',
    'homebase',
    'sto',
    'role',
    'supervisor',
    'regu',
    'mfa_method',
    'telegram_id',
    'surat_tugas_path',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'sto' => 'array',
        ];
    }

    /**
     * Send the password reset notification.
     * Overridden to prevent sending Laravel's default unstyled reset email.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        // Suppress default Laravel notification email.
        // Official emails are dispatched via OtpResetPasswordMail.
    }

    /**
     * Send the email verification notification.
     * Overridden to prevent sending Laravel's default verification email.
     *
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        // Suppress default Laravel verification email.
        // Official welcome & verification email is dispatched via SendWelcomeRegistrationMailJob.
    }
}
