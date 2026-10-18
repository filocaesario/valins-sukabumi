<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Telkom Akses Sukabumi</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- Fonts: Inter, JetBrains Mono, Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Scripts & Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --telkom-red: #bc0007;
            --telkom-red-dark: #960005;
            --telkom-red-light: #ffe5e2;
            --cyber-dark: #0a101f;
            --cyber-card: #131f37;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f6f8fc;
            color: #0b1c30;
        }

        /* Slim Minimalist Scrollbar for Custom Dropdowns */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .font-headline {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-telemetry {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Ambient Floating Glow Animation */
        @keyframes floatMesh {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -25px) scale(1.08); }
            66% { transform: translate(-25px, 20px) scale(0.94); }
        }

        .animate-ambient-1 {
            animation: floatMesh 16s ease-in-out infinite;
        }
        .animate-ambient-2 {
            animation: floatMesh 20s ease-in-out infinite reverse;
        }

        /* Optical Signal Pulse along SVG Lines */
        @keyframes opticalPulse {
            0% { stroke-dashoffset: 80; opacity: 0.2; }
            50% { opacity: 1; }
            100% { stroke-dashoffset: 0; opacity: 0.2; }
        }
        .optical-line {
            stroke-dasharray: 8 6;
            animation: opticalPulse 2.8s linear infinite;
        }

        /* Radar Sonar Ping Animation */
        @keyframes sonarPing {
            0% { transform: scale(1); opacity: 0.9; }
            50% { transform: scale(2.2); opacity: 0.3; }
            100% { transform: scale(3.2); opacity: 0; }
        }
        .sonar-ping {
            animation: sonarPing 2.4s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        /* Shimmer Sheen for Action Buttons */
        @keyframes sheenPass {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
        .hover-sheen {
            position: relative;
            overflow: hidden;
        }
        .hover-sheen::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: translateX(-100%);
        }
        .hover-sheen:hover::after {
            animation: sheenPass 0.9s infinite;
        }

        /* Drag & Drop Pulse */
        @keyframes dropzoneGlow {
            0%, 100% { border-color: #bc0007; box-shadow: 0 0 0 4px rgba(188, 0, 7, 0.12); }
            50% { border-color: #e2241d; box-shadow: 0 0 0 8px rgba(188, 0, 7, 0.25); }
        }
        .drag-active {
            animation: dropzoneGlow 1.5s ease-in-out infinite;
        }

        /* Clean Elegant Telkom Red Progress Stream */
        @keyframes telkomFlowSubtle {
            0% {
                background-position: 0% 50%;
                box-shadow: 0 1px 4px rgba(188, 0, 7, 0.25);
            }
            50% {
                background-position: 100% 50%;
                box-shadow: 0 1px 7px rgba(226, 36, 29, 0.4);
            }
            100% {
                background-position: 0% 50%;
                box-shadow: 0 1px 4px rgba(188, 0, 7, 0.25);
            }
        }
        .progress-line-telkom {
            background: linear-gradient(90deg, #960005 0%, #b80007 35%, #d91b22 65%, #b80007 100%);
            background-size: 200% 100%;
            animation: telkomFlowSubtle 4.5s ease-in-out infinite;
            will-change: background-position, box-shadow;
        }

        /* Clean Elegant Emerald Final Progress Stream */
        @keyframes emeraldFlowSubtle {
            0% {
                background-position: 0% 50%;
                box-shadow: 0 1px 4px rgba(16, 185, 129, 0.25);
            }
            50% {
                background-position: 100% 50%;
                box-shadow: 0 1px 7px rgba(5, 150, 105, 0.4);
            }
            100% {
                background-position: 0% 50%;
                box-shadow: 0 1px 4px rgba(16, 185, 129, 0.25);
            }
        }
        .progress-line-emerald {
            background: linear-gradient(90deg, #047857 0%, #059669 35%, #10b981 65%, #059669 100%);
            background-size: 200% 100%;
            animation: emeraldFlowSubtle 4.5s ease-in-out infinite;
            will-change: background-position, box-shadow;
        }

        /* Subtle Silky Sheen Sweep */
        @keyframes subtleSheenSweep {
            0% {
                transform: translateX(-150%) skewX(-20deg);
                opacity: 0;
            }
            15% {
                opacity: 0.55;
            }
            75% {
                opacity: 0.55;
            }
            100% {
                transform: translateX(250%) skewX(-20deg);
                opacity: 0;
            }
        }
        .line-subtle-sheen {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 45%;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.05) 20%, 
                rgba(255, 255, 255, 0.4) 50%, 
                rgba(255, 255, 255, 0.05) 80%, 
                transparent 100%);
            animation: subtleSheenSweep 3.2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            pointer-events: none;
            will-change: transform, opacity;
        }

        /* Fluid Organic Breathing Aura for Active Step Badge */
        @keyframes softAuraPulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 2px 8px rgba(188, 0, 7, 0.35), 0 0 0 3px rgba(188, 0, 7, 0.15);
            }
            50% {
                transform: scale(1.04);
                box-shadow: 0 4px 14px rgba(188, 0, 7, 0.45), 0 0 0 7px rgba(188, 0, 7, 0.08);
            }
        }
        .step-active-aura {
            animation: softAuraPulse 2.8s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            will-change: transform, box-shadow;
        }

        /* Refined Sonar Ping on Alur Header */
        @keyframes headerRadar {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            70% {
                transform: scale(2.4);
                opacity: 0;
            }
            100% {
                transform: scale(2.4);
                opacity: 0;
            }
        }
        .header-radar-ring {
            animation: headerRadar 2.4s cubic-bezier(0, 0.2, 0.8, 1) infinite;
        }

        /* Multi-Step Smooth Fluid Directional Slide Transitions */
        @keyframes stepSlideInForward {
            0% {
                opacity: 0;
                transform: translate3d(24px, 0, 0);
                filter: blur(2px);
            }
            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0);
                filter: blur(0px);
            }
        }

        @keyframes stepSlideInBackward {
            0% {
                opacity: 0;
                transform: translate3d(-24px, 0, 0);
                filter: blur(2px);
            }
            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0);
                filter: blur(0px);
            }
        }

        .step-pane-forward {
            animation: stepSlideInForward 0.45s cubic-bezier(0.16, 1, 0.3, 1) both;
            will-change: transform, opacity, filter;
        }

        .step-pane-backward {
            animation: stepSlideInBackward 0.45s cubic-bezier(0.16, 1, 0.3, 1) both;
            will-change: transform, opacity, filter;
        }

        /* Enterprise Header Navbar CTA Glow */
        @keyframes pulseGlowRed {
            0%, 100% { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
            50% { box-shadow: 0 4px 16px -2px rgba(188, 0, 7, 0.35); }
        }
        .header-cta-pulse {
            animation: pulseGlowRed 3.5s ease-in-out infinite;
        }

        /* Natural Partner Logo Interaction: Smooth, fluid, no clipping/overflow bug */
        .partner-logo-item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.35rem 0.5rem;
            opacity: 0.85;
            cursor: pointer;
            overflow: visible;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            will-change: transform, opacity;
            transition: transform 0.28s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.25s ease;
        }
        .partner-logo-item:hover {
            transform: translate3d(0, -4px, 0) scale(1.06);
            opacity: 1;
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease;
        }
        .partner-logo-item:active {
            transform: translate3d(0, -1px, 0) scale(1.01);
            transition: transform 0.1s ease;
        }
        .partner-logo-item img {
            pointer-events: none;
            user-select: none;
            -webkit-user-drag: none;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.04));
        }

        /* Official Instagram Brand Theme & Hover Interaction */
        .btn-instagram-bg {
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        }
        .btn-instagram:hover {
            border-color: transparent !important;
            box-shadow: 0 4px 14px -1px rgba(214, 36, 159, 0.45), 0 2px 6px -1px rgba(253, 89, 73, 0.3) !important;
        }
    </style>

    <!-- Alpine.js Registration Component Definition -->
    <script>
        function registrationWizard() {
            return {
                step: {{ $errors->has('password') || $errors->has('password_confirmation') ? 3 : ($errors->any() ? 1 : 1) }},
                stepDirection: 'forward',
                empType: 'inhouse',
                fullName: @json(old('name', '')),
                empId: @json(old('nik', '')),
                email: @json(old('email', '')),
                waPhone: @json(old('wa_phone', '')),
                division: @json(old('divisi', '')),
                homebase: @json(old('homebase', '')),
                selectedStos: @json(old('sto', ['SKB'])),
                supervisor: @json(old('supervisor', '')),
                regu: @json(old('regu', '')),
                role: @json(old('role', 'valins_validator')),

                /* Dropdown Options Data */
                divisions: [
                    {
                        val: 'Operation & Maintenance (O&M) Sukabumi',
                        title: 'Operation & Maintenance (O&M)',
                        badge: 'O&M',
                        desc: 'Pemeliharaan perangkat & monitoring GPON Sukabumi'
                    },
                    {
                        val: 'Construction & Fiber Deployment (CFD)',
                        title: 'Construction & Fiber Deployment (CFD)',
                        badge: 'CFD',
                        desc: 'Penggelaran kabel optik, feeder, & penarikan ODP'
                    },
                    {
                        val: 'Quality Assurance & Inventory Audit',
                        title: 'Quality Assurance & Inventory Audit',
                        badge: 'QA & AUDIT',
                        desc: 'Audit redaman optik & standarisasi validasi VALINS'
                    },
                    {
                        val: 'Network Operations Center (NOC) Core',
                        title: 'Network Operations Center (NOC) Core',
                        badge: 'NOC CORE',
                        desc: 'Pusat komando jaringan Metro & Backbone Witel'
                    }
                ],

                homebases: [
                    {
                        val: 'Telkom Akses Sukabumi - Jl. R.E. Martadinata No. 24, Gunungparang, Kecamatan Cikole, Kota Sukabumi, Jawa Barat.',
                        title: 'Telkom Akses Sukabumi (Kantor Witel)',
                        badge: 'KOTA',
                        desc: 'Jl. R.E. Martadinata No. 24, Gunungparang, Cikole, Sukabumi'
                    },
                    {
                        val: 'Plasa Telkom Cibadak - Jl. Suryakencana No.123, Cibadak, Kec. Cibadak, Kabupaten Sukabumi',
                        title: 'Plasa Telkom Cibadak',
                        badge: 'CIBADAK',
                        desc: 'Jl. Suryakencana No. 123, Cibadak, Kab. Sukabumi'
                    },
                    {
                        val: 'Kantor Sentral Cicurug - Jl. Siliwangi',
                        title: 'Kantor Sentral Cicurug',
                        badge: 'CICURUG',
                        desc: 'Jl. Siliwangi, Sentral Telepon Cicurug, Sukabumi'
                    },
                    {
                        val: 'Sub-Unit Palabuhanratu - Komplek Perkantoran',
                        title: 'Sub-Unit Palabuhanratu',
                        badge: 'PELABUHAN',
                        desc: 'Komplek Perkantoran Pemda, Palabuhanratu, Sukabumi'
                    }
                ],

                regus: [
                    {
                        val: 'Regu Daman 03 - Jalur Feeder Lingkar Selatan',
                        title: 'Regu Helpdesk DAMAN Sukabumi',
                        badge: 'DAMAN',
                        desc: 'Jalur Feeder Lingkar Selatan & Pengawasan Tiket'
                    },
                    {
                        val: 'Regu Patroli ODC 01 - Sukabumi Utara',
                        title: 'Regu Patroli ODC 01',
                        badge: 'PATROLI',
                        desc: 'Inspeksi Fisik ODC/ODP Jalur Distribusi Utara'
                    },
                    {
                        val: 'Regu Audit Validasi Valins Khusus Fiber 02',
                        title: 'Regu Audit Validasi Valins Fiber 02',
                        badge: 'AUDIT',
                        desc: 'Verifikasi Akurasi BAST & Validasi QR Port Lapangan'
                    },
                    {
                        val: 'Regu Emergency Restoration Team (ERT) Witel',
                        title: 'Regu Emergency Restoration Team (ERT)',
                        badge: 'ERT',
                        desc: 'Siaga Cepat Kabel Putus Feeder & Force Majeure'
                    }
                ],

                getDivisionLabel() {
                    const item = this.divisions.find(d => d.val === this.division);
                    return item ? item.title : (this.division || '');
                },
                getDivisionDesc() {
                    const item = this.divisions.find(d => d.val === this.division);
                    return item ? item.desc : '';
                },
                getDivisionBadge() {
                    const item = this.divisions.find(d => d.val === this.division);
                    return item ? item.badge : 'DIVISI';
                },

                getHomebaseLabel() {
                    const item = this.homebases.find(h => h.val === this.homebase);
                    return item ? item.title : (this.homebase || '');
                },
                getHomebaseDesc() {
                    const item = this.homebases.find(h => h.val === this.homebase);
                    return item ? item.desc : '';
                },
                getHomebaseBadge() {
                    const item = this.homebases.find(h => h.val === this.homebase);
                    return item ? item.badge : 'POSKO';
                },

                getReguLabel() {
                    const item = this.regus.find(r => r.val === this.regu);
                    return item ? item.title : (this.regu || '');
                },
                getReguDesc() {
                    const item = this.regus.find(r => r.val === this.regu);
                    return item ? item.desc : '';
                },
                getReguBadge() {
                    const item = this.regus.find(r => r.val === this.regu);
                    return item ? item.badge : 'REGU';
                },
                
                /* Real Upload System & State */
                uploadedFile: null,
                isUploading: false,
                uploadProgress: 0,
                isDragging: false,
                previewModalOpen: false,

                /* Security & Kredensial */
                password: '',
                passwordConfirmation: '',
                showPassword: false,
                showConfirmPassword: false,
                mfaMethod: 'telegram',
                telegramId: @json(old('telegram_id', '')),
                pingTesting: false,
                pingSuccess: false,
                pingStatusText: 'Belum ditest',
                pingLatency: 0,
                agreeIntegrity: false,
                agreeBroadcast: false,
                isSubmitting: false,
                
                /* Password Strength & Entropy */
                passStrength: 0,
                passLabel: 'Belum diisi',
                hasMinLength: false,
                hasUpper: false,
                hasNumber: false,
                hasSymbol: false,
                passwordsMatch: false,
                
                /* Toast Notification */
                toast: { show: false, title: '', message: '', type: 'error' },
                opticalDbm: -18.4,
                
                /* 2FA Live Message Test State */
                testMessageData: null,
                tokenCopied: false,
                isDelivered: false,

                /* Simulated Incoming Push Notification State (Telegram & WhatsApp) */
                incomingNotification: {
                    show: false,
                    channel: 'telegram',
                    title: '',
                    sender: '',
                    token: '',
                    message: '',
                    timeoutId: null
                },

                init() {
                    this.updatePassStrength();
                    this.$watch('empId', (val) => {
                        if (val && /[^0-9\-]/.test(val)) {
                            this.empId = val.replace(/[^0-9\-]/g, '');
                        }
                    });
                    this.$watch('waPhone', (val) => {
                        if (val && /[^0-9]/.test(val)) {
                            this.waPhone = val.replace(/[^0-9]/g, '');
                        }
                        if (this.mfaMethod === 'whatsapp' && this.testMessageData) {
                            const clean = (this.waPhone || '').replace(/^0/, '');
                            const displayRecipient = clean ? `+62 ${clean} (Anda / Message Yourself)` : 'Nomor Anda (Message Yourself)';
                            this.testMessageData.recipient = displayRecipient;
                            this.testMessageData.rawRecipient = clean ? `+62 ${clean}` : 'Message Yourself';
                        }
                    });
                    this.$watch('telegramId', (val) => {
                        if (this.mfaMethod === 'telegram' && this.testMessageData) {
                            const clean = (val || '').replace(/^@/, '').trim();
                            const displayRecipient = clean ? `@${clean} (Saved Messages)` : 'Saved Messages (Akun Anda)';
                            this.testMessageData.recipient = displayRecipient;
                            this.testMessageData.rawRecipient = clean ? `@${clean}` : 'Saved Messages';
                        }
                    });
                    this.$watch('mfaMethod', (newMethod) => {
                        this.ensureDirectMessage(newMethod, false);
                    });
                    
                    // Directly prepare initial 2FA message to Saved Messages / Message Yourself
                    this.ensureDirectMessage(this.mfaMethod, false);

                    setInterval(() => {
                        this.opticalDbm = ( -18.4 + (Math.random() * 0.4 - 0.2) ).toFixed(1);
                    }, 3500);
                },

                triggerToast(title, message, type = 'error') {
                    this.toast.title = title;
                    this.toast.message = message;
                    this.toast.type = type;
                    this.toast.show = true;
                    setTimeout(() => { this.toast.show = false; }, 4500);
                },

                updateEmpType(type) {
                    this.empType = type;
                },

                /* Strict WhatsApp Input: Only numbers (0-9) permitted */
                handleWaKeydown(e) {
                    const allowedKeys = [
                        'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown',
                        'Tab', 'Enter', 'Home', 'End', 'Escape'
                    ];
                    if (allowedKeys.includes(e.key) || e.ctrlKey || e.metaKey || e.altKey) {
                        return;
                    }
                    if (/^[0-9]$/.test(e.key)) {
                        return;
                    }
                    e.preventDefault();
                    this.triggerToast('Karakter Ditolak', 'Hanya variabel angka (0-9) yang diizinkan untuk Nomor WhatsApp.', 'warning');
                },

                handleWaBeforeInput(e) {
                    if (e.data && !/^[0-9]+$/.test(e.data)) {
                        e.preventDefault();
                        this.triggerToast('Karakter Ditolak', 'Hanya variabel angka (0-9) yang diizinkan untuk Nomor WhatsApp.', 'warning');
                    }
                },

                handleWaInput(e) {
                    const original = e.target.value;
                    const sanitized = original.replace(/[^0-9]/g, '');
                    if (original !== sanitized) {
                        e.target.value = sanitized;
                        this.triggerToast('Karakter Ditolak', 'Karakter selain angka (0-9) otomatis dibersihkan.', 'warning');
                    }
                    this.waPhone = sanitized;
                },

                handleWaPaste(e) {
                    e.preventDefault();
                    const pasted = (e.clipboardData || window.clipboardData).getData('text') || '';
                    const sanitized = pasted.replace(/[^0-9]/g, '');
                    if (sanitized !== pasted) {
                        this.triggerToast('Karakter Ditolak', 'Karakter selain angka pada clipboard otomatis dibersihkan.', 'warning');
                    }
                    const input = e.target;
                    const start = input.selectionStart || 0;
                    const end = input.selectionEnd || 0;
                    const current = input.value || '';
                    const nextVal = current.substring(0, start) + sanitized + current.substring(end);
                    input.value = nextVal;
                    this.waPhone = nextVal;
                    this.$nextTick(() => {
                        input.setSelectionRange(start + sanitized.length, start + sanitized.length);
                    });
                },

                /* Strict NIK Filtering: Only numbers (0-9) and hyphen (-) permitted */
                handleNikKeydown(e) {
                    // Allowed navigation, functional & edit keys
                    const allowedKeys = [
                        'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown',
                        'Tab', 'Enter', 'Home', 'End', 'Escape'
                    ];
                    if (allowedKeys.includes(e.key) || e.ctrlKey || e.metaKey || e.altKey) {
                        return;
                    }
                    // Allow numeric characters 0-9 and hyphen/minus
                    if (/^[0-9\-]$/.test(e.key)) {
                        return;
                    }
                    // Block all alphabet characters, spaces, and special symbols immediately
                    e.preventDefault();
                    this.triggerToast('Karakter Ditolak', 'Hanya angka (0-9) dan tanda strip (-) yang diizinkan untuk NIK.', 'warning');
                },

                handleNikBeforeInput(e) {
                    if (e.data && !/^[0-9\-]+$/.test(e.data)) {
                        e.preventDefault();
                        this.triggerToast('Karakter Ditolak', 'Hanya angka (0-9) dan tanda strip (-) yang diizinkan untuk NIK.', 'warning');
                    }
                },

                handleNikInput(e) {
                    const original = e.target.value;
                    const sanitized = original.replace(/[^0-9\-]/g, '');
                    if (original !== sanitized) {
                        e.target.value = sanitized;
                        this.triggerToast('Karakter Ditolak', 'Hanya angka (0-9) dan tanda strip (-) yang diizinkan untuk NIK.', 'warning');
                    }
                    this.empId = sanitized;
                },

                handleNikPaste(e) {
                    e.preventDefault();
                    const pasted = (e.clipboardData || window.clipboardData).getData('text') || '';
                    const sanitized = pasted.replace(/[^0-9\-]/g, '');
                    if (sanitized !== pasted) {
                        this.triggerToast('Karakter Ditolak', 'Karakter selain angka dan strip dari clipboard otomatis dibersihkan.', 'warning');
                    }
                    const input = e.target;
                    const start = input.selectionStart || 0;
                    const end = input.selectionEnd || 0;
                    const current = input.value || '';
                    const nextVal = current.substring(0, start) + sanitized + current.substring(end);
                    input.value = nextVal;
                    this.empId = nextVal;
                    this.$nextTick(() => {
                        input.setSelectionRange(start + sanitized.length, start + sanitized.length);
                    });
                },

                /* Alias for backward compatibility */
                filterNik(event) {
                    this.handleNikInput(event);
                },

                /* Dynamic role permissions check */
                isPermissionGranted(permKey) {
                    if (this.role === 'noc_engineer') {
                        return ['uim_sap', 'gis_topology', 'olt_command'].includes(permKey);
                    } else if (this.role === 'valins_services') {
                        return ['uim_sap', 'valins_mobile', 'gis_topology', 'ticket_ops'].includes(permKey);
                    } else { // valins_validator (default)
                        return ['uim_sap', 'valins_mobile', 'gis_topology'].includes(permKey);
                    }
                },

                /* Real File Upload Handler */
                handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.processFile(file);
                    }
                },

                handleFileDrop(event) {
                    this.isDragging = false;
                    if (event.dataTransfer && event.dataTransfer.files.length > 0) {
                        const file = event.dataTransfer.files[0];
                        this.processFile(file);
                    }
                },

                processFile(file) {
                    // Validasi Ukuran (Max 5MB = 5 * 1024 * 1024 bytes)
                    if (file.size > 5 * 1024 * 1024) {
                        this.triggerToast('Ukuran Terlalu Besar', 'Maksimal ukuran dokumen adalah 5 MB.', 'error');
                        return;
                    }
                    const ext = file.name.split('.').pop().toLowerCase();
                    if (!['pdf', 'jpg', 'jpeg', 'png'].includes(ext)) {
                        this.triggerToast('Format Tidak Didukung', 'Hanya format PDF, JPG, atau PNG yang diperbolehkan.', 'error');
                        return;
                    }

                    // Clean previous preview URL if any
                    if (this.uploadedFile && this.uploadedFile.previewUrl && this.uploadedFile.previewUrl.startsWith('blob:')) {
                        URL.revokeObjectURL(this.uploadedFile.previewUrl);
                    }

                    this.isUploading = true;
                    this.uploadProgress = 10;
                    
                    let previewUrl = null;
                    if (['jpg', 'jpeg', 'png'].includes(ext)) {
                        previewUrl = URL.createObjectURL(file);
                    }

                    // Sync file to real hidden form input
                    const formInput = document.getElementById('suratTugasFormInput');
                    if (formInput && typeof DataTransfer !== 'undefined') {
                        try {
                            const dt = new DataTransfer();
                            dt.items.add(file);
                            formInput.files = dt.files;
                        } catch (e) {
                            console.warn('DataTransfer not fully supported:', e);
                        }
                    }

                    // Smooth simulated progressive upload bar
                    let progress = 15;
                    const progressInterval = setInterval(() => {
                        progress += Math.floor(Math.random() * 20) + 15;
                        if (progress >= 100) {
                            progress = 100;
                            clearInterval(progressInterval);
                            this.uploadProgress = 100;
                            setTimeout(() => {
                                this.isUploading = false;
                                this.uploadedFile = {
                                    name: file.name,
                                    size: this.formatFileSize(file.size),
                                    type: ext === 'pdf' ? 'pdf' : 'image',
                                    extension: ext.toUpperCase(),
                                    previewUrl: previewUrl,
                                    rawSize: file.size
                                };
                                this.triggerToast('Dokumen Siap', `Berkas ${file.name} berhasil dimuat & diverifikasi.`, 'success');
                            }, 200);
                        } else {
                            this.uploadProgress = progress;
                        }
                    }, 70);
                },

                removeFile() {
                    if (this.uploadedFile && this.uploadedFile.previewUrl && this.uploadedFile.previewUrl.startsWith('blob:')) {
                        URL.revokeObjectURL(this.uploadedFile.previewUrl);
                    }
                    this.uploadedFile = null;
                    this.uploadProgress = 0;
                    this.previewModalOpen = false;
                    const input1 = document.getElementById('suratTugasInput');
                    if (input1) input1.value = '';
                    const input2 = document.getElementById('suratTugasFormInput');
                    if (input2) input2.value = '';
                    this.triggerToast('Berkas Dihapus', 'Lampiran surat tugas telah dibatalkan.', 'warning');
                },

                formatFileSize(bytes) {
                    if (!bytes) return '0 B';
                    if (bytes < 1024) return bytes + ' B';
                    else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                    else return (bytes / 1048576).toFixed(1) + ' MB';
                },

                /* Sound alert synthesized via Web Audio API */
                playNotificationTone() {
                    try {
                        const AudioContext = window.AudioContext || window.webkitAudioContext;
                        if (!AudioContext) return;
                        const ctx = new AudioContext();
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(587.33, ctx.currentTime); // D5
                        osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.1); // A5
                        gain.gain.setValueAtTime(0.2, ctx.currentTime);
                        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.35);
                        osc.connect(gain);
                        gain.connect(ctx.destination);
                        osc.start();
                        osc.stop(ctx.currentTime + 0.35);
                    } catch (e) {
                        // ignore if audio blocked
                    }
                },

                showIncomingAlert(channel, token, sender, message) {
                    if (this.incomingNotification.timeoutId) {
                        clearTimeout(this.incomingNotification.timeoutId);
                    }
                    this.incomingNotification = {
                        show: true,
                        channel: channel,
                        title: channel === 'whatsapp' ? 'WhatsApp • Message yourself' : 'Telegram • Saved Messages',
                        sender: sender,
                        token: token,
                        message: message,
                        timeoutId: setTimeout(() => {
                            this.incomingNotification.show = false;
                        }, 9000)
                    };
                },

                /* Direct Delivery 2FA Core: Auto-delivers to Saved Messages / Message Yourself */
                ensureDirectMessage(method = null, showToast = false) {
                    const activeMethod = method || this.mfaMethod || 'telegram';
                    const randCode = Math.floor(100000 + Math.random() * 900000).toString();
                    const token = randCode.substring(0, 3) + '-' + randCode.substring(3);
                    const now = new Date();
                    const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB';
                    this.isDelivered = false;

                    if (activeMethod === 'telegram') {
                        let cleanHandle = (this.telegramId || '').replace(/^@/, '').trim();
                        if (!cleanHandle) {
                            if (this.fullName && this.fullName.trim()) {
                                cleanHandle = this.fullName.toLowerCase().replace(/[^a-z0-9]/g, '_').substring(0, 15);
                            } else {
                                cleanHandle = '';
                            }
                        }
                        const latency = Math.floor(Math.random() * 10) + 16; // 16 - 25ms
                        this.pingTesting = false;
                        this.pingSuccess = true;
                        this.pingLatency = latency;
                        this.pingStatusText = `Token Siap (${latency}ms)`;

                        const displayRecipient = cleanHandle ? `@${cleanHandle} (Saved Messages)` : 'Saved Messages (Akun Anda)';
                        const rawRecipient = cleanHandle ? `@${cleanHandle}` : 'Saved Messages';

                        this.testMessageData = {
                            channel: 'telegram',
                            title: 'Saved Messages (Pesan Tersimpan)',
                            botUsername: 'Telegram Cloud Direct',
                            recipient: displayRecipient,
                            rawRecipient: rawRecipient,
                            token: token,
                            rawToken: randCode,
                            latency: latency + ' ms (Seketika)',
                            time: timeStr,
                            status: 'TOKEN OTP SIAP DIKIRIM',
                            statusSub: 'Pesan Cloud Telegram • Bebas Biaya SMS',
                            gateway: 'STO Sukabumi Kota (Core GPON OLT-SKB)',
                            messageBody: `Halo Rekan ${cleanHandle ? '@' + cleanHandle : 'Petugas'},\n\nKode verifikasi OTP kedinasan Anda:\n\n🔐 KODE OTP RESMI: ${token}\n⏱️ Waktu: ${timeStr}\n🌐 Node Server: STO Sukabumi Kota (Core GPON OLT-SKB)\n\nSimpan pesan ini di Saved Messages Telegram Anda untuk autentikasi 2FA VALINS & GPON.`
                        };

                        if (showToast) {
                            this.triggerToast('Kode OTP Diperbarui', `Token 2FA baru: ${token}. Klik Kirim ke Telegram untuk menyimpan.`, 'success');
                        }
                    } else {
                        const cleanWa = (this.waPhone || '').replace(/[^0-9]/g, '').replace(/^0/, '');
                        const displayRecipient = cleanWa ? `+62 ${cleanWa} (Anda / Message Yourself)` : 'Nomor Anda (Message Yourself)';
                        this.pingTesting = false;
                        this.pingSuccess = true;
                        this.pingLatency = 24;
                        this.pingStatusText = 'Token Siap (Message Yourself)';

                        this.testMessageData = {
                            channel: 'whatsapp',
                            title: 'Message Yourself (Kirim ke Diri Sendiri)',
                            botUsername: cleanWa ? `+62 ${cleanWa} (Anda)` : 'WhatsApp Anda (Message Yourself)',
                            recipient: displayRecipient,
                            rawRecipient: cleanWa ? `+62 ${cleanWa}` : 'Message Yourself (Anda)',
                            token: token,
                            rawToken: randCode,
                            latency: 'Langsung Terkirim (Centang Dua Biru)',
                            time: timeStr,
                            status: 'TOKEN OTP SIAP DIKIRIM',
                            statusSub: 'Chat Pribadi Nomor Anda • Centang Dua Biru',
                            gateway: 'Direct WhatsApp Dispatcher Sukabumi',
                            messageBody: `*TELKOM AKSES WITEL SUKABUMI*\n[Message Yourself / Anda]\n\nHalo Petugas Telkom Akses,\n\nKode autentikasi 2FA kedinasan Anda:\n\n*${token}*\n\nKode resmi berlaku selama 5 menit. Tekan Kirim untuk menyimpan di ruang obrolan Message Yourself WhatsApp Anda.`
                        };

                        if (showToast) {
                            this.triggerToast('Kode OTP Diperbarui', `Token 2FA baru: ${token}. Klik Kirim ke WhatsApp untuk menyimpan.`, 'success');
                        }
                    }
                },

                testPingTelegram() {
                    this.sendTelegramSavedMessages('desktop');
                },

                testOtpWa() {
                    this.sendWhatsAppMessageYourself('desktop');
                },

                getTelegramMessageText() {
                    const token = this.testMessageData ? this.testMessageData.token : '849-201';
                    const handle = (this.telegramId || '').replace(/^@/, '').trim();
                    const greeting = handle ? `@${handle}` : (this.fullName ? this.fullName : 'Rekan Petugas');
                    const now = new Date();
                    const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB';
                    
                    return `🔐 [VALINS GPON 2FA RESMI]\n` +
                        `Halo ${greeting}, berikut kode verifikasi 2FA Anda:\n\n` +
                        `👉 KODE OTP: ${token}\n` +
                        `• Node Server: STO Sukabumi Core OLT\n` +
                        `• Waktu: ${timeStr}\n\n` +
                        `Pesan verifikasi kedinasan SIM VALINS PT Telkom Akses Sukabumi. Tekan Send untuk menyimpan di Saved Messages Telegram Anda.`;
                },

                getTelegramTgUrl() {
                    return `tg://msg_url?url=${encodeURIComponent('https://t.me')}&text=${encodeURIComponent(this.getTelegramMessageText())}`;
                },

                getTelegramWebUrl() {
                    return `https://t.me/share/url?url=${encodeURIComponent('https://t.me')}&text=${encodeURIComponent(this.getTelegramMessageText())}`;
                },

                handleTelegramClick(e) {
                    const token = this.testMessageData ? this.testMessageData.token : '849-201';
                    const text = this.getTelegramMessageText();
                    
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(text);
                    }
                    this.playNotificationTone();
                    this.showIncomingAlert('telegram', token, 'Saved Messages (Pesan Tersimpan)', text);
                    this.isDelivered = true;
                    this.pingTesting = true;
                    this.pingStatusText = 'Membuka Telegram Desktop...';

                    setTimeout(() => {
                        this.pingTesting = false;
                        this.pingSuccess = true;
                        this.pingStatusText = 'Pesan 2FA Disiapkan ke Telegram';
                        this.triggerToast('Pesan & OTP Disalin!', `Token ${token} siap! Buka Telegram Anda lalu tekan Ctrl + V pada chat Saved Messages (atau pilih Saved Messages pada dialog).`, 'success');
                    }, 400);
                },

                handleWhatsAppClick(e) {
                    const token = this.testMessageData ? this.testMessageData.token : '619-405';
                    const text = this.getWhatsAppMessageText();
                    
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(text);
                    }
                    this.playNotificationTone();
                    this.showIncomingAlert('whatsapp', token, 'Message Yourself (Anda)', text);
                    this.isDelivered = true;
                    this.pingTesting = true;
                    this.pingStatusText = 'Membuka WhatsApp...';

                    setTimeout(() => {
                        this.pingTesting = false;
                        this.pingSuccess = true;
                        this.pingStatusText = 'Pesan 2FA Disiapkan ke WhatsApp';
                        this.triggerToast('Pesan & OTP Disalin!', `Token ${token} siap! Buka WhatsApp Anda lalu tekan Ctrl + V (atau tekan Kirim).`, 'success');
                    }, 400);
                },

                sendTelegramSavedMessages(target = 'desktop') {
                    const token = this.testMessageData ? this.testMessageData.token : '849-201';
                    const text = this.getTelegramMessageText();
                    const encoded = encodeURIComponent(text);
                    
                    // 1. Copy formatted text & token to user clipboard immediately
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(text);
                    }

                    // 2. Play subtle chime tone
                    this.playNotificationTone();

                    // 3. Trigger In-App Instant Notification Toast
                    this.showIncomingAlert('telegram', token, 'Saved Messages (Pesan Tersimpan)', text);
                    
                    this.isDelivered = true;
                    this.pingTesting = true;
                    this.pingStatusText = 'Membuka Telegram...';

                    const tgDesktopUrl = `tg://msg_url?url=${encodeURIComponent('https://t.me')}&text=${encoded}`;
                    const tgWebUrl = `https://t.me/share/url?url=${encodeURIComponent('https://t.me')}&text=${encoded}`;

                    if (target === 'web') {
                        window.open(tgWebUrl, '_blank');
                    } else {
                        // Launch desktop protocol directly without popup blocker
                        window.location.href = tgDesktopUrl;
                    }
                    
                    setTimeout(() => {
                        this.pingTesting = false;
                        this.pingSuccess = true;
                        this.pingStatusText = 'Pesan 2FA Disiapkan ke Telegram';
                        this.triggerToast('Pesan Disalin ke Clipboard!', `Token ${token} & pesan disalin! Di Telegram, tekan Ctrl+V pada Saved Messages Anda lalu tekan Enter.`, 'success');
                    }, 400);
                },

                getWhatsAppMessageText() {
                    const token = this.testMessageData ? this.testMessageData.token : '619-405';
                    const now = new Date();
                    const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB';
                    
                    return `*TELKOM AKSES WITEL SUKABUMI*\n[Message Yourself / Anda]\n\n` +
                        `🔐 *KODE OTP 2FA: ${token}*\n` +
                        `• Gateway: Direct Dispatch STO Sukabumi\n` +
                        `• Waktu: ${timeStr}\n\n` +
                        `Kode verifikasi resmi aktif 5 menit. Tekan Kirim untuk menyimpan di obrolan Message Yourself WhatsApp Anda.`;
                },

                getWhatsAppDirectUrl() {
                    const cleanWa = (this.waPhone || '').replace(/[^0-9]/g, '').replace(/^0/, '');
                    if (cleanWa) {
                        return `whatsapp://send?phone=62${cleanWa}&text=${encodeURIComponent(this.getWhatsAppMessageText())}`;
                    }
                    return `whatsapp://send?text=${encodeURIComponent(this.getWhatsAppMessageText())}`;
                },

                getWhatsAppWebUrl() {
                    const cleanWa = (this.waPhone || '').replace(/[^0-9]/g, '').replace(/^0/, '');
                    if (cleanWa) {
                        return `https://api.whatsapp.com/send?phone=62${cleanWa}&text=${encodeURIComponent(this.getWhatsAppMessageText())}`;
                    }
                    return `https://api.whatsapp.com/send?text=${encodeURIComponent(this.getWhatsAppMessageText())}`;
                },

                sendWhatsAppMessageYourself(target = 'desktop') {
                    const cleanWa = (this.waPhone || '').replace(/[^0-9]/g, '').replace(/^0/, '');
                    const token = this.testMessageData ? this.testMessageData.token : '619-405';
                    const text = this.getWhatsAppMessageText();
                    const encoded = encodeURIComponent(text);
                    
                    // 1. Copy text to clipboard immediately
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(text);
                    }

                    // 2. Play subtle chime tone
                    this.playNotificationTone();

                    // 3. Trigger In-App Instant Notification Toast
                    this.showIncomingAlert('whatsapp', token, 'Message Yourself (Anda)', text);
                    
                    this.isDelivered = true;
                    this.pingTesting = true;
                    this.pingStatusText = 'Membuka WhatsApp...';

                    if (target === 'web') {
                        const webUrl = cleanWa ? `https://api.whatsapp.com/send?phone=62${cleanWa}&text=${encoded}` : `https://api.whatsapp.com/send?text=${encoded}`;
                        window.open(webUrl, '_blank');
                    } else {
                        const appUrl = cleanWa ? `whatsapp://send?phone=62${cleanWa}&text=${encoded}` : `whatsapp://send?text=${encoded}`;
                        window.location.href = appUrl;
                    }
                    
                    setTimeout(() => {
                        this.pingTesting = false;
                        this.pingSuccess = true;
                        this.pingStatusText = 'Pesan Disiapkan ke WhatsApp';
                        this.triggerToast('WhatsApp Dibuka & Teks Disalin', `Token ${token} telah disalin ke clipboard! Tekan Kirim di WhatsApp (atau Ctrl+V jika kosong).`, 'success');
                    }, 400);
                },

                copyOtpToken(token) {
                    const clean = token.replace(/[^0-9]/g, '');
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(clean);
                    }
                    this.tokenCopied = true;
                    this.triggerToast('Token Tersalin', `Kode OTP ${clean} berhasil disalin ke papan klip.`, 'success');
                    setTimeout(() => { this.tokenCopied = false; }, 3000);
                },

                copyFullMessage(channel = null) {
                    const active = channel || this.mfaMethod;
                    const text = active === 'telegram' ? this.getTelegramMessageText() : this.getWhatsAppMessageText();
                    const appName = active === 'telegram' ? 'Telegram Saved Messages' : 'WhatsApp Message Yourself';
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(text);
                    }
                    this.playNotificationTone();
                    this.triggerToast('Pesan & OTP Disalin ke Papan Klip!', `Format pesan lengkap & kode OTP disalin. Buka ${appName} lalu tekan Ctrl + V dan Enter.`, 'success');
                },

                closeTestMessage() {
                    this.ensureDirectMessage(this.mfaMethod, false);
                },

                openTelegramSavedMessages() {
                    this.sendTelegramSavedMessages();
                },

                openTelegramBot() {
                    this.sendTelegramSavedMessages();
                },

                openWhatsAppMessageYourself() {
                    this.sendWhatsAppMessageYourself();
                },

                openWhatsAppChat() {
                    this.sendWhatsAppMessageYourself();
                },

                updatePassStrength() {
                    const val = this.password || '';
                    this.hasMinLength = val.length >= 8;
                    this.hasUpper = /[A-Z]/.test(val);
                    this.hasNumber = /[0-9]/.test(val);
                    this.hasSymbol = /[^A-Za-z0-9]/.test(val);

                    let score = 0;
                    if (this.hasMinLength) score++;
                    if (this.hasUpper) score++;
                    if (this.hasNumber) score++;
                    if (this.hasSymbol) score++;

                    this.passStrength = score;

                    if (val.length === 0) {
                        this.passLabel = 'Belum diisi';
                    } else if (score === 1) {
                        this.passLabel = 'Sangat Lemah';
                    } else if (score === 2) {
                        this.passLabel = 'Sedang';
                    } else if (score === 3) {
                        this.passLabel = 'Kuat';
                    } else if (score === 4) {
                        this.passLabel = 'Sangat Kuat (100%)';
                    }

                    this.checkPasswordMatch();
                },

                checkPasswordMatch() {
                    if (!this.passwordConfirmation) {
                        this.passwordsMatch = false;
                        return;
                    }
                    this.passwordsMatch = this.password === this.passwordConfirmation;
                },

                toggleSto(code) {
                    const idx = this.selectedStos.indexOf(code);
                    if (idx > -1) {
                        if (this.selectedStos.length > 1) {
                            this.selectedStos.splice(idx, 1);
                        } else {
                            this.triggerToast('Peringatan STO', 'Pilih minimal satu wilayah pangkalan kerja STO.', 'warning');
                        }
                    } else {
                        this.selectedStos.push(code);
                    }
                },

                goToStep(targetStep) {
                    if (targetStep === this.step) return;

                    // Set transition direction for smooth CSS animation
                    this.stepDirection = targetStep > this.step ? 'forward' : 'backward';

                    if (targetStep === 2) {
                        if (!this.fullName.trim()) {
                            this.triggerToast('Nama Lengkap Wajib', 'Silakan lengkapi Nama Lengkap sesuai KTP / ID Card Petugas.');
                            return;
                        }
                        if (!this.empId.trim()) {
                            this.triggerToast('NIK Wajib', 'Masukkan NIK Telkom Akses / Mitra Lapangan.');
                            return;
                        }
                        if (!/^[0-9\-]+$/.test(this.empId.trim())) {
                            this.triggerToast('Format NIK Keliru', 'NIK hanya boleh memuat angka (0-9) dan tanda strip (-).');
                            return;
                        }
                        if (!this.email.trim()) {
                            this.triggerToast('Email Wajib', 'Masukkan email kedinasan atau email aktif.');
                            return;
                        }
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(this.email.trim())) {
                            this.triggerToast('Format Email Keliru', 'Masukkan format alamat email yang valid.');
                            return;
                        }
                        if (!this.waPhone.trim()) {
                            this.triggerToast('Nomor WhatsApp Wajib', 'Masukkan nomor WhatsApp aktif untuk token OTP.');
                            return;
                        }
                        if (!/^[0-9]+$/.test(this.waPhone.trim())) {
                            this.triggerToast('Format WhatsApp Keliru', 'Nomor WhatsApp hanya boleh memuat variabel angka (0-9).');
                            return;
                        }
                        if (this.waPhone.trim().length < 8) {
                            this.triggerToast('Nomor WhatsApp Terlalu Pendek', 'Nomor WhatsApp minimal terdiri dari 8 digit angka.');
                            return;
                        }
                        this.step = 2;
                        this.scrollToWizard();
                    } else if (targetStep === 3) {
                        // Check Step 1 prerequisites if coming from Step 1
                        if (this.step === 1) {
                            if (!this.fullName.trim() || !this.empId.trim() || !this.email.trim() || !this.waPhone.trim()) {
                                this.triggerToast('Identitas Belum Lengkap', 'Silakan lengkapi form Langkah 1 terlebih dahulu.');
                                return;
                            }
                            if (!/^[0-9\-]+$/.test(this.empId.trim())) {
                                this.triggerToast('Format NIK Keliru', 'NIK hanya boleh memuat angka (0-9) dan tanda strip (-).');
                                return;
                            }
                            if (!/^[0-9]+$/.test(this.waPhone.trim())) {
                                this.triggerToast('Format WhatsApp Keliru', 'Nomor WhatsApp hanya boleh memuat variabel angka (0-9).');
                                return;
                            }
                        }
                        if (this.selectedStos.length === 0) {
                            this.triggerToast('Wilayah Belum Dipilih', 'Pilih minimal satu wilayah penugasan STO utama.');
                            return;
                        }
                        this.step = 3;
                        this.scrollToWizard();
                    } else {
                        this.step = targetStep;
                        this.scrollToWizard();
                    }
                },

                scrollToWizard() {
                    this.$nextTick(() => {
                        const wizardSection = document.getElementById('wizardSection');
                        if (wizardSection) {
                            const rect = wizardSection.getBoundingClientRect();
                            // Only scroll smoothly if wizard top is scrolled off comfortably visible bounds
                            if (rect.top < -30 || rect.top > 220) {
                                const yOffset = -20;
                                const y = rect.top + window.pageYOffset + yOffset;
                                window.scrollTo({ top: y, behavior: 'smooth' });
                            }
                        } else {
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                    });
                },

                submitRegistration() {
                    if (!this.fullName.trim() || !this.empId.trim() || !this.email.trim() || !this.waPhone.trim()) {
                        this.triggerToast('Data Belum Lengkap', 'Silakan lengkapi seluruh field mandatori dengan tanda bintang (*).');
                        this.step = 1;
                        return;
                    }
                    if (!/^[0-9\-]+$/.test(this.empId.trim())) {
                        this.triggerToast('Format NIK Keliru', 'NIK hanya boleh memuat angka (0-9) dan tanda strip (-).');
                        this.step = 1;
                        return;
                    }
                    if (!/^[0-9]+$/.test(this.waPhone.trim())) {
                        this.triggerToast('Format WhatsApp Keliru', 'Nomor WhatsApp hanya boleh memuat variabel angka (0-9).');
                        this.step = 1;
                        return;
                    }
                    if (!this.password) {
                        this.triggerToast('Kata Sandi Kosong', 'Harap isi kata sandi akun kedinasan.');
                        this.step = 3;
                        return;
                    }
                    if (this.password.length < 8) {
                        this.triggerToast('Kata Sandi Kurang Panjang', 'Kata sandi minimal harus 8 karakter.');
                        this.step = 3;
                        return;
                    }
                    if (this.password !== this.passwordConfirmation) {
                        this.triggerToast('Konfirmasi Password Keliru', 'Kata sandi baru dan konfirmasi tidak cocok.');
                        this.step = 3;
                        return;
                    }
                    if (!this.agreeIntegrity) {
                        this.triggerToast('Persetujuan Diperlukan', 'Harap centang persetujuan Pakta Integritas Kerahasiaan Data Fiber Telkom Akses.');
                        this.step = 3;
                        return;
                    }

                    this.isSubmitting = true;
                    // Submit ke backend Laravel Breeze
                    document.getElementById('realLaravelForm').submit();
                }
            };
        }

        if (window.Alpine) {
            Alpine.data('registrationWizard', registrationWizard);
        } else {
            document.addEventListener('alpine:init', () => {
                Alpine.data('registrationWizard', registrationWizard);
            });
        }
    </script>
