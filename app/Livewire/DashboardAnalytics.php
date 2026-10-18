<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ValinsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardAnalytics extends Component
{
    public function render()
    {
        // 1. DATA GRAFIK BAR: Kendala Terbanyak per STO (Di-cache 30 detik agar server responsif)
        $kendalaPerSto = Cache::remember('dashboard_kendala_per_sto', 30, function () {
            return ValinsService::select('sto', DB::raw('count(*) as total'))
                ->whereIn('keterangan', ['ODP TIDAK SAMA', 'DATEK TIDAK SAMA', 'ODP DAN DATEK TIDAK SAMA', 'Not In Service', 'OTB', 'Disconnected'])
                ->groupBy('sto')
                ->pluck('total', 'sto')
                ->toArray();
        });

        // 2. DATA GRAFIK PIE: Persentase Status Port / Valins (Di-cache 30 detik agar server tidak berat)
        $statusValins = Cache::remember('dashboard_status_valins', 30, function () {
            return ValinsService::select('keterangan', DB::raw('count(*) as total'))
                ->groupBy('keterangan')
                ->pluck('total', 'keterangan')
                ->toArray();
        });

        return view('livewire.dashboard-analytics', [
            'stoLabels' => json_encode(empty($kendalaPerSto) ? ['SKB', 'CBD', 'BGL'] : array_keys($kendalaPerSto)),
            'stoData' => json_encode(empty($kendalaPerSto) ? [0, 0, 0] : array_values($kendalaPerSto)),
            
            'pieLabels' => json_encode(empty($statusValins) ? ['DONE', 'OTB', 'DISCONNECTED'] : array_keys($statusValins)),
            'pieData' => json_encode(empty($statusValins) ? [0, 0, 0] : array_values($statusValins)),
        ]);
    }
}