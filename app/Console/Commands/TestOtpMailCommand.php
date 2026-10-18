<?php

namespace App\Console\Commands;

use App\Mail\OtpResetPasswordMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestOtpMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test-otp {email? : Alamat email penerima Gmail}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uji pengiriman surat kode OTP resmi SIM VALINS ke alamat Gmail penerima';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $recipient = $this->argument('email') ?: env('MAIL_FROM_ADDRESS') ?: 'filocaesario707@gmail.com';

        $this->info("Menyiapkan pengiriman kode OTP resmi ke: {$recipient}");
        $this->line("Mailer aktif: " . config('mail.default'));
        $this->line("SMTP Host   : " . config('mail.mailers.smtp.host'));
        $this->line("SMTP User   : " . (config('mail.mailers.smtp.username') ?: '(belum diset)'));

        $user = User::where('email', $recipient)->first() ?: new User([
            'name' => 'Aqilla Pratama',
            'email' => $recipient,
            'nik' => '9812443',
            'emp_type' => 'inhouse',
            'divisi' => 'om_access',
            'sto' => ['SKB'],
            'role' => 'valins_validator',
            'homebase' => 'Plaza Telkom Sukabumi',
        ]);

        $otp = (string) random_int(100000, 999999);

        try {
            Mail::to($recipient)->send(new OtpResetPasswordMail($user, $otp));
            $this->info(" Berhasil! Surat kode OTP ({$otp}) telah terkirim ke: {$recipient}");
            $this->line("Silakan buka aplikasi atau web Google Gmail (https://mail.google.com) untuk memeriksa Kotak Masuk / Inbox.");
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error(" Gagal mengirim email OTP: " . $e->getMessage());
            $this->line("");
            $this->warn("Catatan Solusi:");
            $this->line("1. Pastikan konfigurasi SMTP di file .env sudah benar");
            $this->line("2. Pastikan port 587/465 tidak diblokir firewall");
            return Command::FAILURE;
        }
    }
}
