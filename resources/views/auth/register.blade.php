<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Telkom Akses Sukabumi</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/telkom-akses-logo.png') }}">

    <!-- Fonts: Inter, JetBrains Mono, Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Preload Critical Showcase Images to Eliminate Navigation Flicker/Shift -->
    <link rel="preload" as="image" href="{{ asset('images/auth/login-validation-illustration.png') }}" fetchpriority="high">
    <link rel="preload" as="image" href="{{ asset('images/telkom-akses-official-transparent.png') }}" fetchpriority="high">

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

        /* Slim Minimalist Scrollbar for Split Screen Auth Form */
        .custom-auth-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-auth-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .custom-auth-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 9999px;
        }
        .custom-auth-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
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
                    });

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
<body class="bg-white text-[#0b1c30] antialiased min-h-screen selection:bg-[#bc0007] selection:text-white"
      x-data="registrationWizard()">

    <!-- Split Screen Two-Column Container -->
    <div class="min-h-screen lg:h-screen w-full flex flex-col lg:flex-row lg:overflow-hidden">
        
        <!-- ================= LEFT COLUMN: Modern Telkom Akses Branded Showcase (Desktop Only) ================= -->
        <div class="hidden lg:flex lg:w-1/2 lg:h-full bg-gradient-to-br from-[#ffffff] via-[#f4f8fe] to-[#e8f1fc] border-r border-slate-200/80 relative overflow-hidden flex-col justify-between p-8 lg:p-10 xl:p-12 text-slate-900 select-none shadow-xs shrink-0">
            <!-- Soft Blue Ambient Glow Overlays (Clean Gradient without Dots) -->
            <div class="absolute -top-20 -left-20 w-96 h-96 bg-blue-100/60 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-6 right-0 w-80 h-80 bg-sky-100/60 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-indigo-50/50 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Top Header: Official Transparent Logo Telkom Akses & Status Badge -->
            <div class="relative z-10 flex items-center justify-between h-11 shrink-0">
                <a href="{{ route('login') }}" class="inline-flex items-center focus:outline-none transition-opacity duration-200 hover:opacity-90" title="PT Telkom Akses - Beranda">
                    <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                         alt="Logo Resmi PT Telkom Akses" 
                         width="180"
                         height="44"
                         loading="eager"
                         decoding="sync"
                         fetchpriority="high"
                         class="h-9 sm:h-10 md:h-11 w-auto object-contain shrink-0"
                         onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
                </a>
            </div>

            <!-- Center Visual Composition: Data Validation & Authentication Illustration -->
            <div class="relative z-10 my-auto py-4 sm:py-6 flex flex-col items-center justify-center shrink-0">
                <div class="relative flex items-center justify-center w-full max-w-[360px] sm:max-w-[400px] lg:max-w-[440px] xl:max-w-[470px]">
                    <!-- Subtle Ambient Backdrop Circle -->
                    <div class="absolute -inset-6 sm:-inset-8 bg-gradient-to-tr from-blue-200/40 via-sky-100/45 to-red-100/35 rounded-3xl blur-2xl pointer-events-none"></div>
                    
                    <img src="{{ asset('images/auth/login-validation-illustration.png') }}" 
                         alt="Ilustrasi Sistem Keamanan & Validasi Terpadu PT Telkom Akses" 
                         width="783"
                         height="541"
                         loading="eager"
                         decoding="sync"
                         fetchpriority="high"
                         class="relative z-10 w-full h-auto aspect-[783/541] max-h-[290px] sm:max-h-[320px] lg:max-h-[350px] object-contain drop-shadow-md select-none pointer-events-none">
                </div>
            </div>

            <!-- Bottom Typography: Headline & Subheadline (Dark Slate on Light Background) -->
            <div class="relative z-10 pt-2 shrink-0">
                <!-- Dual Accent Bars (Garis Utama & Garis Pendek Berdampingan) -->
                <div class="flex items-center gap-1.5 mb-3">
                    <div class="w-10 h-1 bg-[#bc0007] rounded-full"></div>
                    <div class="w-2.5 h-1 bg-[#bc0007] rounded-full"></div>
                </div>
                <h2 class="font-headline text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-snug">
                    Sistem Terpadu Validasi dan Monitoring Jaringan
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1.5 leading-relaxed max-w-lg">
                    Platform terpadu data validasi ODC/ODP, monitoring redaman GPON OLT, dan rekonsiliasi jaringan fisik PT Telkom Akses Witel Sukabumi.
                </p>
                <div class="flex flex-wrap items-center gap-4 mt-3 text-xs text-slate-600 font-medium">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Data Fisik Tervalidasi
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        Infrastruktur Resmi Telkom Akses
                    </span>
                </div>
            </div>

        </div>

        <!-- ================= RIGHT COLUMN: Clean Pure White Register Wizard Form ================= -->
        <div class="w-full lg:w-1/2 bg-white flex flex-col justify-between px-4 py-5 sm:px-8 sm:py-7 lg:px-10 lg:py-8 xl:px-12 xl:py-9 min-h-screen lg:min-h-0 lg:h-full lg:overflow-y-auto custom-auth-scrollbar relative">
            
            <!-- Top Navigation: Kembali ke Login & Mobile Logo -->
            <div class="flex items-center justify-between w-full mb-3 sm:mb-5">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-[#bc0007] transition-colors group">
                    <span class="material-symbols-outlined text-base transition-transform group-hover:-translate-x-1">arrow_back</span>
                    <span>Kembali ke Login</span>
                </a>

                <!-- Mobile Only Telkom Akses Logo -->
                <div class="lg:hidden flex items-center">
                    <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                         alt="Logo Resmi PT Telkom Akses" 
                         class="h-8 w-auto object-contain"
                         onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
                </div>
            </div>

            <!-- Vertically Centered Registration Form Container -->
            <div class="my-auto w-full max-w-[680px] xl:max-w-[740px] mx-auto py-2">
                
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

                <!-- Multi-Step Interactive Form Shell -->
                <section id="wizardSection" class="w-full flex flex-col bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-5.5 lg:p-6.5 xl:p-7 shadow-xs border border-slate-200/90 relative">

                    <!-- ================= MOBILE ONLY: Card-based Login Screen Layout (Khusus Mobile / Inspect Saja) ================= -->
                    <div class="block lg:hidden mb-5 text-center">
                        <!-- Visual Teamwork Illustration with Ambient Soft Glow (Synchronized with Login Mobile) -->
                        <div class="flex justify-center items-center py-1 sm:py-2 mb-3 relative">
                            <!-- Subtle Ambient Backlight Glow -->
                            <div class="absolute w-36 h-36 rounded-full bg-gradient-to-tr from-red-500/10 via-sky-400/10 to-red-400/15 blur-2xl pointer-events-none"></div>
                            <img src="{{ asset('images/auth/mobile-login-illustration.png') }}" 
                                 alt="Ilustrasi Sinergi Tim Telkom Akses" 
                                 class="w-auto max-h-[140px] xs:max-h-[155px] sm:max-h-[175px] object-contain select-none pointer-events-none filter drop-shadow-sm relative z-10 transition-transform duration-300">
                        </div>

                        <!-- Mobile Badge & Title -->
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
                                <span class="font-telemetry text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-slate-700 truncate">
                                    <span class="sm:hidden">Alur Pendaftaran</span>
                                    <span class="hidden sm:inline">Alur Pendaftaran Akun</span>
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                                <span class="px-2.5 py-0.5 rounded-full text-[9px] sm:text-[10px] font-telemetry font-bold tracking-wide whitespace-nowrap shrink-0 transition-all duration-300 shadow-3xs bg-red-50 text-[#AE0C00] border border-red-200/80"
                                      x-text="step === 1 ? '33% Lengkap' : (step === 2 ? '66% Lengkap' : '100% Lengkap')">
                                </span>
                            </div>
                        </div>

                        <!-- Progress Bar Track with Clean Elegant Rounded Pill & Subtle Detail Animation -->
                        <div class="w-full bg-slate-100/90 h-1.5 sm:h-2 rounded-full relative mb-3 sm:mb-4 overflow-hidden shadow-inner border border-slate-200/50">
                            <div class="h-full rounded-full transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] relative overflow-hidden progress-line-telkom"
                                 :style="`width: ${step === 1 ? '33.33%' : (step === 2 ? '66.66%' : '100%')}`">
                                
                                <!-- Subtle Top Gloss Highlight -->
                                <div class="absolute inset-x-0 top-0 h-[40%] bg-gradient-to-b from-white/25 to-transparent rounded-t-full pointer-events-none"></div>

                                <!-- Subtle Elegant Sheen Sweep -->
                                <div class="line-subtle-sheen"></div>
                            </div>
                        </div>

                        <!-- ================= MOBILE ONLY STEPPER (Simpul Sejajar & Fokus Langkah Aktif) ================= -->
                        <div class="sm:hidden pt-1 pb-1">
                            <!-- Baris Simpul: 3 Lingkaran Nomor/Centang dengan Garis Penghubung Horizontal -->
                            <div class="flex items-center justify-between relative w-full px-4 xs:px-6">
                                <!-- Step 1 Node -->
                                <button type="button" 
                                        @click="goToStep(1)"
                                        class="w-8 h-8 rounded-full flex items-center justify-center font-headline text-xs font-bold shrink-0 transition-all duration-300 z-10 cursor-pointer focus:outline-none"
                                        :class="step === 1 
                                            ? 'bg-[#bc0007] text-white shadow-sm shadow-red-600/30 ring-2 ring-red-100' 
                                            : (step > 1 
                                                ? 'bg-red-50 text-[#bc0007] border border-red-200/90 font-bold' 
                                                : 'bg-slate-100 text-slate-400 border border-slate-200/80')">
                                    <template x-if="step > 1">
                                        <span class="material-symbols-outlined text-[16px] font-bold text-[#bc0007]">check</span>
                                    </template>
                                    <template x-if="step <= 1">
                                        <span>1</span>
                                    </template>
                                </button>

                                <!-- Connector Line 1-2 -->
                                <div class="flex-1 h-[2px] mx-2 rounded-full transition-colors duration-300"
                                     :class="step > 1 ? 'bg-[#bc0007]' : 'bg-slate-200'"></div>

                                <!-- Step 2 Node -->
                                <button type="button" 
                                        @click="goToStep(2)"
                                        class="w-8 h-8 rounded-full flex items-center justify-center font-headline text-xs font-bold shrink-0 transition-all duration-300 z-10 cursor-pointer focus:outline-none"
                                        :class="step === 2 
                                            ? 'bg-[#bc0007] text-white shadow-sm shadow-red-600/30 ring-2 ring-red-100' 
                                            : (step > 2 
                                                ? 'bg-red-50 text-[#bc0007] border border-red-200/90 font-bold' 
                                                : 'bg-slate-100 text-slate-400 border border-slate-200/80')">
                                    <template x-if="step > 2">
                                        <span class="material-symbols-outlined text-[16px] font-bold text-[#bc0007]">check</span>
                                    </template>
                                    <template x-if="step <= 2">
                                        <span>2</span>
                                    </template>
                                </button>

                                <!-- Connector Line 2-3 -->
                                <div class="flex-1 h-[2px] mx-2 rounded-full transition-colors duration-300"
                                     :class="step > 2 ? 'bg-[#bc0007]' : 'bg-slate-200'"></div>

                                <!-- Step 3 Node -->
                                <button type="button" 
                                        @click="goToStep(3)"
                                        class="w-8 h-8 rounded-full flex items-center justify-center font-headline text-xs font-bold shrink-0 transition-all duration-300 z-10 cursor-pointer focus:outline-none"
                                        :class="step === 3 
                                            ? 'bg-[#bc0007] text-white shadow-sm shadow-red-600/30 ring-2 ring-red-100' 
                                            : 'bg-slate-100 text-slate-400 border border-slate-200/80'">
                                    <span>3</span>
                                </button>
                            </div>

                            <!-- Baris Teks Langkah Aktif: Penegasan Langkah yang Sedang Dikerjakan Pengguna -->
                            <div class="mt-2.5 pt-1.5 text-center">
                                <p class="text-xs font-extrabold text-slate-800 tracking-tight" x-show="step === 1">
                                    <span class="text-[#bc0007] font-telemetry mr-1">Langkah 1:</span> Identitas Diri
                                </p>
                                <p class="text-xs font-extrabold text-slate-800 tracking-tight" x-show="step === 2">
                                    <span class="text-[#bc0007] font-telemetry mr-1">Langkah 2:</span> Unit Kerja &amp; Wilayah
                                </p>
                                <p class="text-xs font-extrabold text-slate-800 tracking-tight" x-show="step === 3">
                                    <span class="text-[#bc0007] font-telemetry mr-1">Langkah 3:</span> Kredensial Akun
                                </p>
                            </div>
                        </div>

                        <!-- ================= DESKTOP STEPPER (Equal Width 3-Column Distribution & Symmetrical Connectors) ================= -->
                        <div class="hidden sm:grid sm:grid-cols-3 gap-0 relative w-full pt-1 pb-0.5">
                            
                            <!-- Step 1 Tab -->
                            <div class="relative flex items-center w-full min-w-0 h-13 pr-1 sm:pr-2">
                                <button type="button" 
                                        @click="goToStep(1)"
                                        class="flex items-center gap-2 sm:gap-2.5 h-12 p-1 rounded-xl transition-all duration-200 text-left group cursor-pointer focus:outline-none hover:opacity-90 active:scale-[0.98] shrink-0 z-10 bg-transparent">
                                    <div class="w-7 h-7 sm:w-8.5 sm:h-8.5 rounded-full flex items-center justify-center font-headline text-xs font-bold shrink-0 transition-all duration-300"
                                         :class="step === 1 
                                            ? 'bg-[#bc0007] text-white shadow-sm shadow-red-600/30 ring-2 ring-red-100' 
                                            : (step > 1 
                                                ? 'bg-red-50 text-[#bc0007] border border-red-200/90 font-bold' 
                                                : 'bg-slate-100 text-slate-400 border border-slate-200/80')">
                                        <template x-if="step > 1">
                                            <span class="material-symbols-outlined text-[15px] sm:text-[17px] font-bold text-[#bc0007]">check</span>
                                        </template>
                                        <template x-if="step <= 1">
                                            <span>1</span>
                                        </template>
                                    </div>
                                    <div class="flex flex-col min-w-0 justify-center">
                                        <span class="font-telemetry text-[9px] sm:text-[10px] uppercase font-bold tracking-wider leading-none mb-1 transition-colors duration-200 whitespace-nowrap"
                                              :class="step === 1 ? 'text-[#bc0007]' : (step > 1 ? 'text-[#bc0007]' : 'text-slate-400')">
                                            LANGKAH 1
                                        </span>
                                        <span class="text-xs sm:text-[13px] tracking-tight leading-tight transition-colors duration-200 whitespace-nowrap"
                                              :class="step === 1 ? 'font-bold text-slate-900' : (step > 1 ? 'font-semibold text-slate-800' : 'font-medium text-slate-500')">
                                            Identitas Diri
                                        </span>
                                    </div>
                                </button>
                                <!-- Connecting Line 1 to 2 -->
                                <div class="flex-1 h-[1.5px] ml-2 sm:ml-3 mr-2 sm:mr-3.5 bg-slate-200/90 rounded-full transition-colors duration-300"
                                     :class="step > 1 ? 'bg-[#bc0007]/40' : 'bg-slate-200/90'"></div>
                            </div>

                            <!-- Step 2 Tab -->
                            <div class="relative flex items-center w-full min-w-0 h-13 pr-1 sm:pr-2">
                                <button type="button" 
                                        @click="goToStep(2)"
                                        class="flex items-center gap-2 sm:gap-2.5 h-12 p-1 rounded-xl transition-all duration-200 text-left group cursor-pointer focus:outline-none hover:opacity-90 active:scale-[0.98] shrink-0 z-10 bg-transparent">
                                    <div class="w-7 h-7 sm:w-8.5 sm:h-8.5 rounded-full flex items-center justify-center font-headline text-xs font-bold shrink-0 transition-all duration-300"
                                         :class="step === 2 
                                            ? 'bg-[#bc0007] text-white shadow-sm shadow-red-600/30 ring-2 ring-red-100' 
                                            : (step > 2 
                                                ? 'bg-red-50 text-[#bc0007] border border-red-200/90 font-bold' 
                                                : 'bg-slate-100 text-slate-400 border border-slate-200/80')">
                                        <template x-if="step > 2">
                                            <span class="material-symbols-outlined text-[15px] sm:text-[17px] font-bold text-[#bc0007]">check</span>
                                        </template>
                                        <template x-if="step <= 2">
                                            <span>2</span>
                                        </template>
                                    </div>
                                    <div class="flex flex-col min-w-0 justify-center">
                                        <span class="font-telemetry text-[9px] sm:text-[10px] uppercase font-bold tracking-wider leading-none mb-1 transition-colors duration-200 whitespace-nowrap"
                                              :class="step === 2 ? 'text-[#bc0007]' : (step > 2 ? 'text-[#bc0007]' : 'text-slate-400')">
                                            LANGKAH 2
                                        </span>
                                        <span class="text-xs sm:text-[13px] tracking-tight leading-snug transition-colors duration-200"
                                              :class="step === 2 ? 'font-bold text-slate-900' : (step > 2 ? 'font-semibold text-slate-800' : 'font-medium text-slate-500')">
                                            <span class="block">Unit Kerja</span>
                                            <span class="block text-[11px] sm:text-xs">&amp; Wilayah</span>
                                        </span>
                                    </div>
                                </button>
                                <!-- Connecting Line 2 to 3 -->
                                <div class="flex-1 h-[1.5px] ml-2 sm:ml-3 mr-2 sm:mr-3.5 bg-slate-200/90 rounded-full transition-colors duration-300"
                                     :class="step > 2 ? 'bg-[#bc0007]/40' : 'bg-slate-200/90'"></div>
                            </div>

                            <!-- Step 3 Tab -->
                            <div class="relative flex items-center w-full min-w-0 h-13">
                                <button type="button" 
                                        @click="goToStep(3)"
                                        class="flex items-center gap-2 sm:gap-2.5 h-12 p-1 rounded-xl transition-all duration-200 text-left group cursor-pointer focus:outline-none hover:opacity-90 active:scale-[0.98] shrink-0 z-10 bg-transparent">
                                    <div class="w-7 h-7 sm:w-8.5 sm:h-8.5 rounded-full flex items-center justify-center font-headline text-xs font-bold shrink-0 transition-all duration-300"
                                         :class="step === 3 
                                            ? 'bg-[#bc0007] text-white shadow-sm shadow-red-600/30 ring-2 ring-red-100' 
                                            : 'bg-slate-100 text-slate-400 border border-slate-200/80'">
                                        <span>3</span>
                                    </div>
                                    <div class="flex flex-col min-w-0 justify-center">
                                        <span class="font-telemetry text-[9px] sm:text-[10px] uppercase font-bold tracking-wider leading-none mb-1 transition-colors duration-200 whitespace-nowrap"
                                              :class="step === 3 ? 'text-[#bc0007]' : 'text-slate-400'">
                                            LANGKAH 3
                                        </span>
                                        <span class="text-xs sm:text-[13px] tracking-tight leading-tight transition-colors duration-200 whitespace-nowrap"
                                              :class="step === 3 ? 'font-bold text-slate-900' : 'font-medium text-slate-500'">
                                            Kredensial Akun
                                        </span>
                                    </div>
                                </button>
                            </div>
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
                                    Hanya mencantumkan variabel angka (0-9) tanpa spasi, huruf, atau tanda strip (-). Contoh: 81234567890. Digunakan untuk token OTP verifikasi.
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
                                    <label class="text-xs font-bold text-slate-800 mb-1.5 flex items-center justify-between h-6 min-h-[24px]">
                                        <span class="flex items-center gap-1.5 min-w-0">
                                            <span class="material-symbols-outlined text-[16px] text-[#bc0007] shrink-0">groups</span>
                                            <span class="truncate">Tim Pemeliharaan / Sektor Regu</span>
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-normal shrink-0 ml-1.5" x-show="regu" style="display: none;">Terpilih</span>
                                    </label>
                                    
                                    <!-- Trigger Button -->
                                    <button type="button"
                                            @click="open = !open"
                                            @click.outside="open = false"
                                            @keydown.escape.window="open = false"
                                            class="w-full h-[46px] min-h-[46px] px-3.5 py-2.5 rounded-xl text-left transition-all duration-200 flex items-center justify-between gap-2.5 border shadow-2xs cursor-pointer select-none bg-white"
                                            :class="open ? 'border-[#bc0007] ring-1 ring-[#bc0007]/20 shadow-xs' : 'border-slate-200 hover:border-slate-300'">
                                        
                                        <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                            <span class="material-symbols-outlined text-[20px] shrink-0 transition-colors"
                                                  :class="regu ? 'text-[#bc0007]' : 'text-slate-400'">groups</span>
                                            
                                            <div class="flex flex-col min-w-0 flex-1">
                                                <template x-if="!regu">
                                                    <span class="text-xs sm:text-sm text-slate-400 font-normal truncate">Pilih Tim Pemeliharaan</span>
                                                </template>
                                                <template x-if="regu">
                                                    <div class="flex flex-col min-w-0">
                                                        <span class="text-xs sm:text-sm font-bold text-slate-900 truncate leading-tight" x-text="getReguLabel()"></span>
                                                        <span class="text-[10px] text-slate-500 truncate leading-tight" x-text="getReguDesc()"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-1.5 shrink-0 ml-1">
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
                                    <label class="text-xs font-bold text-slate-800 mb-1.5 flex items-center justify-between h-6 min-h-[24px]">
                                        <span class="flex items-center gap-1.5 min-w-0">
                                            <span class="material-symbols-outlined text-[16px] text-[#bc0007] shrink-0">badge</span>
                                            <span class="truncate">Atasan Langsung / SPV Verifikator</span>
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-normal shrink-0 ml-1.5" x-show="supervisor" style="display: none;">Terisi</span>
                                    </label>
                                    <div class="relative flex items-center">
                                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[20px] pointer-events-none transition-colors"
                                              :class="supervisor ? 'text-[#bc0007]' : 'text-slate-400'">badge</span>
                                        <input type="text" 
                                               x-model="supervisor" 
                                               placeholder="Nama SPV / Asman Penugasan" 
                                               class="w-full h-[46px] min-h-[46px] pl-[42px] pr-3.5 py-2.5 bg-white text-slate-900 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-[#bc0007] focus:ring-1 focus:ring-[#bc0007]/20 shadow-2xs font-medium placeholder:text-slate-400 transition-all">
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
                                            </div>
                                            <div class="flex items-center gap-2 font-telemetry text-[11px] text-slate-500 mt-1">
                                                <span x-text="uploadedFile.size"></span>
                                                <span>•</span>
                                                <span class="text-slate-600 font-semibold" x-text="uploadedFile.extension"></span>
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
                                        <span class="material-symbols-outlined absolute left-3 text-slate-400 text-[20px] pointer-events-none">lock</span>
                                        <input id="passInput" 
                                                :type="showPassword ? 'text' : 'password'" 
                                                x-model="password"
                                                @input="updatePassStrength()"
                                                required
                                                autocomplete="new-password"
                                                placeholder="Minimal 8 karakter"
                                                class="w-full h-11 bg-white pl-10 pr-11 rounded-xl border border-slate-200 text-slate-900 font-['Inter',sans-serif] text-sm placeholder:text-slate-400 placeholder:font-normal focus:border-[#bc0007] focus:outline-none transition-colors [&::-ms-reveal]:hidden [&::-ms-clear]:hidden">
                                        <button type="button" 
                                                @click="showPassword = !showPassword" 
                                                :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                                class="absolute right-2 w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 focus:outline-none">
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
                                <div class="flex flex-col gap-1.5" x-data="{ confirmTouched: false }">
                                    <label for="confirmPassInput" class="text-xs text-slate-800 font-bold">
                                        Konfirmasi Kata Sandi <span class="text-red-600">*</span>
                                    </label>
                                    <div class="relative flex items-center">
                                        <span class="material-symbols-outlined absolute left-3 text-slate-400 text-[20px] pointer-events-none">lock</span>
                                        <input id="confirmPassInput" 
                                                :type="showConfirmPassword ? 'text' : 'password'" 
                                                x-model="passwordConfirmation"
                                                @input="checkPasswordMatch()"
                                                @blur="confirmTouched = passwordConfirmation.length > 0"
                                                required
                                                autocomplete="new-password"
                                                placeholder="Ulangi kata sandi"
                                                class="w-full h-11 bg-white pl-10 pr-11 rounded-xl border text-slate-900 font-['Inter',sans-serif] text-sm placeholder:text-slate-400 placeholder:font-normal focus:outline-none transition-colors [&::-ms-reveal]:hidden [&::-ms-clear]:hidden"
                                                :class="(confirmTouched && passwordConfirmation.length > 0 && !passwordsMatch) ? 'border-red-400 focus:border-red-500' : 'border-slate-200 focus:border-[#bc0007]'">
                                        <button type="button" 
                                                @click="showConfirmPassword = !showConfirmPassword" 
                                                :aria-label="showConfirmPassword ? 'Sembunyikan konfirmasi kata sandi' : 'Tampilkan konfirmasi kata sandi'"
                                                class="absolute right-2 w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 focus:outline-none">
                                            <span class="material-symbols-outlined text-[20px]" x-text="showConfirmPassword ? 'visibility_off' : 'visibility'">visibility</span>
                                        </button>
                                    </div>
                                    <p x-show="confirmTouched && passwordConfirmation.length > 0 && !passwordsMatch" class="text-[11px] text-red-600" style="display: none;">Konfirmasi kata sandi belum sesuai</p>
                                    <p x-show="!(confirmTouched && passwordConfirmation.length > 0 && !passwordsMatch)" class="text-[11px] text-slate-500">Pastikan penulisan identik tanpa spasi berlebih untuk validasi.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Ringkasan Data Pendaftaran (Review Singkat Langkah 1 & 2) -->
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                                <span class="font-telemetry text-[#bc0007] font-bold text-xs">02.</span>
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

        </div>
    </div>

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
                        <span class="font-telemetry text-xs text-slate-500 mt-1" x-text="`${uploadedFile.size} • Siap Dilampirkan ke Sistem Data`"></span>
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
