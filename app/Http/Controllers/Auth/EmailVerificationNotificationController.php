<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $user = $request->user();
        $stoList = is_array($user->sto) ? $user->sto : (json_decode($user->sto, true) ?: [$user->sto ?: 'SKB']);
        $details = [
            'nik' => $user->nik ?: '9812443',
            'emp_type' => $user->emp_type ?: 'inhouse',
            'wa_phone' => $user->wa_phone ?: '85819537749',
            'divisi_label' => $user->divisi ?: 'Operasi & O&M',
            'sto_label' => 'STO ' . implode(' & ', $stoList),
            'role_label' => $user->role ?: 'Valins & GPON OLT',
            'homebase' => $user->homebase ?: 'Plaza Telkom Sukabumi',
        ];

        try {
            \App\Jobs\SendWelcomeRegistrationMailJob::dispatch($user, $details)->afterResponse();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning("Email dispatch notice: " . $e->getMessage());
        }

        return back()->with('status', 'verification-link-sent');
    }
}
