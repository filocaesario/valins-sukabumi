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
    'nickname',
    'email',
    'email_verified_at',
    'password',
    'nik',
    'emp_type',
    'wa_phone',
    'divisi',
    'homebase',
    'service_start_date',
    'sto',
    'role',
    'supervisor',
    'regu',
    'mfa_method',
    'telegram_id',
    'surat_tugas_path',
    'avatar_path',
    'notification_preferences',
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
            'service_start_date' => 'date',
            'sto' => 'array',
            'notification_preferences' => 'array',
        ];
    }

    /**
     * URL publik foto profil, atau null bila belum diunggah.
     */
    public function avatarUrl(): ?string
    {
        if (empty($this->avatar_path)) {
            return null;
        }

        if (filter_var($this->avatar_path, FILTER_VALIDATE_URL)) {
            return $this->avatar_path;
        }

        $url = asset('storage/' . ltrim($this->avatar_path, '/'));

        if ($this->updated_at) {
            $url .= '?v=' . $this->updated_at->timestamp;
        }

        return $url;
    }

    /**
     * Inisial nama pengguna (2 huruf) untuk avatar fallback.
     */
    public function initials(): string
    {
        $cleanWords = array_values(array_filter(preg_split('/[^A-Za-z0-9]+/', $this->name ?? 'User')));
        if (count($cleanWords) >= 2) {
            $initials = strtoupper(substr($cleanWords[0], 0, 1) . substr($cleanWords[1], 0, 1));
        } elseif (!empty($cleanWords)) {
            $initials = strtoupper(substr($cleanWords[0], 0, 2));
        } else {
            $initials = 'TA';
        }

        if (str_starts_with(strtoupper($this->name ?? ''), 'BINTANG')) {
            $initials = 'BI';
        }

        return $initials;
    }

    /**
     * Preferensi notifikasi dengan nilai bawaan bila belum pernah disimpan.
     *
     * @return array<string, bool>
     */
    public function notificationPreferences(): array
    {
        return array_merge([
            'alert_redaman' => true,
            'dispatch_bot' => true,
            'weekly_audit' => false,
        ], $this->notification_preferences ?? []);
    }

    /**
     * Tanggal mulai kedinasan / tugas operasional, fallback ke created_at atau hari ini.
     */
    public function serviceStartDate(): \Illuminate\Support\Carbon
    {
        if ($this->service_start_date) {
            return \Illuminate\Support\Carbon::parse($this->service_start_date)->locale('id');
        }

        return ($this->created_at ? $this->created_at->copy() : now())->locale('id');
    }

    /**
     * Hitungan durasi masa kerja aktif secara otomatis dan ramah pengguna.
     */
    public function serviceDurationText(): string
    {
        $start = $this->serviceStartDate()->startOfDay();
        $now = now()->locale('id')->startOfDay();

        if ($start->isFuture()) {
            return 'Mulai bertugas ' . $start->translatedFormat('d M Y');
        }

        $diffYears = (int) floor($start->diffInYears($now));
        $diffMonths = ((int) floor($start->diffInMonths($now))) % 12;

        if ($diffYears > 0 && $diffMonths > 0) {
            return "{$diffYears} Tahun {$diffMonths} Bulan Bertugas";
        } elseif ($diffYears > 0) {
            return "{$diffYears} Tahun Bertugas";
        } elseif ($diffMonths > 0) {
            return "{$diffMonths} Bulan Bertugas";
        }

        $diffDays = (int) $start->diffInDays($now);
        if ($diffDays >= 7) {
            $weeks = (int) floor($diffDays / 7);
            return "{$weeks} Minggu Bertugas";
        } elseif ($diffDays > 0) {
            return "{$diffDays} Hari Bertugas";
        }

        return 'Baru mulai bertugas hari ini';
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
