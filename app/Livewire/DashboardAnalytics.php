<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\ValinsService;
use App\Models\MasterGpon;
use App\Models\ValinsCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardAnalytics extends Component
{
    use WithPagination;

    // Filter & Search untuk Tabel Deviasi Bawah
    public $search = '';
    public $filterSto = '';
    public $filterStatus = '';
    public $perPage = 10;
    public $lastSyncTime = null;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->lastSyncTime = now()->format('H:i:s');

        if (request()->filled('filterSto')) {
            $this->filterSto = request('filterSto');
        } elseif (request()->filled('sto')) {
            $this->filterSto = request('sto');
        }

        if (request()->filled('filterStatus')) {
            $this->filterStatus = request('filterStatus');
        } elseif (request()->filled('kategori')) {
            $this->filterStatus = request('kategori');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterSto()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterSto', 'filterStatus']);
        $this->resetPage();
    }

    // Aksi Sinkronisasi Real-Time / Muat Ulang Data
    public function refreshDashboard()
    {
        Cache::forget('dashboard_metrics');
        Cache::forget('dashboard_sto_chart');
        Cache::forget('dashboard_donut_chart');
        Cache::forget('dashboard_gpon_nodes');
        Cache::forget('dashboard_sto_matrix');
        Cache::forget('dashboard_filter_options');
        Cache::forget('dashboard_total_valins_count');

        $this->lastSyncTime = now()->format('H:i:s');
        $this->resetPage();

        $this->dispatch('dashboard-refreshed', [
            'stoChart' => $this->getStoChartData(),
            'donutChart' => $this->getDonutChartData()
        ]);

        session()->flash('dashboard_msg', 'Data Dashboard berhasil dimuat ulang secara real-time!');
    }

    #[On('valinsUpdated')]
    #[On('gponUpdated')]
    public function handleDataUpdated()
    {
        $this->refreshDashboard();
    }

    // 1. Data 5 Kartu KPI Utama & Alert Banner
    public function getKpiMetrics()
    {
        return Cache::remember('dashboard_metrics', 30, function () {
            $totalValins = ValinsService::count();
            $totalSto = ValinsService::whereNotNull('sto')
                ->where('sto', '!=', '-')
                ->where('sto', '!=', '')
                ->distinct('sto')
                ->count();

            $doneCount = ValinsService::whereIn('keterangan', ['DONE', 'DONE OLO'])->count();
            $donePercent = $totalValins > 0 ? round(($doneCount / $totalValins) * 100, 1) : 0;

            // Akumulasi data bermasalah dari kategori deviasi (Menangkap yang belum DONE atau null)
            $deviasiCategories = ['ODP TIDAK SAMA', 'DATEK TIDAK SAMA', 'ODP DAN DATEK TIDAK SAMA', 'Not In Service', 'Kendala ODP'];
            $totalDeviasi = ValinsService::whereIn('kategori', $deviasiCategories)->count();
            $deviasiActive = ValinsService::whereIn('kategori', $deviasiCategories)
                ->where(function ($q) {
                    $q->whereNotIn('keterangan', ['DONE', 'DONE OLO'])
                      ->orWhereNull('keterangan');
                })
                ->count();
            $deviasiPercent = $totalValins > 0 ? round(($deviasiActive / $totalValins) * 100, 1) : 0;

            // Kendala OTB Tercatat
            $otbCount = ValinsService::where(function ($q) {
                $q->where('keterangan', 'like', '%OTB%')
                  ->orWhere('kategori', 'like', '%OTB%');
            })->count();

            // Total Node OLT & Port GPON
            $totalGponNodes = MasterGpon::distinct('node_id')->count('node_id');
            $totalGponPorts = MasterGpon::count();
            $totalGponSlots = MasterGpon::distinct('slot')->count('slot');

            // Deteksi STO dan Kategori Deviasi Tertinggi untuk Alert Banner
            $topStoRow = ValinsService::select('sto', DB::raw('count(*) as total'))
                ->whereNotNull('sto')
                ->where('sto', '!=', '-')
                ->where('sto', '!=', '')
                ->where(function ($q) {
                    $q->whereNotIn('keterangan', ['DONE', 'DONE OLO'])
                      ->orWhereNull('keterangan');
                })
                ->groupBy('sto')
                ->orderByDesc('total')
                ->first();

            $topSto = $topStoRow?->sto ?? 'SKB';
            $topStoCount = $topStoRow?->total ?? 0;

            $topStoCategory = ValinsService::where('sto', $topSto)
                ->where(function ($q) {
                    $q->whereNotIn('keterangan', ['DONE', 'DONE OLO'])
                      ->orWhereNull('keterangan');
                })
                ->select('kategori', DB::raw('count(*) as cat_total'))
                ->groupBy('kategori')
                ->orderByDesc('cat_total')
                ->value('kategori') ?? 'ODP TIDAK SAMA';

            return [
                'totalValins'       => $totalValins,
                'totalSto'          => $totalSto,
                'doneCount'         => $doneCount,
                'donePercent'       => $donePercent,
                'totalDeviasi'      => $totalDeviasi,
                'deviasiActive'     => $deviasiActive,
                'deviasiPercent'    => $deviasiPercent,
                'otbCount'          => $otbCount,
                'totalGponNodes'    => $totalGponNodes,
                'totalGponPorts'    => $totalGponPorts,
                'totalGponSlots'    => $totalGponSlots,
                'topSto'            => $topSto,
                'topStoCount'       => $topStoCount,
                'topStoCategory'    => $topStoCategory,
            ];
        });
    }

    // 2. Data Grafik Bar: Sebaran Kendala Aktif per STO
    public function getStoChartData()
    {
        return Cache::remember('dashboard_sto_chart', 30, function () {
            $stoList = ['SKB', 'CKB', 'CCR', 'PLR', 'CBD', 'SGN', 'CMO', 'BGL', 'JPK', 'KLU', 'NLD'];

            $rawCounts = ValinsService::select('sto', DB::raw('count(*) as total'))
                ->whereNotNull('sto')
                ->where('sto', '!=', '-')
                ->where('sto', '!=', '')
                ->where(function ($q) {
                    $q->whereNotIn('keterangan', ['DONE', 'DONE OLO'])
                      ->orWhereNull('keterangan');
                })
                ->groupBy('sto')
                ->pluck('total', 'sto')
                ->toArray();

            // Gabungkan STO dari database yang mungkin belum ada di list default
            foreach (array_keys($rawCounts) as $dbSto) {
                if (!in_array($dbSto, $stoList)) {
                    $stoList[] = $dbSto;
                }
            }

            // Urutkan berdasarkan jumlah kendala tertinggi
            $sortedData = [];
            foreach ($stoList as $sto) {
                $sortedData[$sto] = $rawCounts[$sto] ?? 0;
            }
            arsort($sortedData);

            $labels = array_keys($sortedData);
            $series = array_values($sortedData);

            // Warna Bar: >= 10 Merah (Kritis), 4-9 Kuning/Oranye (Waspada), <= 3 Hijau/Abu-abu (Aman)
            $colors = [];
            foreach ($series as $count) {
                if ($count >= 10) {
                    $colors[] = '#DC2626'; // Merah Telkom (Kritis)
                } elseif ($count >= 4) {
                    $colors[] = '#F59E0B'; // Kuning/Oranye (Waspada)
                } else {
                    $colors[] = '#10B981'; // Hijau / Aman
                }
            }

            return [
                'labels' => $labels,
                'series' => $series,
                'colors' => $colors,
                'totalActive' => array_sum($series),
            ];
        });
    }

    // 3. Data Grafik Donut: Distribusi Status Rekonsiliasi VALINS (Mutually Exclusive 100% Data)
    public function getDonutChartData()
    {
        return Cache::remember('dashboard_donut_chart', 30, function () {
            $totalValins = ValinsService::count();

            // Filter data yang belum berstatus DONE / DONE OLO (termasuk yang bernilai null)
            $notDoneFilter = function ($q) {
                $q->whereNotIn('keterangan', ['DONE', 'DONE OLO'])
                  ->orWhereNull('keterangan');
            };

            // Kategori Mutually Exclusive (Setiap data terklasifikasi ke tepat 1 kelompok, total tepat = $totalValins)
            $categories = [
                [
                    'key'   => 'done',
                    'label' => 'Status Lurus (DONE)',
                    'color' => '#10B981', // Emerald Hijau
                    'count' => ValinsService::whereIn('keterangan', ['DONE', 'DONE OLO'])->count(),
                ],
                [
                    'key'   => 'not_in_service',
                    'label' => 'Not In Service',
                    'color' => '#8B5CF6', // Purple
                    'count' => ValinsService::where('kategori', 'Not In Service')->where($notDoneFilter)->count(),
                ],
                [
                    'key'   => 'both_diff',
                    'label' => 'ODP & DATEK TIDAK SAMA',
                    'color' => '#F97316', // Orange
                    'count' => ValinsService::where('kategori', 'ODP DAN DATEK TIDAK SAMA')->where($notDoneFilter)->count(),
                ],
                [
                    'key'   => 'odp_diff',
                    'label' => 'ODP TIDAK SAMA',
                    'color' => '#06B6D4', // Cyan
                    'count' => ValinsService::where('kategori', 'ODP TIDAK SAMA')->where($notDoneFilter)->count(),
                ],
                [
                    'key'   => 'datek_diff',
                    'label' => 'DATEK TIDAK SAMA',
                    'color' => '#F59E0B', // Amber
                    'count' => ValinsService::where('kategori', 'DATEK TIDAK SAMA')->where($notDoneFilter)->count(),
                ],
                [
                    'key'   => 'kendala_odp',
                    'label' => 'Kendala ODP / Fisik',
                    'color' => '#EF4444', // Red
                    'count' => ValinsService::where('kategori', 'Kendala ODP')->where($notDoneFilter)->count(),
                ],
            ];

            $labels = [];
            $series = [];
            $colors = [];
            $items  = [];

            foreach ($categories as $cat) {
                $pct = $totalValins > 0 ? round(($cat['count'] / $totalValins) * 100, 1) : 0;
                $items[] = [
                    'label'   => $cat['label'],
                    'count'   => $cat['count'],
                    'percent' => $pct,
                    'color'   => $cat['color'],
                ];

                // Hanya masukkan ke irisan grafik jika nilai > 0 agar rendering chart rapi
                if ($cat['count'] > 0) {
                    $labels[] = $cat['label'];
                    $series[] = $cat['count'];
                    $colors[] = $cat['color'];
                }
            }

            return [
                'labels'     => $labels,
                'series'     => $series,
                'colors'     => $colors,
                'items'      => $items,
                'total'      => $totalValins,
                'doneCount'  => $categories[0]['count'],
                'donePct'    => $totalValins > 0 ? round(($categories[0]['count'] / $totalValins) * 100, 1) : 0,
            ];
        });
    }

    // 4. Data Daftar Node OLT GPON (Seksi Tengah Kiri)
    public function getGponNodeList()
    {
        return Cache::remember('dashboard_gpon_nodes', 30, function () {
            return MasterGpon::select(
                    'node_id',
                    'node_ip',
                    'id_logical_device',
                    'type_gpon',
                    'sto',
                    DB::raw('COUNT(DISTINCT slot) as slot_count'),
                    DB::raw('COUNT(id) as port_count')
                )
                ->whereNotNull('node_id')
                ->where('node_id', '!=', '')
                ->groupBy('node_id', 'node_ip', 'id_logical_device', 'type_gpon', 'sto')
                ->orderByDesc('port_count')
                ->limit(4)
                ->get()
                ->map(function ($row) {
                    return [
                        'node_id'           => $row->node_id,
                        'node_ip'           => $row->node_ip,
                        'id_logical_device' => $row->id_logical_device,
                        'type_gpon'         => $row->type_gpon,
                        'sto'               => $row->sto,
                        'slot_count'        => $row->slot_count,
                        'port_count'        => $row->port_count,
                    ];
                })
                ->toArray();
        });
    }

    // 5. Data Matriks 5 STO Prioritas (Seksi Tengah Kanan)
    public function getStoMatrix()
    {
        return Cache::remember('dashboard_sto_matrix', 30, function () {
            $priorityStos = ['SKB', 'CKB', 'CCR', 'PLR', 'CBD'];
            $matrix = [];

            foreach ($priorityStos as $sto) {
                $valinsDeviasi = ValinsService::where('sto', $sto)
                    ->where(function ($q) {
                        $q->whereNotIn('keterangan', ['DONE', 'DONE OLO'])
                          ->orWhereNull('keterangan');
                    })
                    ->count();

                $gponNodes = MasterGpon::where('sto', $sto)->distinct('node_id')->count('node_id');
                $gponPorts = MasterGpon::where('sto', $sto)->count();

                $statusLevel = 'AMAN';
                $statusTag   = '[STANDBY]';
                $statusClass = 'text-emerald-700 bg-emerald-50 border-emerald-200';

                if ($valinsDeviasi >= 10) {
                    $statusLevel = 'KRITIS';
                    $statusTag   = '[PATROLI AKTIF]';
                    $statusClass = 'text-red-700 bg-red-50 border-red-200';
                } elseif ($valinsDeviasi >= 4) {
                    $statusLevel = 'WASPADA';
                    $statusTag   = '[SIAGA]';
                    $statusClass = 'text-amber-700 bg-amber-50 border-amber-200';
                }

                $matrix[] = [
                    'sto'          => $sto,
                    'name'         => match ($sto) {
                        'SKB' => 'Sukabumi',
                        'CKB' => 'Cikembar',
                        'CCR' => 'Cicurug',
                        'PLR' => 'PL.Ratu',
                        'CBD' => 'Cibadak',
                        default => $sto,
                    },
                    'deviasi'      => $valinsDeviasi,
                    'gpon_nodes'   => $gponNodes,
                    'gpon_ports'   => $gponPorts,
                    'status_level' => $statusLevel,
                    'status_tag'   => $statusTag,
                    'status_class' => $statusClass,
                ];
            }

            return $matrix;
        });
    }

    // 6. Opsi Filter Dropdown (STO & Kategori)
    public function getFilterOptions()
    {
        return Cache::remember('dashboard_filter_options', 60, function () {
            $stos = ValinsService::whereNotNull('sto')
                ->where('sto', '!=', '-')
                ->where('sto', '!=', '')
                ->distinct('sto')
                ->orderBy('sto')
                ->pluck('sto')
                ->toArray();

            $categories = ValinsCategory::orderBy('urutan', 'asc')->pluck('nama_kategori')->toArray();
            if (empty($categories)) {
                $categories = ['DONE', 'ODP TIDAK SAMA', 'DATEK TIDAK SAMA', 'ODP DAN DATEK TIDAK SAMA', 'Not In Service', 'Kendala ODP'];
            }

            return [
                'stos'       => $stos,
                'categories' => $categories,
            ];
        });
    }

    public function render()
    {
        $kpi = $this->getKpiMetrics();
        $stoChart = $this->getStoChartData();
        $donutChart = $this->getDonutChartData();
        $gponNodes = $this->getGponNodeList();
        $stoMatrix = $this->getStoMatrix();
        $filterOptions = $this->getFilterOptions();

        // 7. Query Tabel Deviasi Bawah (Optimasi Select & Dinamis PerPage)
        $isFiltered = !empty(trim($this->search)) || !empty($this->filterSto) || !empty($this->filterStatus);

        $query = ValinsService::query()->select([
            'id',
            'witel',
            'sto',
            'treg',
            'odp_name',
            'panel_o',
            'port_od',
            'valins_id',
            'node_id',
            'node_ip',
            'slot',
            'port',
            'onu_sn',
            'kategori',
            'keterangan',
            'dynamic_data',
            'valins_category_id',
            'pic',
            'updated_at',
        ]);

        if (!empty($this->search)) {
            $term = trim($this->search);
            $query->where(function ($q) use ($term) {
                $q->where('odp_name', 'like', "%{$term}%")
                  ->orWhere('valins_id', 'like', "%{$term}%")
                  ->orWhere('node_id', 'like', "%{$term}%")
                  ->orWhere('node_ip', 'like', "%{$term}%")
                  ->orWhere('sto', 'like', "%{$term}%")
                  ->orWhere('kategori', 'like', "%{$term}%")
                  ->orWhere('keterangan', 'like', "%{$term}%")
                  ->orWhereRaw("CAST(dynamic_data AS CHAR) LIKE ?", ["%{$term}%"]);
            });
        }

        if (!empty($this->filterSto)) {
            $query->where('sto', $this->filterSto);
        }

        if (!empty($this->filterStatus)) {
            $statusTerm = $this->filterStatus;
            $query->where(function ($q) use ($statusTerm) {
                $q->where('kategori', $statusTerm)
                  ->orWhere('keterangan', $statusTerm);
            });
        }

        // Resolusi konfigurasi kolom dinamis sesuai kategori aktif
        $activeCategoryModel = !empty($this->filterStatus)
            ? ValinsCategory::where('nama_kategori', $this->filterStatus)->first()
            : null;

        $isCustomCategory = false;
        $dynamicColumns = [];

        if ($activeCategoryModel && !empty($activeCategoryModel->konfigurasi_kolom)) {
            $config = is_string($activeCategoryModel->konfigurasi_kolom)
                ? json_decode($activeCategoryModel->konfigurasi_kolom, true)
                : $activeCategoryModel->konfigurasi_kolom;

            if (is_array($config) && count($config) > 0) {
                $hasOdpName = false;
                foreach ($config as $col) {
                    $cName = is_array($col) ? ($col['nama'] ?? '') : (is_object($col) ? ($col->nama ?? '') : $col);
                    $norm = strtoupper(preg_replace('/[^A-Z0-9]/', '', (string)$cName));
                    if ($norm === 'ODPNAME') {
                        $hasOdpName = true;
                        break;
                    }
                }

                // Jika kategori tidak memiliki kolom ODP NAME standar (misal: Kendala ODP), aktifkan layout dinamis
                if (!$hasOdpName) {
                    $isCustomCategory = true;
                    $rawCols = [];
                    foreach ($config as $col) {
                        $cName = is_array($col) ? ($col['nama'] ?? '') : (is_object($col) ? ($col->nama ?? '') : $col);
                        $isHidden = is_array($col) ? (!empty($col['hidden'])) : (!empty($col->hidden));
                        if (!$isHidden && !in_array(strtoupper(trim($cName)), ['KETERANGAN', 'TANGGAL', 'PIC'])) {
                            $rawCols[] = $cName;
                        }
                    }

                    if (!empty($rawCols)) {
                        $remainingWidth = 74; // Sisa persentase setelah Kategori Status (16%) dan Aksi (10%)
                        $weights = [];
                        $totalWeight = 0;
                        foreach ($rawCols as $cName) {
                            $norm = strtoupper(preg_replace('/[^A-Z0-9]/', '', (string)$cName));
                            $w = 1.0;
                            if (in_array($norm, ['TREG', 'SLOT', 'PORT'])) $w = 0.8;
                            elseif (in_array($norm, ['STO', 'PORTODP', 'PANELODP'])) $w = 1.0;
                            elseif (in_array($norm, ['WITEL', 'VALINSID', 'UPDATE'])) $w = 1.4;
                            elseif (str_contains($norm, 'QR') || in_array($norm, ['ODPNAME', 'NODEID', 'NODEIP', 'ONUSN'])) $w = 2.4;
                            $weights[] = $w;
                            $totalWeight += $w;
                        }

                        foreach ($rawCols as $idx => $cName) {
                            $pct = round(($weights[$idx] / $totalWeight) * $remainingWidth, 1);
                            $dynamicColumns[] = [
                                'name'  => $cName,
                                'label' => strtoupper($cName),
                                'width' => $pct . '%',
                            ];
                        }
                    }
                }
            }
        }

        // Validasi batasan perPage (5, 10, 15, 20, 25, 50)
        $perPageCount = in_array((int)$this->perPage, [5, 10, 15, 20, 25, 50]) ? (int)$this->perPage : 10;

        // Urutkan yang berstatus deviasi / belum DONE lebih dulu, kemudian ID terbaru
        $valinsDeviations = $query->orderByRaw("CASE WHEN keterangan IN ('DONE', 'DONE OLO') THEN 1 ELSE 0 END")
            ->orderBy('id', 'desc')
            ->paginate($perPageCount);

        $totalAllValins = Cache::remember('dashboard_total_valins_count', 30, function () {
            return ValinsService::count();
        });

        return view('livewire.dashboard-analytics', [
            'kpi'              => $kpi,
            'stoChart'         => $stoChart,
            'donutChart'       => $donutChart,
            'gponNodes'        => $gponNodes,
            'stoMatrix'        => $stoMatrix,
            'filterOptions'    => $filterOptions,
            'valinsDeviations' => $valinsDeviations,
            'isFiltered'       => $isFiltered,
            'totalAllValins'   => $totalAllValins,
            'lastSyncTime'     => $this->lastSyncTime,
            'isCustomCategory' => $isCustomCategory,
            'dynamicColumns'   => $dynamicColumns,
            'activeCategory'   => $activeCategoryModel,
        ]);
    }

    /**
     * Ekstraksi nilai kolom yang akurat & persis, memeriksa atribut model dan dynamic_data
     */
    public function extractValue($item, $namaKolom)
    {
        $upperNama = strtoupper(trim((string)$namaKolom));
        $normK = preg_replace('/[^A-Z0-9]/', '', $upperNama);

        if ($upperNama === 'KETERANGAN') {
            return !empty($item->keterangan) ? trim((string)$item->keterangan) : '-';
        }

        if ($upperNama === 'TANGGAL') {
            if (!empty($item->tanggal)) {
                try {
                    return \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y');
                } catch (\Throwable $th) {
                    return (string)$item->tanggal;
                }
            }
            return '-';
        }

        if ($upperNama === 'PIC') {
            return !empty($item->pic) && trim((string)$item->pic) !== '-' ? trim((string)$item->pic) : '-';
        }

        $propMap = [
            'TREG'          => 'treg',
            'WITEL'         => 'witel',
            'STO'           => 'sto',
            'ODPNAME'       => 'odp_name',
            'PANELODP'      => ['panel_o', 'panel_odp'],
            'PORTODP'       => ['port_od', 'port_odp'],
            'VALINSID'      => 'valins_id',
            'NODEID'        => 'node_id',
            'NODEIP'        => 'node_ip',
            'SLOT'          => 'slot',
            'PORT'          => 'port',
            'ONUSN'         => 'onu_sn',
            'NOINETVALINS'  => 'no_inet_valins',
            'SIP1VALINS'    => 'sip1_valins',
            'SIP2VALINS'    => 'sip2_valins',
            'SID'           => 'sid',
        ];

        $nilai = '-';
        if (isset($propMap[$normK])) {
            $fields = is_array($propMap[$normK]) ? $propMap[$normK] : [$propMap[$normK]];
            foreach ($fields as $f) {
                if (isset($item->{$f}) && $item->{$f} !== null && trim((string)$item->{$f}) !== '' && trim((string)$item->{$f}) !== '-') {
                    $nilai = trim((string)$item->{$f});
                    break;
                }
            }
        } else {
            $customField = strtolower(str_replace(' ', '_', $namaKolom));
            if (isset($item->{$customField}) && $item->{$customField} !== null && trim((string)$item->{$customField}) !== '' && trim((string)$item->{$customField}) !== '-') {
                $nilai = trim((string)$item->{$customField});
            }
        }

        if ($nilai === '-' || $nilai === '') {
            if ($normK === 'TREG') {
                $nilai = $item->treg ?? '3';
            } elseif ($normK === 'WITEL') {
                $nilai = $item->witel ?? 'SUKABUMI';
            }
        }

        if ($nilai === '-' || $nilai === '') {
            $dyn = is_array($item->dynamic_data)
                ? $item->dynamic_data
                : (is_string($item->dynamic_data) ? json_decode($item->dynamic_data, true) : []);

            if (is_array($dyn)) {
                if (isset($dyn[$namaKolom]) && $dyn[$namaKolom] !== null && trim((string)$dyn[$namaKolom]) !== '' && trim((string)$dyn[$namaKolom]) !== '-') {
                    $nilai = trim((string)$dyn[$namaKolom]);
                } else {
                    foreach ($dyn as $k => $v) {
                        if ($v !== null && trim((string)$v) !== '' && trim((string)$v) !== '-' && strtoupper(preg_replace('/[^A-Z0-9]/', '', (string)$k)) === $normK) {
                            $nilai = trim((string)$v);
                            break;
                        }
                    }
                }
            }
        }

        return ($nilai !== '' && $nilai !== null) ? $nilai : '-';
    }

    /**
     * Mengambil identifier dinamis utama untuk baris non-standar saat tampilan Semua Kategori
     */
    public function getPrimaryDynamicIdentifier($item)
    {
        $dyn = is_array($item->dynamic_data)
            ? $item->dynamic_data
            : (is_string($item->dynamic_data) ? json_decode($item->dynamic_data, true) : []);

        if (is_array($dyn)) {
            // Prioritas 1: QR Code
            foreach ($dyn as $k => $v) {
                $norm = strtoupper(preg_replace('/[^A-Z0-9]/', '', (string)$k));
                if (str_contains($norm, 'QR') && !empty($v) && $v !== '-') {
                    return ['label' => $k, 'value' => $v];
                }
            }

            // Prioritas 2: Field non-wilayah lainnya
            foreach ($dyn as $k => $v) {
                $norm = strtoupper(preg_replace('/[^A-Z0-9]/', '', (string)$k));
                if (!in_array($norm, ['TREG', 'WITEL', 'STO', 'PIC', 'TANGGAL', 'KETERANGAN', 'STATUS']) && !empty($v) && $v !== '-') {
                    return ['label' => $k, 'value' => $v];
                }
            }
        }

        return [
            'label' => 'VALINS ID',
            'value' => (!empty($item->valins_id) && $item->valins_id !== '-' ? $item->valins_id : '-')
        ];
    }
}