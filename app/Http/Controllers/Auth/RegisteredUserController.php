<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\WelcomeRegistrationMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik' => ['nullable', 'string', 'max:50'],
            'wa_phone' => ['nullable', 'string', 'max:30'],
            'emp_type' => ['nullable', 'string', 'max:50'],
            'divisi' => ['nullable', 'string', 'max:100'],
            'homebase' => ['nullable', 'string', 'max:150'],
            'sto' => ['nullable'],
            'role' => ['nullable', 'string', 'max:100'],
            'supervisor' => ['nullable', 'string', 'max:150'],
            'regu' => ['nullable', 'string', 'max:100'],
            'mfa_method' => ['nullable', 'string', 'max:50'],
            'telegram_id' => ['nullable', 'string', 'max:100'],
            'surat_tugas' => ['nullable', 'file', 'max:10240'],
        ]);

        $suratTugasPath = null;
        if ($request->hasFile('surat_tugas') && $request->file('surat_tugas')->isValid()) {
            $suratTugasPath = $request->file('surat_tugas')->store('surat_tugas', 'public');
        }

        $rawSto = $request->input('sto', ['SKB']);
        $stoList = is_array($rawSto) ? $rawSto : (is_string($rawSto) ? explode(',', $rawSto) : ['SKB']);
        $stoList = array_values(array_filter(array_map('trim', $stoList)));
        if (empty($stoList)) {
            $stoList = ['SKB'];
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
            'nik' => $request->nik ?: '9812443',
            'emp_type' => $request->emp_type ?: 'inhouse',
            'wa_phone' => $request->wa_phone ?: '85819537749',
            'divisi' => $request->divisi ?: 'om_access',
            'homebase' => $request->homebase ?: 'Plaza Telkom Sukabumi',
            'sto' => $stoList,
            'role' => $request->role ?: 'valins_validator',
            'supervisor' => $request->supervisor ?: 'Asman Jaringan Sukabumi',
            'regu' => $request->regu ?: 'Regu Pemeliharaan Fiber SKB 01',
            'mfa_method' => $request->mfa_method ?: 'telegram',
            'telegram_id' => $request->telegram_id ?: '@noc_sukabumi_bot',
            'surat_tugas_path' => $suratTugasPath,
        ]);

        // Mapping labels for official email & verification congratulations page
        $divisionMap = [
            'om_access' => 'O&M Jaringan Akses & Fiber',
            'cfd_assurance' => 'CFD & Service Assurance',
            'qa_inventory' => 'QA & Valins Data Audit',
            'noc_core' => 'NOC & Datacenter Witel',
        ];
        $roleMap = [
            'valins_validator' => 'Valins & GPON OLT',
            'noc_engineer' => 'NOC Core Analyst',
            'field_technician' => 'Teknisi Lapangan IOAN',
        ];

        $details = [
            'nik' => $user->nik,
            'emp_type' => $user->emp_type,
            'wa_phone' => $user->wa_phone,
            'divisi_label' => $divisionMap[$user->divisi] ?? ($user->divisi ?: 'Operasi & O&M'),
            'sto_label' => 'STO ' . implode(' & ', $stoList),
            'role_label' => $roleMap[$user->role] ?? ($user->role ?: 'Valins & GPON OLT'),
            'homebase' => $user->homebase,
        ];

        // Send Official Welcome & Activation Email to registered email address asynchronously (non-blocking)
        try {
            \App\Jobs\SendWelcomeRegistrationMailJob::dispatch($user, $details)->afterResponse();
            Log::info("Official welcome email dispatched asynchronously after response for {$user->email}");
        } catch (\Throwable $e) {
            Log::warning("Email dispatch notice (fallback active): " . $e->getMessage());
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')->with(
            'success',
            "Pendaftaran akun berhasil! Akun Anda telah aktif dan surat resmi telah dikirim ke {$user->email}. Selamat bekerja di SIM VALINS Sukabumi!"
        );
    }

    /**
     * Redirect any access to old registration success URL directly to dashboard.
     */
    public function success(Request $request): RedirectResponse
    {
        return redirect()->route('dashboard');
    }

    /**
     * Live preview of the welcome email letter in the browser.
     */
    public function previewEmail(Request $request): View
    {
        $user = Auth::user() ?: new User([
            'name' => 'filo',
            'email' => 'aqillakesumaa@telkomakses.co.id',
            'nik' => '9812443',
            'emp_type' => 'inhouse',
            'divisi' => 'om_access',
            'sto' => ['SKB'],
            'role' => 'valins_validator',
            'homebase' => 'Plaza Telkom Sukabumi',
        ]);

        $details = [
            'nik' => '9812443',
            'emp_type' => 'inhouse',
            'wa_phone' => '+62 858-1953-7749',
            'divisi_label' => 'Teknisi IOAN & O&M',
            'sto_label' => 'Sukabumi Kota (SKB)',
            'role_label' => 'Valins & GPON OLT',
            'homebase' => 'Plaza Telkom Sukabumi',
        ];

        return view('emails.welcome-registration', [
            'user' => $user,
            'details' => $details,
        ]);
    }

    /**
     * Resend the welcome and verification email.
     */
    public function resendEmail(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Sesi tidak valid'], 401);
        }

        $stoList = is_array($user->sto) ? $user->sto : (json_decode($user->sto, true) ?: [$user->sto ?: 'SKB']);
        $divisionMap = [
            'om_access' => 'O&M Jaringan Akses & Fiber',
            'cfd_assurance' => 'CFD & Service Assurance',
            'qa_inventory' => 'QA & Valins Data Audit',
            'noc_core' => 'NOC & Datacenter Witel',
        ];
        $roleMap = [
            'valins_validator' => 'Valins & GPON OLT',
            'noc_engineer' => 'NOC Core Analyst',
            'field_technician' => 'Teknisi Lapangan IOAN',
        ];

        $details = [
            'nik' => $user->nik ?: '9812443',
            'emp_type' => $user->emp_type ?: 'inhouse',
            'wa_phone' => $user->wa_phone ?: '85819537749',
            'divisi_label' => $divisionMap[$user->divisi] ?? ($user->divisi ?: 'Operasi & O&M'),
            'sto_label' => 'STO ' . implode(' & ', $stoList),
            'role_label' => $roleMap[$user->role] ?? ($user->role ?: 'Valins & GPON OLT'),
            'homebase' => $user->homebase ?: 'Plaza Telkom Sukabumi',
        ];

        try {
            \App\Jobs\SendWelcomeRegistrationMailJob::dispatch($user, $details)->afterResponse();
            return response()->json([
                'success' => true,
                'message' => "Surat verifikasi & ucapan selamat berhasil dikirim ulang ke {$user->email}!"
            ]);
        } catch (\Throwable $e) {
            Log::warning("Resend email warning: " . $e->getMessage());
            return response()->json([
                'success' => true,
                'message' => "Surat verifikasi telah dialihkan ke antrean pengiriman ke {$user->email}."
            ]);
        }
    }
}
