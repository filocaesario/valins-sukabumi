<?php

namespace App\Console\Commands;

use App\Mail\WelcomeRegistrationMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestWelcomeMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test-welcome {email? : Alamat email penerima Gmail}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uji pengiriman surat selamat datang resmi SIM VALINS ke alamat Gmail penerima';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $recipient = $this->argument('email') ?: env('MAIL_FROM_ADDRESS') ?: 'filocaesario707@gmail.com';

        $this->info("Menyiapkan pengiriman surat resmi ke: {$recipient}");
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

        $details = [
            'nik' => $user->nik ?: '9812443',
            'emp_type' => 'inhouse',
            'wa_phone' => '+62 811-2009-8800',
            'divisi_label' => 'O&M Jaringan Akses & Fiber',
            'sto_label' => 'Sukabumi Kota (SKB)',
            'role_label' => 'Valins & GPON OLT',
            'homebase' => 'Plaza Telkom Sukabumi',
        ];

        try {
            Mail::to($recipient)->send(new WelcomeRegistrationMail($user, $details));
            $this->info(" Berhasil! Surat verifikasi & ucapan selamat telah terkirim ke: {$recipient}");
            $this->line("Silakan buka aplikasi atau web Google Gmail (https://mail.google.com) untuk memeriksa Kotak Masuk / Inbox.");
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error(" Gagal mengirim email: " . $e->getMessage());
            $this->line("");
            $this->warn("Catatan Solusi:");
            $this->line("1. Pastikan MAIL_MAILER=smtp di file .env");
            $this->line("2. Pastikan MAIL_USERNAME adalah alamat akun Gmail Anda");
            $this->line("3. Pastikan MAIL_PASSWORD menggunakan Sandi Aplikasi Google (App Password 16 karakter), bukan sandi biasa.");
            return Command::FAILURE;
        }
    }
}
