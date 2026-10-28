<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Telkom Akses Sukabumi</title>
    <meta name="description" content="Platform monitoring operasional otomatisasi audit fisik ODP/ODC, monitoring telemetri redaman optik OLT GPON real-time PT Telkom Akses Witel Sukabumi.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/telkom-akses-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/telkom-akses-logo.png') }}">

    <!-- Fonts: Inter, JetBrains Mono, Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Preload Critical Images -->
    <link rel="preload" as="image" href="{{ asset('images/telkom-akses-official-transparent.png') }}" fetchpriority="high">
    <link rel="preload" as="image" href="{{ asset('images/landing/telkom-sukabumi-office.jpg') }}" fetchpriority="high">

    <!-- Leaflet.js Interactive Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Tailwind CSS via Vite & Standalone Fallback -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        telkom: {
                            red: '#bc0007',
                            'red-dark': '#960005',
                            'red-light': '#ffe5e2',
                            'red-soft': '#fff5f4'
                        },
                        tech: {
                            blue: '#00628d',
                            'blue-dark': '#004c6e',
                            'blue-light': '#e8f4fc',
                            slate: '#0b1c30'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        headline: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace']
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --telkom-red: #bc0007;
            --telkom-red-dark: #960005;
        }

        html {
            scrollbar-gutter: stable;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9ff;
            color: #0b1c30;
        }

        .font-headline {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-telemetry {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Glassmorphism custom blur */
        .glass-nav {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Hide scrollbars for clean horizontal mobile swipe snap */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Pulse glow animation */
        @keyframes softPulse {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.05); opacity: 0.4; }
        }
        .soft-pulse {
            animation: softPulse 4s ease-in-out infinite;
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

        /* ================= HEADER INTERACTIVE POLISH ================= */
        /* Dynamic Nav Link Styling - Frameless with Glowing Animated Underline */
        .nav-link-item {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.55rem 0.8rem;
            font-size: 0.865rem;
            font-weight: 600;
            color: #475569; /* text-slate-600 */
            background-color: transparent !important;
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            transition: color 0.22s cubic-bezier(0.16, 1, 0.3, 1), transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), text-shadow 0.22s ease;
            cursor: pointer;
            text-decoration: none;
            user-select: none;
            letter-spacing: -0.01em;
        }
        /* Dynamic Smooth Interactive Underline Indicator */
        .nav-link-item::after {
            content: '';
            position: absolute;
            bottom: 0px;
            left: 0.8rem;
            right: 0.8rem;
            height: 2.5px;
            background: linear-gradient(90deg, #e0000a 0%, #bc0007 50%, #960005 100%);
            border-radius: 9999px;
            transform: scaleX(0);
            transform-origin: center;
            opacity: 0;
            /* Smooth closing transition when cursor leaves: graceful ease-out, not too fast */
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.35s ease, box-shadow 0.30s ease;
            pointer-events: none;
        }

        /* Hover State: Red line immediately emerges, closes smoothly on leave */
        .nav-link-item:hover {
            color: #bc0007;
            transform: translateY(-1.5px);
            text-shadow: 0 0 12px rgba(188, 0, 7, 0.18);
        }
        .nav-link-item:hover::after {
            transform: scaleX(1);
            opacity: 1;
            box-shadow: 0 2px 8px rgba(188, 0, 7, 0.45), 0 0 10px rgba(224, 0, 10, 0.25);
            /* Immediate, responsive emergence upon hover */
            transition: transform 0.24s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease, box-shadow 0.24s ease;
        }

        /* Click State: Tactile press feedback */
        .nav-link-item:active {
            transform: translateY(0.5px) scale(0.97);
            transition-duration: 0.08s;
        }

        /* Active State: Clicked/current menu line remains permanently open and visible */
        .nav-link-item.active {
            color: #bc0007;
            font-weight: 700;
            text-shadow: 0 0 16px rgba(188, 0, 7, 0.22);
        }
        .nav-link-item.active::after,
        .nav-link-item.active:hover::after {
            transform: scaleX(1) !important;
            opacity: 1 !important;
            box-shadow: 0 2px 8px rgba(188, 0, 7, 0.5), 0 0 12px rgba(224, 0, 10, 0.3) !important;
        }

        /* Action Button: Masuk (Secondary Bordered) */
        .btn-header-login {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1.15rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #1e293b; /* slate-800 */
            background-color: #ffffff;
            border: 1.5px solid #cbd5e1; /* slate-300 */
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            text-decoration: none;
            user-select: none;
        }
        .btn-header-login:hover {
            color: #bc0007;
            border-color: #fca5a5; /* red-300 */
            background-color: #fff8f8;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px -2px rgba(188, 0, 7, 0.15), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .btn-header-login:active {
            transform: translateY(0.5px) scale(0.96);
            background-color: #fee2e2;
            border-color: #f87171;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition-duration: 0.08s;
        }
        .btn-header-login .btn-login-icon {
            color: #64748b;
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), color 0.22s ease;
        }
        .btn-header-login:hover .btn-login-icon {
            color: #bc0007;
            transform: translateX(3px);
        }
        .btn-header-login:active .btn-login-icon {
            transform: translateX(1px);
        }

        /* Action Button: Daftar Akun (Primary High Impact) */
        .btn-header-register {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff !important;
            background: linear-gradient(135deg, #d30009 0%, #bc0007 50%, #9e0006 100%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px -1px rgba(188, 0, 7, 0.4), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.24s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            text-decoration: none;
            user-select: none;
            overflow: hidden;
        }
        .btn-header-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
            transition: left 0.5s ease-in-out;
            pointer-events: none;
        }
        .btn-header-register:hover {
            background: linear-gradient(135deg, #e3000a 0%, #c90008 50%, #a60006 100%);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 24px -3px rgba(188, 0, 7, 0.55), 0 4px 10px -2px rgba(188, 0, 7, 0.35);
        }
        .btn-header-register:hover::before {
            left: 100%;
        }
        .btn-header-register:active {
            transform: translateY(0.5px) scale(0.96);
            box-shadow: 0 2px 6px rgba(188, 0, 7, 0.45);
            transition-duration: 0.08s;
        }
        .btn-header-register .btn-register-icon {
            color: #ffffff;
            transition: transform 0.24s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .btn-header-register:hover .btn-register-icon {
            transform: scale(1.2) rotate(-5deg);
        }
        .btn-header-register:active .btn-register-icon {
            transform: scale(0.95);
        }

        /* Action Button: Dashboard (Authenticated) */
        .btn-header-dashboard {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff !important;
            background: linear-gradient(135deg, #bc0007 0%, #960005 100%);
            border-radius: 0.75rem;
            box-shadow: 0 2px 6px -1px rgba(188, 0, 7, 0.35);
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            text-decoration: none;
            user-select: none;
        }
        .btn-header-dashboard:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -3px rgba(188, 0, 7, 0.5);
        }
        .btn-header-dashboard:active {
            transform: translateY(0.5px) scale(0.96);
            transition-duration: 0.08s;
        }
        .btn-header-dashboard .btn-dashboard-icon {
            transition: transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .btn-header-dashboard:hover .btn-dashboard-icon {
            transform: scale(1.15) rotate(10deg);
        }

        /* ================= MOBILE OVERLAY SIDEBAR DRAWER STYLES ================= */
        .mobile-drawer-link {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.75rem 1.15rem;
            border-radius: 9999px; /* Full rounded capsule pill */
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155; /* slate-700 */
            background-color: transparent;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            user-select: none;
        }
        .mobile-drawer-link:hover,
        .mobile-drawer-link:active {
            color: #AE0C00;
            background-color: #fef2f2; /* red-50 */
        }
        .mobile-drawer-link .material-symbols-outlined {
            color: #64748b; /* slate-500 */
            font-size: 20px;
            transition: color 0.2s ease, transform 0.2s ease;
        }
        .mobile-drawer-link:hover .material-symbols-outlined {
            color: #AE0C00;
            transform: scale(1.1);
        }
        /* Active Capsule Full Highlight (Solid Corporate Red) */
        .mobile-drawer-link.active {
            background-color: #AE0C00 !important;
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 4px 14px -2px rgba(174, 12, 0, 0.45) !important;
        }
        .mobile-drawer-link.active .material-symbols-outlined {
            color: #ffffff !important;
            transform: scale(1.05);
        }

        /* Mobile Frameless Hamburger & Close Button Touch Ripple */
        .btn-frameless-touch {
            background-color: transparent;
            border: none;
            cursor: pointer;
            border-radius: 9999px;
            transition: background-color 0.2s ease, transform 0.15s ease, color 0.2s ease;
        }
        .btn-frameless-touch:hover {
            background-color: rgba(241, 245, 249, 0.9); /* slate-100 */
            color: #AE0C00;
        }
        .btn-frameless-touch:active {
            transform: scale(0.9);
            background-color: #fee2e2; /* red-100 */
            color: #AE0C00;
        }

        /* Drawer Register & Action Button: Solid corporate red, never turns white on hover/click/active */
        .btn-drawer-register {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            width: 100%;
            padding: 0.8rem 1.25rem;
            border-radius: 0.75rem; /* rounded-xl */
            font-size: 0.875rem;
            font-weight: 700;
            color: #ffffff !important;
            background-color: #bc0007 !important;
            background: linear-gradient(135deg, #d30009 0%, #bc0007 50%, #9e0006 100%) !important;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 14px -2px rgba(188, 0, 7, 0.45), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            user-select: none;
            outline: none;
        }
        .btn-drawer-register:hover {
            background-color: #9e0006 !important;
            background: linear-gradient(135deg, #bc0007 0%, #9e0006 50%, #850004 100%) !important;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px -2px rgba(188, 0, 7, 0.55);
        }
        .btn-drawer-register:active {
            background-color: #850004 !important;
            background: linear-gradient(135deg, #9e0006 0%, #850004 100%) !important;
            color: #ffffff !important;
            transform: translateY(0.5px) scale(0.98);
            box-shadow: 0 2px 6px rgba(188, 0, 7, 0.4);
            transition-duration: 0.08s;
        }
        .btn-drawer-register:focus,
        .btn-drawer-register:focus-visible {
            background-color: #bc0007 !important;
            color: #ffffff !important;
            outline: 2px solid rgba(188, 0, 7, 0.5);
            outline-offset: 2px;
        }
        .btn-drawer-register .material-symbols-outlined {
            color: #ffffff !important;
            font-size: 20px;
        }

        /* Drawer Login Button: Secondary Bordered */
        .btn-drawer-login {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            width: 100%;
            padding: 0.8rem 1.25rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 700;
            color: #1e293b;
            background-color: #ffffff;
            border: 1.5px solid #cbd5e1;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            user-select: none;
            outline: none;
        }
        .btn-drawer-login:hover {
            color: #bc0007;
            border-color: #fca5a5;
            background-color: #fff8f8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px -2px rgba(188, 0, 7, 0.12);
        }
        .btn-drawer-login:active {
            transform: translateY(0.5px) scale(0.98);
            background-color: #fee2e2;
            border-color: #f87171;
            transition-duration: 0.08s;
        }
        .btn-drawer-login:focus,
        .btn-drawer-login:focus-visible {
            border-color: #bc0007;
            outline: 2px solid rgba(188, 0, 7, 0.25);
            outline-offset: 1px;
        }
        .btn-drawer-login .material-symbols-outlined {
            color: #64748b;
            font-size: 20px;
            transition: color 0.2s ease;
        }
        .btn-drawer-login:hover .material-symbols-outlined {
            color: #bc0007;
        }

        /* ================= LIVE STATS STRIP & COUNTER POLISH ================= */
        .stat-count-value {
            font-variant-numeric: tabular-nums;
            display: inline-block;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), color 0.3s ease;
        }
        .stat-count-value.counter-stabilized {
            animation: counterLockPulse 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes counterLockPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.04); }
            100% { transform: scale(1); }
        }

        /* Leaflet Map Corporate Telecom Customization */
        .leaflet-container {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
            background-color: #f1f5f9;
        }
        .leaflet-popup-content-wrapper {
            border-radius: 14px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.12), 0 8px 10px -6px rgba(0, 0, 0, 0.08) !important;
            border: 1px solid #e2e8f0 !important;
            padding: 4px !important;
        }
        .leaflet-popup-content {
            margin: 10px 12px !important;
            line-height: 1.45 !important;
        }
        .leaflet-popup-tip {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
        }
        .leaflet-control-zoom {
            border: 1px solid #cbd5e1 !important;
            border-radius: 10px !important;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
        }
        .leaflet-control-zoom a {
            color: #1e293b !important;
            background-color: #ffffff !important;
            transition: all 0.2s ease !important;
        }
        .leaflet-control-zoom a:hover {
            background-color: #f8fafc !important;
            color: #bc0007 !important;
        }
        .telkom-marker-wrapper {
            background: transparent !important;
            border: none !important;
        }

        /* ================= SCROLL REVEAL & STAGGERED CASCADE ANIMATIONS ================= */
        @keyframes heroFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes heroSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-hero-fade {
            animation: heroFadeIn 0.38s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            will-change: opacity;
        }
        .animate-hero-slide-up {
            opacity: 0;
            animation: heroSlideUp 0.44s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            will-change: opacity, transform;
        }
        .hero-delay-1 { animation-delay: 120ms; }
        .hero-delay-2 { animation-delay: 240ms; }

        /* Unified Scroll Reveal Element */
        .reveal-item {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity 0.44s cubic-bezier(0.16, 1, 0.3, 1), transform 0.44s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-item.reveal-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Stagger Cascade Delays for Multi-Column Grids */
        .stagger-1 { transition-delay: 60ms; }
        .stagger-2 { transition-delay: 130ms; }
        .stagger-3 { transition-delay: 200ms; }
        .stagger-4 { transition-delay: 270ms; }
        .stagger-5 { transition-delay: 340ms; }

        @media (prefers-reduced-motion: reduce) {
            .animate-hero-fade,
            .animate-hero-slide-up,
            .reveal-item {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
        }
    </style>
</head>
<body class="bg-[#f8f9ff] text-[#0b1c30] antialiased selection:bg-[#bc0007] selection:text-white min-h-screen flex flex-col">

    <!-- ================= TOP OPERATIONAL ALERT / TELEMETRY TICKER ================= -->
    <div class="bg-[#bc0007] border-b border-[#960005] text-xs py-2 px-4 sm:px-6 lg:px-8 xl:px-12 shadow-xs text-white">
        <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 sm:gap-4">
            <div class="flex items-center gap-2.5 overflow-hidden text-ellipsis whitespace-nowrap">
                <span class="text-[12px] sm:text-[12.5px] font-medium text-white flex items-center gap-1.5 tracking-wide">
                    <span class="material-symbols-outlined text-[15px] text-red-100">sensors</span>
                    <span>Monitoring Real-time All STO Witel Sukabumi</span>
                </span>
            </div>
        </div>
    </div>

    <!-- ================= STICKY MAIN NAVIGATION BAR ================= -->
    <header class="sticky top-0 z-50 w-full bg-white/95 backdrop-blur-md border-b border-slate-200/80 transition-all duration-300 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
        <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 h-16 sm:h-18 lg:h-20 flex items-center justify-between gap-4">
            
            <!-- Sisi Kiri: Logo Resmi PT Telkom Akses (Proporsional & Bebas Terhimpit di Mobile) -->
            <a href="{{ url('/') }}" class="inline-flex items-center focus:outline-none group active:scale-95 transition-transform duration-200 shrink-0">
                <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                     alt="Logo Resmi PT Telkom Akses" 
                     width="165" 
                     height="42" 
                     class="h-[32px] sm:h-[36px] md:h-[40px] lg:h-[44px] max-h-[32px] sm:max-h-[36px] md:max-h-[40px] lg:max-h-[44px] w-auto object-contain transition-transform duration-200 group-hover:scale-[1.03]" 
                     onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
            </a>

            <!-- Desktop Nav Links (Frameless Floating Aesthetic - Khusus Layar Desktop) -->
            <nav class="hidden lg:flex items-center gap-2 xl:gap-3.5" aria-label="Navigasi Utama">
                <a href="#fitur" class="nav-link-item active">
                    Pilar Operasional
                </a>
                <a href="#telemetri" class="nav-link-item">
                    Validasi &amp; Rekonsiliasi
                </a>
                <a href="#arsitektur" class="nav-link-item">
                    Arsitektur Jaringan
                </a>
                <a href="#valins" class="nav-link-item">
                    Integrasi Valins
                </a>
            </nav>

            <!-- Sisi Kanan: Desktop Auth Buttons & Mobile Frameless Hamburger Button -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Desktop Auth Action Buttons (Khusus Layar Desktop lg:, Disembunyikan di Layar Ponsel) -->
                <div class="hidden lg:flex items-center gap-2.5 sm:gap-3">
                    @if (Route::has('login'))
                        @auth
                            <!-- Authenticated User Dropdown / Dashboard Button -->
                            <div class="flex items-center gap-3">
                                <span class="hidden md:flex flex-col text-right">
                                    <span class="text-xs font-bold text-slate-900 leading-tight">{{ Auth::user()->name }}</span>
                                    <span class="text-[10px] text-slate-500 font-mono leading-none">Petugas Terautentikasi</span>
                                </span>
                                <a href="{{ route('dashboard') }}" 
                                   class="btn-header-dashboard group">
                                    <span class="material-symbols-outlined text-[18px] btn-dashboard-icon">dashboard</span>
                                    <span>Buka Dashboard</span>
                                </a>
                            </div>
                        @else
                            <!-- Guest Auth Buttons -->
                            <a href="{{ route('login') }}" 
                               class="btn-header-login group"
                               title="Masuk ke Akun">
                                <span class="material-symbols-outlined text-[18px] btn-login-icon">login</span>
                                <span>Masuk</span>
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="btn-header-register group"
                                   title="Pendaftaran Akun Baru">
                                    <span class="material-symbols-outlined text-[18px] btn-register-icon">how_to_reg</span>
                                    <span>Daftar Akun</span>
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <!-- Sisi Kanan Ponsel: Mobile Hamburger Button (Frameless Floating Aesthetic) -->
                <button type="button" 
                        id="btn-open-mobile-drawer"
                        onclick="toggleMobileDrawer(true)" 
                        class="lg:hidden relative inline-flex items-center justify-center w-10 h-10 rounded-full text-slate-700 btn-frameless-touch focus:outline-none"
                        aria-label="Buka Menu Navigasi"
                        aria-expanded="false"
                        aria-controls="mobile-overlay-drawer">
                    <span class="material-symbols-outlined text-[24px] sm:text-[26px] leading-none transition-transform duration-200">menu</span>
                </button>
            </div>
        </div>
    </header>

    <!-- ================= MOBILE OVERLAY SIDEBAR (SLIDE-OVER DRAWER DARI SISI KANAN) ================= -->
    <div id="mobile-overlay-drawer" 
         class="fixed inset-0 z-[100] lg:hidden invisible transition-[visibility] duration-300"
         role="dialog"
         aria-modal="true"
         aria-label="Navigasi Menu Mobile">

        <!-- 1. Lapisan Latar Belakang (Backdrop Overlay Buram Lembut) -->
        <div id="mobile-drawer-backdrop" 
             onclick="toggleMobileDrawer(false)"
             class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm opacity-0 transition-opacity duration-300 ease-out cursor-pointer"
             aria-hidden="true"></div>

        <!-- 2. Panel Overlay Sidebar Kanan (Meluncur dari Kanan ke Dalam Layar) -->
        <div id="mobile-drawer-panel" 
             class="fixed top-0 right-0 bottom-0 w-[84%] max-w-[340px] sm:max-w-[380px] h-full bg-white shadow-2xl rounded-l-3xl flex flex-col justify-between overflow-hidden transform translate-x-full transition-transform duration-300 ease-out border-l border-slate-100 z-10">

            <!-- Bagian Atas: Sidebar Header -->
            <div class="px-5 py-4 sm:py-5 border-b border-slate-100 flex items-center justify-between gap-3 bg-white/95">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/telkom-akses-official-transparent.png') }}" 
                         alt="Logo PT Telkom Akses" 
                         class="h-7 sm:h-8 w-auto object-contain"
                         onerror="this.src='{{ asset('images/telkom-akses-official-clean.png') }}'">
                    <div class="flex flex-col border-l border-slate-200 pl-2.5">
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#AE0C00] leading-none"></span>
                        <span class="text-[11px] font-semibold text-slate-700 leading-tight mt-0.5"></span>
                    </div>
                </div>

                <!-- Tombol Tutup (X) Frameless -->
                <button type="button" 
                        onclick="toggleMobileDrawer(false)" 
                        class="w-10 h-10 rounded-full inline-flex items-center justify-center text-slate-500 btn-frameless-touch focus:outline-none"
                        aria-label="Tutup Menu Navigasi">
                    <span class="material-symbols-outlined text-[24px]">close</span>
                </button>
            </div>

            <!-- Bagian Tengah: Daftar Menu Navigasi Berikon Vertikal -->
            <div class="flex-1 overflow-y-auto px-4 py-4 sm:py-5 space-y-1.5 scrollbar-thin scrollbar-thumb-slate-200">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-3 pb-1">
                    Navigasi Beranda
                </div>

                <!-- 1. Pilar Operasional (Active By Default) -->
                <a href="#fitur" 
                   onclick="handleMobileNavClick(this)" 
                   class="mobile-drawer-link active">
                    <span class="material-symbols-outlined">grid_view</span>
                    <span class="truncate">Pilar Operasional</span>
                </a>

                <!-- 2. Validasi & Rekonsiliasi -->
                <a href="#telemetri" 
                   onclick="handleMobileNavClick(this)" 
                   class="mobile-drawer-link">
                    <span class="material-symbols-outlined">verified</span>
                    <span class="truncate">Validasi &amp; Rekonsiliasi</span>
                </a>

                <!-- 3. Arsitektur Jaringan -->
                <a href="#arsitektur" 
                   onclick="handleMobileNavClick(this)" 
                   class="mobile-drawer-link">
                    <span class="material-symbols-outlined">lan</span>
                    <span class="truncate">Arsitektur Jaringan</span>
                </a>

                <!-- 4. Integrasi VALINS -->
                <a href="#valins" 
                   onclick="handleMobileNavClick(this)" 
                   class="mobile-drawer-link">
                    <span class="material-symbols-outlined">dataset</span>
                    <span class="truncate">Integrasi Valins</span>
                </a>
            </div>

            <!-- Bagian Bawah: Integrasi Fitur Masuk & Daftar Akun -->
            <div class="p-4 sm:p-5 border-t border-slate-100/90 bg-slate-50/80 space-y-2.5">
                @if (Route::has('login'))
                    @auth
                        <!-- User Card Terautentikasi -->
                        <div class="p-3 bg-white rounded-2xl border border-slate-200/90 shadow-2xs flex items-center gap-3 mb-2">
                            <div class="w-9 h-9 rounded-xl bg-red-50 text-[#AE0C00] flex items-center justify-center font-bold text-sm shrink-0 border border-red-100">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="flex flex-col min-w-0 flex-1">
                                <span class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-slate-500 truncate">{{ Auth::user()->email }}</span>
                            </div>
                        </div>

                        <!-- Tombol Buka Dashboard -->
                        <a href="{{ route('dashboard') }}" 
                           class="btn-drawer-register">
                            <span class="material-symbols-outlined">dashboard</span>
                            <span>Buka Dashboard Operasional</span>
                            <span class="material-symbols-outlined text-[17px]">arrow_forward</span>
                        </a>
                    @else
                        <!-- Fitur Masuk: Tombol Berbingkai Rapi dengan Ikon Masuk -->
                        <a href="{{ route('login') }}" 
                           class="btn-drawer-login">
                            <span class="material-symbols-outlined">login</span>
                            <span>Masuk ke Akun</span>
                        </a>

                        <!-- Fitur Daftar Akun: Tombol Utama Berwarna Merah Solid Khas Telkom Akses -->
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="btn-drawer-register">
                                <span class="material-symbols-outlined">how_to_reg</span>
                                <span>Daftar Akun Baru</span>
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>

    <!-- ================= MAIN HERO SECTION ================= -->
    <main class="flex-grow">
        <section class="relative w-full pt-10 pb-12 sm:pt-14 sm:pb-16 lg:pt-18 lg:pb-22 bg-white border-b border-slate-200/80 overflow-hidden">
            
            <!-- 1. Area Atas: Tipografi Terpusat di Atas Latar Putih Bersih (Centered Editorial Header) -->
            <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center relative z-20 animate-hero-fade">
                
                <!-- Lencana Kategori Atas -->

                <!-- Judul Utama (2-3 Baris Seimbang & Terpusat) -->
                <h1 class="font-headline text-2xl sm:text-4xl md:text-5xl lg:text-[52px] xl:text-[56px] font-extrabold tracking-tight text-slate-900 leading-[1.2] sm:leading-[1.12] max-w-4xl mx-auto">
                    Transformasi Digital Monitoring Jaringan <span class="text-[#bc0007]">GPON &amp; Validasi Data Valins</span> Terpadu
                </h1>

                <!-- Sub-Judul Deskripsi (Lebar Bacaan Nyaman) -->
                <p class="mt-4 sm:mt-5 text-sm sm:text-base lg:text-lg text-slate-600 leading-relaxed max-w-3xl mx-auto">
                    Platform monitoring operasional otomatisasi audit fisik ODP/ODC, monitoring telemetri redaman optik OLT GPON real-time, sinkronisasi spasial GIS rute feeder, dan rekonsiliasi inventori UIM PT Telkom Akses Sukabumi.
                </p>

            </div>

            <!-- 2. Area Transisi Tengah: Wadah Kapsul Tombol Aksi Utama (Floating Action Dock pada Desktop, In-Flow Side-by-Side pada Mobile) -->
            <div class="relative z-30 mb-4 sm:-mb-7 lg:-mb-8 mt-5 sm:mt-9 w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 flex justify-center animate-hero-slide-up hero-delay-1">
                <div class="w-full sm:w-auto p-1.5 sm:p-2 bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-full border border-slate-200/90 shadow-lg sm:shadow-xl shadow-slate-300/40 grid grid-cols-2 gap-2 sm:flex sm:items-center sm:gap-2.5">
                    <!-- Tombol Utama: Mulai Monitoring -->
                    @auth
                        <a href="{{ route('dashboard') }}" 
                            class="order-2 sm:order-1 w-full sm:w-auto inline-flex items-center justify-center gap-1 sm:gap-2 px-2 sm:px-7 py-2.5 sm:py-3.5 rounded-xl sm:rounded-full bg-[#bc0007] hover:bg-[#960005] active:scale-95 text-white font-bold text-xs sm:text-sm shadow-md shadow-red-600/20 hover:shadow-lg hover:shadow-red-600/30 transition-all duration-200 whitespace-nowrap">
                            <span class="material-symbols-outlined text-[16px] sm:text-[20px] shrink-0">dashboard</span>
                            <span class="truncate">Mulai Monitoring</span>
                            <span class="material-symbols-outlined text-[14px] sm:text-[18px] shrink-0">arrow_forward</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                            class="order-2 sm:order-1 w-full sm:w-auto inline-flex items-center justify-center gap-1 sm:gap-2 px-2 sm:px-7 py-2.5 sm:py-3.5 rounded-xl sm:rounded-full bg-[#bc0007] hover:bg-[#960005] active:scale-95 text-white font-bold text-xs sm:text-sm shadow-md shadow-red-600/20 hover:shadow-lg hover:shadow-red-600/30 transition-all duration-200 whitespace-nowrap">
                            <span class="material-symbols-outlined text-[16px] sm:text-[20px] shrink-0">play_circle</span>
                            <span class="truncate">Mulai Monitoring</span>
                            <span class="material-symbols-outlined text-[14px] sm:text-[18px] shrink-0">arrow_forward</span>
                        </a>
                    @endauth
                    <!-- Tombol Sekunder: Unduh Panduan SOP Lapangan (PDF) -->
                    <a href="#arsitektur" 
                        class="order-1 sm:order-2 w-full sm:w-auto inline-flex items-center justify-center gap-1.5 sm:gap-2 px-2 sm:px-6 py-2.5 sm:py-3.5 rounded-xl sm:rounded-full bg-slate-100 hover:bg-slate-200/80 active:scale-95 text-slate-700 font-semibold text-xs sm:text-sm border border-slate-200/80 transition-all duration-200 whitespace-nowrap">
                        <span class="material-symbols-outlined text-[16px] sm:text-[18px] text-[#bc0007] shrink-0">description</span>
                        <span class="sm:hidden truncate">Panduan SOP</span>
                        <span class="hidden sm:inline">Unduh Panduan SOP Lapangan (PDF)</span>
                    </a>
                </div>
            </div>

            <!-- 3. Area Bawah: Visual Panorama Gedung Witel Sukabumi -->
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 relative z-10 animate-hero-slide-up hero-delay-2">
                <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl border border-slate-200/90 bg-slate-950 group">
                    <!-- Foto Gedung Membentang Lebar Secara Horisontal (Panoramik) -->
                    <div class="relative w-full h-64 sm:h-80 md:h-[400px] lg:h-[480px] xl:h-[520px] overflow-hidden">
                        <img src="{{ asset('images/landing/telkom-sukabumi-office.jpg') }}" 
                             alt="Kantor PT Telkom Indonesia Witel Sukabumi - Jl. R. E. Martadinata No.24" 
                             width="1920"
                             height="1080"
                             class="w-full h-full object-cover object-[center_34%] transition-transform duration-1000 group-hover:scale-105"
                             onerror="this.onerror=null; this.src='{{ asset('images/landing/noc-monitoring-room.jpg') }}'">

                        <!-- Top-Edge Gradient Fade (Lapisan pudar putih halus di bagian tepi atas foto gedung - Khusus Desktop/Tablet) -->
                        <div class="hidden sm:block absolute inset-x-0 top-0 h-24 sm:h-32 lg:h-40 bg-gradient-to-b from-white via-white/50 to-transparent pointer-events-none z-10"></div>

                        <!-- Lapisan Vignette Halus Bawah untuk Keterbacaan Foto -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-transparent to-transparent pointer-events-none z-10"></div>
                    </div>
                </div>
            </div>

        </section>

        <!-- ================= LIVE TELEMETRY STATS STRIP ================= -->
        <section class="relative w-full bg-gradient-to-b from-[#f8f9ff] via-white to-[#f8f9ff] border-y border-slate-200/80 py-10 sm:py-12 lg:py-14 px-4 sm:px-6 lg:px-8 xl:px-12 shadow-xs overflow-hidden" id="live-stats-strip">
            <!-- Subtle Ambient Background Accents -->
            <div class="absolute -top-20 left-1/4 w-96 h-36 bg-red-100/35 blur-3xl rounded-full pointer-events-none"></div>
            <div class="absolute -bottom-20 right-1/4 w-96 h-36 bg-sky-100/35 blur-3xl rounded-full pointer-events-none"></div>

            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto relative z-10">
                
                <!-- Section Header (Telemetri & Kapasitas Fisik) -->
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 mb-8 sm:mb-10 reveal-item">
                    <div>
                        <span class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-[#bc0007] block mb-1">Telemetri &amp; Kapasitas Fisik</span>
                        <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-[#0b1c30] tracking-tight">
                            Parameter Inti Jaringan Fiber Witel Sukabumi
                        </h2>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md lg:text-right leading-relaxed">
                        Statistik dihitung secara otomatis melalui kueri UIM API dan polling modul NMS OLT setiap 60 detik.
                    </p>
                </div>

                <!-- 4 Modular Telemetry Cards Grid (2x2 Compact Grid on Mobile, 4-Cols on Desktop) -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 lg:gap-6">
                    
                    <!-- Card 1: Titik ODP Termonitor -->
                    <div class="stat-counter-card group relative bg-white rounded-xl sm:rounded-2xl p-3.5 sm:p-5 lg:p-6 border border-slate-200/90 hover:border-red-200 shadow-2xs hover:shadow-xl hover:shadow-red-500/10 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between reveal-item stagger-1">
                        <div>
                            <div class="flex items-center justify-between mb-2 sm:mb-3 gap-1">
                                <span class="text-xs sm:text-[13px] font-semibold text-slate-700 truncate">Titik ODP Termonitor</span>
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-red-50 text-[#bc0007] border border-red-100/80 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-[#bc0007] group-hover:text-white transition-all duration-300">
                                    <span class="material-symbols-outlined text-[16px] sm:text-[18px]">alt_route</span>
                                </div>
                            </div>
                            <div class="my-1.5 sm:my-2.5 flex items-baseline">
                                <span class="font-telemetry text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight stat-count-value"
                                      data-target="8420"
                                      data-format="integer">8,420</span>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium leading-tight truncate">Cakupan 23 Sektor Sukabumi</p>
                        </div>
                        
                        <!-- Segmented Progress Bar (5 Blocks) -->
                        <div class="grid grid-cols-5 gap-1 sm:gap-1.5 mt-3 sm:mt-5 pt-1">
                            <div class="h-1.5 sm:h-2 rounded-xs bg-red-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-red-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-red-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-red-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-[#bc0007]"></div>
                        </div>
                    </div>

                    <!-- Card 2: Active PON Ports -->
                    <div class="stat-counter-card group relative bg-white rounded-xl sm:rounded-2xl p-3.5 sm:p-5 lg:p-6 border border-slate-200/90 hover:border-sky-200 shadow-2xs hover:shadow-xl hover:shadow-sky-500/10 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between reveal-item stagger-2">
                        <div>
                            <div class="flex items-center justify-between mb-2 sm:mb-3 gap-1">
                                <span class="text-xs sm:text-[13px] font-semibold text-slate-700 truncate">Active PON Ports</span>
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-sky-50 text-[#00628d] border border-sky-100/80 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-[#00628d] group-hover:text-white transition-all duration-300">
                                    <span class="material-symbols-outlined text-[16px] sm:text-[18px]">router</span>
                                </div>
                            </div>
                            <div class="my-1.5 sm:my-2.5 flex items-baseline gap-1">
                                <span class="font-telemetry text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight stat-count-value"
                                      data-target="384"
                                      data-format="integer">384</span>
                                <span class="font-sans text-xs sm:text-sm font-semibold text-slate-500">Port</span>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium leading-tight truncate">24 Chassis OLT MA5800</p>
                        </div>

                        <!-- Segmented Progress Bar (5 Blocks) -->
                        <div class="grid grid-cols-5 gap-1 sm:gap-1.5 mt-3 sm:mt-5 pt-1">
                            <div class="h-1.5 sm:h-2 rounded-xs bg-sky-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-sky-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-sky-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-sky-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-[#00628d]"></div>
                        </div>
                    </div>

                    <!-- Card 3: SLA Ketersediaan Optik -->
                    <div class="stat-counter-card group relative bg-white rounded-xl sm:rounded-2xl p-3.5 sm:p-5 lg:p-6 border border-slate-200/90 hover:border-emerald-200 shadow-2xs hover:shadow-xl hover:shadow-emerald-500/10 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between reveal-item stagger-3">
                        <div>
                            <div class="flex items-center justify-between mb-2 sm:mb-3 gap-1">
                                <span class="text-xs sm:text-[13px] font-semibold text-slate-700 truncate">SLA Optik</span>
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100/80 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                                    <span class="material-symbols-outlined text-[16px] sm:text-[18px]">verified</span>
                                </div>
                            </div>
                            <div class="my-1.5 sm:my-2.5 flex items-baseline">
                                <span class="font-telemetry text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight stat-count-value"
                                      data-target="99.98"
                                      data-decimals="2"
                                      data-format="decimal">99.98</span><span class="font-telemetry text-lg sm:text-2xl font-extrabold text-slate-900 ml-0.5">%</span>
                            </div>
                            <p class="text-[11px] sm:text-xs font-semibold text-emerald-600 leading-tight truncate">Target: 99.85%</p>
                        </div>

                        <!-- Segmented Progress Bar (5 Blocks) -->
                        <div class="grid grid-cols-5 gap-1 sm:gap-1.5 mt-3 sm:mt-5 pt-1">
                            <div class="h-1.5 sm:h-2 rounded-xs bg-emerald-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-emerald-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-emerald-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-emerald-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-emerald-600"></div>
                        </div>
                    </div>

                    <!-- Card 4: Mean Time to Repair -->
                    <div class="stat-counter-card group relative bg-white rounded-xl sm:rounded-2xl p-3.5 sm:p-5 lg:p-6 border border-slate-200/90 hover:border-rose-200 shadow-2xs hover:shadow-xl hover:shadow-rose-500/10 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between reveal-item stagger-4">
                        <div>
                            <div class="flex items-center justify-between mb-2 sm:mb-3 gap-1">
                                <span class="text-xs sm:text-[13px] font-semibold text-slate-700 truncate">MTTR Restorasi</span>
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-red-50 text-[#bc0007] border border-red-100/80 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-[#bc0007] group-hover:text-white transition-all duration-300">
                                    <span class="material-symbols-outlined text-[16px] sm:text-[18px]">fmd_good</span>
                                </div>
                            </div>
                            <div class="my-1.5 sm:my-2.5 flex items-baseline gap-1">
                                <span class="font-telemetry text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight stat-count-value"
                                      data-target="1.74"
                                      data-decimals="2"
                                      data-format="decimal">1.74</span>
                                <span class="font-sans text-xs sm:text-sm font-semibold text-slate-500">Jam</span>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium leading-tight truncate">Restorasi Kabel Optik</p>
                        </div>

                        <!-- Segmented Progress Bar (5 Blocks) -->
                        <div class="grid grid-cols-5 gap-1 sm:gap-1.5 mt-3 sm:mt-5 pt-1">
                            <div class="h-1.5 sm:h-2 rounded-xs bg-red-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-red-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-red-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-red-100"></div>
                            <div class="h-1.5 sm:h-2 rounded-xs bg-[#bc0007]"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ================= 4 PILAR OPERASIONAL SECTION ================= -->
        <section class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-16 lg:py-24 bg-[#f8f9ff]" id="fitur">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto flex flex-col gap-12">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 reveal-item">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-8 h-1 bg-[#bc0007] rounded-full"></span>
                            <span class="text-xs uppercase tracking-wider text-[#bc0007] font-bold">Modul Inti Platform Monitoring</span>
                        </div>
                        <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0b1c30]">
                            4 Pilar Operasional Infrastruktur Optik Sukabumi
                        </h2>
                    </div>
                    <p class="text-sm text-slate-600 max-w-md leading-relaxed">
                        Dirancang untuk menjamin akurasi fisik ke sistem, mendeteksi redaman abnormal seketika, dan mempercepat tindakan korektif tim patroli lapangan.
                    </p>
                </div>

                <!-- Mobile Swipe Indicator (Hidden on Desktop) -->
                <div class="flex items-center justify-between lg:hidden -mb-4">
                    <span class="text-[11px] font-semibold text-slate-500 flex items-center gap-1.5 font-mono">
                        <span class="material-symbols-outlined text-sm text-[#bc0007]">swipe</span>
                        <span>Geser untuk modul lainnya</span>
                    </span>
                    <span class="text-[11px] font-mono text-slate-400 font-semibold">1 - 4 Pilar</span>
                </div>

                <!-- 4 Cards: Horizontal Scroll Snap on Mobile (< lg), 4-col Grid on Desktop (lg+) -->
                <div class="flex overflow-x-auto snap-x snap-mandatory pb-4 pt-1 gap-4 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 lg:overflow-visible lg:grid lg:grid-cols-4 lg:gap-6 no-scrollbar">
                    
                    <!-- Pilar 1 -->
                    <div class="w-[82vw] max-w-[320px] sm:w-[340px] lg:w-auto shrink-0 snap-center lg:shrink bg-white p-5 sm:p-7 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-300 group reveal-item stagger-1">
                        <div class="flex flex-col gap-3.5 sm:gap-4">
                            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-red-100 flex items-center justify-center text-[#bc0007] group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-2xl">signal_cellular_alt</span>
                            </div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-[#bc0007]">Telemetri Real-Time</span>
                            <h3 class="font-headline text-base sm:text-lg font-bold text-slate-900 group-hover:text-[#bc0007] transition-colors">
                                Monitoring GPON &amp; Redaman OLT
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Monitoring daya pancar/terima optik Tx/Rx per slot PON secara kontinu. Deteksi dini potensi degradasi kualitas, macrobending kabel, dan peringatan instan kabel fiber putus.
                            </p>
                        </div>
                    </div>

                    <!-- Pilar 2 -->
                    <div class="w-[82vw] max-w-[320px] sm:w-[340px] lg:w-auto shrink-0 snap-center lg:shrink bg-white p-5 sm:p-7 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-300 group reveal-item stagger-2">
                        <div class="flex flex-col gap-3.5 sm:gap-4">
                            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-sky-100 flex items-center justify-center text-[#00628d] group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-2xl">qr_code_scanner</span>
                            </div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-[#00628d]">Validasi Aset Fisik</span>
                            <h3 class="font-headline text-base sm:text-lg font-bold text-slate-900 group-hover:text-[#00628d] transition-colors">
                                Audit &amp; Validasi Data Valins Fisik
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Sinkronisasi data QR Code ODP lapangan dengan sistem database UIM. Identifikasi otomatis port ODP bodong, dropcore tidak terdaftar, dan pembaruan visual kondisi perangkat.
                            </p>
                        </div>
                    </div>

                    <!-- Pilar 3 -->
                    <div class="w-[82vw] max-w-[320px] sm:w-[340px] lg:w-auto shrink-0 snap-center lg:shrink bg-white p-5 sm:p-7 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-300 group reveal-item stagger-3">
                        <div class="flex flex-col gap-3.5 sm:gap-4">
                            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-700 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-2xl">map</span>
                            </div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-indigo-700">Geospasial Presisi</span>
                            <h3 class="font-headline text-base sm:text-lg font-bold text-slate-900 group-hover:text-indigo-700 transition-colors">
                                Peta Topologi GIS Spasial Fiber
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Visualisasi rute kabel Feeder, Distribution, dan Closure FDT/ODC berbasis titik koordinat GPS presisi tinggi Sukabumi untuk navigasi cepat regu perbaikan darurat.
                            </p>
                        </div>
                    </div>

                    <!-- Pilar 4 -->
                    <div class="w-[82vw] max-w-[320px] sm:w-[340px] lg:w-auto shrink-0 snap-center lg:shrink bg-white p-5 sm:p-7 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-300 group reveal-item stagger-4">
                        <div class="flex flex-col gap-3.5 sm:gap-4">
                            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-red-100 flex items-center justify-center text-[#bc0007] group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-2xl">troubleshoot</span>
                            </div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-[#bc0007]">Automasi Korektif</span>
                            <h3 class="font-headline text-base sm:text-lg font-bold text-slate-900 group-hover:text-[#bc0007] transition-colors">
                                Analisis OTDR &amp; Notifikasi Bot
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Analisis kurva trace OTDR cerdas untuk pinpoint jarak putus serat optik. Penerbitan Surat Perintah Kerja (SPK) otomatis ke grup Telegram regu patroli Sukabumi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= LIVE DIAGNOSTICS & TELEMETRY PREVIEW ================= -->
        <section class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-16 lg:py-24 bg-white border-y border-slate-200/80" id="telemetri">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto flex flex-col gap-10">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 reveal-item">
                    <div>
                        <div class="flex items-center gap-2 mb-1.5">
                            <svg class="w-4 h-4 text-[#bc0007] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                            </svg>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-600">INTEGRITAS &amp; SINKRONISASI DATA JARINGAN</span>
                        </div>
                        <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-[#0b1c30] tracking-tight">
                            Status Validasi Data Valins & Audit Lapangan Telkom Akses Witel Sukabumi
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1.5 flex items-center gap-1.5 font-medium">
                            <svg class="w-3.5 h-3.5 text-[#bc0007] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Kantor Witel Sukabumi: Jl. R. E. Martadinata No.24, Gunungparang, Kec. Cikole, Kota Sukabumi</span>
                        </p>
                    </div>
                </div>

                <!-- Mobile Tab Switcher (Segmented Control, Hidden on Desktop >= lg) -->
                <div class="flex lg:hidden items-center p-1 bg-slate-100 rounded-xl border border-slate-200/90 w-full max-w-sm mx-auto shadow-2xs -mb-2">
                    <button type="button" 
                            id="btn-tab-telemetri-table" 
                            onclick="switchTelemetriTab('table')"
                            class="flex-1 py-2 px-3 rounded-lg text-xs font-bold transition-all flex items-center justify-center gap-1.5 bg-white text-slate-900 shadow-xs border border-slate-200/80">
                        <span class="material-symbols-outlined text-[16px] text-[#bc0007]">table_chart</span>
                        <span>Tabel Rekonsiliasi</span>
                    </button>
                    <button type="button" 
                            id="btn-tab-telemetri-map" 
                            onclick="switchTelemetriTab('map')"
                            class="flex-1 py-2 px-3 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all flex items-center justify-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-slate-500">map</span>
                        <span>Peta Lokasi</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    
                    <!-- Table Section (2 Cols on Desktop, Tab Pane 1 on Mobile) -->
                    <div id="telemetri-table-wrapper" class="lg:col-span-2 bg-[#f8f9ff] rounded-2xl shadow-sm overflow-hidden flex flex-col border border-slate-200 block reveal-item stagger-1">
                        
                        <!-- Table Sub-header -->
                        <div class="px-5 py-3.5 bg-white border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#bc0007] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                </svg>
                                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Daftar Rekonsiliasi Valins & Status Layanan (ODP Tidak Sama)</h3>
                            </div>
                        </div>

                        <!-- Data Table -->
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-100/70 text-slate-600 font-mono text-[11px] uppercase tracking-wider border-b border-slate-200">
                                        <th class="py-3.5 px-4 font-bold text-left">WITEL</th>
                                        <th class="py-3.5 px-4 font-bold text-left">STO</th>
                                        <th class="py-3.5 px-4 font-bold text-left">ODP NAME</th>
                                        <th class="py-3.5 px-4 font-bold text-left">NODE ID</th>
                                        <th class="py-3.5 px-4 font-bold text-center">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200/70 text-xs font-medium text-slate-700">
                                    <tr class="hover:bg-white/80 transition-colors">
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-900">SUKABUMI</td>
                                        <td class="py-3.5 px-4 font-mono font-semibold text-slate-800">CBD</td>
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-800">ODP-CBD-FAR/9</td>
                                        <td class="py-3.5 px-4 font-mono text-slate-600">GPON02-D3-CBD-4</td>
                                        <td class="py-3.5 px-4 text-center">
                                            <span class="inline-flex items-center justify-center px-3 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-300/80 shadow-2xs">
                                                ASTINET
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="hover:bg-white/80 transition-colors">
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-900">SUKABUMI</td>
                                        <td class="py-3.5 px-4 font-mono font-semibold text-slate-800">CMO</td>
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-800">OTB-CMO-FAB/1</td>
                                        <td class="py-3.5 px-4 font-mono text-slate-600">GPON00-D3-CMO-3</td>
                                        <td class="py-3.5 px-4 text-center">
                                            <span class="inline-flex items-center justify-center px-3 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200 shadow-2xs">
                                                OTB
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="bg-rose-50/40 hover:bg-rose-50/70 transition-colors">
                                        <td class="py-3.5 px-4 font-mono font-bold text-rose-700">SUKABUMI</td>
                                        <td class="py-3.5 px-4 font-mono font-semibold text-slate-900">PLR</td>
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-800">ODP-PLR-FAD/125</td>
                                        <td class="py-3.5 px-4 font-mono text-slate-600">GPON01-D3-PLR-2</td>
                                        <td class="py-3.5 px-4 text-center">
                                            <span class="inline-flex items-center justify-center px-3 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200 shadow-2xs">
                                                Disconnected
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="hover:bg-white/80 transition-colors">
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-900">SUKABUMI</td>
                                        <td class="py-3.5 px-4 font-mono font-semibold text-slate-800">SKB</td>
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-800">ODP-SKB-FCE/8</td>
                                        <td class="py-3.5 px-4 font-mono text-slate-600">GPON01-D3-SKB-4</td>
                                        <td class="py-3.5 px-4 text-center">
                                            <span class="inline-flex items-center justify-center px-3 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                                                DONE OLO
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer Table -->
                        <div class="p-4 bg-white border-t border-slate-200 text-slate-600 text-xs flex flex-col sm:flex-row items-center justify-between gap-2">
                            <span>Menampilkan 4 dari 384 entri pemetaan ODP &amp; status layanan di Witel Sukabumi</span>
                            <a href="{{ route('login') }}" class="text-[#bc0007] font-bold uppercase tracking-wider hover:underline flex items-center gap-1">
                                <span>LIHAT SELURUH DATA VALINS</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Right Side Card: Audit Lapangan ODP Preview with Interactive Map (1 Col on Desktop, Tab Pane 2 on Mobile) -->
                    <div id="telemetri-map-wrapper" class="lg:col-span-1 bg-[#f8f9ff] p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between gap-5 hidden lg:flex reveal-item stagger-2">
                        <div class="flex flex-col gap-4">
                            <!-- Card Header -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#bc0007] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <h3 class="text-sm font-bold text-slate-900 tracking-tight">Titik Koordinat & Lokasi Terkini</h3>
                                </div>
                            </div>

                            <!-- Interactive Map Canvas Container -->
                            <div class="relative w-full h-56 sm:h-60 rounded-xl overflow-hidden border border-slate-200 shadow-inner bg-slate-100" style="isolation: isolate;">
                                <div id="interactive-audit-map" class="w-full h-full z-0">
                                    <!-- Fallback interactive iframe if JS/CDN is loading or offline -->
                                    <iframe 
                                        class="w-full h-full border-0" 
                                        src="https://www.openstreetmap.org/export/embed.html?bbox=106.9240%2C-6.9235%2C106.9330%2C-6.9175&amp;layer=mapnik&amp;marker=-6.92059%2C106.92868"
                                        title="Peta Audit Lapangan Telkom Sukabumi"
                                        loading="lazy">
                                    </iframe>
                                </div>

                                <!-- Floating Semi-Transparent Coordinate Badge -->
                                <div class="absolute bottom-2.5 left-2.5 z-20 pointer-events-none">
                                    <span class="bg-slate-900/80 backdrop-blur-sm text-white text-xs px-3 py-1.5 rounded-lg font-mono shadow-md inline-flex items-center gap-1.5 border border-white/10">
                                        <svg class="w-3.5 h-3.5 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span>Koordinat: -6.9206, 106.9287</span>
                                    </span>
                                </div>

                                <!-- Recenter Button -->
                                <div class="absolute top-2.5 right-2.5 z-20">
                                    <button type="button" 
                                            id="btn-recenter-audit-map" 
                                            title="Fokuskan kembali ke STO Sukabumi" 
                                            class="bg-white/90 hover:bg-white backdrop-blur-sm text-slate-700 hover:text-red-600 text-[11px] font-semibold px-2.5 py-1 rounded-md shadow-sm border border-slate-200 transition-all flex items-center gap-1 cursor-pointer">
                                        <svg class="w-3 h-3 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <circle cx="12" cy="12" r="3"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v3m0 14v3M2 12h3m14 0h3"/>
                                        </svg>
                                        <span>Pusatkan Lokasi</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= END-TO-END FIBER ARCHITECTURE ================= -->
        <section class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-16 lg:py-24 bg-[#f8f9ff]" id="arsitektur">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto flex flex-col gap-12">
                
                <div class="text-center max-w-2xl mx-auto flex flex-col gap-3 reveal-item">
                    <span class="text-xs uppercase tracking-wider text-[#bc0007] font-bold">Arsitektur Jalur Optik GPON</span>
                    <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0b1c30]">
                        Dari Sentral Telepon Otomat (STO) Hingga Rumah Pelanggan
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Peta transmisi optik fisik standar Telkom Akses dengan titik kendali validasi Valins serta toleransi redaman per segmen.
                    </p>
                </div>

                <!-- Mobile Swipe Indicator (Hidden on Desktop) -->
                <div class="flex items-center justify-between lg:hidden -mb-4">
                    <span class="text-[11px] font-semibold text-slate-500 flex items-center gap-1.5 font-mono">
                        <span class="material-symbols-outlined text-sm text-[#bc0007]">swipe</span>
                        <span>Geser alur transmisi (01 - 04)</span>
                    </span>
                    <span class="text-[11px] font-mono text-slate-400 font-semibold">4 Tahapan</span>
                </div>

                <!-- 4 Stages Process Cards: Horizontal Scroll Snap on Mobile (< lg), 4-Cols on Desktop (lg+) -->
                <div class="flex overflow-x-auto snap-x snap-mandatory pb-4 pt-1 gap-4 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 lg:overflow-visible lg:grid lg:grid-cols-4 lg:gap-6 no-scrollbar">
                    
                    <!-- Stage 1 -->
                    <div class="w-[82vw] max-w-[320px] sm:w-[340px] lg:w-auto shrink-0 snap-center lg:shrink bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-200/80 relative flex flex-col justify-between hover:shadow-md transition-shadow reveal-item stagger-1">
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <span class="w-9 h-9 rounded-xl bg-[#bc0007] text-white flex items-center justify-center font-mono text-sm font-bold shadow-xs">
                                    01
                                </span>
                            </div>
                            <h4 class="font-headline text-base font-bold text-slate-900 mt-2">
                                STO &amp; Optical Line Terminal (OLT)
                            </h4>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Perangkat aktif utama OLT ZTE C300 &amp; Huawei MA5800. Titik awal injeksi daya optik laser 1490nm (Downstream) dan 1310nm (Upstream).
                            </p>
                        </div>
                    </div>

                    <!-- Stage 2 -->
                    <div class="w-[82vw] max-w-[320px] sm:w-[340px] lg:w-auto shrink-0 snap-center lg:shrink bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-200/80 relative flex flex-col justify-between hover:shadow-md transition-shadow reveal-item stagger-2">
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <span class="w-9 h-9 rounded-xl bg-[#00628d] text-white flex items-center justify-center font-mono text-sm font-bold shadow-xs">
                                    02
                                </span>
                            </div>
                            <h4 class="font-headline text-base font-bold text-slate-900 mt-2">
                                Optical Distribution Cabinet (ODC)
                            </h4>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Kabinet distribusi outdoor dengan passive optical splitter 1:4. Menyalurkan core kabel backbone ke masing-masing klaster permukiman.
                            </p>
                        </div>
                    </div>

                    <!-- Stage 3 -->
                    <div class="w-[82vw] max-w-[320px] sm:w-[340px] lg:w-auto shrink-0 snap-center lg:shrink bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-200/80 relative flex flex-col justify-between hover:shadow-md transition-shadow reveal-item stagger-3">
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <span class="w-9 h-9 rounded-xl bg-slate-800 text-white flex items-center justify-center font-mono text-sm font-bold shadow-xs">
                                    03
                                </span>
                            </div>
                            <h4 class="font-headline text-base font-bold text-slate-900 mt-2">
                                Optical Distribution Point (ODP)
                            </h4>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Kotak distribusi tiang atau pedestal (Splitter 1:8 / 1:16). Titik fokus audit tag QR Code Valins untuk validasi fisik dan port availability.
                            </p>
                        </div>
                    </div>

                    <!-- Stage 4 -->
                    <div class="w-[82vw] max-w-[320px] sm:w-[340px] lg:w-auto shrink-0 snap-center lg:shrink bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-200/80 relative flex flex-col justify-between hover:shadow-md transition-shadow reveal-item stagger-4">
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <span class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-mono text-sm font-bold shadow-xs">
                                    04
                                </span>
                            </div>
                            <h4 class="font-headline text-base font-bold text-slate-900 mt-2">
                                Optical Network Terminal (ONT)
                            </h4>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Modem optik di tempat pelanggan IndiHome maupun Enterprise Astinet. Menerima sinyal data, voice VoIP, dan IPTV tanpa dispersi abnormal.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= VALINS & FIELD OPERATION VALUE SECTION ================= -->
        <section class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-16 lg:py-24 bg-white border-y border-slate-200/80" id="valins">
            <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
                
                <!-- Left Content -->
                <div class="flex-1 flex flex-col gap-6 reveal-item stagger-1">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-8 h-1 bg-[#bc0007] rounded-full"></span>
                            <span class="text-xs uppercase tracking-wider text-[#bc0007] font-bold">Efisiensi & Akurasi Operasi</span>
                        </div>
                        <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0b1c30]">
                            Mengapa data Valins Service & GPON sangat penting untuk Witel Sukabumi?
                        </h2>
                    </div>

                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                        Sebelum implementasi data Valins terpadu, deviasi data antara catatan inventori logis UIM dan kenyataan kabel lapangan di wilayah Sukabumi mencapai 18%. Platform ini memangkas selisih secara otomatis dan mempercepat waktu perbaikan gangguan.
                    </p>

                    <div class="flex flex-col gap-4 mt-2">
                        
                        <!-- Value Item 1 -->
                        <div class="flex items-start gap-4 bg-[#f8f9ff] p-4 sm:p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                            <div class="p-2 rounded-lg bg-red-100 text-[#bc0007] mt-0.5 shrink-0">
                                <span class="material-symbols-outlined text-xl">verified</span>
                            </div>
                            <div>
                                <h5 class="font-headline text-sm sm:text-base font-bold text-slate-900">
                                    Eliminasi Deviasi Data hingga 98.6%
                                </h5>
                                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                                    Pencocokan barcode QR instan menjamin nomor port dan pelanggan tersimpan presisi di database pusat tanpa entri manual yang rentan salah.
                                </p>
                            </div>
                        </div>

                        <!-- Value Item 2 -->
                        <div class="flex items-start gap-4 bg-[#f8f9ff] p-4 sm:p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                            <div class="p-2 rounded-lg bg-sky-100 text-[#00628d] mt-0.5 shrink-0">
                                <span class="material-symbols-outlined text-xl">send</span>
                            </div>
                            <div>
                                <h5 class="font-headline text-sm sm:text-base font-bold text-slate-900">
                                    Peringatan Instan Bot Telegram NOC 24/7
                                </h5>
                                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                                    Jika terdeteksi fiber cut atau lonjakan redaman di atas ambang -24 dBm, notifikasi koordinat GPS langsung diteruskan ke regu teknisi patroli Sukabumi.
                                </p>
                            </div>
                        </div>

                        <!-- Value Item 3 -->
                        <div class="flex items-start gap-4 bg-[#f8f9ff] p-4 sm:p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                            <div class="p-2 rounded-lg bg-indigo-100 text-indigo-700 mt-0.5 shrink-0">
                                <span class="material-symbols-outlined text-xl">download_for_offline</span>
                            </div>
                            <div>
                                <h5 class="font-headline text-sm sm:text-base font-bold text-slate-900">
                                    Ekspor BAST Mitra 1-Klik (PDF & XLSX)
                                </h5>
                                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                                    Penyusunan Berita Acara Serah Terima (BAST) hasil uji petik fisik mitra kontraktor Telkom Akses siap cetak format PDF dan XLSX standar Telkom Group.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Visual: Field Technician -->
                <div class="w-full lg:w-5/12 flex flex-col gap-4 reveal-item stagger-2">
                    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-xl bg-slate-950 border border-slate-200/80 group">
                        <img src="{{ asset('images/landing/technician-field-odc.jpg') }}" 
                             alt="Teknisi Telkom Akses Pemeliharaan ODC dan Validasi ODP Lapangan Sukabumi" 
                             class="w-full h-84 sm:h-96 lg:h-[400px] object-cover object-[center_25%] transition-transform duration-700 group-hover:scale-105"
                             onerror="this.onerror=null; this.src='{{ asset('images/landing/technician-field-odp.jpg') }}'">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/20 to-transparent pointer-events-none"></div>
                        
                        <div class="absolute bottom-4 left-4 right-4 bg-slate-900/85 backdrop-blur-md p-3.5 sm:p-4 rounded-xl sm:rounded-2xl text-white border border-white/10 shadow-lg">
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-red-300 font-bold flex items-center gap-1.5">
                                    <span>Regu Teknisi Lapangan</span>
                                </span>
                                <span class="text-[10px] text-slate-400 font-mono">Witel Sukabumi</span>
                            </div>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                Audit berkala fisik ODP &amp; ODC di kawasan Cikole, Baros, Citamiang, dan Jalur Lingkar Selatan Sukabumi.
                            </p>
                        </div>
                    </div>

                    <!-- Supporting Mini Security Card -->
                    <div class="bg-[#f8f9ff] p-4 rounded-xl border border-slate-200 shadow-2xs flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#bc0007] text-2xl">lock</span>
                            <div>
                                <span class="text-xs sm:text-sm font-bold text-slate-900 block">Keamanan Standar Telkom SSO</span>
                                <span class="text-[11px] text-slate-500">Enkripsi TLS 1.3 & Audit Log Forensik</span>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-[#00628d] text-xl">verified_user</span>
                    </div>
                </div>

            </div>
        </section>

        <!-- ================= FULL-WIDTH CTA BANNER (MORDANT RED 19) ================= -->
        <section class="w-full bg-[#AE0C00] rounded-none shadow-none mb-0" id="konsol">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12 lg:py-16 reveal-item">
                <!-- Split 2 Kolom Layout (Kiri Informasi, Kanan Tombol Aksi) -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                    <!-- Kolom Kiri (Judul & Deskripsi) -->
                    <div class="lg:max-w-2xl">
                        <h2 class="text-2xl md:text-4xl font-bold text-white tracking-tight leading-tight">
                            Tingkatkan Integritas Data Jaringan Fiber Optik Sukabumi Sekarang
                        </h2>
                        <p class="text-white/90 text-sm md:text-base mt-3 leading-relaxed">
                            Akses konsol monitoring diperuntukkan bagi Network Engineer, Validator Data Valins, Asisten Manager Pemeliharaan, dan Teknisi Lapangan PT Telkom Akses Witel Sukabumi.
                        </p>
                    </div>

                    <!-- Kolom Kanan (Area Tombol Aksi) -->
                    <div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row items-stretch sm:items-center gap-3.5 shrink-0">
                        @auth
                            <a href="{{ route('dashboard') }}" 
                               class="bg-white text-[#AE0C00] hover:bg-neutral-100 font-semibold px-6 py-3.5 rounded-lg transition-colors flex items-center justify-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-[19px]">dashboard</span>
                                <span>Buka Dashboard Saya</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="bg-white text-[#AE0C00] hover:bg-neutral-100 font-semibold px-6 py-3.5 rounded-lg transition-colors flex items-center justify-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-[19px]">login</span>
                                <span>Masuk Akun Sekarang</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Persistent Telkom Akses Operations Footer (Hidden on Mobile / Inspect < lg) -->
    <footer class="hidden lg:block w-full bg-white border-t border-slate-200/80 shadow-xs mt-0 pt-7 sm:pt-8.5 pb-4 sm:pb-5 text-left" id="bantuan">
        <div class="w-full max-w-[1536px] 2xl:max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
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
                            Sistem Informasi Manajemen Data Valins & Monitoring GPON OLT Terpadu Kawasan Sukabumi. Platform resmi operasional jaringan optik dan integrasi topologi ODC/ODP regional.
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
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Masuk Akun</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Registrasi Akun</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Validasi Data Valins</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Monitoring &amp; Rekonsiliasi</span>
                            </a>
                        </li>
                        <li>
                             <a href="{{ url('contact-us') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                    <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Hubungi Kami</span>
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
                           <a href="{{ route('about.us') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
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
                            <a href="{{ route('login') }}" class="group flex items-center gap-2 text-slate-600 hover:text-[#bc0007] transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-[#bc0007] group-hover:translate-x-1 transition-all duration-200 shrink-0">arrow_forward</span>
                                <span class="font-medium group-hover:translate-x-0.5 transition-transform duration-200">Arsitektur Jaringan GPON</span>
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

            <!-- Garis Pembatas Horisontal Tunggal yang Presisi -->
            <div class="border-t border-slate-200/80 mt-8 mb-6 sm:mt-9 sm:mb-6"></div>

            <!-- Bilah Hak Cipta & Media Sosial (Bottom Bar) -->
            <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-500">
                <!-- Sisi Kiri: Teks Hak Cipta & Otoritas Regional -->
                <p class="text-center sm:text-left leading-relaxed text-slate-500">
                    <span class="font-medium text-slate-700">© {{ date('Y') }} PT Telkom Akses Witel Sukabumi.</span>
                    <span class="text-slate-300 hidden sm:inline">•</span>
                    <span class="text-slate-500">Sub-Direktorat Operasi Jaringan Regional Jawa Barat</span>
                </p>

                <!-- Sisi Kanan: Deretan Ikon Media Sosial (Lingkaran Abu-abu Tipis Membulat, Hover State Merah Korporat) -->
                <div class="flex items-center gap-2">
                    <!-- 1. Instagram -->
                    <a href="https://www.instagram.com/telkomaksesindonesia/" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-full bg-slate-50 hover:bg-[#bc0007] text-slate-600 hover:text-white border border-slate-200/90 hover:border-[#bc0007] flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-sm active:scale-95" 
                       title="Instagram Resmi Telkom Akses (@telkomaksesindonesia)">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>

                    <!-- 2. YouTube -->
                    <a href="https://www.youtube.com/@TelkomAksesOfficial/streams" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-full bg-slate-50 hover:bg-[#bc0007] text-slate-600 hover:text-white border border-slate-200/90 hover:border-[#bc0007] flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-sm active:scale-95" 
                       title="YouTube Channel Telkom Akses">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>

                    <!-- 3. TikTok -->
                    <a href="https://www.tiktok.com/@telkomaksesindonesia" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-full bg-slate-50 hover:bg-[#bc0007] text-slate-600 hover:text-white border border-slate-200/90 hover:border-[#bc0007] flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-sm active:scale-95" 
                       title="TikTok Telkom Akses (@telkomaksesindonesia)">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-1.01-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    </a>

                    <!-- 4. Facebook -->
                    <a href="https://www.facebook.com/telkomaksesofficial/" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-full bg-slate-50 hover:bg-[#bc0007] text-slate-600 hover:text-white border border-slate-200/90 hover:border-[#bc0007] flex items-center justify-center transition-all duration-200 shadow-2xs hover:shadow-sm active:scale-95" 
                       title="Facebook Telkom Akses">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Header Navigation Interactive & Stable Scroll Controller -->
    <script>
        // Telemetri Section Tab Switcher for Mobile Devices
        function switchTelemetriTab(tab) {
            const tableWrapper = document.getElementById('telemetri-table-wrapper');
            const mapWrapper = document.getElementById('telemetri-map-wrapper');
            const btnTable = document.getElementById('btn-tab-telemetri-table');
            const btnMap = document.getElementById('btn-tab-telemetri-map');

            if (!tableWrapper || !mapWrapper || !btnTable || !btnMap) return;

            if (tab === 'table') {
                tableWrapper.classList.remove('hidden');
                tableWrapper.classList.add('block');
                mapWrapper.classList.add('hidden');
                mapWrapper.classList.remove('flex');

                btnTable.className = 'flex-1 py-2 px-3 rounded-lg text-xs font-bold transition-all flex items-center justify-center gap-1.5 bg-white text-slate-900 shadow-xs border border-slate-200/80';
                btnMap.className = 'flex-1 py-2 px-3 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all flex items-center justify-center gap-1.5';
            } else if (tab === 'map') {
                tableWrapper.classList.add('hidden');
                tableWrapper.classList.remove('block');
                mapWrapper.classList.remove('hidden');
                mapWrapper.classList.add('flex');

                btnMap.className = 'flex-1 py-2 px-3 rounded-lg text-xs font-bold transition-all flex items-center justify-center gap-1.5 bg-white text-slate-900 shadow-xs border border-slate-200/80';
                btnTable.className = 'flex-1 py-2 px-3 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all flex items-center justify-center gap-1.5';

                if (window.auditMap) {
                    setTimeout(() => {
                        window.auditMap.invalidateSize();
                    }, 50);
                }
            }
        }

        // ================= MOBILE OVERLAY SIDEBAR DRAWER CONTROLLER =================
        function toggleMobileDrawer(open) {
            const drawer = document.getElementById('mobile-overlay-drawer');
            const backdrop = document.getElementById('mobile-drawer-backdrop');
            const panel = document.getElementById('mobile-drawer-panel');
            const openBtn = document.getElementById('btn-open-mobile-drawer');

            if (!drawer || !backdrop || !panel) return;

            if (open) {
                drawer.classList.remove('invisible');
                requestAnimationFrame(() => {
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');
                    panel.classList.remove('translate-x-full');
                    panel.classList.add('translate-x-0');
                });
                document.body.classList.add('overflow-hidden');
                if (openBtn) openBtn.setAttribute('aria-expanded', 'true');
            } else {
                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0');
                panel.classList.remove('translate-x-0');
                panel.classList.add('translate-x-full');
                document.body.classList.remove('overflow-hidden');
                if (openBtn) openBtn.setAttribute('aria-expanded', 'false');

                setTimeout(() => {
                    if (panel.classList.contains('translate-x-full')) {
                        drawer.classList.add('invisible');
                    }
                }, 300);
            }
        }

        function handleMobileNavClick(el) {
            document.querySelectorAll('.mobile-drawer-link').forEach(link => {
                link.classList.remove('active');
            });
            el.classList.add('active');
            toggleMobileDrawer(false);
        }

        // Close drawer on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const drawer = document.getElementById('mobile-overlay-drawer');
                if (drawer && !drawer.classList.contains('invisible')) {
                    toggleMobileDrawer(false);
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const navLinks = document.querySelectorAll('.nav-link-item');
            const sections = [];
            let isUserClicking = false;
            let clickTimeout = null;

            navLinks.forEach(link => {
                const targetId = link.getAttribute('href');
                if (targetId && targetId.startsWith('#')) {
                    const section = document.querySelector(targetId);
                    if (section) {
                        sections.push({ id: targetId, el: section, link: link });
                    }
                }

                link.addEventListener('click', function (e) {
                    // Lock active state immediately to the clicked link, preventing intermediate jumps during scroll
                    isUserClicking = true;
                    if (clickTimeout) clearTimeout(clickTimeout);

                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');

                    // Release lock after smooth scroll animation settles
                    clickTimeout = setTimeout(() => {
                        isUserClicking = false;
                    }, 850);
                });
            });

            // Smooth, deterministic scroll position tracker
            let scrollTicking = false;
            function updateActiveOnScroll() {
                if (isUserClicking || sections.length === 0) return;

                const scrollPos = window.scrollY + 140; // 140px accounts for sticky header height
                let currentSection = null;

                for (let i = 0; i < sections.length; i++) {
                    const top = sections[i].el.offsetTop;
                    const height = sections[i].el.offsetHeight;
                    if (scrollPos >= top && scrollPos < top + height) {
                        currentSection = sections[i];
                        break;
                    }
                }

                // If scrolled to near the bottom of the page, activate the last section
                if ((window.innerHeight + window.scrollY) >= (document.documentElement.scrollHeight - 80)) {
                    currentSection = sections[sections.length - 1];
                }

                if (currentSection) {
                    navLinks.forEach(link => {
                        if (link === currentSection.link) {
                            link.classList.add('active');
                        } else {
                            link.classList.remove('active');
                        }
                    });

                    // Synchronize active highlight with mobile drawer links
                    const activeHref = currentSection.link.getAttribute('href');
                    document.querySelectorAll('.mobile-drawer-link').forEach(mLink => {
                        if (mLink.getAttribute('href') === activeHref) {
                            mLink.classList.add('active');
                        } else {
                            mLink.classList.remove('active');
                        }
                    });
                }
            }

            window.addEventListener('scroll', function () {
                if (!scrollTicking) {
                    window.requestAnimationFrame(function () {
                        updateActiveOnScroll();
                        scrollTicking = false;
                    });
                    scrollTicking = true;
                }
            }, { passive: true });

            // Live Telemetry Animated Counter (Count-Up Animation with Stable Settling)
            const statsSection = document.getElementById('live-stats-strip');
            if (statsSection) {
                let hasAnimated = false;
                const counters = statsSection.querySelectorAll('.stat-count-value');

                // Pre-initialize counters to 0 so the animation cleanly counts up from zero when scrolled into view
                counters.forEach(counter => {
                    const format = counter.getAttribute('data-format');
                    const decimals = parseInt(counter.getAttribute('data-decimals') || '0', 10);
                    counter.textContent = (format === 'decimal') ? (0).toFixed(decimals) : '0';
                });

                function runStatsCounter() {
                    if (hasAnimated) return;
                    hasAnimated = true;

                    const duration = 1800; // 1.8 seconds duration
                    const startTime = performance.now();

                    function updateCounter(currentTime) {
                        const elapsedTime = currentTime - startTime;
                        const progress = Math.min(elapsedTime / duration, 1);
                        // Quartic ease-out for smooth energetic start and gentle settling into stable value
                        const ease = 1 - Math.pow(1 - progress, 4);

                        counters.forEach(counter => {
                            const target = parseFloat(counter.getAttribute('data-target'));
                            const format = counter.getAttribute('data-format');
                            const decimals = parseInt(counter.getAttribute('data-decimals') || '0', 10);
                            const currentVal = target * ease;

                            if (format === 'decimal') {
                                counter.textContent = currentVal.toFixed(decimals);
                            } else {
                                counter.textContent = Math.floor(currentVal).toLocaleString('en-US');
                            }
                        });

                        if (progress < 1) {
                            requestAnimationFrame(updateCounter);
                        } else {
                            // Settle into exact target values and apply stabilized visual lock
                            counters.forEach(counter => {
                                const target = parseFloat(counter.getAttribute('data-target'));
                                const format = counter.getAttribute('data-format');
                                const decimals = parseInt(counter.getAttribute('data-decimals') || '0', 10);

                                if (format === 'decimal') {
                                    counter.textContent = target.toFixed(decimals);
                                } else {
                                    counter.textContent = Math.round(target).toLocaleString('en-US');
                                }
                                counter.classList.add('counter-stabilized');
                            });
                        }
                    }

                    requestAnimationFrame(updateCounter);
                }

                if ('IntersectionObserver' in window) {
                    const statsObserver = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                runStatsCounter();
                                statsObserver.unobserve(statsSection);
                            }
                        });
                    }, { threshold: 0.15 });
                    statsObserver.observe(statsSection);
                } else {
                    runStatsCounter();
                }
            }

            // ================= INTERACTIVE FIELD AUDIT MAP (LEAFLET.JS) =================
            const auditMapContainer = document.getElementById('interactive-audit-map');
            if (auditMapContainer && typeof L !== 'undefined') {
                try {
                    // Exact coordinates: Telkom Indonesia / STO Witel Sukabumi (Jl. R. E. Martadinata No.24, Cikole)
                    const telkomSukabumiCoords = [-6.920591, 106.928677];

                    // Clear static fallback iframe
                    auditMapContainer.innerHTML = '';

                    const auditMap = L.map('interactive-audit-map', {
                        center: telkomSukabumiCoords,
                        zoom: 17,
                        zoomControl: true,
                        scrollWheelZoom: false, // Prevents unintended scroll hijack
                        attributionControl: false
                    });
                    window.auditMap = auditMap;

                    // Add high-clarity OpenStreetMap tiles
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap'
                    }).addTo(auditMap);

                    // Enable wheel zoom on click/interaction
                    auditMap.on('focus', () => { auditMap.scrollWheelZoom.enable(); });
                    auditMap.on('click', () => { auditMap.scrollWheelZoom.enable(); });

                    // Custom Telkom Red Pin Marker (Static SVG, Zero Pulse/Blink)
                    const telkomRedPin = L.divIcon({
                        className: 'telkom-marker-wrapper',
                        html: `
                            <div style="position: relative; display: flex; flex-direction: column; align-items: center; cursor: pointer; filter: drop-shadow(0 4px 10px rgba(188,0,7,0.45));">
                                <div style="background: linear-gradient(135deg, #e3000a 0%, #bc0007 100%); width: 36px; height: 36px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); display: flex; align-items: center; justify-content: center; border: 2.5px solid #ffffff;">
                                    <svg style="transform: rotate(45deg); width: 18px; height: 18px; color: #ffffff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div style="width: 14px; height: 5px; background: rgba(15,23,42,0.4); border-radius: 50%; margin-top: 3px; filter: blur(1px);"></div>
                            </div>
                        `,
                        iconSize: [36, 44],
                        iconAnchor: [18, 42],
                        popupAnchor: [0, -42]
                    });

                    // Add Marker & Custom Popup
                    const auditMarker = L.marker(telkomSukabumiCoords, { icon: telkomRedPin }).addTo(auditMap);

                    const popupContent = `
                        <div style="font-family: 'Plus Jakarta Sans', Inter, sans-serif; min-width: 215px;">
                            <div style="font-size: 13px; font-weight: 800; color: #bc0007; margin-bottom: 3px;">
                                Telkom Akses Witel Sukabumi
                            </div>
                            <div style="font-size: 11px; color: #475569; margin-bottom: 6px; line-height: 1.35;">
                                Jl. R. E. Martadinata No.24, Gunungparang, Kec. Cikole, Kota Sukabumi
                            </div>
                        </div>
                    `;

                    auditMarker.bindPopup(popupContent).openPopup();

                    // Recenter button listener
                    const recenterBtn = document.getElementById('btn-recenter-audit-map');
                    if (recenterBtn) {
                        recenterBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            auditMap.flyTo(telkomSukabumiCoords, 17, { duration: 1.2 });
                            setTimeout(() => {
                                auditMarker.openPopup();
                            }, 1250);
                        });
                    }

                    // Invalidate size to guarantee tile rendering without grey edges
                    setTimeout(() => { auditMap.invalidateSize(); }, 350);
                    window.addEventListener('resize', () => { auditMap.invalidateSize(); });

                    if ('IntersectionObserver' in window) {
                        const mapObserver = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    auditMap.invalidateSize();
                                }
                            });
                        }, { threshold: 0.1 });
                        mapObserver.observe(auditMapContainer);
                    }
                } catch (err) {
                    console.error('Interactive map init error:', err);
                }
            }

            // ================= UNIFIED SCROLL REVEAL (AOS) ENGINE =================
            const revealItems = document.querySelectorAll('.reveal-item');
            if (revealItems.length > 0) {
                if (!('IntersectionObserver' in window)) {
                    revealItems.forEach(el => el.classList.add('reveal-visible'));
                } else {
                    const scrollRevealObserver = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('reveal-visible');
                                scrollRevealObserver.unobserve(entry.target);
                            }
                        });
                    }, {
                        threshold: 0.12,
                        rootMargin: '0px 0px -40px 0px'
                    });

                    revealItems.forEach(el => scrollRevealObserver.observe(el));

                    // Failsafe: After 1.4s, make sure any elements in viewport are visible
                    setTimeout(() => {
                        revealItems.forEach(el => {
                            const rect = el.getBoundingClientRect();
                            if (rect.top < window.innerHeight + 100) {
                                el.classList.add('reveal-visible');
                            }
                        });
                    }, 1400);
                }
            }
        });
    </script>
</body>
</html>