</head>
<body class="min-h-screen antialiased selection:bg-[#bc0007] selection:text-white relative overflow-x-hidden flex flex-col justify-between"
      x-data="registrationWizard()">

    <!-- Ambient Glowing Background Spheres -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-red-500/10 rounded-full blur-3xl animate-ambient-1"></div>
        <div class="absolute top-1/3 -right-36 w-[30rem] h-[30rem] bg-sky-500/10 rounded-full blur-3xl animate-ambient-2"></div>
        <div class="absolute -bottom-36 left-1/3 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl animate-ambient-1"></div>
    </div>

    <!-- Persistent Telkom Akses Top Navigation Header (Full Width Edge-to-Edge) -->
    <header class="w-full sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs transition-all duration-300">
        <div class="w-full max-w-[1400px] xl:max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-8 py-2 sm:py-2.5 flex items-center justify-between gap-3 sm:gap-4">
            
            <!-- Brand Logo Telkom Akses (Resmi) -->
            <a href="{{ route('login') }}" 
               class="inline-flex items-center group focus:outline-none transition-transform duration-200 hover:opacity-90"
               title="PT Telkom Akses - Beranda">
                <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                     alt="Logo Resmi PT Telkom Akses" 
                     class="h-9 sm:h-11 md:h-12 w-auto object-contain shrink-0 transition-transform duration-200 group-hover:scale-102"
                     onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
            </a>

            <!-- Right Telemetry Badges & Portal Action -->
            <div class="flex items-center gap-2 sm:gap-3.5">
                
                <!-- LDAP Sync Status Badge -->
               

                <!-- TLS Security Badge -->
                <div class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-3.5 sm:py-2 rounded-full bg-slate-50/90 hover:bg-slate-100/90 text-slate-700 text-xs font-medium border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-slate-300 transition-all duration-300 cursor-default select-none group"
                     title="Enkripsi End-to-End Transport Layer Security v1.3 Aktif">
                    <span class="material-symbols-outlined text-[17px] text-sky-600 transition-transform duration-300 group-hover:scale-115 group-hover:rotate-6">shield</span>
                    <span class="tracking-tight text-[11px] sm:text-xs">
                        <span class="text-slate-500 font-normal">TLS v1.3</span> 
                        <span class="text-slate-800 font-bold ml-0.5">Enforced</span>
                    </span>
                </div>

                <!-- Masuk Portal Button with Rich Animation -->
                

            </div>
        </div>
    </header>

    <!-- Main Container Shell -->
    <main class="flex-1 w-full max-w-[1400px] xl:max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4.5 lg:py-5 relative z-10">
        <div class="w-full">

            <!-- Laravel Session Error Banner -->
            @if ($errors->any())
                <div class="mb-4 p-4 rounded-2xl bg-red-50 border-l-4 border-[#bc0007] text-red-800 shadow-sm flex items-start gap-3.5">
                    <span class="material-symbols-outlined text-[#bc0007] text-2xl shrink-0 mt-0.5">error</span>
                    <div>
                        <h4 class="font-bold text-xs uppercase tracking-wider text-red-900">Periksa Kembali Data Anda:</h4>
                        <ul class="list-disc list-inside text-xs mt-1 space-y-0.5 text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Main Dual-Column Bento Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-4.5 lg:gap-5 items-start">

                <!-- ================= LEFT COLUMN: Enterprise Telemetry & Guidance (Desktop Only - Hidden on Mobile) ================= -->
                <aside class="hidden lg:flex lg:col-span-4 flex-col gap-3.5">

                    <!-- Identity & Context Card (Desktop Only - Clean Professional Layout without Illustration) -->
                    <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-xs border border-slate-200/90 relative overflow-hidden transition-all hover:shadow-md">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#bc0007] inline-block shadow-xs"></span>
                            <span class="font-telemetry text-[11px] font-bold uppercase tracking-wider text-slate-500">SISTEM OTENTIKASI RESMI</span>
                        </div>
                        <h2 class="font-headline text-xl font-bold text-slate-900 tracking-tight mb-1.5">Portal Registrasi Terpadu</h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                            Daftarkan akun kedinasan untuk personil lapangan dan analis NOC guna validasi data ODC/ODP pada platform VALINS serta instrumen Optical Line Terminal (OLT).
                        </p>
                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-200/80 flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-[#bc0007] text-[20px] shrink-0 mt-0.5">verified_user</span>
                            <div>
                                <span class="text-xs font-bold text-slate-900 block mb-0.5">Otorisasi Berjenjang</span>
                                <p class="text-[11px] text-slate-500 leading-relaxed">
                                    Setiap pengajuan diverifikasi otomatis sesuai NIK kedinasan dan disinkronkan ke Asman Jaringan Regional Sukabumi.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Telemetry Dark Card with Animated Optical Fiber Topology -->
                    <div class="rounded-2xl p-4 sm:p-4.5 shadow-xl text-white border border-slate-800 relative overflow-hidden transition-all"
                         style="background: linear-gradient(145deg, #091122 0%, #131f37 100%);">
                        
                        <!-- Watermark Topology SVG with Animated Pulses -->
                        <svg class="absolute -right-6 -bottom-6 w-56 h-56 text-[#38bdf8] opacity-20 pointer-events-none select-none z-0 transform rotate-12" viewBox="0 0 200 200" fill="none" stroke="currentColor" aria-hidden="true">
                            <circle cx="100" cy="100" r="18" stroke-width="3" fill="currentColor" fill-opacity="0.1"></circle>
                            <circle cx="45" cy="55" r="12" stroke-width="2.5" fill="currentColor" fill-opacity="0.15"></circle>
                            <circle cx="155" cy="55" r="12" stroke-width="2.5" fill="currentColor" fill-opacity="0.15"></circle>
                            <circle cx="35" cy="145" r="10" stroke-width="2" fill="currentColor" fill-opacity="0.15"></circle>
                            <circle cx="165" cy="145" r="10" stroke-width="2" fill="currentColor" fill-opacity="0.15"></circle>
                            <circle cx="100" cy="175" r="14" stroke-width="2.5" fill="currentColor" fill-opacity="0.15"></circle>
                            <circle cx="100" cy="25" r="9" stroke-width="2" fill="currentColor" fill-opacity="0.15"></circle>
                            
                            <!-- Animated optical lines -->
                            <line class="optical-line" x1="100" y1="82" x2="100" y2="34" stroke-width="2"></line>
                            <line class="optical-line" x1="86" y1="89" x2="55" y2="63" stroke-width="2.5"></line>
                            <line class="optical-line" x1="114" y1="89" x2="145" y2="63" stroke-width="2.5"></line>
                            <line class="optical-line" x1="86" y1="111" x2="43" y2="139" stroke-width="2"></line>
                            <line class="optical-line" x1="114" y1="111" x2="157" y2="139" stroke-width="2"></line>
                            <line class="optical-line" x1="100" y1="118" x2="100" y2="161" stroke-width="2.5"></line>
                            
                            <circle cx="100" cy="100" r="42" stroke-width="1.5" stroke-dasharray="4 4" opacity="0.6"></circle>
                            <circle cx="100" cy="100" r="70" stroke-width="1" stroke-dasharray="6 6" opacity="0.4"></circle>
                        </svg>

                        <!-- Content over SVG -->
                        <div class="relative z-10 flex flex-col">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold tracking-widest uppercase font-telemetry text-sky-400">TELEMETRI DISTRIBUSI</span>
                                    <h3 class="text-[16px] font-bold tracking-tight text-white leading-snug font-headline mt-0.5">
                                        KAWASAN SUKABUMI – 5 STO Utama
                                    </h3>
                                </div>
                                <div class="shrink-0 p-1.5 rounded-lg bg-sky-950/60 border border-sky-800/40 text-sky-400">
                                    <span class="material-symbols-outlined text-[20px] animate-pulse">hub</span>
                                </div>
                            </div>

                            <p class="text-xs mb-4 text-slate-300">Monitoring Jalur Fiber & Core Distribution</p>

                            <!-- Live Telemetry Status Rows -->
                            <div class="flex flex-col gap-2.5 font-telemetry">
                                <!-- STO SKB -->
                                <div class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-950/60 border border-slate-800/70 hover:border-emerald-500/50 transition-colors">
                                    <div class="flex items-center gap-2.5 min-w-0 pr-2">
                                        <div class="relative flex h-2.5 w-2.5 shrink-0">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                        </div>
                                        <span class="text-xs font-semibold text-white truncate">Cakupan STO Sukabumi Kota</span>
                                    </div>
                                    <span class="text-xs font-bold text-emerald-400 tracking-wider">ACTIVE</span>
                                </div>

                                <!-- Pelabuhanratu Sub-Loop -->
                                <div class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-950/60 border border-slate-800/70 hover:border-sky-500/50 transition-colors">
                                    <div class="flex items-center gap-2.5 min-w-0 pr-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-sky-400 shrink-0 shadow-xs shadow-sky-400/50"></span>
                                        <span class="text-xs font-semibold text-white truncate">Pelabuhanratu Sub-Loop</span>
                                    </div>
                                    <span class="text-xs font-bold text-sky-400 tracking-wider">SYNCHRONIZED</span>
                                </div>

                                <!-- Cibadak - Cicurug Feeder with live micro fluctuation -->
                                <div class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-950/60 border border-slate-800/70 hover:border-amber-500/50 transition-colors">
                                    <div class="flex items-center gap-2.5 min-w-0 pr-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 shrink-0 shadow-xs shadow-amber-400/50"></span>
                                        <span class="text-xs font-semibold text-white truncate">Cibadak - Cicurug Feeder</span>
                                    </div>
                                    <div class="flex flex-col items-end shrink-0 leading-tight">
                                        <span class="text-xs font-bold text-amber-400">NORMAL</span>
                                        <span class="text-[10px] text-amber-300 font-semibold" x-text="`${opticalDbm} dBm`">-18.4 dBm</span>
                                    </div>
                                </div>

                                <!-- Audit Valins Berjalan -->
                                <div class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-950/60 border border-slate-800/70 hover:border-rose-400/50 transition-colors">
                                    <div class="flex items-center gap-2.5 min-w-0 pr-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-rose-400 shrink-0 shadow-xs shadow-rose-400/50"></span>
                                        <span class="text-xs font-semibold text-white truncate">Audit Valins Berjalan</span>
                                    </div>
                                    <span class="text-xs font-bold text-rose-300">94.8% Akurasi</span>
                                </div>
                            </div>

                            <!-- Animated Telemetry Progress Bars -->
                            <div class="mt-4 flex flex-col gap-1.5 opacity-70">
                                <div class="h-1.5 w-full rounded-full bg-slate-800 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-emerald-500 via-sky-500 to-red-500 w-4/5 rounded-full animate-pulse"></div>
                                </div>
                                <div class="h-1 w-3/5 rounded-full bg-slate-800 overflow-hidden">
                                    <div class="h-full bg-sky-400 w-2/3 rounded-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SLA & Support Card -->
                    <div class="rounded-2xl p-3.5 bg-sky-50/90 text-sky-950 shadow-xs border border-sky-200/80 flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-sky-100 flex items-center justify-center shrink-0 text-sky-700 mt-0.5">
                            <span class="material-symbols-outlined text-[22px]">support_agent</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-sky-900">Butuh Bantuan Akses?</span>
                            <span class="text-[11px] text-sky-700 mt-0.5 leading-relaxed">
                                Hubungi PIC NOC Sukabumi di <span class="font-bold font-telemetry text-sky-950">(0266) 221100 / ext. 408</span> atau via kanal Dispatcher Telkom Akses.
                            </span>
                        </div>
                    </div>
                </aside>

                <!-- ================= RIGHT COLUMN: Multi-Step Interactive Form Shell ================= -->
                <section id="wizardSection" class="w-full lg:col-span-8 flex flex-col bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-5.5 lg:p-6.5 xl:p-7 shadow-xs border border-slate-200/90 relative">

                    <!-- ================= MOBILE ONLY: Card-based Login Screen Layout (Khusus Mobile / Inspect Saja) ================= -->
                    <div class="block lg:hidden mb-5 text-center">
                        <!-- Visual Illustration (Seamless Transparent Background, Zero White Box Frame) -->
                        <div class="flex justify-center items-center py-1 sm:py-2 mb-2 relative">
                            <!-- Subtle Ambient Backlight Glow -->
                            <div class="absolute w-32 h-32 rounded-full bg-red-500/10 blur-2xl pointer-events-none"></div>
                            <img src="{{ asset('images/auth/mobile-register-illustration.png') }}" 
                                 alt="Ilustrasi Registrasi Akun Kedinasan" 
                                 class="w-36 sm:w-44 max-h-32 object-contain select-none pointer-events-none filter drop-shadow-md relative z-10 transition-transform duration-300">
                        </div>

                        <!-- Mobile Badge & Title -->
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 border border-red-200/80 text-[10px] font-telemetry font-bold text-[#bc0007] uppercase tracking-wider mb-1.5">
                            <span>Sistem Otentikasi Resmi</span>
                        </div>
                        <h1 class="font-headline text-lg sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                            Registrasi Akun 
                        </h1>
                        <p class="text-[11px] sm:text-xs text-slate-500 max-w-xs sm:max-w-sm mx-auto mt-0.5 leading-relaxed">
                            Personil Lapangan & Analis NOC Telkom Akses Witel Sukabumi
                        </p>

                        <!-- Quick Direct Link to Login for Existing Users (Khusus Mobile / Inspect) -->
                        <div class="mt-2.5 pt-2.5 border-t border-slate-100 flex items-center justify-center gap-1.5 text-xs text-slate-500">
                            <span>Sudah Punya Akun?</span>
                            <a href="{{ route('login') }}" class="font-bold text-[#bc0007] hover:underline inline-flex items-center gap-0.5">
                                <span>Masuk</span>
                            </a>
                        </div>
                    </div>

                    <!-- ================= DESKTOP ONLY: Form Header Section (Hidden on Mobile) ================= -->
                    <div class="hidden lg:flex items-center justify-between mb-3.5 pb-3 border-b border-slate-100 gap-4">
                        <div>
                            <div class="flex items-center gap-2.5 mb-0.5">
                                <span class="material-symbols-outlined text-[#bc0007] text-[26px]">assignment_ind</span>
                                <h1 class="font-headline text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                                    Registrasi Akun Petugas & Validator
                                </h1>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-500 max-w-xl leading-relaxed">
                                Daftarkan identitas kedinasan Anda untuk mendapatkan hak akses monitoring GPON & audit VALINS Sukabumi.
                            </p>
                        </div>
                    </div>

                    <!-- 3-Step Interactive Timeline Bar with Sleek High-Tech Progress Line -->
                    <div class="w-full mb-3.5 sm:mb-4.5 bg-gradient-to-b from-white via-slate-50/90 to-slate-50/70 p-3 sm:p-3.5 lg:p-4 rounded-2xl border border-slate-200/90 shadow-xs relative overflow-hidden backdrop-blur-sm">
                        <!-- Top Ambient Line Accent -->
                        <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-[#bc0007]/25 to-transparent"></div>
                        
                        <!-- Timeline Header with Dynamic Indicator -->
                        <div class="flex items-center justify-between mb-2.5 px-0.5 gap-2">
                            <div class="flex items-center gap-1.5 sm:gap-2.5 min-w-0">
                                <span class="relative flex h-2 sm:h-2.5 w-2 sm:w-2.5 items-center justify-center shrink-0">
                                    <span class="header-radar-ring absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-1.5 sm:h-2 w-1.5 sm:w-2 bg-[#bc0007] shadow-xs shadow-red-500/50"></span>
                                </span>
                                <span class="font-telemetry text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-slate-700 truncate">
                                    <span class="sm:hidden">Alur Pendaftaran</span>
                                    <span class="hidden sm:inline">Alur Pendaftaran Akun</span>
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                                <span class="px-2 py-0.5 rounded-full text-[9px] sm:text-[10px] font-telemetry font-bold tracking-wide whitespace-nowrap shrink-0 transition-all duration-300 shadow-3xs"
                                      :class="step === 3 ? 'bg-emerald-100 text-emerald-800 border border-emerald-200/60' : 'bg-red-100 text-[#960005] border border-red-200/60'"
                                      x-text="step === 1 ? '33% Selesai' : (step === 2 ? '66% Selesai' : '100% Lengkap')">
                                </span>
                            </div>
                        </div>

                        <!-- Progress Bar Track with Clean Elegant Rounded Pill & Subtle Detail Animation -->
                        <div class="w-full bg-slate-100/90 h-1.5 sm:h-2.5 rounded-full relative mb-3 sm:mb-5 overflow-hidden shadow-inner border border-slate-200/50">
                            <div class="h-full rounded-full transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] relative overflow-hidden"
                                 :class="step === 3 ? 'progress-line-emerald' : 'progress-line-telkom'"
                                 :style="`width: ${step === 1 ? '33.33%' : (step === 2 ? '66.66%' : '100%')}`">
                                
                                <!-- Subtle Top Gloss Highlight -->
                                <div class="absolute inset-x-0 top-0 h-[40%] bg-gradient-to-b from-white/25 to-transparent rounded-t-full pointer-events-none"></div>

                                <!-- Subtle Elegant Sheen Sweep -->
                                <div class="line-subtle-sheen"></div>
                            </div>
                        </div>

                        <!-- 3-Step Interactive Navigation Tabs (Responsive: 3 Compact Columns on Mobile & Desktop) -->
                        <div class="grid grid-cols-3 gap-1.5 sm:gap-3">
                            
                            <!-- Step 1 Tab -->
                            <button type="button" 
                                    @click="goToStep(1)"
                                    class="flex flex-col sm:flex-row items-center text-center sm:text-left gap-1.5 sm:gap-3 p-2 sm:p-3 rounded-xl transition-all duration-300 ease-[cubic-bezier(0.2,0.8,0.2,1)] group cursor-pointer hover:-translate-y-0.5 hover:shadow-md active:scale-[0.98]"
                                    :class="step === 1 ? 'bg-white shadow-md shadow-red-500/10 border-2 border-[#bc0007] ring-2 sm:ring-4 ring-red-500/10' : (step > 1 ? 'bg-gradient-to-r from-emerald-50/90 to-teal-50/70 border border-emerald-300 hover:border-emerald-400 hover:bg-emerald-100/80 shadow-2xs' : 'bg-white/80 border border-slate-200/90 hover:border-slate-300 hover:bg-white')">
                                <div class="w-7 h-7 sm:w-8.5 sm:h-8.5 rounded-full flex items-center justify-center font-headline text-xs font-bold shrink-0 transition-all duration-300"
                                     :class="step === 1 ? 'bg-[#bc0007] text-white step-active-aura' : (step > 1 ? 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-xs shadow-emerald-500/30 group-hover:scale-105' : 'bg-slate-100 text-slate-500 border border-slate-200 group-hover:bg-slate-200/80')">
                                    <template x-if="step > 1">
                                        <span class="material-symbols-outlined text-[16px] sm:text-[18px]">check</span>
                                    </template>
                                    <template x-if="step <= 1">
                                        <span>1</span>
                                    </template>
                                </div>
                                <div class="flex flex-col min-w-0 w-full">
                                    <div class="flex items-center justify-center sm:justify-start gap-1 sm:gap-1.5 mb-0.5">
                                        <span class="font-telemetry text-[9px] sm:text-[10px] uppercase font-bold tracking-wider whitespace-nowrap"
                                              :class="step === 1 ? 'text-[#bc0007]' : (step > 1 ? 'text-emerald-700' : 'text-slate-500')">
                                            <span class="sm:hidden">Langkah 1</span>
                                            <span class="hidden sm:inline">Langkah 1</span>
                                        </span>
                                        <span x-show="step === 1" class="hidden sm:inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-red-100 text-[#960005] border border-red-200/80">Aktif</span>
                                        <span x-show="step > 1" class="hidden sm:inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200/80"><span class="material-symbols-outlined text-[11px] text-emerald-700">check</span>Selesai</span>
                                    </div>
                                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 truncate block group-hover:text-[#bc0007] transition-colors">
                                        <span class="sm:hidden">Identitas</span>
                                        <span class="hidden sm:inline">Identitas Diri & NIK</span>
                                    </span>
                                </div>
                            </button>

                            <!-- Step 2 Tab -->
                            <button type="button" 
                                    @click="goToStep(2)"
                                    class="flex flex-col sm:flex-row items-center text-center sm:text-left gap-1.5 sm:gap-3 p-2 sm:p-3 rounded-xl transition-all duration-300 ease-[cubic-bezier(0.2,0.8,0.2,1)] group cursor-pointer hover:-translate-y-0.5 hover:shadow-md active:scale-[0.98]"
                                    :class="step === 2 ? 'bg-white shadow-md shadow-red-500/10 border-2 border-[#bc0007] ring-2 sm:ring-4 ring-red-500/10' : (step > 2 ? 'bg-gradient-to-r from-emerald-50/90 to-teal-50/70 border border-emerald-300 hover:border-emerald-400 hover:bg-emerald-100/80 shadow-2xs' : 'bg-white/80 border border-slate-200/90 hover:border-slate-300 hover:bg-white')">
                                <div class="w-7 h-7 sm:w-8.5 sm:h-8.5 rounded-full flex items-center justify-center font-headline text-xs font-bold shrink-0 transition-all duration-300"
                                     :class="step === 2 ? 'bg-[#bc0007] text-white step-active-aura' : (step > 2 ? 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-xs shadow-emerald-500/30 group-hover:scale-105' : 'bg-slate-100 text-slate-500 border border-slate-200 group-hover:bg-slate-200/80')">
                                    <template x-if="step > 2">
                                        <span class="material-symbols-outlined text-[16px] sm:text-[18px]">check</span>
                                    </template>
                                    <template x-if="step <= 2">
                                        <span>2</span>
                                    </template>
                                </div>
                                <div class="flex flex-col min-w-0 w-full">
                                    <div class="flex items-center justify-center sm:justify-start gap-1 sm:gap-1.5 mb-0.5">
                                        <span class="font-telemetry text-[9px] sm:text-[10px] uppercase font-bold tracking-wider whitespace-nowrap"
                                              :class="step === 2 ? 'text-[#bc0007]' : (step > 2 ? 'text-emerald-700' : 'text-slate-500')">
                                            <span class="sm:hidden">Langkah 2</span>
                                            <span class="hidden sm:inline">Langkah 2</span>
                                        </span>
                                        <span x-show="step === 2" class="hidden sm:inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-red-100 text-[#960005] border border-red-200/80">Aktif</span>
                                        <span x-show="step > 2" class="hidden sm:inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200/80"><span class="material-symbols-outlined text-[11px] text-emerald-700">check</span>Selesai</span>
                                        <span x-show="step < 2" class="hidden sm:inline-flex px-1.5 py-0.5 rounded-full text-[9px] font-medium bg-slate-100 text-slate-500 border border-slate-200">Menunggu</span>
                                    </div>
                                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 truncate block group-hover:text-[#bc0007] transition-colors">
                                        <span class="sm:hidden">Unit & STO</span>
                                        <span class="hidden sm:inline">Unit Kerja & STO</span>
                                    </span>
                                </div>
                            </button>

                            <!-- Step 3 Tab -->
                            <button type="button" 
                                    @click="goToStep(3)"
                                    class="flex flex-col sm:flex-row items-center text-center sm:text-left gap-1.5 sm:gap-3 p-2 sm:p-3 rounded-xl transition-all duration-300 ease-[cubic-bezier(0.2,0.8,0.2,1)] group cursor-pointer hover:-translate-y-0.5 hover:shadow-md active:scale-[0.98]"
                                    :class="step === 3 ? 'bg-white shadow-md shadow-red-500/10 border-2 border-[#bc0007] ring-2 sm:ring-4 ring-red-500/10' : 'bg-white/80 border border-slate-200/90 hover:border-slate-300 hover:bg-white'">
                                <div class="w-7 h-7 sm:w-8.5 sm:h-8.5 rounded-full flex items-center justify-center font-headline text-xs font-bold shrink-0 transition-all duration-300"
                                     :class="step === 3 ? 'bg-[#bc0007] text-white step-active-aura' : 'bg-slate-100 text-slate-500 border border-slate-200 group-hover:bg-slate-200/80'">
                                    <span>3</span>
                                </div>
                                <div class="flex flex-col min-w-0 w-full">
                                    <div class="flex items-center justify-center sm:justify-start gap-1 sm:gap-1.5 mb-0.5">
                                        <span class="font-telemetry text-[9px] sm:text-[10px] uppercase font-bold tracking-wider whitespace-nowrap"
                                              :class="step === 3 ? 'text-[#bc0007]' : 'text-slate-500'">
                                            <span class="sm:hidden">Langkah 3</span>
                                            <span class="hidden sm:inline">Langkah 3</span>
                                        </span>
                                        <span x-show="step === 3" class="hidden sm:inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-red-100 text-[#960005] border border-red-200/80">Aktif</span>
                                        <span x-show="step < 3" class="hidden sm:inline-flex px-1.5 py-0.5 rounded-full text-[9px] font-medium bg-slate-100 text-slate-500 border border-slate-200">Menunggu</span>
                                    </div>
                                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 truncate block group-hover:text-[#bc0007] transition-colors">
                                        <span class="sm:hidden">Kredensial</span>
                                        <span class="hidden sm:inline">Kredensial & Akses</span>
                                    </span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Hidden Form with Laravel CSRF Token for Real Backend Submit -->
                    <form method="POST" action="{{ route('register') }}" id="realLaravelForm" class="hidden" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="name" :value="fullName">
                        <input type="hidden" name="email" :value="email">
                        <input type="hidden" name="password" :value="password">
                        <input type="hidden" name="password_confirmation" :value="passwordConfirmation">
                        <input type="hidden" name="emp_type" :value="empType">
                        <input type="hidden" name="nik" :value="empId">
                        <input type="hidden" name="wa_phone" :value="waPhone">
                        <input type="hidden" name="divisi" :value="division">
                        <input type="hidden" name="homebase" :value="homebase">
                        <template x-for="sto in selectedStos" :key="sto">
                            <input type="hidden" name="sto[]" :value="sto">
                        </template>
                        <input type="hidden" name="role" :value="role">
                        <input type="hidden" name="supervisor" :value="supervisor">
                        <input type="hidden" name="regu" :value="regu">
                        <input type="hidden" name="mfa_method" :value="mfaMethod">
                        <input type="hidden" name="telegram_id" :value="telegramId">
                        <!-- File Input for Surat Tugas connected here -->
                        <input type="file" name="surat_tugas" id="suratTugasFormInput" class="hidden">
                    </form>

                    <!-- ========================================================================= -->
                    <!-- STEP 1: Identitas Diri & NIK                                              -->
                    <!-- ========================================================================= -->
                    <div x-show="step === 1" 
                         :class="stepDirection === 'forward' ? 'step-pane-forward' : 'step-pane-backward'"
                         class="flex flex-col gap-4 sm:gap-4.5">

                        <!-- Friendly Verification Notice -->
                        <div class="rounded-2xl bg-sky-50/80 p-3.5 sm:p-4 flex items-start gap-3 border border-sky-200/80 shadow-2xs">
                            <span class="material-symbols-outlined text-[24px] text-sky-700 mt-0.5" style="font-variation-settings: 'FILL' 1;">info</span>
                            <div class="flex flex-col">
                                <span class="text-xs sm:text-sm font-bold text-sky-900">Prosedur Aktivasi Otomatis Akun</span>
                                <p class="text-xs text-sky-700 mt-0.5 leading-relaxed">
                                    Pastikan data NIK dan dokumen tugas Anda sudah benar dan valid. Akun akan langsung dibuat dan aktif secara otomatis tanpa perlu menunggu persetujuan manual.
                                </p>
                            </div>
                        </div>

                        <!-- Field Group: Kepegawaian Pill Selector -->
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-800 flex items-center gap-1">
                                <span>Jenis Kepegawaian</span>
                                <span class="text-[#bc0007]">*</span>
                            </label>
                            <p class="text-[11px] text-slate-500">Pilih status hubungan kerja penugasan Anda di Telkom Akses Sukabumi</p>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-1">
                                <!-- Inhouse Radio -->
                                <label class="relative flex items-center p-3.5 rounded-xl cursor-pointer transition-all border"
                                       :class="empType === 'inhouse' ? 'bg-red-50/50 border-[#bc0007] shadow-xs ring-2 ring-red-500/20' : 'bg-slate-50 border-slate-200 hover:bg-slate-100/70'">
                                    <input type="radio" 
                                           name="emp_type_radio" 
                                           value="inhouse" 
                                           @change="updateEmpType('inhouse')" 
                                           :checked="empType === 'inhouse'"
                                           class="w-4 h-4 text-[#bc0007] focus:ring-0 accent-[#bc0007]">
                                    <div class="ml-3 flex flex-col">
                                        <span class="text-xs font-bold text-slate-900">Karyawan Tetap (Inhouse)</span>
                                        <span class="text-[11px] text-slate-500">PT Telkom Akses Sukabumi (NIK Angka)</span>
                                    </div>
                                </label>

                                <!-- Mitra Radio -->
                                <label class="relative flex items-center p-3.5 rounded-xl cursor-pointer transition-all border"
                                       :class="empType === 'mitra' ? 'bg-red-50/50 border-[#bc0007] shadow-xs ring-2 ring-red-500/20' : 'bg-slate-50 border-slate-200 hover:bg-slate-100/70'">
                                    <input type="radio" 
                                           name="emp_type_radio" 
                                           value="mitra" 
                                           @change="updateEmpType('mitra')" 
                                           :checked="empType === 'mitra'"
                                           class="w-4 h-4 text-[#bc0007] focus:ring-0 accent-[#bc0007]">
                                    <div class="ml-3 flex flex-col">
                                        <span class="text-xs font-bold text-slate-900">Mitra Kerja Lapangan</span>
                                        <span class="text-[11px] text-slate-500">Kopegtel / Vendor Rekanan Resmi</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- 2-Column Grid: Nama Lengkap & NIK -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama Lengkap -->
                            <div class="flex flex-col gap-1.5">
                                <label for="fullName" class="text-xs font-bold text-slate-800 flex items-center gap-1">
                                    <span>Nama Lengkap</span>
                                    <span class="text-[#bc0007]">*</span>
                                </label>
                                <div class="relative">
                                    <input id="fullName" 
                                           type="text" 
                                           x-model="fullName"
                                           placeholder="Sesuai KTP / ID Card Petugas" 
                                           required
                                           class="w-full h-11 px-3.5 bg-slate-50 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 border border-slate-200 focus:bg-white focus:outline-none focus:border-[#bc0007] focus:ring-2 focus:ring-red-500/20 transition-all shadow-2xs">
                                </div>
                                <span class="text-[11px] text-slate-500">Contoh: Mochamad Farhan Pratama</span>
                            </div>

                            <!-- NIK (Strict Numbers and Hyphen Only) -->
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center justify-between">
                                    <label for="empId" class="text-xs font-bold text-slate-800 flex items-center gap-1">
                                        <span x-text="empType === 'mitra' ? 'NIK Mitra Lapangan' : 'NIK Telkom Akses'">NIK Telkom Akses</span>
                                        <span class="text-[#bc0007]">*</span>
                                    </label>
                                    <span class="font-telemetry text-xs font-bold text-[#0284c7] tracking-wider">
                                        VAL-SYS
                                    </span>
                                </div>
                                <div class="relative">
                                    <input id="empId" 
                                           type="text" 
                                           inputmode="numeric"
                                           pattern="[0-9\-]*"
                                           autocomplete="off"
                                           x-model="empId"
                                           @beforeinput="handleNikBeforeInput($event)"
                                           @keydown="handleNikKeydown($event)"
                                           @input="handleNikInput($event)"
                                           @paste="handleNikPaste($event)"
                                           :placeholder="empType === 'mitra' ? 'Contoh: 3202-0984-2109' : 'Contoh: 941029 atau 210984-01'" 
                                           required
                                           class="w-full h-11 px-3.5 bg-slate-50 rounded-xl font-telemetry text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 border border-slate-200 focus:bg-white focus:outline-none focus:border-[#bc0007] focus:ring-2 focus:ring-red-500/20 transition-all shadow-2xs">
                                </div>
                                <span class="text-[11px] text-slate-500">
                                    Gunakan NIK resmi untuk matching database SAP Telkom.
                                </span>
                            </div>
                        </div>

                        <!-- 2-Column Grid: Email & WhatsApp OTP -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Email -->
                            <div class="flex flex-col gap-1.5">
                                <label for="corpEmail" class="text-xs font-bold text-slate-800 flex items-center gap-1">
                                    <span>Email Korporat / Email Aktif</span>
                                    <span class="text-[#bc0007]">*</span>
                                </label>
                                <div class="relative">
                                    <input id="corpEmail" 
                                           type="email" 
                                           x-model="email"
                                           placeholder="nama.petugas@telkomakses.co.id" 
                                           required
                                           class="w-full h-11 px-3.5 bg-slate-50 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 border border-slate-200 focus:bg-white focus:outline-none focus:border-[#bc0007] focus:ring-2 focus:ring-red-500/20 transition-all shadow-2xs">
                                </div>
                                <span class="text-[11px] text-slate-500">Domain @telkomakses.co.id atau @gmail.com yang terdaftar</span>
                            </div>

                            <!-- WhatsApp (Strict Numbers Only) -->
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center justify-between">
                                    <label for="waPhone" class="text-xs font-bold text-slate-800 flex items-center gap-1">
                                        <span>Nomor WhatsApp Aktif</span>
                                        <span class="text-[#bc0007]">*</span>
                                    </label>
                                </div>
                                <div class="flex h-11">
                                    <span class="inline-flex items-center px-3.5 bg-slate-200/80 text-slate-800 font-telemetry text-xs font-bold rounded-l-xl border border-r-0 border-slate-200 select-none">
                                        +62
                                    </span>
                                    <input id="waPhone" 
                                           type="tel" 
                                           inputmode="numeric"
                                           pattern="[0-9]*"
                                           maxlength="15"
                                           autocomplete="tel"
                                           x-model="waPhone"
                                           @beforeinput="handleWaBeforeInput($event)"
                                           @keydown="handleWaKeydown($event)"
                                           @input="handleWaInput($event)"
                                           @paste="handleWaPaste($event)"
                                           onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                           placeholder="81234567890" 
                                           required
                                           class="w-full px-3.5 bg-slate-50 rounded-r-xl font-telemetry text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 border border-slate-200 focus:bg-white focus:outline-none focus:border-[#bc0007] focus:ring-2 focus:ring-red-500/20 transition-all shadow-2xs">
                                </div>
                                <span class="text-[11px] text-slate-500">
                                    Hanya mencantumkan variabel angka (0-9) tanpa spasi, huruf, atau tanda strip (-). Contoh: 81234567890. Digunakan untuk token OTP verifikasi tiket GPON.
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons Step 1 & Login Link -->
                        <div class="pt-4 border-t border-slate-100 flex flex-col gap-3">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                                <a href="{{ url('/') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 h-11 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                                    <span>Kembali</span>
                                </a>

                                <button type="button" 
                                        @click="goToStep(2)"
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 h-11 rounded-xl bg-[#bc0007] hover:bg-[#960005] text-white font-bold text-xs tracking-wide shadow-md shadow-red-600/25 transition-all group hover-sheen">
                                    <span>Lanjut ke Langkah 2: Unit Kerja & STO</span>
                                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </button>
                            </div>

                            <!-- Centered Direct Link to Login (Khusus Desktop & Laptop) -->
                            <div class="hidden lg:block text-center pt-1">
                                <p class="text-xs text-slate-500">
                                    <span>Sudah Punya Akun?</span>
                                    <a href="{{ route('login') }}" class="font-bold text-[#bc0007] hover:text-[#960005] hover:underline inline-flex items-center gap-0.5 ml-1 transition-colors">
                                        <span>Masuk</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================================================= -->
                    <!-- STEP 2: Unit Kerja & STO + Working File Upload Dropzone                   -->
                    <!-- ========================================================================= -->
                    <div x-show="step === 2" 
                         :class="stepDirection === 'forward' ? 'step-pane-forward' : 'step-pane-backward'"
                         class="flex flex-col gap-4 sm:gap-4.5" style="display: none;">

                        <!-- Callout Info Box -->
                        <div class="p-3.5 sm:p-4 rounded-2xl bg-slate-50 text-slate-900 flex items-start gap-3 border border-slate-200">
                            <span class="material-symbols-outlined text-[#bc0007] text-2xl mt-0.5 shrink-0">location_city</span>
                            <div>
                                <h4 class="font-headline text-xs sm:text-sm font-bold text-slate-900 mb-0.5">
                                    Penempatan Basecamp Operasional & Radius Patroli
                                </h4>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Informasi pemilihan Sentral Telepon Otomat (STO) dan Sub-Rayon menentukan penugasan tiket anomali VALINS otomatis serta akses berkas BAST di aplikasi mobile teknisi.
                                </p>
                            </div>
                        </div>

                        <!-- SECTION 1: Unit Kerja & Basis Operasional -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                <span class="text-xs font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                                    <span class="w-1.5 h-4 bg-[#bc0007] rounded-full"></span>
                                    1. Unit Kerja & Basis Operasional
                                </span>
                                <span class="text-[11px] font-semibold text-slate-500">Wajib Diisi</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Sub-Direktorat Custom Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5 flex items-center justify-between">
                                        <span class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[16px] text-[#bc0007]">domain</span>
                                            Sub-Direktorat / Divisi Operasi
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-normal" x-show="division">Terpilih</span>
                                    </label>
                                    
                                    <!-- Trigger Button -->
                                    <button type="button"
                                            @click="open = !open"
                                            @click.outside="open = false"
                                            @keydown.escape.window="open = false"
                                            class="w-full min-h-[46px] px-3.5 py-2 rounded-xl text-left transition-all duration-200 flex items-center justify-between gap-2.5 border shadow-2xs cursor-pointer select-none"
                                            :class="open ? 'bg-white border-[#bc0007] ring-2 ring-red-500/15 shadow-xs' : 'bg-slate-50 hover:bg-slate-100/70 border-slate-200/90'">
                                        
                                        <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                            <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 transition-colors"
                                                 :class="division ? 'bg-red-50 text-[#bc0007]' : 'bg-slate-200/60 text-slate-400'">
                                                <span class="material-symbols-outlined text-[17px]">domain</span>
                                            </div>
                                            
                                            <div class="flex flex-col min-w-0 flex-1">
                                                <template x-if="!division">
                                                    <span class="text-xs sm:text-sm text-slate-400 font-normal truncate">-- Pilih Sub-Direktorat / Divisi --</span>
                                                </template>
                                                <template x-if="division">
                                                    <div class="flex flex-col min-w-0">
                                                        <span class="text-xs sm:text-sm font-bold text-slate-900 truncate" x-text="getDivisionLabel()"></span>
                                                        <span class="text-[10px] text-slate-500 truncate" x-text="getDivisionDesc()"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-1.5 shrink-0">
                                            <template x-if="division">
                                                <span class="px-1.5 py-0.5 rounded text-[10px] font-telemetry font-bold bg-red-100/80 text-[#bc0007]" x-text="getDivisionBadge()"></span>
                                            </template>
                                            <span class="material-symbols-outlined text-[18px] text-slate-400 transition-transform duration-200"
                                                  :class="open ? 'rotate-180 text-[#bc0007]' : ''">keyboard_arrow_down</span>
                                        </div>
                                    </button>

                                    <!-- Custom Dropdown Menu -->
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-150 transform"
                                         x-transition:enter-start="opacity-0 translate-y-1 scale-[0.99]"
                                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                         x-transition:leave="transition ease-in duration-100 transform"
                                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                         x-transition:leave-end="opacity-0 translate-y-1 scale-[0.99]"
                                         class="absolute z-50 left-0 right-0 mt-1.5 max-h-64 sm:max-h-72 overflow-y-auto rounded-xl bg-white/98 backdrop-blur-md border border-slate-200 shadow-xl shadow-slate-900/10 p-1.5 space-y-1 divide-y divide-slate-100/60 custom-scrollbar"
                                         style="display: none;">
                                         
                                        <template x-for="item in divisions" :key="item.val">
                                            <div @click="division = item.val; open = false"
                                                 class="w-full text-left p-2.5 sm:p-3 rounded-lg transition-all flex items-start justify-between gap-3 group cursor-pointer"
                                                 :class="division === item.val ? 'bg-red-50/80 border border-red-200/70 text-[#bc0007]' : 'hover:bg-slate-50 text-slate-800 border border-transparent'">
                                                <div class="flex flex-col min-w-0 flex-1">
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#bc0007] transition-colors" x-text="item.title"></span>
                                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-telemetry font-bold shrink-0"
                                                              :class="division === item.val ? 'bg-red-200/80 text-[#bc0007]' : 'bg-slate-100 text-slate-600'" 
                                                              x-text="item.badge"></span>
                                                    </div>
                                                    <span class="text-[11px] text-slate-500 leading-relaxed mt-0.5" x-text="item.desc"></span>
                                                </div>
                                                <span class="material-symbols-outlined text-[18px] text-[#bc0007] shrink-0 mt-0.5"
                                                      x-show="division === item.val">check_circle</span>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Posko Lapangan Custom Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5 flex items-center justify-between">
                                        <span class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[16px] text-[#bc0007]">home_pin</span>
                                            Posko Lapangan / Homebase
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-normal" x-show="homebase">Terpilih</span>
                                    </label>
                                    
                                    <!-- Trigger Button -->
                                    <button type="button"
                                            @click="open = !open"
                                            @click.outside="open = false"
                                            @keydown.escape.window="open = false"
                                            class="w-full min-h-[46px] px-3.5 py-2 rounded-xl text-left transition-all duration-200 flex items-center justify-between gap-2.5 border shadow-2xs cursor-pointer select-none"
                                            :class="open ? 'bg-white border-[#bc0007] ring-2 ring-red-500/15 shadow-xs' : 'bg-slate-50 hover:bg-slate-100/70 border-slate-200/90'">
                                        
                                        <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                            <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 transition-colors"
                                                 :class="homebase ? 'bg-red-50 text-[#bc0007]' : 'bg-slate-200/60 text-slate-400'">
                                                <span class="material-symbols-outlined text-[17px]">home_pin</span>
                                            </div>
                                            
                                            <div class="flex flex-col min-w-0 flex-1">
                                                <template x-if="!homebase">
                                                    <span class="text-xs sm:text-sm text-slate-400 font-normal truncate">-- Pilih Posko / Homebase --</span>
                                                </template>
                                                <template x-if="homebase">
                                                    <div class="flex flex-col min-w-0">
                                                        <span class="text-xs sm:text-sm font-bold text-slate-900 truncate" x-text="getHomebaseLabel()"></span>
                                                        <span class="text-[10px] text-slate-500 truncate" x-text="getHomebaseDesc()"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-1.5 shrink-0">
                                            <template x-if="homebase">
                                                <span class="px-1.5 py-0.5 rounded text-[10px] font-telemetry font-bold bg-red-100/80 text-[#bc0007]" x-text="getHomebaseBadge()"></span>
                                            </template>
                                            <span class="material-symbols-outlined text-[18px] text-slate-400 transition-transform duration-200"
                                                  :class="open ? 'rotate-180 text-[#bc0007]' : ''">keyboard_arrow_down</span>
                                        </div>
                                    </button>

                                    <!-- Custom Dropdown Menu -->
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-150 transform"
                                         x-transition:enter-start="opacity-0 translate-y-1 scale-[0.99]"
                                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                         x-transition:leave="transition ease-in duration-100 transform"
                                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                         x-transition:leave-end="opacity-0 translate-y-1 scale-[0.99]"
                                         class="absolute z-50 left-0 right-0 mt-1.5 max-h-64 sm:max-h-72 overflow-y-auto rounded-xl bg-white/98 backdrop-blur-md border border-slate-200 shadow-xl shadow-slate-900/10 p-1.5 space-y-1 divide-y divide-slate-100/60 custom-scrollbar"
                                         style="display: none;">
                                         
                                        <template x-for="item in homebases" :key="item.val">
                                            <div @click="homebase = item.val; open = false"
                                                 class="w-full text-left p-2.5 sm:p-3 rounded-lg transition-all flex items-start justify-between gap-3 group cursor-pointer"
                                                 :class="homebase === item.val ? 'bg-red-50/80 border border-red-200/70 text-[#bc0007]' : 'hover:bg-slate-50 text-slate-800 border border-transparent'">
                                                <div class="flex flex-col min-w-0 flex-1">
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#bc0007] transition-colors" x-text="item.title"></span>
                                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-telemetry font-bold shrink-0"
                                                              :class="homebase === item.val ? 'bg-red-200/80 text-[#bc0007]' : 'bg-slate-100 text-slate-600'" 
                                                              x-text="item.badge"></span>
                                                    </div>
                                                    <div class="flex items-start gap-1 mt-1 text-[11px] text-slate-500 leading-relaxed">
                                                        <span class="material-symbols-outlined text-[13px] text-slate-400 mt-0.5 shrink-0">pin_drop</span>
                                                        <span x-text="item.desc"></span>
                                                    </div>
                                                </div>
                                                <span class="material-symbols-outlined text-[18px] text-[#bc0007] shrink-0 mt-0.5"
                                                      x-show="homebase === item.val">check_circle</span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Wilayah Penugasan STO Utama (Grid Multi-Select Cards) -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block text-xs font-bold text-slate-800">
                                        Wilayah Penugasan STO Utama <span class="text-slate-500 font-normal">(Pilih satu atau beberapa wilayah kerja)</span>
                                    </label>
                                    <span class="text-[11px] font-bold text-[#bc0007]" x-text="`${selectedStos.length} STO Terpilih`"></span>
                                </div>
                                
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-2">
                                    
                                    <!-- STO SKB (Sukabumi Kota) -->
                                    <div @click="toggleSto('SKB')" 
                                         class="p-3 rounded-xl transition-all cursor-pointer select-none flex items-start justify-between shadow-2xs border transform active:scale-95"
                                         :class="selectedStos.includes('SKB') ? 'bg-red-50/70 text-[#410001] border-[#bc0007] ring-1 ring-[#bc0007]' : 'bg-slate-50 text-slate-900 border-slate-200 hover:bg-slate-100/70'">
                                        <div>
                                            <span class="font-headline text-sm font-bold block">SKB</span>
                                            <span class="text-xs block text-slate-700">Sukabumi</span>
                                            <span class="font-telemetry text-[11px] mt-1 block"
                                                  :class="selectedStos.includes('SKB') ? 'text-red-700 font-bold' : 'text-slate-500'">42 ODC // 380 ODP</span>
                                        </div>
                                        <span class="material-symbols-outlined text-lg"
                                              :class="selectedStos.includes('SKB') ? 'text-[#bc0007]' : 'text-slate-300'"
                                              x-text="selectedStos.includes('SKB') ? 'check_circle' : 'radio_button_unchecked'"></span>
                                    </div>

                                    <!-- STO CCR (Cicurug) -->
                                    <div @click="toggleSto('CCR')" 
                                         class="p-3 rounded-xl transition-all cursor-pointer select-none flex items-start justify-between shadow-2xs border transform active:scale-95"
                                         :class="selectedStos.includes('CCR') ? 'bg-red-50/70 text-[#410001] border-[#bc0007] ring-1 ring-[#bc0007]' : 'bg-slate-50 text-slate-900 border-slate-200 hover:bg-slate-100/70'">
                                        <div>
                                            <span class="font-headline text-sm font-bold block">CCR</span>
                                            <span class="text-xs block text-slate-700">Cicurug</span>
                                            <span class="font-telemetry text-[11px] mt-1 block"
                                                  :class="selectedStos.includes('CCR') ? 'text-red-700 font-bold' : 'text-slate-500'">28 ODC // 215 ODP</span>
                                        </div>
                                        <span class="material-symbols-outlined text-lg"
                                              :class="selectedStos.includes('CCR') ? 'text-[#bc0007]' : 'text-slate-300'"
                                              x-text="selectedStos.includes('CCR') ? 'check_circle' : 'radio_button_unchecked'"></span>
                                    </div>

                                    <!-- STO CBD (Cibadak) -->
                                    <div @click="toggleSto('CBD')" 
                                         class="p-3 rounded-xl transition-all cursor-pointer select-none flex items-start justify-between shadow-2xs border transform active:scale-95"
                                         :class="selectedStos.includes('CBD') ? 'bg-red-50/70 text-[#410001] border-[#bc0007] ring-1 ring-[#bc0007]' : 'bg-slate-50 text-slate-900 border-slate-200 hover:bg-slate-100/70'">
                                        <div>
                                            <span class="font-headline text-sm font-bold block">CBD</span>
                                            <span class="text-xs block text-slate-700">Cibadak</span>
                                            <span class="font-telemetry text-[11px] mt-1 block"
                                                  :class="selectedStos.includes('CBD') ? 'text-red-700 font-bold' : 'text-slate-500'">34 ODC // 290 ODP</span>
                                        </div>
                                        <span class="material-symbols-outlined text-lg"
                                              :class="selectedStos.includes('CBD') ? 'text-[#bc0007]' : 'text-slate-300'"
                                              x-text="selectedStos.includes('CBD') ? 'check_circle' : 'radio_button_unchecked'"></span>
                                    </div>

                                    <!-- STO PLR (Pelabuhanratu) -->
                                    <div @click="toggleSto('PLR')" 
                                         class="p-3 rounded-xl transition-all cursor-pointer select-none flex items-start justify-between shadow-2xs border transform active:scale-95"
                                         :class="selectedStos.includes('PLR') ? 'bg-red-50/70 text-[#410001] border-[#bc0007] ring-1 ring-[#bc0007]' : 'bg-slate-50 text-slate-900 border-slate-200 hover:bg-slate-100/70'">
                                        <div>
                                            <span class="font-headline text-sm font-bold block">PLR</span>
                                            <span class="text-xs block text-slate-700">Palabuhanratu</span>
                                            <span class="font-telemetry text-[11px] mt-1 block"
                                                  :class="selectedStos.includes('PLR') ? 'text-red-700 font-bold' : 'text-slate-500'">19 ODC // 142 ODP</span>
                                        </div>
                                        <span class="material-symbols-outlined text-lg"
                                              :class="selectedStos.includes('PLR') ? 'text-[#bc0007]' : 'text-slate-300'"
                                              x-text="selectedStos.includes('PLR') ? 'check_circle' : 'radio_button_unchecked'"></span>
                                    </div>

                                    <!-- STO SGN (Sagaranten) -->
                                    <div @click="toggleSto('SGN')" 
                                         class="p-3 rounded-xl transition-all cursor-pointer select-none flex items-start justify-between shadow-2xs border transform active:scale-95"
                                         :class="selectedStos.includes('SGN') ? 'bg-red-50/70 text-[#410001] border-[#bc0007] ring-1 ring-[#bc0007]' : 'bg-slate-50 text-slate-900 border-slate-200 hover:bg-slate-100/70'">
                                        <div>
                                            <span class="font-headline text-sm font-bold block">SGN</span>
                                            <span class="text-xs block text-slate-700">Sagaranten</span>
                                            <span class="font-telemetry text-[11px] mt-1 block"
                                                  :class="selectedStos.includes('SGN') ? 'text-red-700 font-bold' : 'text-slate-500'">9 ODC // 64 ODP</span>
                                        </div>
                                        <span class="material-symbols-outlined text-lg"
                                              :class="selectedStos.includes('SGN') ? 'text-[#bc0007]' : 'text-slate-300'"
                                              x-text="selectedStos.includes('SGN') ? 'check_circle' : 'radio_button_unchecked'"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Regu & Atasan Langsung -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Tim Pemeliharaan / Sektor Regu Custom Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5 flex items-center justify-between min-h-[22px]">
                                        <span class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[16px] text-[#bc0007]">groups</span>
                                            <span>Tim Pemeliharaan / Sektor Regu</span>
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-normal" x-show="regu">Terpilih</span>
                                    </label>
                                    
                                    <!-- Trigger Button -->
                                    <button type="button"
                                            @click="open = !open"
                                            @click.outside="open = false"
                                            @keydown.escape.window="open = false"
                                            class="w-full h-[46px] min-h-[46px] px-3.5 py-2 rounded-xl text-left transition-all duration-200 flex items-center justify-between gap-2.5 border shadow-2xs cursor-pointer select-none"
                                            :class="open ? 'bg-white border-[#bc0007] ring-2 ring-red-500/15 shadow-xs' : 'bg-slate-50 hover:bg-slate-100/70 border-slate-200/90'">
                                        
                                        <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                            <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 transition-colors"
                                                 :class="regu ? 'bg-red-50 text-[#bc0007]' : 'bg-slate-200/60 text-slate-400'">
                                                <span class="material-symbols-outlined text-[17px]">groups</span>
                                            </div>
                                            
                                            <div class="flex flex-col min-w-0 flex-1">
                                                <template x-if="!regu">
                                                    <span class="text-xs sm:text-sm text-slate-400 font-normal truncate">-- Pilih Tim Pemeliharaan / Regu --</span>
                                                </template>
                                                <template x-if="regu">
                                                    <div class="flex flex-col min-w-0">
                                                        <span class="text-xs sm:text-sm font-bold text-slate-900 truncate" x-text="getReguLabel()"></span>
                                                        <span class="text-[10px] text-slate-500 truncate" x-text="getReguDesc()"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-1.5 shrink-0">
                                            <template x-if="regu">
                                                <span class="px-1.5 py-0.5 rounded text-[10px] font-telemetry font-bold bg-red-100/80 text-[#bc0007]" x-text="getReguBadge()"></span>
                                            </template>
                                            <span class="material-symbols-outlined text-[18px] text-slate-400 transition-transform duration-200"
                                                  :class="open ? 'rotate-180 text-[#bc0007]' : ''">keyboard_arrow_down</span>
                                        </div>
                                    </button>

                                    <!-- Custom Dropdown Menu -->
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-150 transform"
                                         x-transition:enter-start="opacity-0 translate-y-1 scale-[0.99]"
                                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                         x-transition:leave="transition ease-in duration-100 transform"
                                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                         x-transition:leave-end="opacity-0 translate-y-1 scale-[0.99]"
                                         class="absolute z-50 left-0 right-0 mt-1.5 max-h-64 sm:max-h-72 overflow-y-auto rounded-xl bg-white/98 backdrop-blur-md border border-slate-200 shadow-xl shadow-slate-900/10 p-1.5 space-y-1 divide-y divide-slate-100/60 custom-scrollbar"
                                         style="display: none;">
                                         
                                        <template x-for="item in regus" :key="item.val">
                                            <div @click="regu = item.val; open = false"
                                                 class="w-full text-left p-2.5 sm:p-3 rounded-lg transition-all flex items-start justify-between gap-3 group cursor-pointer"
                                                 :class="regu === item.val ? 'bg-red-50/80 border border-red-200/70 text-[#bc0007]' : 'hover:bg-slate-50 text-slate-800 border border-transparent'">
                                                <div class="flex flex-col min-w-0 flex-1">
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#bc0007] transition-colors" x-text="item.title"></span>
                                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-telemetry font-bold shrink-0"
                                                              :class="regu === item.val ? 'bg-red-200/80 text-[#bc0007]' : 'bg-slate-100 text-slate-600'" 
                                                              x-text="item.badge"></span>
                                                    </div>
                                                    <span class="text-[11px] text-slate-500 leading-relaxed mt-0.5" x-text="item.desc"></span>
                                                </div>
                                                <span class="material-symbols-outlined text-[18px] text-[#bc0007] shrink-0 mt-0.5"
                                                      x-show="regu === item.val">check_circle</span>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div class="relative">
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5 flex items-center justify-between min-h-[22px]">
                                        <span class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[16px] text-[#bc0007]">badge</span>
                                            <span>Atasan Langsung / SPV / Asman Verifikator</span>
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-normal" x-show="supervisor">Terisi</span>
                                    </label>
                                    <div class="relative flex items-center">
                                        <input type="text" 
                                               x-model="supervisor" 
                                               placeholder="Nama & Jabatan SPV / Asman (Contoh: Bpk. Rian Pratama - SPV DAMAN)" 
                                               class="w-full h-[46px] min-h-[46px] px-3.5 pr-10 py-2 bg-slate-50 text-slate-900 text-xs sm:text-sm rounded-xl border border-slate-200 focus:bg-white focus:outline-none focus:border-[#bc0007] focus:ring-2 focus:ring-red-500/20 shadow-2xs font-medium placeholder:text-slate-400 transition-all">
                                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px] pointer-events-none">badge</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: Peran Akun & Hak Akses (Role Hierarchy) -->
                        <div class="space-y-4 pt-2">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                <span class="text-xs font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                                    <span class="w-1.5 h-4 bg-[#bc0007] rounded-full"></span>
                                    2. Peran Akun & Hak Akses (Role Hierarchy)
                                </span>
                                <span class="text-[11px] font-semibold text-slate-500">Tentukan Tingkat Wewenang</span>
                            </div>

                            <!-- Radio Role Selectors -->
                            <div class="space-y-3">
                                
                                <!-- Role 1: Helpdesk HD Daman -->
                                <label class="flex items-start gap-3.5 p-4 rounded-xl cursor-pointer shadow-2xs border transition-all"
                                       :class="role === 'valins_validator' ? 'bg-red-50/40 border-[#bc0007] ring-1 ring-[#bc0007]' : 'bg-white border-slate-200 hover:bg-slate-50'">
                                    <input type="radio" name="role_choice" value="valins_validator" x-model="role" class="mt-1 w-4 h-4 text-[#bc0007] focus:ring-[#bc0007] accent-[#bc0007]">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-headline text-xs sm:text-sm font-bold text-slate-900">Helpdesk HD Daman</span>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase"
                                                  :class="role === 'valins_validator' ? 'bg-red-100 text-[#960005]' : 'bg-slate-100 text-slate-600'">
                                                Terpilih
                                            </span>
                                        </div>
                                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                                            Akses validasi QR code, update status data, unggah foto redaman, serta sinkronisasi BAST lapangan.
                                        </p>
                                    </div>
                                </label>

                                <!-- Role 2: NOC Engineer & GPON Analyst -->
                                <label class="flex items-start gap-3.5 p-4 rounded-xl cursor-pointer shadow-2xs border transition-all"
                                       :class="role === 'noc_engineer' ? 'bg-red-50/40 border-[#bc0007] ring-1 ring-[#bc0007]' : 'bg-white border-slate-200 hover:bg-slate-50'">
                                    <input type="radio" name="role_choice" value="noc_engineer" x-model="role" class="mt-1 w-4 h-4 text-[#bc0007] focus:ring-[#bc0007] accent-[#bc0007]">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-headline text-xs sm:text-sm font-bold text-slate-900">NOC Engineer & GPON Analyst</span>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 text-slate-600">
                                                NOC Console
                                            </span>
                                        </div>
                                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                                            Akses monitoring telemetri OLT, alarm redaman LOS/LOF, diagnosis trace route optik, dan konfigurasi port GPON.
                                        </p>
                                    </div>
                                </label>

                                <!-- Role 3: Validator Valins Services & GPON -->
                                <label class="flex items-start gap-3.5 p-4 rounded-xl cursor-pointer shadow-2xs border transition-all"
                                       :class="role === 'valins_services' ? 'bg-red-50/40 border-[#bc0007] ring-1 ring-[#bc0007]' : 'bg-white border-slate-200 hover:bg-slate-50'">
                                    <input type="radio" name="role_choice" value="valins_services" x-model="role" class="mt-1 w-4 h-4 text-[#bc0007] focus:ring-[#bc0007] accent-[#bc0007]">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-headline text-xs sm:text-sm font-bold text-slate-900">Validator Valins Services & GPON</span>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 text-slate-600">
                                                Operasional Tiket
                                            </span>
                                        </div>
                                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                                            Pengelolaan tiket insiden fisik kabel putus, eskalasi bot Telegram dispatcher, rekapitulasi performa teknisi harian.
                                        </p>
                                    </div>
                                </label>
                            </div>

                            <!-- Matriks Izin Modul Sistem Dinamis -->
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                                <span class="text-xs font-bold text-slate-900 block mb-2.5">
                                    Matriks Izin Modul Sistem (Otomatis disesuaikan dengan Role terpilih)
                                </span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                    <div class="flex items-center gap-2 transition-colors duration-200"
                                         :class="isPermissionGranted('uim_sap') ? 'text-slate-800 font-medium' : 'text-slate-400 opacity-60'">
                                        <span class="material-symbols-outlined text-[18px]"
                                              :class="isPermissionGranted('uim_sap') ? 'text-emerald-600' : 'text-slate-400'"
                                              x-text="isPermissionGranted('uim_sap') ? 'check_box' : 'check_box_outline_blank'">check_box</span>
                                        <span>Sinkronisasi Data UIM SAP</span>
                                    </div>
                                    <div class="flex items-center gap-2 transition-colors duration-200"
                                         :class="isPermissionGranted('valins_mobile') ? 'text-slate-800 font-medium' : 'text-slate-400 opacity-60'">
                                        <span class="material-symbols-outlined text-[18px]"
                                              :class="isPermissionGranted('valins_mobile') ? 'text-emerald-600' : 'text-slate-400'"
                                              x-text="isPermissionGranted('valins_mobile') ? 'check_box' : 'check_box_outline_blank'">check_box</span>
                                        <span>Input Validasi Lapangan (VALINS Mobile)</span>
                                    </div>
                                    <div class="flex items-center gap-2 transition-colors duration-200"
                                         :class="isPermissionGranted('gis_topology') ? 'text-slate-800 font-medium' : 'text-slate-400 opacity-60'">
                                        <span class="material-symbols-outlined text-[18px]"
                                              :class="isPermissionGranted('gis_topology') ? 'text-emerald-600' : 'text-slate-400'"
                                              x-text="isPermissionGranted('gis_topology') ? 'check_box' : 'check_box_outline_blank'">check_box</span>
                                        <span>Akses Peta Topologi Fiber GIS</span>
                                    </div>
                                    <div class="flex items-center gap-2 transition-colors duration-200"
                                         :class="isPermissionGranted('olt_command') ? 'text-slate-800 font-medium' : 'text-slate-400 opacity-60'">
                                        <span class="material-symbols-outlined text-[18px]"
                                              :class="isPermissionGranted('olt_command') ? 'text-emerald-600' : 'text-slate-400'"
                                              x-text="isPermissionGranted('olt_command') ? 'check_box' : 'check_box_outline_blank'">check_box</span>
                                        <span>Kontrol Command OLT GPON (Read-Only)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: Real Working Document Upload System -->
                        <div class="space-y-4 pt-2">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                <span class="text-xs font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                                    <span class="w-1.5 h-4 bg-[#bc0007] rounded-full"></span>
                                    3. Dokumen Verifikasi Penugasan
                                </span>
                                <span class="text-[11px] font-semibold text-slate-500">PDF / JPG / PNG (Maks 5MB)</span>
                            </div>

                            <!-- Hidden Native File Input -->
                            <input type="file" 
                                   id="suratTugasInput" 
                                   class="hidden" 
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   @change="handleFileSelect($event)">

                            <!-- STATE 1: Empty Dropzone (No File & Not Uploading) -->
                            <template x-if="!uploadedFile && !isUploading">
                                <div @click="document.getElementById('suratTugasInput').click()"
                                     @dragover.prevent="isDragging = true"
                                     @dragleave.prevent="isDragging = false"
                                     @drop.prevent="handleFileDrop($event)"
                                     class="relative p-8 rounded-2xl bg-gradient-to-b from-slate-50/80 to-white hover:bg-red-50/20 border-2 border-dashed text-center flex flex-col items-center justify-center cursor-pointer transition-all duration-300 group shadow-2xs"
                                     :class="isDragging ? 'drag-active bg-red-50/70 border-[#bc0007] scale-[1.01]' : 'border-slate-300 hover:border-[#bc0007] hover:shadow-md'">
                                    
                                    <div class="w-14 h-14 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center text-[#bc0007] mb-3.5 group-hover:scale-110 group-hover:bg-[#bc0007] group-hover:text-white transition-all duration-300 shadow-sm">
                                        <span class="material-symbols-outlined text-[30px]">cloud_upload</span>
                                    </div>
                                    
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#bc0007] transition-colors">
                                        Upload berkas Surat Tugas resmi atau klik untuk telusuri (Opsional)
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-1 max-w-md leading-relaxed">
                                        Format didukung: <span class="font-semibold text-slate-700">PDF, JPG, atau PNG</span> yang disahkan oleh Manager Witel/Asman Unit.
                                    </p>
                                    
                                    <div class="mt-4 flex flex-wrap items-center justify-center gap-2">
                                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white text-slate-700 font-semibold text-xs border border-slate-200 shadow-2xs group-hover:border-red-200 transition-colors">
                                            <span class="material-symbols-outlined text-[16px] text-[#bc0007]">attach_file</span>
                                            <span>Pilih berkas dari perangkat Anda</span>
                                        </span>
                                    </div>
                                </div>
                            </template>

                            <!-- STATE 2: Uploading Progress Bar -->
                            <template x-if="isUploading">
                                <div class="p-8 rounded-2xl bg-white border border-slate-200 shadow-sm text-center flex flex-col items-center justify-center animate-pulse">
                                    <div class="w-12 h-12 rounded-2xl bg-red-50 text-[#bc0007] flex items-center justify-center mb-3">
                                        <span class="material-symbols-outlined text-2xl animate-spin">sync</span>
                                    </div>
                                    <p class="text-xs sm:text-sm font-bold text-slate-900">Memproses & Memverifikasi Integritas Dokumen...</p>
                                    <p class="font-telemetry text-xs text-slate-500 mt-1" x-text="`${uploadProgress}% Selesai`"></p>
                                    
                                    <div class="w-full max-w-sm bg-slate-100 h-2.5 rounded-full mt-3.5 overflow-hidden p-0.5 border border-slate-200">
                                        <div class="h-full bg-gradient-to-r from-red-600 to-[#bc0007] transition-all duration-150 rounded-full"
                                             :style="`width: ${uploadProgress}%`"></div>
                                    </div>
                                </div>
                            </template>

                            <!-- STATE 3: File Uploaded & Verified Card -->
                            <template x-if="uploadedFile && !isUploading">
                                <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-emerald-50/50 via-white to-white border border-emerald-300/90 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all">
                                    <div class="flex items-center gap-3.5 min-w-0">
                                        <!-- Thumbnail if Image, or PDF Badge -->
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 shadow-xs border overflow-hidden"
                                             :class="uploadedFile.type === 'pdf' ? 'bg-red-50 border-red-200 text-[#bc0007]' : 'bg-sky-50 border-sky-200 text-sky-700'">
                                            <template x-if="uploadedFile.type === 'image' && uploadedFile.previewUrl">
                                                <img :src="uploadedFile.previewUrl" alt="Pratinjau" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="uploadedFile.type === 'pdf' || !uploadedFile.previewUrl">
                                                <div class="flex flex-col items-center">
                                                    <span class="material-symbols-outlined text-[24px]">picture_as_pdf</span>
                                                    <span class="text-[9px] font-bold uppercase leading-none font-telemetry mt-0.5">PDF</span>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- File Information -->
                                        <div class="flex flex-col min-w-0">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs sm:text-sm font-bold text-slate-900 truncate" x-text="uploadedFile.name"></span>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold shrink-0 shadow-2xs">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                                    Terunggah & Valid
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2 font-telemetry text-[11px] text-slate-500 mt-1">
                                                <span x-text="uploadedFile.size"></span>
                                                <span>•</span>
                                                <span class="text-slate-600 font-semibold" x-text="uploadedFile.extension"></span>
                                                <span>•</span>
                                                <span class="text-emerald-700 font-semibold">Siap Disinkronkan</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                                        <!-- Preview Button -->
                                        <button type="button" 
                                                @click="previewModalOpen = true"
                                                title="Lihat Pratinjau Dokumen"
                                                class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-slate-900 hover:bg-slate-50 font-semibold text-xs flex items-center gap-1.5 shadow-2xs transition-colors">
                                            <span class="material-symbols-outlined text-[16px] text-sky-700">visibility</span>
                                            <span>Pratinjau</span>
                                        </button>

                                        <!-- Replace Button -->
                                        <button type="button" 
                                                @click="document.getElementById('suratTugasInput').click()" 
                                                title="Ganti Berkas Lain"
                                                class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-slate-900 hover:bg-slate-50 font-semibold text-xs flex items-center gap-1.5 shadow-2xs transition-colors">
                                            <span class="material-symbols-outlined text-[16px] text-slate-600">sync</span>
                                            <span>Ganti</span>
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" 
                                                @click="removeFile()" 
                                                title="Batalkan & Hapus Berkas"
                                                class="w-8 h-8 rounded-xl bg-red-50 border border-red-200 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition-colors shadow-2xs">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Action Navigation Buttons Step 2 & Login Link -->
                        <div class="pt-4 border-t border-slate-100 flex flex-col gap-3">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                                <button type="button" 
                                        @click="goToStep(1)"
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 h-11 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                                    <span>Kembali ke Langkah 1</span>
                                </button>

                                <button type="button" 
                                        @click="goToStep(3)"
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 h-11 rounded-xl bg-[#bc0007] hover:bg-[#960005] text-white font-bold text-xs tracking-wide shadow-md shadow-red-600/25 transition-all group hover-sheen">
                                    <span>Lanjut ke Langkah 3: Kredensial & Akses</span>
                                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </button>
                            </div>

                            <!-- Centered Direct Link to Login (Khusus Desktop & Laptop) -->
                            <div class="hidden lg:block text-center pt-1">
                                <p class="text-xs text-slate-500">
                                    <span>Sudah Punya Akun?</span>
                                    <a href="{{ route('login') }}" class="font-bold text-[#bc0007] hover:text-[#960005] hover:underline inline-flex items-center gap-0.5 ml-1 transition-colors">
                                        <span>Masuk</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================================================= -->
                    <!-- STEP 3: Kredensial & Akses                                                -->
                    <!-- ========================================================================= -->
                    <div x-show="step === 3" 
                         :class="stepDirection === 'forward' ? 'step-pane-forward' : 'step-pane-backward'"
                         class="flex flex-col gap-4 sm:gap-4.5" style="display: none;">

                        <!-- Security Callout Info Box -->
                        <div class="bg-slate-50 border-l-4 border-[#bc0007] p-3.5 sm:p-4 rounded-r-2xl flex gap-3 items-start border border-slate-200">
                            <span class="material-symbols-outlined text-[#bc0007] text-[22px] shrink-0 mt-0.5">shield</span>
                            <div class="flex flex-col gap-1">
                                <h4 class="font-headline text-xs sm:text-sm text-slate-900 font-bold">Standar Keamanan Siber Jaringan Korporat & SSO Telkom</h4>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Kredensial akun Anda akan dienkripsi dengan standar TLS v1.3 & SHA-256. Akun ini mendukung autentikasi Multi-Factor (MFA) via OTP WhatsApp & Telegram Bot NOC Witel Sukabumi.
                                </p>
                            </div>
                        </div>

                        <!-- Section 1: Kredensial Akun & Kata Sandi -->
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                                <span class="font-telemetry text-[#bc0007] font-bold text-xs">01.</span>
                                <h3 class="font-headline text-xs sm:text-sm text-slate-900 font-semibold">Kredensial Akun & Kata Sandi</h3>
                            </div>

                            <!-- SSO ID (Readonly LDAP) -->
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs text-slate-800 font-bold">
                                        Username / User ID SSO Kedinasan <span class="text-red-600">*</span>
                                    </label>
                                </div>
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined absolute left-3 text-slate-400 text-[20px]">badge</span>
                                    <input type="text" 
                                           readonly 
                                           :value="email || (fullName ? fullName.toLowerCase().replace(/\s+/g, '.') + '@telkomakses.co.id' : 'petugas@telkomakses.co.id')"
                                           class="w-full bg-slate-100 pl-10 pr-24 py-2.5 rounded-xl border border-slate-200 text-slate-800 font-telemetry text-xs sm:text-sm cursor-not-allowed select-all focus:outline-none">
                                    <span class="absolute right-3 font-telemetry text-[11px] text-slate-500 font-semibold bg-slate-200/70 px-2 py-0.5 rounded">
                                        AUTO-SYNC
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500">Username SSO disinkronkan otomatis sesuai email resmi Anda.</p>
                            </div>

                            <!-- 2-Column Grid: Password & Confirm Password -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Password Input -->
                                <div class="flex flex-col gap-1.5">
                                    <label for="passInput" class="text-xs text-slate-800 font-bold">
                                        Kata Sandi Akun <span class="text-red-600">*</span>
                                    </label>
                                    <div class="relative flex items-center">
                                        <span class="material-symbols-outlined absolute left-3 text-slate-400 text-[20px]">lock</span>
                                        <input id="passInput" 
                                                :type="showPassword ? 'text' : 'password'" 
                                                x-model="password"
                                                @input="updatePassStrength()"
                                                required
                                                placeholder="Minimal 8 karakter unik"
                                                class="w-full bg-slate-50 pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 text-slate-900 font-telemetry text-xs sm:text-sm focus:bg-white focus:border-[#bc0007] focus:ring-2 focus:ring-red-500/20 focus:outline-none transition-all shadow-2xs">
                                        <button type="button" 
                                                @click="showPassword = !showPassword" 
                                                class="absolute right-3 text-slate-400 hover:text-slate-700 focus:outline-none">
                                            <span class="material-symbols-outlined text-[20px]" x-text="showPassword ? 'visibility_off' : 'visibility'">visibility</span>
                                        </button>
                                    </div>

                                    <!-- Password Strength Meter -->
                                    <div class="flex flex-col gap-1 pt-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-telemetry text-[11px] font-bold"
                                                  :class="passStrength === 4 ? 'text-emerald-700' : (passStrength >= 2 ? 'text-amber-600' : 'text-slate-500')">
                                                <span class="w-1.5 h-1.5 rounded-full inline-block mr-1"
                                                      :class="passStrength === 4 ? 'bg-emerald-600' : (passStrength >= 2 ? 'bg-amber-500' : 'bg-slate-400')"></span>
                                                Kekuatan: <span x-text="passLabel">Belum diisi</span>
                                            </span>
                                            <span class="font-telemetry text-[11px] text-slate-500" x-text="`Skor Entropi: ${passStrength}/4`">Skor Entropi: 0/4</span>
                                        </div>
                                        <div class="w-full h-1.5 rounded-full bg-slate-200 overflow-hidden flex gap-1">
                                            <div class="h-full flex-1 rounded-full transition-colors duration-300"
                                                 :class="passStrength >= 1 ? (passStrength === 1 ? 'bg-red-500' : (passStrength === 2 ? 'bg-amber-400' : (passStrength === 3 ? 'bg-sky-500' : 'bg-emerald-500'))) : 'bg-slate-200'"></div>
                                            <div class="h-full flex-1 rounded-full transition-colors duration-300"
                                                 :class="passStrength >= 2 ? (passStrength === 2 ? 'bg-amber-400' : (passStrength === 3 ? 'bg-sky-500' : 'bg-emerald-500')) : 'bg-slate-200'"></div>
                                            <div class="h-full flex-1 rounded-full transition-colors duration-300"
                                                 :class="passStrength >= 3 ? (passStrength === 3 ? 'bg-sky-500' : 'bg-emerald-500') : 'bg-slate-200'"></div>
                                            <div class="h-full flex-1 rounded-full transition-colors duration-300"
                                                 :class="passStrength >= 4 ? 'bg-emerald-500' : 'bg-slate-200'"></div>
                                        </div>
                                    </div>

                                    <!-- Rule Checklist Grid -->
                                    <div class="grid grid-cols-2 gap-2 pt-1 font-telemetry text-[11px]">
                                        <div class="flex items-center gap-1.5 px-2 py-1 rounded border transition-colors"
                                             :class="hasMinLength ? 'bg-emerald-50 border-emerald-100 text-emerald-800' : 'bg-slate-50 border-slate-200 text-slate-400'">
                                            <span class="material-symbols-outlined text-[14px]" :class="hasMinLength ? 'text-emerald-600' : 'text-slate-400'" x-text="hasMinLength ? 'check_circle' : 'circle'">circle</span>
                                            <span>Min. 8 karakter</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 px-2 py-1 rounded border transition-colors"
                                             :class="hasUpper ? 'bg-emerald-50 border-emerald-100 text-emerald-800' : 'bg-slate-50 border-slate-200 text-slate-400'">
                                            <span class="material-symbols-outlined text-[14px]" :class="hasUpper ? 'text-emerald-600' : 'text-slate-400'" x-text="hasUpper ? 'check_circle' : 'circle'">circle</span>
                                            <span>Huruf kapital (A-Z)</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 px-2 py-1 rounded border transition-colors"
                                             :class="hasNumber ? 'bg-emerald-50 border-emerald-100 text-emerald-800' : 'bg-slate-50 border-slate-200 text-slate-400'">
                                            <span class="material-symbols-outlined text-[14px]" :class="hasNumber ? 'text-emerald-600' : 'text-slate-400'" x-text="hasNumber ? 'check_circle' : 'circle'">circle</span>
                                            <span>Angka numerik (0-9)</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 px-2 py-1 rounded border transition-colors"
                                             :class="hasSymbol ? 'bg-emerald-50 border-emerald-100 text-emerald-800' : 'bg-slate-50 border-slate-200 text-slate-400'">
                                            <span class="material-symbols-outlined text-[14px]" :class="hasSymbol ? 'text-emerald-600' : 'text-slate-400'" x-text="hasSymbol ? 'check_circle' : 'circle'">circle</span>
                                            <span>Simbol (!@#$)</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Confirm Password Input -->
                                <div class="flex flex-col gap-1.5">
                                    <label for="confirmPassInput" class="text-xs text-slate-800 font-bold">
                                        Konfirmasi Kata Sandi <span class="text-red-600">*</span>
                                    </label>
                                    <div class="relative flex items-center">
                                        <span class="material-symbols-outlined absolute left-3 text-slate-400 text-[20px]">lock_clock</span>
                                        <input id="confirmPassInput" 
                                                :type="showConfirmPassword ? 'text' : 'password'" 
                                                x-model="passwordConfirmation"
                                                @input="checkPasswordMatch()"
                                                required
                                                placeholder="Ulangi kata sandi"
                                                class="w-full bg-slate-50 pl-10 pr-24 py-2.5 rounded-xl border text-slate-900 font-telemetry text-xs sm:text-sm focus:outline-none transition-all shadow-2xs"
                                                :class="passwordConfirmation.length > 0 ? (passwordsMatch ? 'border-emerald-500 ring-2 ring-emerald-500/20 bg-white' : 'border-red-400 ring-2 ring-red-500/20 bg-white') : 'border-slate-200 focus:bg-white focus:border-[#bc0007] focus:ring-2 focus:ring-red-500/20'">
                                        
                                        <!-- Match Badge -->
                                        <div x-show="passwordConfirmation.length > 0" 
                                             class="absolute right-3 flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-telemetry font-bold"
                                             :class="passwordsMatch ? 'text-emerald-700 bg-emerald-100' : 'text-red-700 bg-red-100'">
                                            <span class="material-symbols-outlined text-[14px]" x-text="passwordsMatch ? 'check' : 'close'">check</span>
                                            <span x-text="passwordsMatch ? 'Cocok' : 'Belum sama'">Cocok</span>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-slate-500">Pastikan penulisan identik tanpa spasi berlebih untuk validasi.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Verifikasi Dua Faktor (2FA) & Notifikasi Dispatch -->
                        <div class="flex flex-col gap-5">
                            <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                                <span class="font-telemetry text-[#bc0007] font-bold text-xs">02.</span>
                                <h3 class="font-headline text-xs sm:text-sm text-slate-900 font-semibold">Verifikasi Dua Faktor (2FA) & Notifikasi Dispatch</h3>
                            </div>

                            <!-- Radio Selection of 2FA Methods with Modern Minimalist Outlined (Line Art) Squircle Icons -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Option A: Telegram Saved Messages -->
                                <label class="group relative flex flex-col p-4 sm:p-5 rounded-2xl border-2 cursor-pointer shadow-xs transition-all duration-300"
                                       :class="mfaMethod === 'telegram' 
                                           ? 'border-[#24A1DE] bg-gradient-to-br from-sky-50/90 via-white to-sky-50/40 ring-2 ring-[#24A1DE]/30 shadow-md shadow-sky-500/10' 
                                           : 'border-slate-200 bg-white/80 hover:border-slate-300 hover:bg-slate-50/70 shadow-2xs'">
                                    <input type="radio" name="mfa_choice" value="telegram" x-model="mfaMethod" class="sr-only">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <!-- Modern Minimalist Outlined (Line Art) Telegram Squircle Icon -->
                                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 transition-all duration-300"
                                                 :class="mfaMethod === 'telegram' ? 'bg-sky-100/90 text-[#0284C7] border border-sky-300/80 shadow-sm shadow-sky-500/10' : 'bg-slate-100/90 text-slate-500 border border-slate-200 group-hover:bg-sky-50 group-hover:text-[#0284C7]'">
                                                <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M22 2L11 13" />
                                                    <path d="M22 2L15 22L11 13L2 9L22 2Z" />
                                                </svg>
                                            </div>
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                                                    <span class="font-headline text-xs sm:text-sm font-bold text-slate-900">Telegram Saved Messages</span>
                                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full whitespace-nowrap shrink-0 transition-colors"
                                                          :class="mfaMethod === 'telegram' ? 'bg-[#24A1DE]/20 text-[#1578a7] border border-[#24A1DE]/40' : 'bg-slate-100 text-slate-500'">
                                                        LINE ART
                                                    </span>
                                                </div>
                                                <span class="text-[11px] text-slate-500 font-sans mt-0.5">Pesan Tersimpan Cloud • Bebas Biaya SMS</span>
                                            </div>
                                        </div>
                                        <span class="material-symbols-outlined text-[22px] shrink-0 transition-colors duration-300"
                                              :class="mfaMethod === 'telegram' ? 'text-[#24A1DE]' : 'text-slate-300'"
                                              x-text="mfaMethod === 'telegram' ? 'radio_button_checked' : 'radio_button_unchecked'">radio_button_checked</span>
                                    </div>
                                    <p class="text-[11px] text-slate-600 leading-relaxed mt-2.5 pt-2 border-t border-slate-100">
                                        Kanal instan Telegram Cloud: Kode OTP dikirim ke <strong>Saved Messages</strong> akun Telegram Anda dengan latensi ultra rendah STO Sukabumi.
                                    </p>
                                </label>

                                <!-- Option B: WhatsApp Message Yourself -->
                                <label class="group relative flex flex-col p-4 sm:p-5 rounded-2xl border-2 cursor-pointer shadow-xs transition-all duration-300"
                                       :class="mfaMethod === 'whatsapp' 
                                           ? 'border-[#25D366] bg-gradient-to-br from-emerald-50/90 via-white to-emerald-50/40 ring-2 ring-[#25D366]/30 shadow-md shadow-emerald-500/10' 
                                           : 'border-slate-200 bg-white/80 hover:border-slate-300 hover:bg-slate-50/70 shadow-2xs'">
                                    <input type="radio" name="mfa_choice" value="whatsapp" x-model="mfaMethod" class="sr-only">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <!-- Official High-Precision WhatsApp Icon & Badge -->
                                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 transition-all duration-300"
                                                 :class="mfaMethod === 'whatsapp' ? 'bg-emerald-100 text-[#25D366] border border-emerald-300 shadow-sm shadow-emerald-500/10' : 'bg-slate-100 text-slate-500 border border-slate-200 group-hover:bg-emerald-50 group-hover:text-[#25D366]'">
                                                <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 16 16" fill="currentColor">
                                                    <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                                </svg>
                                            </div>
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="font-headline text-xs sm:text-sm font-bold text-slate-900">WhatsApp Message Yourself</span>
                                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full whitespace-nowrap shrink-0 transition-colors"
                                                          :class="mfaMethod === 'whatsapp' ? 'bg-[#25D366]/20 text-[#137c38] border border-[#25D366]/40' : 'bg-slate-100 text-slate-500 border border-slate-200'">
                                                        OFFICIAL
                                                    </span>
                                                </div>
                                                <span class="text-[11px] text-slate-500 font-sans mt-0.5">Kirim ke Nomor Sendiri • Chat Pribadi</span>
                                            </div>
                                        </div>
                                        <span class="material-symbols-outlined text-[22px] shrink-0 transition-colors duration-300"
                                              :class="mfaMethod === 'whatsapp' ? 'text-[#25D366]' : 'text-slate-300'"
                                              x-text="mfaMethod === 'whatsapp' ? 'radio_button_checked' : 'radio_button_unchecked'">radio_button_unchecked</span>
                                    </div>
                                    <p class="text-[11px] text-slate-600 leading-relaxed mt-2.5 pt-2 border-t border-slate-100">
                                        Kanal instan WhatsApp: Kode OTP dikirim ke obrolan <strong>Message Yourself (Kirim ke Diri Sendiri)</strong> nomor WhatsApp Anda seketika.
                                    </p>
                                </label>
                            </div>

                            <!-- Full-Width Container: When Telegram is Selected -->
                            <div x-show="mfaMethod === 'telegram'" 
                                 x-transition:enter="transition ease-out duration-300 transform"
                                 x-transition:enter-start="opacity-0 -translate-y-2 scale-[0.99]"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 class="flex flex-col gap-3">
                                
                                <!-- Unified Elegant 2FA Card (Theme Aligned) -->
                                <div class="relative overflow-hidden rounded-2xl border border-sky-200/90 bg-gradient-to-br from-sky-50/80 via-white to-sky-50/40 p-3.5 sm:p-5 shadow-xs transition-all duration-300">
                                    <!-- Top Color Bar Accent -->
                                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-[#24A1DE] to-transparent"></div>

                                    <!-- Header Row: Identity & Status -->
                                    <div class="flex flex-wrap items-center justify-between gap-2.5 pb-3 border-b border-sky-100">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-10 h-10 rounded-xl bg-sky-100/90 text-[#0284C7] border border-sky-300/80 flex items-center justify-center shrink-0 shadow-2xs">
                                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M22 2L11 13" />
                                                    <path d="M22 2L15 22L11 13L2 9L22 2Z" />
                                                </svg>
                                            </div>
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-1.5 flex-wrap">
                                                    <span class="font-headline text-xs sm:text-sm font-bold text-slate-900">Telegram Saved Messages</span>
                                                    <span class="text-[10px] font-bold text-sky-700 bg-sky-100 px-2 py-0.5 rounded-full border border-sky-200">
                                                        CLOUD DIRECT
                                                    </span>
                                                </div>
                                                <span class="text-[11px] text-slate-500 font-sans">Kanal 2FA instan tanpa SMS • Sinkronisasi akun</span>
                                            </div>
                                        </div>

                                        <!-- Live Status & Node Latency Indicator -->
                                        <div class="flex items-center gap-2">
                                            <span class="hidden sm:inline-block font-telemetry text-[11px] text-slate-400">STO Sukabumi • 18ms</span>
                                        </div>
                                    </div>

                                    <!-- Middle Row: Interactive Input + High-Tech OTP Display -->
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5 my-3.5 items-center">
                                        <!-- Left: Handle Input (7 Cols) -->
                                        <div class="md:col-span-7 flex flex-col gap-1.5 min-w-0">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1.5 sm:gap-2">
                                                <label class="text-xs text-slate-800 font-bold flex items-center gap-1.5 select-none">
                                                    <span>Telegram Handle / ID</span>
                                                    <span class="text-slate-400 font-normal text-[10px] bg-slate-100 px-1.5 py-0.5 rounded">Opsional</span>
                                                </label>
                                                <div class="inline-flex items-center gap-1.5 text-[11px] text-slate-600 bg-sky-50/90 border border-sky-200/80 px-2.5 py-1 rounded-lg max-w-full sm:max-w-[60%] self-start sm:self-auto min-w-0">
                                                    <span class="text-slate-400 text-[10px] uppercase font-bold shrink-0">Tujuan:</span>
                                                    <strong class="text-sky-700 font-telemetry truncate block" 
                                                            x-text="telegramId ? `@${telegramId.replace(/^@/, '')}` : 'Saved Messages'">Saved Messages</strong>
                                                </div>
                                            </div>
                                            <div class="relative flex items-center">
                                                <span class="font-telemetry text-slate-400 absolute left-3.5 text-xs sm:text-sm font-bold">@</span>
                                                <input type="text" 
                                                       x-model="telegramId"
                                                       @input="ensureDirectMessage('telegram', false)"
                                                       placeholder="username_telegram_anda"
                                                       class="w-full bg-white pl-8 pr-3.5 py-2.5 rounded-xl border border-slate-200 font-telemetry text-xs sm:text-sm text-slate-900 focus:outline-none focus:border-[#24A1DE] focus:ring-2 focus:ring-[#24A1DE]/20 shadow-2xs transition-all">
                                            </div>
                                        </div>

                                        <!-- Right: Elegant OTP Highlight Box with Copy Button (5 Cols) -->
                                        <div class="md:col-span-5 bg-white p-3 rounded-xl border border-sky-200/80 shadow-2xs flex items-center justify-between gap-3">
                                            <div class="flex flex-col min-w-0">
                                                <span class="text-[10px] uppercase font-telemetry text-slate-400 font-bold tracking-wider flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[13px] text-[#24A1DE]">key</span>
                                                    <span>KODE TOKEN OTP</span>
                                                </span>
                                                <span class="font-telemetry text-xl sm:text-2xl font-black text-sky-700 tracking-widest leading-tight mt-0.5" 
                                                      x-text="testMessageData ? testMessageData.token : '849-201'">849-201</span>
                                            </div>
                                            <button type="button" 
                                                    @click="copyOtpToken(testMessageData ? testMessageData.token : '849-201')"
                                                    class="px-3 py-2 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-800 border border-sky-200 font-bold text-xs flex items-center gap-1.5 transition-all active:scale-95 shrink-0"
                                                    title="Salin Token">
                                                <span class="material-symbols-outlined text-[16px]" x-text="tokenCopied ? 'check' : 'content_copy'">content_copy</span>
                                                <span x-text="tokenCopied ? 'Tersalin' : 'Salin'">Salin</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Subtle Info Strip: Clean, Single-line, Elegant -->
                                    <div class="px-3.5 py-2 rounded-xl bg-sky-50/60 border border-sky-100 text-[11px] text-slate-600 flex items-start sm:items-center gap-2">
                                        <span class="material-symbols-outlined text-[#24A1DE] text-[16px] shrink-0 mt-0.5 sm:mt-0">info</span>
                                        <span class="leading-relaxed">
                                            Pesan 2FA otomatis disiapkan. Klik <strong>Kirim ke Telegram</strong> atau salin token OTP untuk verifikasi akun Anda.
                                        </span>
                                    </div>

                                    <!-- Action Buttons: Clean Responsive Row -->
                                    <div class="mt-3.5 pt-3 border-t border-sky-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5">
                                        <!-- Primary Send Button -->
                                        <a :href="getTelegramTgUrl()"
                                           @click="handleTelegramClick($event)"
                                           class="w-full sm:w-auto px-4 sm:px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#24A1DE] to-[#1a8fc5] hover:from-[#1b8ec5] hover:to-[#157da9] text-white text-xs font-bold font-headline flex items-center justify-center gap-2 shadow-md shadow-sky-500/20 transition-all active:scale-95 cursor-pointer text-center">
                                            <span class="material-symbols-outlined text-[16px]">send</span>
                                            <span>Kirim ke Telegram</span>
                                        </a>

                                        <!-- Secondary Copy, Web, and Refresh Buttons -->
                                        <div class="flex items-center gap-2 w-full sm:w-auto">
                                            <button type="button" 
                                                    @click="copyFullMessage('telegram')"
                                                    class="flex-1 sm:flex-initial px-3 sm:px-3.5 py-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold flex items-center justify-center gap-1.5 transition-colors border border-slate-200 shadow-2xs active:scale-95">
                                                <span class="material-symbols-outlined text-[15px] text-slate-500">content_paste</span>
                                                <span>Salin Pesan</span>
                                            </button>

                                            <a :href="getTelegramWebUrl()"
                                               target="_blank"
                                               class="p-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-600 text-xs font-semibold flex items-center justify-center transition-colors border border-slate-200 shadow-2xs active:scale-95 shrink-0"
                                               title="Buka di Telegram Web">
                                                <span class="material-symbols-outlined text-[16px] text-slate-600">language</span>
                                            </a>

                                            <button type="button" 
                                                    @click="ensureDirectMessage('telegram', true)"
                                                    class="p-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-600 text-xs font-semibold flex items-center justify-center transition-colors border border-slate-200 shadow-2xs active:scale-95 shrink-0"
                                                    title="Perbarui Kode OTP">
                                                <span class="material-symbols-outlined text-[16px] text-[#24A1DE]">refresh</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Full-Width Container: When WhatsApp is Selected -->
                            <div x-show="mfaMethod === 'whatsapp'" 
                                 x-transition:enter="transition ease-out duration-300 transform"
                                 x-transition:enter-start="opacity-0 -translate-y-2 scale-[0.99]"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 class="flex flex-col gap-3">
                                
                                <!-- Unified Elegant 2FA Card (Theme Aligned) -->
                                <div class="relative overflow-hidden rounded-2xl border border-emerald-200/90 bg-gradient-to-br from-emerald-50/80 via-white to-emerald-50/40 p-3.5 sm:p-5 shadow-xs transition-all duration-300">
                                    <!-- Top Color Bar Accent -->
                                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-[#25D366] to-transparent"></div>

                                    <!-- Header Row: Identity & Status -->
                                    <div class="flex flex-wrap items-center justify-between gap-2.5 pb-3 border-b border-emerald-100">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-10 h-10 rounded-xl bg-emerald-100/90 text-[#25D366] border border-emerald-300/80 flex items-center justify-center shrink-0 shadow-2xs">
                                                <svg class="w-5 h-5" viewBox="0 0 16 16" fill="currentColor">
                                                    <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                                </svg>
                                            </div>
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-1.5 flex-wrap">
                                                    <span class="font-headline text-xs sm:text-sm font-bold text-slate-900">WhatsApp Message Yourself</span>
                                                    <span class="text-[10px] font-bold text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded-full border border-emerald-200">
                                                        DIRECT CHAT
                                                    </span>
                                                </div>
                                                <span class="text-[11px] text-slate-500 font-sans">Kirim kode OTP ke obrolan nomor WhatsApp sendiri • Centang dua biru</span>
                                            </div>
                                        </div>

                                        <!-- Live Status & Read Receipt Indicator -->
                                        <div class="flex items-center gap-2">
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold transition-all"
                                                 :class="isDelivered ? 'bg-emerald-50 border border-emerald-200 text-emerald-700' : 'bg-emerald-50 border border-emerald-200 text-emerald-800'">
                                                <span class="w-2 h-2 rounded-full" :class="isDelivered ? 'bg-emerald-500 animate-pulse' : 'bg-[#25D366] animate-ping'"></span>
                                                <span x-text="isDelivered ? 'Terkirim ke WhatsApp' : 'Token 2FA Siap'">Token 2FA Siap</span>
                                            </div>
                                            <span class="hidden sm:inline-flex items-center gap-1 font-telemetry text-[11px] text-sky-600">
                                                <span class="material-symbols-outlined text-[14px]">done_all</span>
                                                Otomatis
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Middle Row: Interactive Input + High-Tech OTP Display -->
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5 my-3.5 items-center">
                                        <!-- Left: Phone Input (7 Cols) -->
                                        <div class="md:col-span-7 flex flex-col gap-1.5 min-w-0">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1.5 sm:gap-2">
                                                <label class="text-xs text-slate-800 font-bold flex items-center gap-1.5 select-none">
                                                    <span>Nomor WhatsApp Penerima</span>
                                                    <span class="text-slate-500 font-normal text-[10px] bg-slate-100 px-1.5 py-0.5 rounded">Angka saja</span>
                                                </label>
                                                <div class="inline-flex items-center gap-1.5 text-[11px] text-slate-600 bg-emerald-50/90 border border-emerald-200/80 px-2.5 py-1 rounded-lg max-w-full sm:max-w-[60%] self-start sm:self-auto min-w-0">
                                                    <span class="text-slate-400 text-[10px] uppercase font-bold shrink-0">Tujuan:</span>
                                                    <strong class="text-emerald-700 font-telemetry truncate block" 
                                                            x-text="waPhone ? `+62 ${waPhone.replace(/^0/, '')}` : 'Message Yourself'">Message Yourself</strong>
                                                </div>
                                            </div>
                                            <div class="flex h-11">
                                                <span class="inline-flex items-center px-3.5 bg-slate-100 text-slate-700 font-telemetry text-xs font-bold rounded-l-xl border border-r-0 border-slate-200 select-none">
                                                    +62
                                                </span>
                                                <input type="tel" 
                                                       inputmode="numeric"
                                                       pattern="[0-9]*"
                                                       maxlength="15"
                                                       x-model="waPhone"
                                                       @beforeinput="handleWaBeforeInput($event)"
                                                       @keydown="handleWaKeydown($event)"
                                                       @input="handleWaInput($event); ensureDirectMessage('whatsapp', false)"
                                                       @paste="handleWaPaste($event)"
                                                       onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                       placeholder="81234567890 (atau no. sendiri)" 
                                                       class="w-full px-3.5 bg-white rounded-r-xl font-telemetry text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 border border-slate-200 focus:outline-none focus:border-[#25D366] focus:ring-2 focus:ring-[#25D366]/20 shadow-2xs transition-all">
                                            </div>
                                        </div>

                                        <!-- Right: Elegant OTP Highlight Box with Copy Button (5 Cols) -->
                                        <div class="md:col-span-5 bg-white p-3 rounded-xl border border-emerald-200/80 shadow-2xs flex items-center justify-between gap-3">
                                            <div class="flex flex-col min-w-0">
                                                <span class="text-[10px] uppercase font-telemetry text-slate-400 font-bold tracking-wider flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[13px] text-[#25D366]">key</span>
                                                    <span>KODE TOKEN OTP</span>
                                                </span>
                                                <span class="font-telemetry text-xl sm:text-2xl font-black text-emerald-700 tracking-widest leading-tight mt-0.5" 
                                                      x-text="testMessageData ? testMessageData.token : '619-405'">619-405</span>
                                            </div>
                                            <button type="button" 
                                                    @click="copyOtpToken(testMessageData ? testMessageData.token : '619-405')"
                                                    class="px-3 py-2 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 font-bold text-xs flex items-center gap-1.5 transition-all active:scale-95 shrink-0"
                                                    title="Salin Token">
                                                <span class="material-symbols-outlined text-[16px]" x-text="tokenCopied ? 'check' : 'content_copy'">content_copy</span>
                                                <span x-text="tokenCopied ? 'Tersalin' : 'Salin'">Salin</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Subtle Info Strip -->
                                    <div class="px-3.5 py-2 rounded-xl bg-emerald-50/60 border border-emerald-100 text-[11px] text-slate-600 flex items-start sm:items-center gap-2">
                                        <span class="material-symbols-outlined text-[#25D366] text-[16px] shrink-0 mt-0.5 sm:mt-0">info</span>
                                        <span class="leading-relaxed">
                                            Pesan 2FA otomatis disiapkan. Klik <strong>Kirim ke WhatsApp</strong> atau salin token OTP untuk verifikasi akun Anda.
                                        </span>
                                    </div>

                                    <!-- Action Buttons: Clean Responsive Row -->
                                    <div class="mt-3.5 pt-3 border-t border-emerald-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5">
                                        <!-- Primary Send Button -->
                                        <a :href="getWhatsAppDirectUrl()"
                                           @click="handleWhatsAppClick($event)"
                                           class="w-full sm:w-auto px-4 sm:px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#25D366] to-[#1faa53] hover:from-[#20ba59] hover:to-[#178a42] text-white text-xs font-bold font-headline flex items-center justify-center gap-2 shadow-md shadow-emerald-500/20 transition-all active:scale-95 cursor-pointer text-center">
                                            <span class="material-symbols-outlined text-[16px]">send</span>
                                            <span>Kirim ke WhatsApp</span>
                                        </a>

                                        <!-- Secondary Copy, Web, and Refresh Buttons -->
                                        <div class="flex items-center gap-2 w-full sm:w-auto">
                                            <button type="button" 
                                                    @click="copyFullMessage('whatsapp')"
                                                    class="flex-1 sm:flex-initial px-3 sm:px-3.5 py-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold flex items-center justify-center gap-1.5 transition-colors border border-slate-200 shadow-2xs active:scale-95">
                                                <span class="material-symbols-outlined text-[15px] text-slate-500">content_paste</span>
                                                <span>Salin Pesan</span>
                                            </button>

                                            <a :href="getWhatsAppWebUrl()"
                                               target="_blank"
                                               class="p-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-600 text-xs font-semibold flex items-center justify-center transition-colors border border-slate-200 shadow-2xs active:scale-95 shrink-0"
                                               title="Buka di WhatsApp Web">
                                                <span class="material-symbols-outlined text-[16px] text-slate-600">language</span>
                                            </a>

                                            <button type="button" 
                                                    @click="ensureDirectMessage('whatsapp', true)"
                                                    class="p-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-600 text-xs font-semibold flex items-center justify-center transition-colors border border-slate-200 shadow-2xs active:scale-95 shrink-0"
                                                    title="Perbarui Kode OTP">
                                                <span class="material-symbols-outlined text-[16px] text-[#25D366]">refresh</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Ringkasan Data Pendaftaran (Review Singkat Langkah 1 & 2) -->
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                                <span class="font-telemetry text-[#bc0007] font-bold text-xs">03.</span>
                                <h3 class="font-headline text-xs sm:text-sm text-slate-900 font-semibold">Ringkasan Data Pendaftaran (Review Langkah 1 & 2)</h3>
                            </div>

                            <!-- Compact Preview Grid Card -->
                            <div class="bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-200 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                <!-- Column 1 -->
                                <div class="flex flex-col gap-1 border-b sm:border-b-0 sm:border-r border-slate-200 pb-3 sm:pb-0 sm:pr-3">
                                    <span class="font-telemetry text-[10px] text-slate-500 uppercase tracking-wider font-bold">Identitas Pegawai</span>
                                    <span class="font-headline text-slate-900 text-xs sm:text-sm font-bold truncate" x-text="fullName || 'Belum diisi'">Belum diisi</span>
                                    <div class="flex items-center gap-1.5 mt-1">
                                        <span class="font-telemetry text-[11px] bg-slate-200/80 px-2 py-0.5 rounded text-slate-800" x-text="empId ? `NIK: ${empId}` : 'NIK: -'">NIK: -</span>
                                        <span class="font-telemetry text-[11px] text-slate-500" x-text="empType === 'inhouse' ? 'Inhouse' : 'Mitra'">Inhouse</span>
                                    </div>
                                </div>

                                <!-- Column 2 -->
                                <div class="flex flex-col gap-1 border-b sm:border-b-0 sm:border-r border-slate-200 pb-3 sm:pb-0 sm:pr-3">
                                    <span class="font-telemetry text-[10px] text-slate-500 uppercase tracking-wider font-bold">Penempatan</span>
                                    <span class="font-headline text-slate-900 text-xs sm:text-sm font-bold truncate" x-text="getDivisionLabel() || 'Unit Belum Dipilih'">Unit O&M Sukabumi</span>
                                    <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                                        <span class="font-telemetry text-[11px] bg-slate-200/80 px-2 py-0.5 rounded text-slate-800" x-text="selectedStos.length > 0 ? `STO ${selectedStos.join(' & ')}` : 'Belum pilih STO'">STO SKB</span>
                                        <span class="font-telemetry text-[10px] text-slate-600 truncate max-w-[130px]" x-show="homebase" x-text="getHomebaseBadge()"></span>
                                    </div>
                                </div>

                                <!-- Column 3 -->
                                <div class="flex flex-col gap-1 border-b sm:border-b-0 sm:border-r border-slate-200 pb-3 sm:pb-0 sm:pr-3">
                                    <span class="font-telemetry text-[10px] text-slate-500 uppercase tracking-wider font-bold">Wewenang / Role</span>
                                    <span class="font-headline text-slate-900 text-xs sm:text-sm font-bold truncate" 
                                          x-text="role === 'valins_validator' ? 'Helpdesk HD Daman' : (role === 'noc_engineer' ? 'NOC Analyst' : 'Validator Valins')">
                                        Helpdesk HD Daman
                                    </span>
                                    <div class="flex items-center gap-1 mt-1">
                                        <span class="font-telemetry text-[11px] text-sky-700 font-semibold">Tingkat Regional Witel</span>
                                    </div>
                                </div>

                                <!-- Column 4: Dokumen Upload Status -->
                                <div class="flex flex-col gap-1">
                                    <span class="font-telemetry text-[10px] text-slate-500 uppercase tracking-wider font-bold">Surat Tugas</span>
                                    <template x-if="uploadedFile">
                                        <div class="flex flex-col">
                                            <span class="font-headline text-emerald-800 text-xs font-bold truncate flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[15px] text-emerald-600">check_circle</span>
                                                <span x-text="uploadedFile.name"></span>
                                            </span>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="font-telemetry text-[11px] text-slate-500" x-text="uploadedFile.size"></span>
                                                <button type="button" @click="previewModalOpen = true" class="text-xs text-[#bc0007] hover:underline font-bold">Pratinjau</button>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="!uploadedFile">
                                        <div class="flex flex-col">
                                            <span class="text-xs text-slate-500 italic mt-0.5">Tidak ada berkas (Opsional)</span>
                                            <span class="font-telemetry text-[11px] text-slate-400 mt-1">Verifikasi NIK SAP</span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Pernyataan Pakta Integritas & Kepatuhan SOP -->
                        <div class="flex flex-col gap-3 bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-200">
                            <h4 class="font-headline text-xs sm:text-sm text-slate-900 font-bold flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#bc0007] text-[18px]">gavel</span>
                                Pernyataan Pakta Integritas & Kepatuhan SOP
                            </h4>
                            <div class="space-y-3">
                                <!-- Agreement 1 -->
                                <label class="flex items-start gap-3 cursor-pointer select-none">
                                    <input type="checkbox" x-model="agreeIntegrity" class="mt-1 w-4 h-4 rounded text-[#bc0007] focus:ring-0 accent-[#bc0007] cursor-pointer">
                                    <span class="text-xs text-slate-700 leading-relaxed">
                                        Saya menyetujui <span class="font-bold text-[#bc0007]">Pakta Integritas Kerahasiaan Data Topologi Jaringan Fiber PT Telkom Akses</span>. Saya bersedia mematuhi SOP keamanan data distribusi ODC/ODP dan memahami bahwa penyebaran data rute kabel optik tanpa hak akan diproses sesuai hukum kedinasan dan regulasi telekomunikasi nasional.
                                    </span>
                                </label>

                                <!-- Agreement 2 -->
                                <label class="flex items-start gap-3 cursor-pointer select-none">
                                    <input type="checkbox" x-model="agreeBroadcast" class="mt-1 w-4 h-4 rounded text-[#bc0007] focus:ring-0 accent-[#bc0007] cursor-pointer">
                                    <span class="text-xs text-slate-700 leading-relaxed">
                                        Saya bersedia menerima broadcast penugasan patroli, audit redaman OLT, dan rekonsiliasi data ODP dari Dispatcher NOC Witel Sukabumi secara real-time via kanal Telegram/WhatsApp terdaftar.
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons Step 3 & Login Link -->
                        <div class="pt-4 border-t border-slate-100 flex flex-col gap-3">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                                <button type="button" 
                                        @click="goToStep(2)"
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 h-11 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                                    <span>Kembali ke Langkah 2</span>
                                </button>

                                <button type="button" 
                                        @click="submitRegistration()"
                                        :disabled="isSubmitting"
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 h-11 rounded-xl bg-[#bc0007] text-white font-bold text-xs tracking-wide hover:bg-[#960005] active:scale-[0.99] transition-all shadow-md shadow-red-600/25 group hover-sheen disabled:opacity-75 disabled:cursor-not-allowed">
                                    <template x-if="!isSubmitting">
                                        <span class="flex items-center gap-2">
                                            <span>Daftar & Aktifkan Akun</span>
                                            <span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-1">send</span>
                                        </span>
                                    </template>
                                    <template x-if="isSubmitting">
                                        <span class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[18px] animate-spin">sync</span>
                                            <span>Mendaftarkan Akun...</span>
                                        </span>
                                    </template>
                                </button>
                            </div>

                            <!-- Centered Direct Link to Login (Khusus Desktop & Laptop) -->
                            <div class="hidden lg:block text-center pt-1">
                                <p class="text-xs text-slate-500">
                                    <span>Sudah Punya Akun?</span>
                                    <a href="{{ route('login') }}" class="font-bold text-[#bc0007] hover:text-[#960005] hover:underline inline-flex items-center gap-0.5 ml-1 transition-colors">
                                        <span>Masuk</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                </section>
            </div>

            <!-- Modal Pratinjau Dokumen -->
            <div x-show="previewModalOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm"
                 style="display: none;"
                 @keydown.escape.window="previewModalOpen = false">
                
                <div @click.away="previewModalOpen = false" 
                     class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col max-h-[85vh]">
                    
                    <!-- Modal Header -->
                    <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/80">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[#bc0007] text-[22px]">description</span>
                            <div class="flex flex-col">
                                <span class="font-headline text-sm font-bold text-slate-900 truncate max-w-xs sm:max-w-md" x-text="uploadedFile?.name || 'Pratinjau Dokumen'"></span>
                                <span class="font-telemetry text-[11px] text-slate-500" x-text="`${uploadedFile?.size || ''} • Format: ${uploadedFile?.extension || ''}`"></span>
                            </div>
                        </div>
                        <button type="button" @click="previewModalOpen = false" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-4 sm:p-6 overflow-y-auto flex items-center justify-center bg-slate-100 min-h-[300px]">
                        <template x-if="uploadedFile?.type === 'image' && uploadedFile?.previewUrl">
                            <img :src="uploadedFile.previewUrl" alt="Pratinjau Dokumen" class="max-h-[60vh] max-w-full rounded-xl shadow-md object-contain border border-slate-200">
                        </template>
                        <template x-if="uploadedFile?.type === 'pdf'">
                            <div class="flex flex-col items-center justify-center p-8 text-center bg-white rounded-2xl shadow-sm border border-slate-200 max-w-md">
                                <div class="w-16 h-16 rounded-2xl bg-red-50 text-[#bc0007] flex items-center justify-center mb-3 shadow-xs">
                                    <span class="material-symbols-outlined text-[36px]">picture_as_pdf</span>
                                </div>
                                <span class="font-headline text-sm font-bold text-slate-900" x-text="uploadedFile.name"></span>
                                <span class="font-telemetry text-xs text-slate-500 mt-1" x-text="`${uploadedFile.size} • Siap Dilampirkan ke Sistem SIM`"></span>
                                <p class="text-xs text-slate-600 mt-3 leading-relaxed">
                                    Dokumen PDF siap diunggah bersama data registrasi ke server Telkom Akses.
                                </p>
                            </div>
                        </template>
                    </div>

                    <!-- Modal Footer -->
                    <div class="p-4 border-t border-slate-100 flex items-center justify-between bg-slate-50">
                        <span class="font-telemetry text-xs text-emerald-700 font-bold flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Status Dokumen: Terverifikasi Valid
                        </span>
                        <button type="button" @click="previewModalOpen = false" class="px-5 py-2 rounded-xl bg-slate-900 text-white font-semibold text-xs hover:bg-slate-800 transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

            <!-- Simulated Incoming 2FA Push Notification Toast (Telegram / WhatsApp) -->
            <div x-show="incomingNotification.show" 
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
                 class="fixed top-6 right-4 sm:right-6 max-w-sm sm:max-w-md w-full bg-[#0f172a]/95 backdrop-blur-md text-white p-4 rounded-2xl shadow-2xl border z-50 flex flex-col gap-2.5"
                 :class="incomingNotification.channel === 'whatsapp' ? 'border-emerald-500/60 shadow-emerald-950/40' : 'border-[#24A1DE]/60 shadow-sky-950/40'"
                 style="display: none;">
                
                <!-- Notification Header -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0"
                             :class="incomingNotification.channel === 'whatsapp' ? 'bg-emerald-950 text-[#10b981] border border-emerald-500/40' : 'bg-sky-950 text-[#24A1DE] border border-sky-500/40'">
                            <template x-if="incomingNotification.channel === 'whatsapp'">
                                <svg class="w-4 h-4" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                </svg>
                            </template>
                            <template x-if="incomingNotification.channel === 'telegram'">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 2L11 13" />
                                    <path d="M22 2L15 22L11 13L2 9L22 2Z" />
                                </svg>
                            </template>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold font-headline" x-text="incomingNotification.title"></span>
                            <span class="text-[10px] text-slate-400 font-sans" x-text="incomingNotification.sender"></span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-[10px] text-emerald-400 font-telemetry flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Baru Saja
                        </span>
                        <button type="button" @click="incomingNotification.show = false" class="text-slate-400 hover:text-white p-1 rounded-lg">
                            <span class="material-symbols-outlined text-[16px]">close</span>
                        </button>
                    </div>
                </div>

                <!-- Notification Body -->
                <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700/60 flex items-center justify-between gap-3">
                    <div class="flex flex-col">
                        <span class="text-[10px] uppercase tracking-wider font-telemetry text-slate-400 font-semibold">Kode Autentikasi 2FA:</span>
                        <span class="font-telemetry text-xl font-black tracking-widest"
                              :class="incomingNotification.channel === 'whatsapp' ? 'text-emerald-400' : 'text-sky-300'"
                              x-text="incomingNotification.token"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" 
                                @click="copyOtpToken(incomingNotification.token); incomingNotification.show = false;"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all active:scale-95 flex items-center gap-1.5 shadow-md"
                                :class="incomingNotification.channel === 'whatsapp' ? 'bg-[#25D366] text-slate-950 hover:bg-[#20ba59]' : 'bg-[#24A1DE] text-white hover:bg-[#1f8ec4]'">
                            <span class="material-symbols-outlined text-[15px]">content_copy</span>
                            <span>Salin Token</span>
                        </button>
                    </div>
                </div>
            </div>


            <!-- Toast / Notification Container (Controlled by Alpine) -->
            <div x-show="toast.show" 
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-4"
                 class="fixed bottom-6 right-6 max-w-sm w-full bg-white p-4 rounded-2xl shadow-2xl border border-slate-200 z-50 flex items-start gap-3"
                 style="display: none;">
                <span class="material-symbols-outlined text-[24px] shrink-0 mt-0.5"
                      :class="toast.type === 'warning' ? 'text-amber-500' : (toast.type === 'success' ? 'text-emerald-600' : 'text-[#bc0007]')"
                      x-text="toast.type === 'warning' ? 'report_problem' : (toast.type === 'success' ? 'check_circle' : 'error')">error</span>
                <div class="flex flex-col flex-1">
                    <span class="text-xs font-bold text-slate-900" x-text="toast.title"></span>
                    <p class="text-xs text-slate-600 mt-0.5 leading-snug" x-text="toast.message"></p>
                </div>
                <button type="button" @click="toast.show = false" class="text-slate-400 hover:text-slate-700">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        </div>
    </main>

    <!-- Persistent Telkom Akses Operations Footer -->
    <footer class="w-full bg-white border-t border-slate-200/80 shadow-xs mt-8 sm:mt-10 pt-7 sm:pt-8.5 pb-4 sm:pb-5 text-left">
        <div class="w-full max-w-[1400px] xl:max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-8 xl:gap-10">
                
                <!-- Column 1: Brand & Profil + Kontak Bantuan NOC (lg:col-span-5, xl:col-span-5) -->
                <div class="lg:col-span-5 xl:col-span-5 flex flex-col gap-6">
                    <!-- Brand & Profil -->
                    <div class="flex flex-col">
                        <div class="flex items-center mb-4">
                            <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                                 alt="Logo Resmi PT Telkom Akses" 
                                 class="h-11 sm:h-12 md:h-13 w-auto object-contain shrink-0"
                                 onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed max-w-md">
                            Sistem Informasi Manajemen Data VALINS & Monitoring GPON OLT Terpadu Kawasan Sukabumi. Platform resmi operasional jaringan optik dan integrasi topologi ODC/ODP regional.
                        </p>
                        <div class="flex flex-wrap items-center gap-2.5 mt-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 text-sky-800 text-[11px] font-semibold border border-slate-200">
                                <span class="material-symbols-outlined text-[15px] text-sky-600">verified</span>
                                BUMN Terpercaya
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-50 text-[#bc0007] text-[11px] font-semibold border border-red-200/60">
                                <span class="material-symbols-outlined text-[15px]">security</span>
                                ISO 27001 Certified
                            </span>
                        </div>
                    </div>

                    <!-- Kontak Bantuan NOC (Tepat di Bawah Brand & Profil - Vertikal Rapi Tanpa Garis Pembatas) -->
                    <div class="flex flex-col pt-1">
                        <div class="flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-slate-900 mb-3">
                            <span>KONTAK BANTUAN NOC</span>
                        </div>
                        <div class="flex flex-col gap-2.5 max-w-md">
                            <!-- Hotline Fixed Line -->
                            <a href="tel:0266221100" class="group flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50/80 hover:bg-red-50/60 border border-slate-100 hover:border-red-200 transition-all duration-200 shadow-2xs">
                                <div class="w-9 h-9 rounded-xl bg-red-100 text-[#bc0007] flex items-center justify-center shrink-0 border border-red-200/60 group-hover:scale-105 transition-transform">
                                    <span class="material-symbols-outlined text-[19px]">call</span>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-[11px] font-bold text-slate-900 group-hover:text-[#bc0007] transition-colors leading-tight">Hotline Fixed Line</span>
                                    <span class="font-telemetry text-[11px] text-slate-600 mt-0.5 font-semibold tracking-wide truncate">(0266) 221100 / ext. 408</span>
                                </div>
                            </a>

                            <!-- WhatsApp Dispatcher NOC -->
                            <a href="https://wa.me/6281120098800" target="_blank" class="group flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50/80 hover:bg-emerald-50/60 border border-slate-100 hover:border-emerald-200 transition-all duration-200 shadow-2xs">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-[#25D366] flex items-center justify-center shrink-0 border border-emerald-200/60 group-hover:scale-105 transition-transform">
                                    <svg class="w-4.5 h-4.5" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-[11px] font-bold text-slate-900 group-hover:text-emerald-700 transition-colors leading-tight">WhatsApp Dispatcher</span>
                                    <span class="font-telemetry text-[11px] text-slate-600 mt-0.5 font-semibold tracking-wide truncate">+62 811-2009-8800</span>
                                </div>
                            </a>

                            <!-- Email Kedinasan -->
                            <a href="mailto:noc.sukabumi@telkomakses.co.id" class="group flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50/80 hover:bg-sky-50/60 border border-slate-100 hover:border-sky-200 transition-all duration-200 shadow-2xs">
                                <div class="w-9 h-9 rounded-xl bg-sky-100 text-[#0284C7] flex items-center justify-center shrink-0 border border-sky-200/60 group-hover:scale-105 transition-transform">
                                    <span class="material-symbols-outlined text-[19px]">mail</span>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-[11px] font-bold text-slate-900 group-hover:text-sky-700 transition-colors leading-tight">Email Kedinasan</span>
                                    <span class="font-telemetry text-[11px] text-slate-600 mt-0.5 truncate font-semibold">noc.sukabumi@telkomakses.co.id</span>
                                </div>
                            </a>                            
                        </div>
                    </div>
                </div>

                <!-- Column 2: Navigasi Portal (lg:col-span-2, xl:col-span-2) -->
                <div class="lg:col-span-2 xl:col-span-2 flex flex-col">
                    <div class="flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-slate-900 mb-4">
                        <span>NAVIGASI PORTAL</span>
                    </div>
                    <ul class="flex flex-col gap-3 text-xs text-slate-600">
                        <li>
                            <a href="{{ route('login') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Masuk Portal SIM</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Portal Registrasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Panduan Validasi ODP</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Cek NIK / HRMS</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Status Server NOC</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 3: Informasi / Tentang Perusahaan (lg:col-span-2, xl:col-span-2) -->
                <div class="lg:col-span-2 xl:col-span-2 flex flex-col">
                    <div class="flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-slate-900 mb-4">
                        <span>TENTANG KAMI</span>
                    </div>
                    <ul class="flex flex-col gap-3 text-xs text-slate-600">
                        <li>
                            <a href="https://telkomakses.co.id/profil" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Tentang Kami</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('privacy.policy') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Kebijakan Privasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('terms.conditions') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Syarat & Ketentuan</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://wbs.telkom.co.id/" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Masuk</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 4: Area Distribusi STO (lg:col-span-3, xl:col-span-3) -->
                <div class="lg:col-span-3 xl:col-span-3 flex flex-col">
                    <div class="flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-slate-900 mb-4">
                        <span>AREA DISTRIBUSI STO</span>
                    </div>
                    <div class="flex flex-col gap-2 font-telemetry text-xs">
                        <div class="bg-slate-50/90 px-3.5 py-2.5 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-2xs transition-all duration-200 group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate group-hover:text-slate-950">STO SKB - Sukabumi Kota</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                        <div class="bg-slate-50/90 px-3.5 py-2.5 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-2xs transition-all duration-200 group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate group-hover:text-slate-950">STO CCR - Cicurug</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                        <div class="bg-slate-50/90 px-3.5 py-2.5 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-2xs transition-all duration-200 group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate group-hover:text-slate-950">STO CBD - Cibadak</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                        <div class="bg-slate-50/90 px-3.5 py-2.5 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-2xs transition-all duration-200 group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate group-hover:text-slate-950">STO PLR - Pelabuhanratu</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                        <div class="bg-slate-50/90 px-3.5 py-2.5 rounded-xl flex items-center justify-between border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-2xs transition-all duration-200 group">
                            <span class="font-semibold text-slate-800 text-[11px] truncate group-hover:text-slate-950">STO SGN - Sagaranten</span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 font-bold shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Online</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Single Clean Divider -->
            <div class="border-t border-slate-200/80 my-6 sm:my-7"></div>

            <!-- Footer Bottom Area: 2 Dedicated Distinct Rows -->
            <div class="flex flex-col gap-5 sm:gap-5.5">
                
                <!-- Row 1: Logo Mitra Kerja (Lembaga Pendukung - Berlatar Transparan, Tanpa Bingkai Kotak) -->
                <div class="flex flex-col items-center gap-3 sm:gap-3.5">
                    <!-- Label: Supported By -->
                    <div class="flex items-center justify-center gap-3">
                        <div class="h-px w-8 sm:w-14 bg-gradient-to-r from-transparent to-slate-300/80"></div>
                        <span class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400 select-none">
                            Supported By
                        </span>
                        <div class="h-px w-8 sm:w-14 bg-gradient-to-l from-transparent to-slate-300/80"></div>
                    </div>

                    <!-- Logos Container -->
                    <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-9 md:gap-12 py-2.5 sm:py-3 overflow-visible">
                        <!-- 1. Kementerian BUMN / Garuda Pancasila -->
                        <a href="https://www.bumn.go.id/" target="_blank" rel="noopener noreferrer" 
                           class="partner-logo-item focus:outline-none" 
                           title="Kementerian Badan Usaha Milik Negara (BUMN) Republik Indonesia">
                            <img src="{{ asset('images/partners/bumn.png') }}" 
                                 alt="Logo Kementerian BUMN" 
                                 class="h-7 sm:h-8 md:h-8.5 w-auto object-contain">
                        </a>

                        <!-- 2. PT Telkom Indonesia (Persero) Tbk -->
                        <a href="https://www.telkom.co.id/" target="_blank" rel="noopener noreferrer" 
                           class="partner-logo-item focus:outline-none" 
                           title="PT Telkom Indonesia (Persero) Tbk - the world in your hand">
                            <img src="{{ asset('images/partners/telkom-indonesia.png') }}" 
                                 alt="Logo Telkom Indonesia" 
                                 class="h-6 sm:h-7 md:h-7.5 w-auto object-contain">
                        </a>

                        <!-- 3. Kementerian Komunikasi dan Digital RI (KOMDIGI) -->
                        <a href="https://www.komdigi.go.id/" target="_blank" rel="noopener noreferrer" 
                           class="partner-logo-item focus:outline-none" 
                           title="Kementerian Komunikasi dan Digital Republik Indonesia (KOMDIGI)">
                            <img src="{{ asset('images/partners/komdigi.png') }}" 
                                 alt="Logo KOMDIGI" 
                                 class="h-8 sm:h-9 md:h-10 w-auto object-contain">
                        </a>

                        <!-- 4. PT Bank Syariah Indonesia Tbk (BSI) -->
                        <a href="https://www.bankbsi.co.id/" target="_blank" rel="noopener noreferrer" 
                           class="partner-logo-item focus:outline-none" 
                           title="PT Bank Syariah Indonesia Tbk (BSI)">
                            <img src="{{ asset('images/partners/bsi.png') }}" 
                                 alt="Logo Bank Syariah Indonesia" 
                                 class="h-6 sm:h-7 md:h-7.5 w-auto object-contain">
                        </a>

                        <!-- 5. Telkom University -->
                        <a href="https://telkomuniversity.ac.id/" target="_blank" rel="noopener noreferrer" 
                           class="partner-logo-item focus:outline-none" 
                           title="Telkom University (Tel-U)">
                            <img src="{{ asset('images/partners/telkom-university.png') }}" 
                                 alt="Logo Telkom University" 
                                 class="h-6 sm:h-7 md:h-7.5 w-auto object-contain">
                        </a>
                    </div>
                </div>

                <!-- Row 2: Copyright & Social Media Icons (Social Media di atas Copyright pada Mobile) -->
                <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-3.5 sm:gap-4 text-[11px] text-slate-500 pt-3.5 sm:pt-4 border-t border-slate-100/80">
                    
                    <!-- Left: Copyright & Regional Authority -->
                    <p class="text-center sm:text-left leading-relaxed">
                        <span class="font-medium text-slate-700">© 2026 PT Telkom Akses Witel Sukabumi.</span>
                        <span class="text-slate-300 hidden sm:inline">•</span>
                        <span class="text-slate-500">Sub-Direktorat Operasi Jaringan Regional Jawa Barat</span>
                    </p>

                    <!-- Right: Official Social Media Icons -->
                    <div class="flex items-center gap-2">
                        <!-- 1. INSTAGRAM -->
                        <a href="https://www.instagram.com/telkomaksesindonesia/" target="_blank" rel="noopener noreferrer" 
                           class="btn-instagram relative overflow-hidden w-9 h-9 rounded-xl bg-slate-50 text-slate-600 hover:text-white border border-slate-200/80 hover:border-transparent flex items-center justify-center transition-all duration-300 shadow-2xs hover:-translate-y-1 active:scale-95 group" 
                           title="Instagram Resmi Telkom Akses (@telkomaksesindonesia)">
                            <span class="btn-instagram-bg absolute inset-0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></span>
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110 relative z-10" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>

                        <!-- 2. YOUTUBE -->
                        <a href="https://www.youtube.com/@TelkomAksesOfficial/streams" target="_blank" rel="noopener noreferrer" 
                           class="w-9 h-9 rounded-xl bg-slate-50 hover:bg-[#FF0000] text-slate-600 hover:text-white border border-slate-200/80 hover:border-[#FF0000] flex items-center justify-center transition-all duration-300 shadow-2xs hover:shadow-md hover:shadow-red-500/25 hover:-translate-y-1 active:scale-95 group" 
                           title="YouTube Channel Resmi Telkom Akses">
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>

                        <!-- 3. TIKTOK -->
                        <a href="https://www.tiktok.com/@telkomaksesindonesia" target="_blank" rel="noopener noreferrer" 
                           class="w-9 h-9 rounded-xl bg-slate-50 hover:bg-black text-slate-600 hover:text-white border border-slate-200/80 hover:border-black flex items-center justify-center transition-all duration-300 shadow-2xs hover:shadow-md hover:shadow-slate-900/30 hover:-translate-y-1 active:scale-95 group" 
                           title="TikTok Resmi Telkom Akses (@telkomaksesindonesia)">
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-1.01-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                            </svg>
                        </a>

                        <!-- 4. FACEBOOK -->
                        <a href="https://www.facebook.com/telkomaksesofficial/" target="_blank" rel="noopener noreferrer" 
                           class="w-9 h-9 rounded-xl bg-slate-50 hover:bg-[#1877F2] text-slate-600 hover:text-white border border-slate-200/80 hover:border-[#1877F2] flex items-center justify-center transition-all duration-300 shadow-2xs hover:shadow-md hover:shadow-blue-500/25 hover:-translate-y-1 active:scale-95 group" 
                           title="Facebook Resmi PT Telkom Akses">
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </footer>

    <!-- Modal Pratinjau Dokumen (Fixed Top-Level Overlay with Z-Index 100) -->
    <div x-show="previewModalOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm"
         style="display: none;"
         @keydown.escape.window="previewModalOpen = false">
        
        <div @click.away="previewModalOpen = false" 
             class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col max-h-[85vh]">
            
            <!-- Modal Header -->
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/80">
                <div class="flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[#bc0007] text-[22px]">description</span>
                    <div class="flex flex-col">
                        <span class="font-headline text-sm font-bold text-slate-900 truncate max-w-xs sm:max-w-md" x-text="uploadedFile?.name || 'Pratinjau Dokumen'"></span>
                        <span class="font-telemetry text-[11px] text-slate-500" x-text="`${uploadedFile?.size || ''} • Format: ${uploadedFile?.extension || ''}`"></span>
                    </div>
                </div>
                <button type="button" @click="previewModalOpen = false" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 sm:p-6 overflow-y-auto flex items-center justify-center bg-slate-100 min-h-[300px]">
                <template x-if="uploadedFile?.type === 'image' && uploadedFile?.previewUrl">
                    <img :src="uploadedFile.previewUrl" alt="Pratinjau Dokumen" class="max-h-[60vh] max-w-full rounded-xl shadow-md object-contain border border-slate-200">
                </template>
                <template x-if="uploadedFile?.type === 'pdf'">
                    <div class="flex flex-col items-center justify-center p-8 text-center bg-white rounded-2xl shadow-sm border border-slate-200 max-w-md">
                        <div class="w-16 h-16 rounded-2xl bg-red-50 text-[#bc0007] flex items-center justify-center mb-3 shadow-xs">
                            <span class="material-symbols-outlined text-[36px]">picture_as_pdf</span>
                        </div>
                        <span class="font-headline text-sm font-bold text-slate-900" x-text="uploadedFile.name"></span>
                        <span class="font-telemetry text-xs text-slate-500 mt-1" x-text="`${uploadedFile.size} • Siap Dilampirkan ke Sistem SIM`"></span>
                        <p class="text-xs text-slate-600 mt-3 leading-relaxed">
                            Dokumen PDF siap diunggah bersama data registrasi ke server Telkom Akses.
                        </p>
                    </div>
                </template>
            </div>

            <!-- Modal Footer -->
            <div class="p-4 border-t border-slate-100 flex items-center justify-between bg-slate-50">
                <span class="font-telemetry text-xs text-emerald-700 font-bold flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Status Dokumen: Terverifikasi Valid
                </span>
                <button type="button" @click="previewModalOpen = false" class="px-5 py-2 rounded-xl bg-slate-900 text-white font-semibold text-xs hover:bg-slate-800 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Simulated Incoming 2FA Push Notification Toast (Telegram / WhatsApp) -->
    <div x-show="incomingNotification.show" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
         class="fixed top-6 right-4 sm:right-6 max-w-sm sm:max-w-md w-full bg-[#0f172a]/95 backdrop-blur-md text-white p-4 rounded-2xl shadow-2xl border z-[100] flex flex-col gap-2.5"
         :class="incomingNotification.channel === 'whatsapp' ? 'border-emerald-500/60 shadow-emerald-950/40' : 'border-[#24A1DE]/60 shadow-sky-950/40'"
         style="display: none;">
        
        <!-- Notification Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0"
                     :class="incomingNotification.channel === 'whatsapp' ? 'bg-emerald-950 text-[#10b981] border border-emerald-500/40' : 'bg-sky-950 text-[#24A1DE] border border-sky-500/40'">
                    <template x-if="incomingNotification.channel === 'whatsapp'">
                        <svg class="w-4 h-4" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                        </svg>
                    </template>
                    <template x-if="incomingNotification.channel === 'telegram'">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 2L11 13" />
                            <path d="M22 2L15 22L11 13L2 9L22 2Z" />
                        </svg>
                    </template>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-bold font-headline" x-text="incomingNotification.title"></span>
                    <span class="text-[10px] text-slate-400 font-sans" x-text="incomingNotification.sender"></span>
                </div>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="text-[10px] text-emerald-400 font-telemetry flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Baru Saja
                </span>
                <button type="button" @click="incomingNotification.show = false" class="text-slate-400 hover:text-white p-1 rounded-lg">
                    <span class="material-symbols-outlined text-[16px]">close</span>
                </button>
            </div>
        </div>

        <!-- Notification Body -->
        <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700/60 flex items-center justify-between gap-3">
            <div class="flex flex-col">
                <span class="text-[10px] uppercase tracking-wider font-telemetry text-slate-400 font-semibold">Kode Autentikasi 2FA:</span>
                <span class="font-telemetry text-xl font-black tracking-widest"
                      :class="incomingNotification.channel === 'whatsapp' ? 'text-emerald-400' : 'text-sky-300'"
                      x-text="incomingNotification.token"></span>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" 
                        @click="copyOtpToken(incomingNotification.token); incomingNotification.show = false;"
                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all active:scale-95 flex items-center gap-1.5 shadow-md"
                        :class="incomingNotification.channel === 'whatsapp' ? 'bg-[#25D366] text-slate-950 hover:bg-[#20ba59]' : 'bg-[#24A1DE] text-white hover:bg-[#1f8ec4]'">
                    <span class="material-symbols-outlined text-[15px]">content_copy</span>
                    <span>Salin Token</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Toast / Notification Container (Controlled by Alpine) -->
    <div x-show="toast.show" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-6 right-6 max-w-sm w-full bg-white p-4 rounded-2xl shadow-2xl border border-slate-200 z-[100] flex items-start gap-3"
         style="display: none;">
        <span class="material-symbols-outlined text-[24px] shrink-0 mt-0.5"
              :class="toast.type === 'warning' ? 'text-amber-500' : (toast.type === 'success' ? 'text-emerald-600' : 'text-[#bc0007]')"
              x-text="toast.type === 'warning' ? 'report_problem' : (toast.type === 'success' ? 'check_circle' : 'error')">error</span>
        <div class="flex flex-col flex-1">
            <span class="text-xs font-bold text-slate-900" x-text="toast.title"></span>
            <p class="text-xs text-slate-600 mt-0.5 leading-snug" x-text="toast.message"></p>
        </div>
        <button type="button" @click="toast.show = false" class="text-slate-400 hover:text-slate-700">
            <span class="material-symbols-outlined text-[18px]">close</span>
        </button>
    </div>
</body>
</html>
