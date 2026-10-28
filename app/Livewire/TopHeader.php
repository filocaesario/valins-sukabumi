<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ValinsService;
use App\Models\MasterGpon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TopHeader extends Component
{
    public $pageTitle = 'Dashboard Monitoring';
    public $breadcrumb = 'Panel Kendali';

    // State Real-Time
    public $inboxItems = [];
    public $notifItems = [];
    public $unreadNotifCount = 0;
    public $hasUnreadInbox = false;
    public $lastSyncTime = '';
    public $avatarUrl = null;

    public function mount($pageTitle = null, $breadcrumb = null)
    {
        if ($pageTitle) {
            $this->pageTitle = $pageTitle;
            $this->breadcrumb = $breadcrumb ?? 'Panel Kendali';
        } else {
            $this->resolvePageMeta();
        }

        $this->avatarUrl = Auth::user()?->avatarUrl();
        $this->loadData();
    }

    public function resolvePageMeta()
    {
        if (request()->routeIs('dashboard')) {
            $this->pageTitle = 'Dashboard Monitoring';
            $this->breadcrumb = 'Panel Kendali';
        } elseif (request()->routeIs('valins.*')) {
            $this->pageTitle = 'Valins Services';
            $this->breadcrumb = 'Valins Services & Rekonsiliasi';
        } elseif (request()->routeIs('master-gpon.*')) {
            $this->pageTitle = 'Monitoring GPON';
            $this->breadcrumb = 'Monitoring GPON & Port OLT';
        } elseif (request()->routeIs('profile.*')) {
            $this->pageTitle = 'Pengaturan Profil';
            $this->breadcrumb = 'Akun Pengguna';
        } else {
            $this->pageTitle = 'Panel Kendali';
            $this->breadcrumb = 'Sistem Terpadu';
        }
    }

    #[On('valinsUpdated')]
    #[On('gponUpdated')]
    #[On('dashboard-refreshed')]
    public function handleRealtimeUpdate()
    {
        $this->loadData();
    }

    #[On('avatar-updated')]
    #[On('profile-avatar-updated')]
    #[On('profile-updated')]
    public function handleAvatarUpdated($avatarUrl = null)
    {
        $this->avatarUrl = $avatarUrl ?? Auth::user()?->fresh()->avatarUrl();
    }

    public function loadData()
    {
        $this->lastSyncTime = now()->format('H:i:s');
        $this->fetchInboxLogs();
        $this->fetchDeviationAlerts();
    }

    // 1. Tarik Log Pesan & Aktivitas Nyata dari Database
    public function fetchInboxLogs()
    {
        $logs = [];

        // Tarik log dari Valins Services terbaru
        $recentValins = ValinsService::orderBy('updated_at', 'desc')->take(8)->get();
        foreach ($recentValins as $v) {
            $isCreated = abs(strtotime($v->created_at) - strtotime($v->updated_at)) < 5;
            $odp = $v->odp_name ?: ($v->valins_id ? 'Valins ID ' . $v->valins_id : 'ID #' . $v->id);
            $sto = $v->sto ?: 'SKB';
            $actor = $v->updated_by ?: ($v->pic ?: 'Tim DAMAN');
            $timestamp = $v->updated_at ? $v->updated_at->timestamp : now()->timestamp;
            $id = 'v_' . $v->id . '_' . $timestamp;

            if ($isCreated) {
                $logs[] = [
                    'id'        => $id,
                    'type'      => 'create',
                    'title'     => 'Penambahan Data ODP',
                    'subject'   => $odp,
                    'detail'    => "STO {$sto} • Kategori: {$v->kategori}",
                    'actor'     => $actor,
                    'time_ago'  => $v->updated_at ? $v->updated_at->diffForHumans() : 'Baru saja',
                    'timestamp' => $timestamp,
                    'link'      => route('valins.index', ['search' => $v->odp_name ?: $v->valins_id]),
                ];
            } else {
                $statusKet = $v->keterangan ?: 'Sedang Diproses';
                $logs[] = [
                    'id'        => $id,
                    'type'      => 'update',
                    'title'     => 'Pembaruan Data ODP',
                    'subject'   => $odp,
                    'detail'    => "STO {$sto} • Status: {$statusKet} • {$v->kategori}",
                    'actor'     => $actor,
                    'time_ago'  => $v->updated_at ? $v->updated_at->diffForHumans() : 'Baru saja',
                    'timestamp' => $timestamp,
                    'link'      => route('valins.index', ['search' => $v->odp_name ?: $v->valins_id]),
                ];
            }
        }

        // Tarik log dari Master GPON terbaru
        $recentGpon = MasterGpon::orderBy('updated_at', 'desc')->take(4)->get();
        foreach ($recentGpon as $g) {
            $timestamp = $g->updated_at ? $g->updated_at->timestamp : now()->timestamp;
            $id = 'g_' . $g->id . '_' . $timestamp;
            $logs[] = [
                'id'        => $id,
                'type'      => 'gpon',
                'title'     => 'Audit Port GPON OLT',
                'subject'   => $g->node_id,
                'detail'    => "STO {$g->sto} • {$g->slot} / {$g->port} ({$g->type_gpon})",
                'actor'     => 'NOC GPON',
                'time_ago'  => $g->updated_at ? $g->updated_at->diffForHumans() : 'Baru saja',
                'timestamp' => $timestamp,
                'link'      => route('master-gpon.index', ['search' => $g->node_id]),
            ];
        }

        // Urutkan berdasarkan waktu paling mutakhir
        usort($logs, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);
        $this->inboxItems = array_slice($logs, 0, 6);

        // Hitung unread status berdasarkan session
        $readInboxIds = session('inbox_read_ids', []);
        $inboxLastReadTime = session('inbox_last_read_time', 0);

        $unreadCount = 0;
        foreach ($this->inboxItems as $item) {
            if (!in_array($item['id'], $readInboxIds) && $item['timestamp'] > $inboxLastReadTime) {
                $unreadCount++;
            }
        }
        $this->hasUnreadInbox = $unreadCount > 0;
    }

    // 2. Tarik Peringatan Deviasi Sistem dari Database (Data-Driven Alerts)
    public function fetchDeviationAlerts()
    {
        $alerts = [];

        // 1. STO dengan Deviasi Tertinggi (Status Kritis / Waspada)
        $topStos = ValinsService::whereNotNull('sto')
            ->where('sto', '!=', '-')
            ->where('sto', '!=', '')
            ->where(function ($q) {
                $q->whereNotIn('keterangan', ['DONE', 'DONE OLO'])
                  ->orWhereNull('keterangan');
            })
            ->select('sto', DB::raw('count(*) as total'))
            ->groupBy('sto')
            ->orderByDesc('total')
            ->take(3)
            ->get();

        foreach ($topStos as $s) {
            $isCritical = $s->total >= 50;
            $alerts[] = [
                'id'          => 'sto_' . $s->sto . '_' . $s->total,
                'type'        => 'sto_deviation',
                'is_critical' => $isCritical,
                'badge'       => $s->total . ' Deviasi',
                'title'       => 'Sentral ' . $s->sto . ' (' . ($isCritical ? 'Prioritas Kritis' : 'Siaga Waspada') . ')',
                'detail'      => $isCritical 
                                  ? "Ditemukan {$s->total} kasus deviasi aktif di wilayah {$s->sto}. Memerlukan patroli rekonsiliasi prioritas."
                                  : "Tercatat {$s->total} temuan deviasi data ODP dan port yang sedang dalam antrean verifikasi.",
                'link'        => route('dashboard', ['filterSto' => $s->sto]),
            ];
        }

        // 2. Kategori Deviasi Masalah Tertinggi
        $deviasiCats = [
            'ODP TIDAK SAMA', 
            'DATEK TIDAK SAMA', 
            'ODP DAN DATEK TIDAK SAMA', 
            'Not In Service', 
            'Kendala ODP',
            'KENDALA OTB'
        ];
        $topCategories = ValinsService::whereIn('kategori', $deviasiCats)
            ->where(function ($q) {
                $q->whereNotIn('keterangan', ['DONE', 'DONE OLO'])
                  ->orWhereNull('keterangan');
            })
            ->select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->take(2)
            ->get();

        foreach ($topCategories as $cat) {
            $isCritical = $cat->total >= 50;
            $alerts[] = [
                'id'          => 'cat_' . md5($cat->kategori) . '_' . $cat->total,
                'type'        => 'category_deviation',
                'is_critical' => $isCritical,
                'badge'       => $cat->total . ' Kasus',
                'title'       => 'Deviasi ' . $cat->kategori,
                'detail'      => "Sebanyak {$cat->total} data ODP belum berstatus DONE rekonsiliasi.",
                'link'        => route('valins.index', ['kategori' => $cat->kategori]),
            ];
        }

        // 3. Status Telemetri Master GPON
        $totalGponNodes = MasterGpon::distinct('node_id')->count('node_id');
        $totalGponPorts = MasterGpon::count();
        if ($totalGponNodes > 0) {
            $alerts[] = [
                'id'          => 'gpon_telemetry_' . $totalGponNodes . '_' . $totalGponPorts,
                'type'        => 'gpon_telemetry',
                'is_critical' => false,
                'badge'       => 'Normal',
                'title'       => "Telemetri GPON: {$totalGponNodes} Node OLT",
                'detail'      => "Total {$totalGponPorts} port optik termonitoring aktif di Witel Sukabumi.",
                'link'        => route('master-gpon.index'),
            ];
        }

        $this->notifItems = $alerts;

        // Hitung unread status
        $readNotifIds = session('notif_read_ids', []);
        $unreadCount = 0;
        foreach ($this->notifItems as $a) {
            if (!in_array($a['id'], $readNotifIds)) {
                $unreadCount++;
            }
        }
        $this->unreadNotifCount = $unreadCount;
    }

    // Aksi Tandai Dibaca Kotak Pesan
    public function markInboxAsRead()
    {
        $currentIds = array_column($this->inboxItems, 'id');
        $readIds = session('inbox_read_ids', []);
        $newReadIds = array_unique(array_merge($readIds, $currentIds));
        session(['inbox_read_ids' => $newReadIds, 'inbox_last_read_time' => now()->timestamp]);
        $this->hasUnreadInbox = false;
    }

    // Aksi Tandai Semua Dibaca Lonceng Notifikasi
    public function markAllNotifAsRead()
    {
        $currentIds = array_column($this->notifItems, 'id');
        $readIds = session('notif_read_ids', []);
        $newReadIds = array_unique(array_merge($readIds, $currentIds));
        session(['notif_read_ids' => $newReadIds, 'notif_last_read_time' => now()->timestamp]);
        $this->unreadNotifCount = 0;
    }

    // Klik satu item notifikasi langsung
    public function openNotifItem($id, $targetUrl)
    {
        $readIds = session('notif_read_ids', []);
        if (!in_array($id, $readIds)) {
            $readIds[] = $id;
            session(['notif_read_ids' => $readIds]);
        }
        return $this->redirect($targetUrl);
    }

    // Klik satu item inbox langsung
    public function openInboxItem($id, $targetUrl)
    {
        $readIds = session('inbox_read_ids', []);
        if (!in_array($id, $readIds)) {
            $readIds[] = $id;
            session(['inbox_read_ids' => $readIds]);
        }
        return $this->redirect($targetUrl);
    }

    public function render()
    {
        $user = Auth::user();
        $userName = $user->name ?? 'User';
        $userEmail = $user->email ?? '';
        $userRole = !empty($user->regu) ? $user->regu : (!empty($user->role) ? strtoupper($user->role) : 'MO DAMAN SKB');
        $avatarUrl = $this->avatarUrl ?? $user?->avatarUrl();

        $cleanWords = array_values(array_filter(preg_split('/[^A-Za-z0-9]+/', $userName)));
        $initials = $user ? $user->initials() : 'TA';

        return view('livewire.top-header', [
            'userName'  => $userName,
            'userEmail' => $userEmail,
            'userRole'  => $userRole,
            'initials'  => $initials,
            'avatarUrl' => $avatarUrl,
            'readNotifIds' => session('notif_read_ids', []),
            'readInboxIds' => session('inbox_read_ids', []),
        ]);
    }
}
