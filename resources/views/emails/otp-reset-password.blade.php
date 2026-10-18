<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Verifikasi Sandi - PT Telkom Akses Witel Sukabumi</title>
    <style>
        /* Base Reset */
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        body {
            margin: 0;
            padding: 0;
            width: 100% !important;
            height: 100% !important;
            background-color: #f8f9ff;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #0b1c30;
            line-height: 1.5;
        }
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }
        table {
            border-collapse: collapse !important;
        }
        /* Mobile styles */
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: auto !important;
                border-radius: 0 !important;
            }
            .stack-col {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
                margin-bottom: 10px !important;
            }
            .p-mobile {
                padding: 20px 16px !important;
            }
            .mobile-title {
                font-size: 20px !important;
                line-height: 26px !important;
            }
            .otp-digits {
                font-size: 34px !important;
                letter-spacing: 6px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f8f9ff;">
    <!-- Wrapper -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8f9ff;">
        <tr>
            <td align="center" style="padding: 24px 12px 36px 12px;">
                
                <!-- Main Container -->
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" class="email-container" style="max-width: 620px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); border: 1px solid #dce9ff;">
                    
                    <!-- Header Banner -->
                    <tr>
                        <td align="center" style="background-color: #ffffff; padding: 32px 24px 24px 24px; border-bottom: 1px solid #e2e8f0; text-align: center;">
                            <!-- Logo Telkom Akses -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 12px;">
                                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAT21dTkL_Q3-aQEp6yJNTVylV9jyqG3AAbaUDmiXYGb97kbucNre5i45QZFcX5iRscK2vBZLRprDq3ToihtMPidcPKIX5CRBMRRTGRySQJAk0l2qJYq6MKNvUzbr10mWZAjsP5mtO41dAUlIWfjwzIxSu77cxRVYQxyj33Cdi-jEvaU_5qL6Z_jeSZjSlg64uCPeKaP2Rz10MS9rNdx362hHV54J8YkScq4oyoa4BlQoJ8gKrSH_bTT3XzGVfGL0iGhA" 
                                             alt="Telkom Akses Logo" 
                                             width="180" 
                                             style="display: block; max-width: 180px; height: auto;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div style="display: inline-block; background-color: #fee2e2; border: 1px solid #fecaca; border-radius: 9999px; padding: 4px 14px; margin-bottom: 10px;">
                                            <span style="font-size: 11px; font-weight: 700; letter-spacing: 0.08em; color: #bc0007; text-transform: uppercase;">Kode Otorisasi OTP</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                            <h1 class="mobile-title" style="margin: 0 0 6px 0; font-size: 22px; font-weight: 800; color: #0b1c30; letter-spacing: -0.02em; text-transform: uppercase;">
                                MONITORING VALINS &amp; GPON SUKABUMI
                            </h1>
                            <p style="margin: 0; font-size: 13px; font-weight: 600; color: #565e74;">
                                PT Telkom Akses Witel Sukabumi
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td class="p-mobile" style="padding: 32px 32px 24px 32px;">
                            
                            <!-- Greeting -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding-bottom: 16px;">
                                        <h2 style="margin: 0 0 10px 0; font-size: 20px; font-weight: 700; color: #0b1c30;">
                                            Halo, {{ $user->name }}! 👋
                                        </h2>
                                        <p style="margin: 0; font-size: 14px; line-height: 22px; color: #475569;">
                                            Kami menerima permintaan verifikasi untuk pembaruan kata sandi akun Anda pada platform <strong style="color: #0f172a;">Monitoring VALINS &amp; GPON</strong> PT Telkom Akses Witel Sukabumi. Gunakan kode 6-digit OTP resmi di bawah ini untuk mengonfirmasi identitas Anda.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- OTP Box -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border: 1.5px dashed #f87171; border-radius: 12px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(188, 0, 7, 0.04);">
                                <tr>
                                    <td align="center" style="padding: 24px 16px; background: linear-gradient(180deg, #ffffff 0%, #fff8f8 100%); border-radius: 12px;">
                                        <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; color: #991b1b; margin-bottom: 10px;">
                                            🔒 KODE OTORISASI OTP (6 DIGIT)
                                        </div>
                                        <div class="otp-digits" style="font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 42px; font-weight: 800; color: #bc0007; letter-spacing: 10px; line-height: 1.2;">
                                            {{ $otp }}
                                        </div>
                                        <div style="margin-top: 14px; display: inline-block; background-color: #fee2e2; border: 1px solid #fecaca; border-radius: 9999px; padding: 4px 16px;">
                                            <span style="font-size: 11px; font-weight: 700; color: #991b1b;">
                                                ⏱ Berlaku selama 15 menit sejak pesan ini dikirim
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Identitas Penerima Kode Otorisasi Box -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border: 1px solid #dce9ff; border-radius: 12px; margin-bottom: 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.03);">
                                <tr>
                                    <td style="padding: 16px 16px 12px 16px; border-bottom: 1px solid #f1f5f9;">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td align="left">
                                                    <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                                        🪪 Identitas Penerima Kode Otorisasi
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 14px 16px 16px 16px;">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <!-- Col 1: NIK -->
                                                <td class="stack-col" width="25%" valign="top" style="padding-right: 8px;">
                                                    <div style="background-color: #eff4ff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px;">
                                                        <div style="font-size: 10px; color: #64748b; font-weight: 600; text-transform: uppercase;">NIK Karyawan</div>
                                                        <div style="font-size: 13px; font-weight: 700; color: #0f172a; margin-top: 2px; font-family: monospace;">{{ $user->nik ?? '-' }}</div>
                                                    </div>
                                                </td>
                                                <!-- Col 2: Email Terdaftar -->
                                                <td class="stack-col" width="25%" valign="top" style="padding-right: 8px;">
                                                    <div style="background-color: #eff4ff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px;">
                                                        <div style="font-size: 10px; color: #64748b; font-weight: 600; text-transform: uppercase;">Email Terdaftar</div>
                                                        <div style="font-size: 13px; font-weight: 700; color: #0f172a; margin-top: 2px; word-break: break-all;">{{ $user->email }}</div>
                                                    </div>
                                                </td>
                                                <!-- Col 3: Unit Kerja / STO -->
                                                <td class="stack-col" width="25%" valign="top" style="padding-right: 8px;">
                                                    <div style="background-color: #eff4ff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px;">
                                                        <div style="font-size: 10px; color: #64748b; font-weight: 600; text-transform: uppercase;">Unit / STO</div>
                                                        <div style="font-size: 13px; font-weight: 700; color: #0f172a; margin-top: 2px;">{{ is_array($user->sto) ? implode(', ', $user->sto) : ($user->sto ?? ($user->divisi ?? 'Sukabumi Kota (SKB)')) }}</div>
                                                    </div>
                                                </td>
                                                <!-- Col 4: Keperluan Sesi -->
                                                <td class="stack-col" width="25%" valign="top">
                                                    <div style="background-color: #eff4ff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px;">
                                                        <div style="font-size: 10px; color: #64748b; font-weight: 600; text-transform: uppercase;">Keperluan Sesi</div>
                                                        <div style="font-size: 13px; font-weight: 700; color: #bc0007; margin-top: 2px;">Pemulihan Sandi</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Protokol Keamanan Box -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border: 1px solid #dce9ff; border-radius: 12px; margin-bottom: 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.03);">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #0f172a; margin-bottom: 14px;">
                                            🛡 Standar Protokol Keamanan Akun GPON:
                                        </div>
                                        
                                        <!-- Point 1 -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 10px;">
                                            <tr>
                                                <td width="24" valign="top" style="padding-right: 8px;">
                                                    <div style="width: 20px; height: 20px; background-color: #059669; border-radius: 4px; text-align: center; color: #ffffff; font-size: 12px; line-height: 20px; font-weight: bold;">✓</div>
                                                </td>
                                                <td valign="top" style="font-size: 13px; color: #334155; line-height: 19px;">
                                                    <strong>Salin atau ketik kode OTP 6-digit</strong> pada formulir verifikasi browser Anda untuk mengesahkan identitas Anda.
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Point 2 -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 10px;">
                                            <tr>
                                                <td width="24" valign="top" style="padding-right: 8px;">
                                                    <div style="width: 20px; height: 20px; background-color: #059669; border-radius: 4px; text-align: center; color: #ffffff; font-size: 12px; line-height: 20px; font-weight: bold;">✓</div>
                                                </td>
                                                <td valign="top" style="font-size: 13px; color: #334155; line-height: 19px;">
                                                    <strong>Jaga kerahasiaan kredensial:</strong> Tim Helpdesk atau IT Telkom Akses tidak akan pernah meminta kode OTP melalui sambungan telepon maupun pesan pribadi.
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Point 3 -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 10px;">
                                            <tr>
                                                <td width="24" valign="top" style="padding-right: 8px;">
                                                    <div style="width: 20px; height: 20px; background-color: #059669; border-radius: 4px; text-align: center; color: #ffffff; font-size: 12px; line-height: 20px; font-weight: bold;">✓</div>
                                                </td>
                                                <td valign="top" style="font-size: 13px; color: #334155; line-height: 19px;">
                                                    <strong>Masa berlaku 15 menit:</strong> Kode berlaku terbatas dan hanya dapat dipergunakan 1 (satu) kali transaksi verifikasi.
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Point 4 -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="24" valign="top" style="padding-right: 8px;">
                                                    <div style="width: 20px; height: 20px; background-color: #dc2626; border-radius: 4px; text-align: center; color: #ffffff; font-size: 12px; line-height: 20px; font-weight: bold;">!</div>
                                                </td>
                                                <td valign="top" style="font-size: 13px; color: #334155; line-height: 19px;">
                                                    <strong>Bukan Anda yang meminta?</strong> Segera abaikan email ini dan laporkan indikasi akses tidak sah ke Hotline NOC Sukabumi.
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button: Verifikasi OTP Sekarang -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('password.otp', ['email' => $user->email]) }}" target="_blank" 
                                           style="display: block; width: 100%; box-sizing: border-box; background-color: #bc0007; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 700; text-align: center; padding: 14px 24px; border-radius: 10px; box-shadow: 0 4px 12px rgba(188, 0, 7, 0.3);">
                                            Verifikasi Kode OTP Sekarang ➔
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Hotline Assistance Box -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; margin-bottom: 12px;">
                                <tr>
                                    <td class="p-mobile" style="padding: 12px 16px;">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td class="stack-col" align="left" style="font-size: 12px; color: #475569;">
                                                    <strong>Butuh bantuan verifikasi akun?</strong><br>
                                                    Dispatcher NOC Telkom Sukabumi siap siaga 24/7
                                                </td>
                                                <td class="stack-col" align="right">
                                                    <a href="https://wa.me/6285819537749" target="_blank" style="display: inline-block; color: #0284c7; text-decoration: none; font-size: 12px; font-weight: 700; background-color: #e0f2fe; padding: 6px 12px; border-radius: 6px;">
                                                        💬 WhatsApp: +62 858-1953-7749
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Footer Notice -->
                    <tr>
                        <td align="center" style="background-color: #f8fafc; padding: 20px 24px; border-top: 1px solid #e2e8f0; text-align: center;">
                            <p style="margin: 0 0 4px 0; font-size: 12px; font-weight: 700; color: #334155;">
                                PT TELKOM AKSES WITEL SUKABUMI
                            </p>
                            <p style="margin: 0 0 6px 0; font-size: 11px; color: #64748b; font-weight: 500;">
                                Operasi Jaringan Optik VALINS &amp; Monitoring GPON OLT • Sukabumi
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #94a3b8; line-height: 16px;">
                                Email &amp; notifikasi ini dikirim otomatis oleh Sistem Keamanan Terpadu MONITORING VALINS &amp; GPON.<br>
                                Helpdesk NOC Sukabumi: (0266) 221100 • Mohon tidak membalas email ini secara manual.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- End Main Container -->

            </td>
        </tr>
    </table>
</body>
</html>
