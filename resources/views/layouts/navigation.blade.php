@php
    if (request()->routeIs('dashboard')) {
        $pageTitle = 'Dashboard Monitoring';
        $breadcrumb = 'Panel Kendali';
    } elseif (request()->routeIs('valins.*')) {
        $tab = \App\Models\NavbarTab::where('route_name', 'valins.index')->first();
        $pageTitle = $tab?->nama_tab ?? 'Valins Services';
        $breadcrumb = 'Valins Services & Rekonsiliasi';
    } elseif (request()->routeIs('master-gpon.*')) {
        $tab = \App\Models\NavbarTab::where('route_name', 'master-gpon.index')->first();
        $pageTitle = $tab?->nama_tab ?? 'Monitoring GPON';
        $breadcrumb = 'Monitoring GPON & Port OLT';
    } elseif (request()->routeIs('profile.*')) {
        $pageTitle = 'Pengaturan Profil';
        $breadcrumb = 'Akun Pengguna';
    } else {
        $pageTitle = 'Panel Kendali';
        $breadcrumb = 'Sistem Terpadu';
    }
@endphp

<livewire:top-header :page-title="$pageTitle" :breadcrumb="$breadcrumb" />
