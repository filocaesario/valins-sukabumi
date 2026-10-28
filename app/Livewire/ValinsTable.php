<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ValinsService;
use App\Models\ValinsCategory;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\DB;

class ValinsTable extends Component
{
    use WithPagination, WithFileUploads; // TAMBAHAN: WithFileUploads

    #[Url(as: 'kategori', history: true)]
    public $kategori = '';

    #[Url(as: 'search', history: true)]
    public $search = '';

    public $selectedRows = [];

   protected function getLockKey()
    {
        $userName = auth()->check() ? auth()->user()->name : 'System';
        return $userName . '|' . session()->getId();
    }
    // Fungsi bawaan Livewire: Berjalan otomatis setiap kali kotak dicentang/dihapus
    // =========================================================================
    // 2. LOGIKA CENTANG DATA (ANTI-OVERWRITE AKUN LAIN)
    // =========================================================================
  public function updatedSelectedRows()
    {
        $currentUser = auth()->check() ? auth()->user()->name : 'System';

        // 1. Jika keranjang kosong, lepas gembok sesi akun ini TANPA mengubah updated_at
        if (empty($this->selectedRows)) {
            \Illuminate\Support\Facades\DB::table('valins_services')
                ->where('locked_by', $currentUser)
                ->update([
                    'locked_by' => null,
                    'locked_at' => null
                ]);
            return;
        }

        // 2. Lepas gembok pada data yang baru saja di-uncheck TANPA mengubah updated_at
        \Illuminate\Support\Facades\DB::table('valins_services')
            ->where('locked_by', $currentUser)
            ->whereNotIn('id', $this->selectedRows)
            ->update([
                'locked_by' => null,
                'locked_at' => null
            ]);

        // 3. Pasang gembok HANYA pada data yang bebas/milik sendiri TANPA mengubah updated_at
        \Illuminate\Support\Facades\DB::table('valins_services')
            ->whereIn('id', $this->selectedRows)
            ->where(function($q) use ($currentUser) {
                $q->whereNull('locked_by')
                  ->orWhere('locked_by', $currentUser);
            })
            ->update([
                'locked_by' => $currentUser,
                'locked_at' => now()
            ]);

        // 4. Pastikan array seleksi di UI hanya menyimpan ID yang sah dikunci
        $this->selectedRows = ValinsService::whereIn('id', $this->selectedRows)
            ->where('locked_by', $currentUser)
            ->pluck('id')
            ->map(fn($id) => (string) $id)
            ->toArray();
    }
    // Modal Bulk Edit
    public $bulkEditOpen = false;
    public $bulkEditKeterangan = '';
    public $bulkEditPic = '';
    public $bulkEditTanggal = '';
    public $bulkEditUpdateProgress = '';

    // TAMBAHAN: Properti Modal Import
    public $importModalOpen = false;
    public $importFile;

    // Tambahkan fungsi ini agar ValinsTable mengenali template kolom standar
    public function getTemplateKolomStandar()
    {
        return [
            ['nama' => 'TREG', 'tipe' => 'text', 'hidden' => false],
            ['nama' => 'WITEL', 'tipe' => 'text', 'hidden' => false],
            ['nama' => 'STO', 'tipe' => 'text', 'hidden' => false],
            ['nama' => 'ODP NAME', 'tipe' => 'text', 'hidden' => false],
            ['nama' => 'PANEL ODP', 'tipe' => 'text', 'hidden' => false],
            ['nama' => 'PORT ODP', 'tipe' => 'number', 'hidden' => false],
            ['nama' => 'VALINS ID', 'tipe' => 'number', 'hidden' => false],
            ['nama' => 'NODE ID', 'tipe' => 'text', 'hidden' => false],
            ['nama' => 'NODE IP', 'tipe' => 'text', 'hidden' => false],
            ['nama' => 'SLOT', 'tipe' => 'number', 'hidden' => false],
            ['nama' => 'PORT', 'tipe' => 'number', 'hidden' => false],
            ['nama' => 'ONU SN', 'tipe' => 'text', 'hidden' => false],
            ['nama' => 'NO INET VALINS', 'tipe' => 'number', 'hidden' => false],
            ['nama' => 'SIP 1 VALINS', 'tipe' => 'number', 'hidden' => false],
            ['nama' => 'SIP 2 VALINS', 'tipe' => 'number', 'hidden' => false],
            ['nama' => 'SID', 'tipe' => 'text', 'hidden' => false],
        ];
    }

    public function mount()
    {
        if (request()->filled('kategori')) {
            $this->kategori = request('kategori');
        } elseif (empty($this->kategori)) {
            $firstCat = ValinsCategory::orderBy('urutan', 'asc')->orderBy('id', 'asc')->first();
            $this->kategori = $firstCat ? $firstCat->nama_kategori : '';
        }

        if (request()->filled('search')) {
            $this->search = request('search');
        }
    }

    public function updatedSearch()
    {
        $this->clearSelection();
        $this->resetPage();
        $this->dispatch('clear-checkboxes');
    }

    public function setKategori($kat)
    {
        $this->clearSelection();
        $this->kategori = $kat;
        $this->search = ''; 
        $this->resetPage();
        $this->dispatch('clear-checkboxes');
    }

    public function updatingPage()
    {
        $this->clearSelection();
        $this->dispatch('clear-checkboxes');
    }

    #[On('refreshKategori')]
    public function segarkanKategori()
    {
        $categories = ValinsCategory::orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        if (!empty($this->kategori)) {
            $masihAda = $categories->where('nama_kategori', $this->kategori)->isNotEmpty();
            if (!$masihAda) {
                $this->kategori = $categories->isNotEmpty() ? $categories->first()->nama_kategori : '';
            }
        } elseif ($categories->isNotEmpty()) {
            $this->kategori = $categories->first()->nama_kategori;
        }
    }

// =========================================================================
    // 3. BATALKAN SELEKSI (HANYA MELEPAS MILIK SENDIRI)
    // =========================================================================
  public function clearSelection()
    {
        $currentUser = auth()->check() ? auth()->user()->name : 'System';

        // Gunakan DB::table agar updated_at tidak tergeser saat dibatalkan
        \Illuminate\Support\Facades\DB::table('valins_services')
            ->where('locked_by', $currentUser)
            ->update([
                'locked_by' => null,
                'locked_at' => null
            ]);

        $this->selectedRows = [];
        $this->dispatch('clear-checkboxes');
    }

   // =========================================================================
    // 4. PILIH SEMUA DATA (KEBAL PEMBAJAKAN DATA AKUN LAIN)
    // =========================================================================
    public function selectAllMatching()
    {
        $currentUser = auth()->check() ? auth()->user()->name : 'System';
        $query = ValinsService::query();

        if (!empty($this->kategori)) {
            $query->where('kategori', $this->kategori);
        }

        if (!empty($this->search)) {
            $searchTerm = trim($this->search);
            $query->where(function($q) use ($searchTerm) {
                $q->where('onu_sn', 'like', "%{$searchTerm}%")
                  ->orWhere('no_inet_valins', 'like', "%{$searchTerm}%")
                  ->orWhere('odp_name', 'like', "%{$searchTerm}%")
                  ->orWhere('valins_id', 'like', "%{$searchTerm}%")
                  ->orWhere('node_id', 'like', "%{$searchTerm}%")
                  ->orWhere('node_ip', 'like', "%{$searchTerm}%")
                  ->orWhere('sto', 'like', "%{$searchTerm}%")
                  ->orWhere('pic', 'like', "%{$searchTerm}%")
                  ->orWhere('keterangan', 'like', "%{$searchTerm}%")
                  ->orWhere('sid', 'like', "%{$searchTerm}%")
                  ->orWhere('treg', 'like', "%{$searchTerm}%")
                  ->orWhere('witel', 'like', "%{$searchTerm}%")
                  ->orWhereRaw("CAST(dynamic_data AS CHAR) LIKE ?", ["%{$searchTerm}%"]);
            });
        }

        // Lewati data yang sedang dikunci akun lain
        $query->where(function($q) use ($currentUser) {
            $q->whereNull('locked_by')
              ->orWhere('locked_by', $currentUser);
        });

        $this->selectedRows = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();
        $this->updatedSelectedRows();
    }

   public function hapusData($id)
    {
        $item = ValinsService::find($id);
        if (!$item) {
            session()->flash('error', 'Data tidak ditemukan atau sudah dihapus.');
            $this->dispatch('clear-checkboxes');
            return;
        }

        $user = auth()->user();
        $userName = $user ? $user->name : 'System';
        $isAdmin = $user && in_array(strtolower($user->role ?? ''), ['admin', 'superadmin', 'management']);
        $lockedByName = explode('|', $item->locked_by ?? '')[0];
        $expireTime = now()->subMinutes(15);

        // Tolak jika dikunci orang lain DAN belum kedaluwarsa (kecuali admin/management)
        if (!$isAdmin && !empty($item->locked_by) && $lockedByName !== $userName && $item->locked_at >= $expireTime) {
            session()->flash('error', "Gagal! Data ini sedang diproses oleh {$lockedByName}.");
            $this->dispatch('clear-checkboxes');
            return;
        }

        $item->delete();

        // Bersihkan dari array seleksi jika ada
        $this->selectedRows = array_values(array_filter($this->selectedRows, fn($rowId) => (string)$rowId !== (string)$id));

        // Periksa jika halaman saat ini melebihi total halaman setelah data dihapus
        $remainingCount = ValinsService::when(!empty($this->kategori), fn($q) => $q->where('kategori', $this->kategori))->count();
        if ($remainingCount == 0 || $this->getPage() > ceil($remainingCount / 15)) {
            $this->resetPage();
        }

        $this->dispatch('clear-checkboxes');
        $this->dispatch('valinsUpdated');

        // Bersihkan SEMUA cache statistik agar metrik kartu dan kategori langsung ter-refresh 100%
        \Illuminate\Support\Facades\Cache::forget('valins_stats_counts');
        \Illuminate\Support\Facades\Cache::forget('valins_category_row_counts');
        \Illuminate\Support\Facades\Cache::forget('dashboard_metrics');
        \Illuminate\Support\Facades\Cache::forget('dashboard_sto_chart');
        \Illuminate\Support\Facades\Cache::forget('dashboard_donut_chart');
        \Illuminate\Support\Facades\Cache::forget('dashboard_sto_matrix');

        session()->flash('success', 'Data berhasil dihapus permanen!');
    }

    public function bulkDelete($ids = [])
    {
        // Prioritaskan ID yang dikirim langsung dari parameter client, fallback ke $this->selectedRows
        $idsToDelete = !empty($ids) ? array_map('strval', (array)$ids) : array_map('strval', $this->selectedRows);

        if (!empty($idsToDelete)) {
            $user = auth()->user();
            $userName = $user ? $user->name : 'System';
            $isAdmin = $user && in_array(strtolower($user->role ?? ''), ['admin', 'superadmin', 'management']);
            $expireTime = now()->subMinutes(15);

            $query = ValinsService::whereIn('id', $idsToDelete);

            // Jika bukan admin/superadmin, pastikan hanya menghapus data yang tidak dikunci orang lain yang masih aktif
            if (!$isAdmin) {
                $query->where(function($q) use ($userName, $expireTime) {
                    $q->whereNull('locked_by')
                      ->orWhere('locked_by', $userName)
                      ->orWhere('locked_by', 'like', $userName . '|%')
                      ->orWhere('locked_at', '<', $expireTime);
                });
            }

            $deletedCount = $query->delete();

            // Lepaskan gembok apapun yang mungkin tersisa dari data yang diproses
            \Illuminate\Support\Facades\DB::table('valins_services')
                ->where('locked_by', $userName)
                ->whereIn('id', $idsToDelete)
                ->update([
                    'locked_by' => null,
                    'locked_at' => null
                ]);

            $this->selectedRows = [];

            // Periksa jika halaman saat ini melebihi total halaman setelah data dihapus
            $remainingCount = ValinsService::when(!empty($this->kategori), fn($q) => $q->where('kategori', $this->kategori))->count();
            if ($remainingCount == 0 || $this->getPage() > ceil($remainingCount / 15)) {
                $this->resetPage();
            }

            $this->dispatch('clear-checkboxes');
            $this->dispatch('valinsUpdated');

            // Bersihkan SEMUA cache statistik agar metrik kartu dan kategori langsung ter-refresh 100%
            \Illuminate\Support\Facades\Cache::forget('valins_stats_counts');
            \Illuminate\Support\Facades\Cache::forget('valins_category_row_counts');
            \Illuminate\Support\Facades\Cache::forget('dashboard_metrics');
            \Illuminate\Support\Facades\Cache::forget('dashboard_sto_chart');
            \Illuminate\Support\Facades\Cache::forget('dashboard_donut_chart');
            \Illuminate\Support\Facades\Cache::forget('dashboard_sto_matrix');

            session()->flash('success', "{$deletedCount} data berhasil dihapus permanen!");
        }
    }

    public function bulkChangeStatus($status)
    {
        if (count($this->selectedRows) > 0) {
            $dataUpdate = ['keterangan' => $status];
            if ($status === 'DONE' || $status === 'DONE OLO') {
                $dataUpdate['tanggal'] = now();
            }
            ValinsService::whereIn('id', $this->selectedRows)->update($dataUpdate);
            $this->selectedRows = [];
            $this->dispatch('clear-checkboxes');
            $this->dispatch('valinsUpdated');
            $this->clearSelection();

            \Illuminate\Support\Facades\Cache::forget('valins_stats_counts');
            \Illuminate\Support\Facades\Cache::forget('valins_category_row_counts');
            \Illuminate\Support\Facades\Cache::forget('dashboard_metrics');
            \Illuminate\Support\Facades\Cache::forget('dashboard_sto_chart');
            \Illuminate\Support\Facades\Cache::forget('dashboard_donut_chart');
            \Illuminate\Support\Facades\Cache::forget('dashboard_sto_matrix');

            session()->flash('success', "Status berhasil diubah menjadi {$status}!");
        }
    }

    public function openBulkEdit()
    {
        if (empty($this->selectedRows)) {
            return;
        }

        // Jika hanya 1 data yang dipilih: Muat data asli dari database ke dalam form
        if (count($this->selectedRows) === 1) {
            $firstId = reset($this->selectedRows);
            $item = ValinsService::find($firstId);

            if ($item) {
                $this->bulkEditKeterangan = $item->keterangan ?? '';
                $this->bulkEditPic = $item->pic ?? '';
                $this->bulkEditTanggal = $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') : '';
                $this->bulkEditUpdateProgress = $item->update_progress ?? '';
            }
        } 
        // Jika lebih dari 1 data: Muat data jika seluruh baris yang dipilih memiliki nilai yang sama persis
        else {
            $items = ValinsService::whereIn('id', $this->selectedRows)->get();
            $uniqueKeterangan = $items->pluck('keterangan')->unique();
            $uniquePic = $items->pluck('pic')->unique();
            $uniqueTanggal = $items->pluck('tanggal')->unique();

            $this->bulkEditKeterangan = $uniqueKeterangan->count() === 1 ? ($uniqueKeterangan->first() ?? '') : '';
            $this->bulkEditPic = $uniquePic->count() === 1 ? ($uniquePic->first() ?? '') : '';
            $this->bulkEditTanggal = ($uniqueTanggal->count() === 1 && $uniqueTanggal->first()) 
                ? \Carbon\Carbon::parse($uniqueTanggal->first())->format('Y-m-d') 
                : '';
            $this->bulkEditUpdateProgress = '';
        }

        $this->bulkEditOpen = true;
    }

    public function closeBulkEdit()
    {
        $this->bulkEditOpen = false;
        $this->reset(['bulkEditKeterangan', 'bulkEditPic', 'bulkEditTanggal', 'bulkEditUpdateProgress']);
    }

    public function saveBulkEdit()
    {
        if (count($this->selectedRows) > 0) {
            $currentUser = auth()->check() ? auth()->user()->name : 'System';
            $dataToUpdate = [];

            if (!empty($this->bulkEditKeterangan)) $dataToUpdate['keterangan'] = $this->bulkEditKeterangan;
            if (!empty($this->bulkEditPic)) $dataToUpdate['pic'] = $this->bulkEditPic;
            if (!empty($this->bulkEditTanggal)) $dataToUpdate['tanggal'] = $this->bulkEditTanggal;
            if (!empty($this->bulkEditUpdateProgress)) $dataToUpdate['update_progress'] = $this->bulkEditUpdateProgress;

            // KUNCI PERBAIKAN: Selalu lepaskan gembok setelah proses edit selesai
            $dataToUpdate['locked_by'] = null;
            $dataToUpdate['locked_at'] = null;

            if (\Illuminate\Support\Facades\Schema::hasColumn('valins_services', 'updated_by')) {
                $dataToUpdate['updated_by'] = $currentUser;
            }
            $dataToUpdate['updated_at'] = now();

            ValinsService::whereIn('id', $this->selectedRows)->update($dataToUpdate);

            session()->flash('success', count($this->selectedRows) . ' data berhasil diperbarui!');
            
            $this->selectedRows = [];
            $this->dispatch('clear-checkboxes');
            $this->dispatch('valinsUpdated');
        }

        $this->closeBulkEdit();
    }

    // ==========================================
    // TAMBAHAN: FUNGSI IMPORT DATA (DINAMIS)
    // ==========================================
    public function openImportModal()
    {
        $this->cleanupImportFile();
        $this->importModalOpen = true;
    }

    public function closeImportModal()
    {
        $this->importModalOpen = false;
        $this->cleanupImportFile();
    }

    protected function cleanupImportFile()
    {
        if ($this->importFile) {
            try {
                $path = $this->importFile->getRealPath();
                if ($path && file_exists($path)) {
                    @unlink($path);
                }
            } catch (\Throwable $e) {}
        }
        $this->reset('importFile');
        $this->resetErrorBag('importFile');
    }

    // =========================================================================
    // FITUR IMPORT EXCEL / CSV: TERKUNCI MUTLAK PADA KATEGORI AKTIF
    // =========================================================================
    public function importData()
    {
        $this->validate([
            'importFile' => 'required|file|max:30720',
        ], [
            'importFile.required' => 'Silakan pilih file Excel (.xlsx, .xls) atau CSV terlebih dahulu.',
        ]);

        $filePath = $this->importFile->getRealPath();
        $ext = strtolower($this->importFile->getClientOriginalExtension());
        $importedCount = 0;

        // 1. PENGUNCIAN MUTLAK KATEGORI TARGET:
        // Gunakan hanya kategori yang sedang aktif dibuka pengguna saat ini
        $activeKategoriName = trim((string)$this->kategori);
        $targetCategory = null;

        if (!empty($activeKategoriName)) {
            $targetCategory = ValinsCategory::where('nama_kategori', $activeKategoriName)->first();
        }

        if (!$targetCategory) {
            $targetCategory = ValinsCategory::orderBy('urutan', 'asc')->orderBy('id', 'asc')->first();
        }

        if (!$targetCategory) {
            session()->flash('error', 'Tidak ada kategori aktif yang tersedia untuk tujuan impor.');
            $this->closeImportModal();
            return;
        }

        $targetCatName = $targetCategory->nama_kategori;
        $targetCatId = $targetCategory->id;

        // Helper parser & normalisasi
        $parseConn = function($str) {
            $res = [];
            if (empty($str)) return $res;
            foreach (preg_split('/[|,;]/', $str) as $seg) {
                if (strpos($seg, '=') !== false) {
                    list($k, $v) = explode('=', $seg, 2);
                    $res[strtoupper(trim($k))] = trim($v);
                }
            }
            return $res;
        };

        $normalizeStr = function($str) {
            $s = strtoupper(str_replace(['&', '_', '-', ' '], ['DAN', '', '', ''], (string)$str));
            return preg_replace('/[^A-Z0-9]/', '', $s);
        };

        $normalizeCol = function($str) {
            return preg_replace('/[^A-Z0-9]/', '', strtoupper((string)$str));
        };

        $limitStr = function($str, $maxLen) {
            if ($str === null || $str === '') return null;
            $str = (string) $str;
            if (strpos($str, '=') === 0 && strlen($str) > 10) return '-';
            return mb_strlen($str) > $maxLen ? mb_substr($str, 0, $maxLen) : $str;
        };

        // Helper pemroses tanggal berkas Excel / CSV
        // Helper pemroses tanggal berkas Excel / CSV (Aman dari 1970 dan akurat mengonversi serial Excel)
        $parseFileDate = function($raw) {
            if ($raw === null || $raw === '' || $raw === '-' || $raw === '0' || $raw === 0) return null;
            if (is_numeric($raw)) {
                $num = (float)$raw;
                // Angka serial Excel standar (20000 s/d 80000 = rentang tahun 1954 - 2119)
                if ($num >= 20000 && $num < 80000) {
                    $days = floor($num);
                    return gmdate('Y-m-d', (int)(($days - 25569) * 86400));
                }
                return null;
            }
            $rawStr = trim((string)$raw);
            if (empty($rawStr) || $rawStr === '-' || $rawStr === '0000-00-00' || $rawStr === '1970-01-01' || $rawStr === '01-01-1970' || $rawStr === '1970-01-01 00:00:00') return null;
            try {
                $carbon = \Carbon\Carbon::parse($rawStr);
                if ($carbon->year > 1971) {
                    return $carbon->format('Y-m-d');
                }
            } catch (\Throwable $e) {}
            return null;
        };

        // State carry-forward untuk menangani penggabungan sel (merged cells) wilayah
        $lastTreg = null;
        $lastWitel = null;
        $lastSto = null;

        // Pemroses baris data: Seluruh baris dikunci khusus ke kategori aktif
        $processRow = function($headersNorm, $headersOrig, $row) use (
            $parseConn, $targetCatName, $targetCatId, $limitStr, $parseFileDate, &$importedCount,
            &$lastTreg, &$lastWitel, &$lastSto
        ) {
            $assocNorm = [];
            $assocOrig = [];
            foreach ($row as $i => $val) {
                $hN = !empty($headersNorm[$i]) ? $headersNorm[$i] : "COL_{$i}";
                $hO = !empty($headersOrig[$i]) ? $headersOrig[$i] : (string)($hN ?: "COL_{$i}");
                
                $v = is_string($val) ? trim($val) : $val;
                if (is_string($v) && strpos($v, '=') === 0 && strlen($v) > 10) $v = '-';
                
                $assocNorm[$hN] = $v;
                $assocOrig[$hO] = $v;
            }

            if (count(array_filter($assocNorm, fn($x) => $x !== null && $x !== '')) === 0) return;

            $connRaw = $assocNorm['UIMCONNECTIVITY'] ?? ($assocNorm['VALINSCONNECTIVITY'] ?? ($assocNorm['NMSCONNECTIVITY'] ?? ''));
            $conn = $parseConn($connRaw);

            $odpName = $assocNorm['ODPNAME'] ?? ($assocNorm['ODPLOCATION'] ?? ($assocNorm['ODP'] ?? null));

            // STO: Dukung carry-forward merged cells jika sel kosong
            $rawSto = $assocNorm['STO'] ?? null;
            if (empty($rawSto) && !empty($odpName) && preg_match('/ODP-([A-Z0-9]+)-/i', $odpName, $mSto)) {
                $rawSto = strtoupper($mSto[1]);
            }
            if (!empty($rawSto) && trim((string)$rawSto) !== '-') {
                $lastSto = strtoupper(trim((string)$rawSto));
            } elseif (!empty($lastSto)) {
                $rawSto = $lastSto;
            }
            $sto = $rawSto ?: '-';

            $nodeId = $assocNorm['NODEID'] ?? null;
            $nodeIp = $assocNorm['NODEIP'] ?? null;
            if (!empty($conn['ODP_OLT'])) {
                if (empty($nodeIp) && preg_match('/\((\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\)/', $conn['ODP_OLT'], $mIp)) {
                    $nodeIp = $mIp[1];
                }
                if (empty($nodeId) && preg_match('/^([^(]+)/', $conn['ODP_OLT'], $mN)) {
                    $nodeId = trim($mN[1]);
                }
            }

            $slot = $assocNorm['SLOT'] ?? null;
            $port = $assocNorm['PORT'] ?? null;
            if ((empty($slot) || empty($port)) && !empty($conn['ODP_OLT_PORT'])) {
                $parts = explode('/', $conn['ODP_OLT_PORT']);
                if (count($parts) >= 4) { $slot = $parts[2]; $port = $parts[3]; }
                elseif (count($parts) === 2) { $slot = $parts[0]; $port = $parts[1]; }
            }

            // Keterangan: Murni membaca kolom Keterangan berkas. Dilarang fallback ke Status, dilarang default "VALID"!
            $rawKet = $assocNorm['KETERANGAN'] ?? ($assocNorm['KETERANGANSTATUS'] ?? null);
            $keterangan = (!empty($rawKet) && trim((string)$rawKet) !== '-' && trim((string)$rawKet) !== '')
                ? $limitStr(rtrim(trim((string)$rawKet), '^'), 150)
                : null;

            // Tanggal: Konversi angka serial Excel atau format teks tanggal, null jika kosong tanpa menjadi 1970
            $rawTgl = $assocNorm['TANGGAL'] ?? ($assocNorm['DATE'] ?? null);
            $tgl = $parseFileDate($rawTgl);

            // PIC: Murni membaca kolom PIC berkas. Dilarang keras fallback ke nama pengguna yang sedang login!
            $rawPic = $assocNorm['PIC'] ?? ($assocNorm['PETUGAS'] ?? ($assocNorm['USER'] ?? null));
            $pic = (!empty($rawPic) && trim((string)$rawPic) !== '-' && trim((string)$rawPic) !== '')
                ? $limitStr(trim((string)$rawPic), 100)
                : null;

            // Resolusi TREG: Deteksi cerdas kolom TREG / Regional / Area Regional
            $rawTreg = $assocNorm['TREG'] ?? ($assocNorm['REGIONAL'] ?? ($assocNorm['AREAREGIONAL'] ?? ($assocNorm['TELKOMREGIONAL'] ?? ($assocNorm['AREANUM'] ?? ($assocNorm['NOMORAREA'] ?? null)))));

            // Periksa jika sel index 0 berisi TREG (kasus berkas tanpa judul di kolom pertama)
            if ($rawTreg === null || $rawTreg === '' || $rawTreg === '-') {
                $firstVal = reset($row);
                if (!empty($firstVal) && $firstVal !== '-') {
                    $firstStr = trim((string)$firstVal);
                    if (preg_match('/^(TREG\s*\d+|\d+)$/i', $firstStr)) {
                        $rawTreg = $firstStr;
                    }
                }
            }

            // Carry-forward merged cells untuk TREG
            if ($rawTreg !== null && trim((string)$rawTreg) !== '' && trim((string)$rawTreg) !== '-') {
                $lastTreg = trim((string)$rawTreg);
            } elseif (!empty($lastTreg)) {
                $rawTreg = $lastTreg;
            }

            // Format baku TREG: Simpan angka saja tanpa teks "TREG"
            $resolvedTreg = null;
            if (!empty($rawTreg) && trim((string)$rawTreg) !== '-') {
                $tregTrim = trim((string)$rawTreg);
                if (preg_match('/(\d+)/', $tregTrim, $mTr)) {
                    $resolvedTreg = $mTr[1];
                } else {
                    $resolvedTreg = $tregTrim;
                }
            }

            // WITEL: Dukung carry-forward merged cells (terisolasi dari kolom regional)
            $rawWitel = $assocNorm['WITEL'] ?? ($assocNorm['DISTRICT'] ?? ($assocNorm['AREA'] ?? null));
            if (!empty($rawWitel) && trim((string)$rawWitel) !== '-') {
                $lastWitel = trim((string)$rawWitel);
            } elseif (!empty($lastWitel)) {
                $rawWitel = $lastWitel;
            }
            $resolvedWitel = $rawWitel ?: 'SUKABUMI';

            $portOdpRaw = $assocNorm['PORTODP'] ?? ($assocNorm['PORTOD'] ?? ($conn['ODP_PORT'] ?? null));
            $cleanedPortOdp = null;
            if ($portOdpRaw !== null && trim((string)$portOdpRaw) !== '' && trim((string)$portOdpRaw) !== '-') {
                $portTrim = trim((string)$portOdpRaw);
                $cleanedPortOdp = preg_match('/(\d+)/', $portTrim, $mPort) ? $mPort[1] : $portTrim;
            }

            $dbData = [
                'kategori' => $limitStr($targetCatName, 100),
                'valins_category_id' => $targetCatId,
                'treg' => $resolvedTreg,
                'witel' => $limitStr($resolvedWitel, 100),
                'sto' => $limitStr($sto, 50),
                'odp_name' => $limitStr($odpName ?: ($sto ? "ODP-{$sto}" : $targetCatName), 150),
                'panel_o' => $limitStr($assocNorm['PANELODP'] ?? ($assocNorm['PANELO'] ?? ($conn['ODP_PANEL'] ?? null)), 50),
                'port_od' => $limitStr($cleanedPortOdp, 50),
                'valins_id' => $limitStr($assocNorm['VALINSID'] ?? ($conn['ODP_ID'] ?? ($conn['VALINS_ID'] ?? null)), 50),
                'node_id' => $limitStr($nodeId ?: null, 100),
                'node_ip' => $limitStr($nodeIp ?: null, 50),
                'slot' => $limitStr($slot ?: null, 20),
                'port' => $limitStr($port ?: null, 20),
                'onu_sn' => $limitStr($assocNorm['ONUSN'] ?? ($assocNorm['SN'] ?? ($conn['ONU_SN'] ?? null)), 100),
                'no_inet_valins' => $limitStr($assocNorm['NOINETVALINS'] ?? ($assocNorm['NOINET'] ?? ($conn['NO_INET'] ?? null)), 50),
                'sip1_valins' => $limitStr($assocNorm['SIP1VALINS'] ?? ($assocNorm['SIP1'] ?? null), 50),
                'sip2_valins' => $limitStr($assocNorm['SIP2VALINS'] ?? ($assocNorm['SIP2'] ?? null), 50),
                'sid' => $limitStr($assocNorm['SID'] ?? ($conn['SID'] ?? null), 50),
                'keterangan' => $keterangan,
                'tanggal' => $tgl,
                'pic' => $pic,
                'update_progress' => $limitStr($assocNorm['UPDATEPROGRESS'] ?? ($assocNorm['NOTES'] ?? ($assocNorm['CATATAN'] ?? null)), 1000),
            ];

            // dynamic_data menyimpan data berkas 100% akurat 1:1 sesuai kolom aslinya
            // serta merapikan format tanggal numerik serial di dalamnya jika ada
            $dyn = [];
            $tregStoredInDyn = false;
            foreach ($assocOrig as $kOrig => $vOrig) {
                $normK = preg_replace('/[^A-Z0-9]/', '', strtoupper((string)$kOrig));
                if (in_array($normK, ['TANGGAL', 'DATE', 'DBLASTUPDATEDATE', 'TANGGALUPDATEDATABASE'])) {
                    $formattedDate = $parseFileDate($vOrig);
                    $dyn[$kOrig] = $formattedDate ? \Carbon\Carbon::parse($formattedDate)->format('d-m-Y') : null;
                } elseif ($normK === 'KETERANGAN') {
                    $dyn[$kOrig] = (!empty($vOrig) && trim((string)$vOrig) !== '-' && trim((string)$vOrig) !== '')
                        ? rtrim(trim((string)$vOrig), '^')
                        : null;
                } elseif (in_array($normK, ['PIC', 'PETUGAS'])) {
                    $dyn[$kOrig] = (!empty($vOrig) && trim((string)$vOrig) !== '-' && trim((string)$vOrig) !== '')
                        ? trim((string)$vOrig)
                        : null;
                } elseif (in_array($normK, ['TREG', 'REGIONAL', 'AREAREGIONAL', 'TELKOMREGIONAL'])) {
                    $dyn[$kOrig] = $resolvedTreg;
                    $tregStoredInDyn = true;
                } elseif (in_array($normK, ['PORTODP', 'PORTOD'])) {
                    if ($vOrig !== null && trim((string)$vOrig) !== '' && trim((string)$vOrig) !== '-') {
                        $pTrim = trim((string)$vOrig);
                        $dyn[$kOrig] = preg_match('/(\d+)/', $pTrim, $mP) ? $mP[1] : $pTrim;
                    } else {
                        $dyn[$kOrig] = null;
                    }
                } else {
                    $dyn[$kOrig] = ($vOrig === '' || $vOrig === '-') ? null : (is_string($vOrig) ? trim($vOrig) : $vOrig);
                }
            }

            // Pastikan TREG selalu tercatat pada dynamic_data agar kolom skema dapat menampilkannya
            if (!$tregStoredInDyn && !empty($resolvedTreg)) {
                $dyn['TREG'] = $resolvedTreg;
            }

            $dbData['dynamic_data'] = $dyn;

            if (\Illuminate\Support\Facades\Schema::hasColumn('valins_services', 'updated_by')) {
                $dbData['updated_by'] = auth()->check() ? auth()->user()->name : 'System Import';
            }

            ValinsService::create($dbData);
            $importedCount++;
        };

        // Sinkronisasi skema kolom dinamis 1:1 dengan penempatan hierarki wilayah (TREG di sisi paling kiri)
        $adaptColumns = function($headersOrig, $headersNorm, $sampleRows = []) use ($targetCategory, $limitStr) {
            $newCols = [];
            $seenCols = [];

            // Cek apakah kolom pertama tidak bertajuk tetapi datanya angka TREG (1-9 atau "TREG X")
            $hasFirstColTreg = false;
            if (!empty($headersOrig)) {
                $firstHeader = trim((string)reset($headersOrig));
                $firstNorm = !empty($headersNorm[0]) ? $headersNorm[0] : '';
                if (empty($firstHeader) || strpos($firstNorm, 'COL') === 0) {
                    foreach ($sampleRows as $sRow) {
                        $v0 = trim((string)reset($sRow));
                        if (preg_match('/^(TREG\s*\d+|\d+)$/i', $v0)) {
                            $hasFirstColTreg = true;
                            break;
                        }
                    }
                }
            }

            foreach ($headersOrig as $idx => $hOrigName) {
                $trimmed = trim((string)$hOrigName);
                if ($idx === 0 && empty($trimmed) && $hasFirstColTreg) {
                    $trimmed = 'TREG';
                }
                if (empty($trimmed)) continue;
                $hNorm = $headersNorm[$idx] ?? preg_replace('/[^A-Z0-9]/', '', strtoupper($trimmed));
                if ($idx === 0 && $hasFirstColTreg) {
                    $hNorm = 'TREG';
                }
                if (isset($seenCols[$hNorm])) continue;
                $seenCols[$hNorm] = true;

                $type = 'text';
                if (in_array($hNorm, ['TANGGAL', 'DATE', 'DBLASTUPDATEDATE', 'TANGGALUPDATEDATABASE'])) {
                    $type = 'date';
                } elseif (in_array($hNorm, ['AREANUM', 'NOMORAREA', 'VALINSID', 'SLOT', 'PORT', 'NOINETVALINS', 'SIP1VALINS', 'SIP2VALINS'])) {
                    $type = 'number';
                }

                $newCols[] = [
                    'nama' => $limitStr($trimmed, 100),
                    'tipe' => $type,
                    'hidden' => false,
                ];
            }

            // Pastikan TREG selalu berada di posisi paling kiri tabel jika ditemukan di berkas
            $tregColIndex = -1;
            foreach ($newCols as $cIdx => $cItem) {
                $cNorm = preg_replace('/[^A-Z0-9]/', '', strtoupper($cItem['nama']));
                if (in_array($cNorm, ['TREG', 'REGIONAL', 'AREAREGIONAL', 'TELKOMREGIONAL'])) {
                    $tregColIndex = $cIdx;
                    break;
                }
            }
            if ($tregColIndex > 0) {
                $tregCol = $newCols[$tregColIndex];
                unset($newCols[$tregColIndex]);
                array_unshift($newCols, $tregCol);
                $newCols = array_values($newCols);
            }

            if (!empty($newCols)) {
                $targetCategory->update(['konfigurasi_kolom' => $newCols]);
                $targetCategory->konfigurasi_kolom = $newCols;
            }
        };

        DB::beginTransaction();
        try {
            if ($ext === 'xlsx' || $ext === 'xls') {
                $sheetsData = $this->readExcelSheetsRaw($filePath);

                // Filter hanya sheet yang memiliki baris data (minimal header + 1 baris)
                $validSheets = [];
                foreach ($sheetsData as $sheetTitle => $sheetRows) {
                    if (!empty($sheetRows) && count($sheetRows) >= 2) {
                        $validSheets[$sheetTitle] = $sheetRows;
                    }
                }

                if (empty($validSheets)) {
                    throw new \Exception("Berkas Excel tidak memiliki data atau baris kosong.");
                }

                $sheetToProcess = null;
                $chosenSheetTitle = '';

                // ATURAN PEMILIHAN LEMBAR KERJA TEPAT SASARAN:
                // Kasus 1: Jika hanya ada 1 sheet, langsung gunakan sheet tersebut
                if (count($validSheets) === 1) {
                    $chosenSheetTitle = array_key_first($validSheets);
                    $sheetToProcess = $validSheets[$chosenSheetTitle];
                } else {
                    // Kasus 2: Multi-sheet, cari HANYA sheet yang namanya cocok dengan kategori aktif
                    $targetNorm = $normalizeStr($targetCatName);
                    foreach ($validSheets as $sheetTitle => $sheetRows) {
                        $sNorm = $normalizeStr($sheetTitle);
                        if ($sNorm === $targetNorm || strpos($sNorm, $targetNorm) !== false || strpos($targetNorm, $sNorm) !== false) {
                            $chosenSheetTitle = $sheetTitle;
                            $sheetToProcess = $sheetRows;
                            break;
                        }
                    }

                    // Jika tidak ada sheet yang cocok, ambil HANYA lembar kerja pertama yang tampil
                    if (!$sheetToProcess) {
                        $chosenSheetTitle = array_key_first($validSheets);
                        $sheetToProcess = $validSheets[$chosenSheetTitle];
                    }
                }

                // Jika kolom pertama tanpa tajuk namun barisnya berisi TREG
                if (!empty($hOrig) && (empty($hOrig[0]) || strpos($hNorm[0], 'COL') === 0)) {
                    $firstSample = !empty($sheetToProcess[0][0]) ? trim((string)$sheetToProcess[0][0]) : '';
                    if (preg_match('/^(TREG\s*\d+|\d+)$/i', $firstSample)) {
                        $hOrig[0] = 'TREG';
                        $hNorm[0] = 'TREG';
                    }
                }

                $adaptColumns($hOrig, $hNorm, array_slice($sheetToProcess, 0, 10));

                foreach ($sheetToProcess as $r) {
                    $processRow($hNorm, $hOrig, $r);
                }

            } else {
                // Berkas CSV
                $file = fopen($filePath, 'r');
                $firstLine = fgets($file);
                $delimiter = strpos($firstLine, ';') !== false ? ';' : (strpos($firstLine, "\t") !== false ? "\t" : ',');
                rewind($file);

                $rawHeader = fgetcsv($file, 10000, $delimiter);
                $rawHeader[0] = ltrim($rawHeader[0], "\xEF\xBB\xBF");
                $hOrig = array_map('trim', $rawHeader);
                $hNorm = array_map(fn($h) => preg_replace('/[^A-Z0-9]/', '', strtoupper((string)$h)), $hOrig);

                $csvSample = [];
                $csvPos = ftell($file);
                for ($si = 0; $si < 10 && ($sr = fgetcsv($file, 10000, $delimiter)); $si++) {
                    $csvSample[] = $sr;
                }
                fseek($file, $csvPos);

                if (!empty($hOrig) && (empty($hOrig[0]) || strpos($hNorm[0], 'COL') === 0)) {
                    $firstSample = !empty($csvSample[0][0]) ? trim((string)$csvSample[0][0]) : '';
                    if (preg_match('/^(TREG\s*\d+|\d+)$/i', $firstSample)) {
                        $hOrig[0] = 'TREG';
                        $hNorm[0] = 'TREG';
                    }
                }

                $adaptColumns($hOrig, $hNorm, $csvSample);

                while ($r = fgetcsv($file, 10000, $delimiter)) {
                    if (count($rawHeader) !== count($r)) continue;
                    $processRow($hNorm, $hOrig, $r);
                }
                fclose($file);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->cleanupImportFile();
            session()->flash('error', 'Gagal memproses file: ' . $e->getMessage());
            $this->closeImportModal();
            return;
        }

        // Pembersihan berkas sementara server setelah proses tuntas
        $this->cleanupImportFile();
        $this->closeImportModal();
        $this->resetPage();

        // Bersihkan cache metrik & statistik agar sinkron seketika
        \Illuminate\Support\Facades\Cache::forget('valins_stats_counts');
        \Illuminate\Support\Facades\Cache::forget('valins_category_row_counts');
        \Illuminate\Support\Facades\Cache::forget('dashboard_metrics');
        \Illuminate\Support\Facades\Cache::forget('dashboard_sto_chart');
        \Illuminate\Support\Facades\Cache::forget('dashboard_donut_chart');
        \Illuminate\Support\Facades\Cache::forget('dashboard_sto_matrix');

        // Memancarkan sinyal refresh ke tabel dan kategori
        $this->dispatch('refreshKategori');
        $this->dispatch('valinsUpdated');

        session()->flash('success', "Berhasil mengimpor {$importedCount} data khusus ke kategori '{$targetCatName}'!");
    }

    // =========================================================================
    // Ekstraktor File Excel (Bebas Formula Crash & Mengabaikan Sheet Tersembunyi)
    // =========================================================================
    protected function readExcelSheetsRaw($filePath)
    {
        // 1. Jika server menggunakan PhpSpreadsheet
        if (class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filePath);
            
            // Matikan kalkulasi formula agar tidak crash
            $reader->setReadDataOnly(true);
            $reader->setReadEmptyCells(false);
            
            $spreadsheet = $reader->load($filePath);
            $res = [];
            foreach ($spreadsheet->getAllSheets() as $sheet) {
                // Abaikan lembar kerja yang disembunyikan (hidden / very hidden)
                if ($sheet->getSheetState() !== \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_VISIBLE) {
                    continue;
                }
                $res[$sheet->getTitle()] = $sheet->toArray(null, false, false, false);
            }
            return $res;
        }

        // 2. Parser Native Zip XML (Fallback tanpa dependensi package)
        $zip = new \ZipArchive();
        if ($zip->open($filePath) !== true) return [];

        $sharedStrings = [];
        $stringsXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($stringsXml) {
            $xml = simplexml_load_string($stringsXml);
            foreach ($xml->si as $si) {
                $t = '';
                if (isset($si->t)) $t = (string)$si->t;
                elseif (isset($si->r)) { foreach ($si->r as $r) $t .= (string)$r->t; }
                $sharedStrings[] = $t;
            }
        }

        $wbXml = $zip->getFromName('xl/workbook.xml');
        $relsXml = $zip->getFromName('xl/_rels/workbook.xml.rels');
        $sheets = [];
        if ($wbXml && $relsXml) {
            $wb = simplexml_load_string($wbXml);
            $rels = simplexml_load_string($relsXml);
            $relMap = [];
            foreach ($rels->Relationship as $rel) {
                $relMap[(string)$rel['Id']] = (string)$rel['Target'];
            }
            foreach ($wb->sheets->sheet as $s) {
                // Abaikan lembar kerja yang disembunyikan
                if (isset($s['state']) && (string)$s['state'] !== 'visible') {
                    continue;
                }
                $rId = (string)$s->attributes('http://schemas.openxmlformats.org/officeDocument/2006/relationships')['id'];
                if (isset($relMap[$rId])) {
                    $path = 'xl/' . ltrim(str_replace('xl/', '', $relMap[$rId]), '/');
                    $sheets[(string)$s['name']] = $path;
                }
            }
        }

        $result = [];
        foreach ($sheets as $name => $path) {
            $content = $zip->getFromName($path);
            if (!$content) continue;
            $sXml = simplexml_load_string($content);
            $rows = [];
            if (isset($sXml->sheetData->row)) {
                foreach ($sXml->sheetData->row as $r) {
                    $rowCells = [];
                    $lastCol = 0;
                    foreach ($r->c as $c) {
                        preg_match('/([A-Z]+)/', (string)$c['r'], $m);
                        $colLetter = $m[1] ?? 'A';
                        $colIdx = 0;
                        for ($i = 0; $i < strlen($colLetter); $i++) {
                            $colIdx = $colIdx * 26 + (ord($colLetter[$i]) - ord('A') + 1);
                        }
                        $colIdx--;

                        while ($lastCol < $colIdx) { $rowCells[] = ''; $lastCol++; }

                        $val = (string)$c->v;
                        if ((string)$c['t'] === 's' && isset($sharedStrings[(int)$val])) {
                            $val = $sharedStrings[(int)$val];
                        }
                        $rowCells[] = $val;
                        $lastCol = $colIdx + 1;
                    }
                    $rows[] = $rowCells;
                }
            }
            $result[$name] = $rows;
        }
        $zip->close();
        return $result;
    }

    public function exportExcel()
    {
        $filename = 'valins_export_' . ($this->kategori ? \Illuminate\Support\Str::slug($this->kategori) : 'data') . '_' . date('Y-m-d_H-i-s') . '.csv';

        $query = ValinsService::query();
        
        if (!empty($this->kategori)) {
            $query->where('kategori', $this->kategori);
        }

        if (!empty($this->search)) {
            $searchTerm = trim($this->search);
            $query->where(function($q) use ($searchTerm) {
                $q->where('onu_sn', 'like', "%{$searchTerm}%")
                  ->orWhere('no_inet_valins', 'like', "%{$searchTerm}%")
                  ->orWhere('odp_name', 'like', "%{$searchTerm}%")
                  ->orWhere('valins_id', 'like', "%{$searchTerm}%")
                  ->orWhere('node_id', 'like', "%{$searchTerm}%")
                  ->orWhere('node_ip', 'like', "%{$searchTerm}%")
                  ->orWhere('sto', 'like', "%{$searchTerm}%")
                  ->orWhere('pic', 'like', "%{$searchTerm}%")
                  ->orWhere('keterangan', 'like', "%{$searchTerm}%")
                  ->orWhere('sid', 'like', "%{$searchTerm}%")
                  ->orWhere('treg', 'like', "%{$searchTerm}%")
                  ->orWhere('witel', 'like', "%{$searchTerm}%")
                  ->orWhereRaw("CAST(dynamic_data AS CHAR) LIKE ?", ["%{$searchTerm}%"]);
            });
        }

        $activeCategory = ValinsCategory::where('nama_kategori', $this->kategori)->first();
        
        $kolomDinamis = [];
        if (!empty($activeCategory) && !empty($activeCategory->konfigurasi_kolom)) {
            foreach ($activeCategory->konfigurasi_kolom as $kolom) {
                $isHidden = is_array($kolom) ? (!empty($kolom['hidden'])) : (!empty($kolom->hidden));
                if ($isHidden) {
                    continue;
                }
                if (!in_array(strtoupper(trim($kolom['nama'])), ['KETERANGAN', 'TANGGAL', 'PIC'])) {
                    $kolomDinamis[] = $kolom['nama'];
                }
            }
        } else {
            $kolomDinamis = ['TREG', 'WITEL', 'STO', 'ODP NAME', 'PANEL ODP', 'PORT ODP', 'VALINS ID', 'NODE ID', 'NODE IP', 'SLOT', 'PORT', 'ONU SN', 'NO INET VALINS', 'SIP 1 VALINS', 'SIP 2 VALINS', 'SID'];
        }

        $csvHeaders = array_merge(['KATEGORI'], $kolomDinamis, ['KETERANGAN', 'TANGGAL', 'PIC', 'UPDATE PROGRESS']);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($query, $csvHeaders, $kolomDinamis) {
            $file = fopen('php://output', 'w');
            // Menambahkan BOM agar file terbaca mulus di Microsoft Excel
            fputs($file, "\xEF\xBB\xBF"); 
            fputcsv($file, $csvHeaders);

            $query->chunk(500, function($rows) use ($file, $kolomDinamis) {
                foreach ($rows as $row) {
                    $rowData = [];
                    $rowData[] = $row->kategori ?? '-';

                    foreach ($kolomDinamis as $namaKolom) {
                        $propName = strtolower(str_replace(' ', '_', $namaKolom));
                        if ($propName === 'panel_odp') $propName = 'panel_o';
                        if ($propName === 'port_odp') $propName = 'port_od';

                        $nilai = '-';
                        if (is_array($row->dynamic_data) && array_key_exists($namaKolom, $row->dynamic_data) && $row->dynamic_data[$namaKolom] !== null && $row->dynamic_data[$namaKolom] !== '') {
                            $nilai = $row->dynamic_data[$namaKolom];
                        } elseif (isset($row->{$propName}) && $row->{$propName} !== null && $row->{$propName} !== '') {
                            $nilai = $row->{$propName};
                        }
                        
                        $rowData[] = $nilai;
                    }

                    $rowData[] = $row->keterangan ?? '-';
                    $rowData[] = $row->tanggal ? date('Y-m-d', strtotime($row->tanggal)) : '-';
                    $rowData[] = $row->pic ?? '-';
                    $rowData[] = $row->update_progress ?? '-';

                    fputcsv($file, $rowData);
                }
            });
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPDF()
    {
        $query = \App\Models\ValinsService::query();

        if (!empty($this->kategori)) {
            $query->where('kategori', $this->kategori);
        }

        if (!empty($this->search)) {
            $searchTerm = trim($this->search);
            $query->where(function($q) use ($searchTerm) {
                $q->where('onu_sn', 'like', "%{$searchTerm}%")
                  ->orWhere('no_inet_valins', 'like', "%{$searchTerm}%")
                  ->orWhere('odp_name', 'like', "%{$searchTerm}%")
                  ->orWhere('valins_id', 'like', "%{$searchTerm}%")
                  ->orWhere('node_id', 'like', "%{$searchTerm}%")
                  ->orWhere('node_ip', 'like', "%{$searchTerm}%")
                  ->orWhere('sto', 'like', "%{$searchTerm}%")
                  ->orWhere('pic', 'like', "%{$searchTerm}%")
                  ->orWhere('keterangan', 'like', "%{$searchTerm}%")
                  ->orWhere('sid', 'like', "%{$searchTerm}%")
                  ->orWhere('treg', 'like', "%{$searchTerm}%")
                  ->orWhere('witel', 'like', "%{$searchTerm}%")
                  ->orWhereRaw("CAST(dynamic_data AS CHAR) LIKE ?", ["%{$searchTerm}%"]);
            });
        }

        // Batasi maksimal 2000 data untuk ekspor PDF agar PHP tidak kehabisan memori (Out Of Memory)
        $rawData = $query->orderBy('id', 'asc')->limit(2000)->get();

        // 2. Info Dokumen & Nama File
        $waktuCetak = \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y - H:i:s') . ' WIB';
        $bagianAktif = !empty($this->kategori) ? strtoupper($this->kategori) : (!empty($this->search) ? 'PENCARIAN' : 'SEMUA DATA');
        $namaFile = 'Laporan_Valins_' . str_replace(' ', '_', $bagianAktif) . '.pdf';

        // =========================================================================
        // 3. SUSUN DAFTAR KOLOM PERSIS SESUAI LOGIKA <thead> WEBSITE
        // =========================================================================
        $activeCategory = null;
        if (!empty($this->kategori)) {
            $activeCategory = \App\Models\ValinsCategory::where('nama_kategori', $this->kategori)->first();
        }
        if (!$activeCategory && empty($this->search)) {
            $activeCategory = \App\Models\ValinsCategory::orderBy('urutan', 'asc')->orderBy('id', 'asc')->first();
        }

        $konfigurasiKolom = $activeCategory?->konfigurasi_kolom;
        if (is_string($konfigurasiKolom)) {
            $konfigurasiKolom = json_decode($konfigurasiKolom, true);
        }

        $isDynamicCategory = !empty($activeCategory) && !empty($konfigurasiKolom) && is_array($konfigurasiKolom) && count($konfigurasiKolom) > 0;

        $columns = [];
        if ($isDynamicCategory) {
            // MODE A: KATEGORI DINAMIS (Mengikuti konfigurasi_kolom)
            foreach ($konfigurasiKolom as $idx => $kolom) {
                $nama = is_array($kolom) ? ($kolom['nama'] ?? '') : (is_object($kolom) ? ($kolom->nama ?? '') : $kolom);
                $nama = trim((string)$nama);
                $isHidden = is_array($kolom) ? (!empty($kolom['hidden'])) : (!empty($kolom->hidden));

                // JANGAN masukkan ke PDF jika kolom dicentang sembunyikan (hidden)
                if ($isHidden) {
                    continue;
                }

                if (!empty($nama) && !in_array(strtoupper($nama), ['KETERANGAN', 'TANGGAL', 'PIC'])) {
                    $columns[] = [
                        'key'      => 'col_' . $idx,
                        'nama'     => $nama,
                        'label'    => strtoupper($nama),
                        'field_db' => is_array($kolom) ? ($kolom['field'] ?? null) : null,
                    ];
                }
            }
        } else {
            // MODE B: KATEGORI DEFAULT (16 Kolom Bawaan Web)
            $defaultList = [
                'TREG',
                'WITEL',
                'STO',
                'ODP NAME',
                'PANEL ODP',
                'PORT ODP',
                'VALINS ID',
                'NODE ID',
                'NODE IP',
                'SLOT',
                'PORT',
                'ONU SN',
                'NO INET VALINS',
                'SIP 1 VALINS',
                'SIP 2 VALINS',
                'SID',
            ];

            foreach ($defaultList as $i => $lbl) {
                $columns[] = [
                    'key'   => 'col_' . $i,
                    'nama'  => $lbl,
                    'label' => $lbl,
                ];
            }
        }

        // Tiga Kolom Penutup Sesuai thead Web
        $columns[] = ['key' => 'col_ket', 'nama' => 'KETERANGAN', 'label' => 'KETERANGAN'];
        $columns[] = ['key' => 'col_tgl', 'nama' => 'TANGGAL',    'label' => 'TANGGAL'];
        $columns[] = ['key' => 'col_pic', 'nama' => 'PIC',        'label' => 'PIC'];

        // =========================================================================
        // 4. HITUNG LEBAR KOLOM PROPORSIONAL
        // =========================================================================
        $totalWeight = 0;
        $weights = [];
        foreach ($columns as $c) {
            $lbl = $c['label'];
            $w = 4;
            if (in_array($lbl, ['TREG', 'SLOT', 'PORT'])) $w = 2.5;
            elseif (in_array($lbl, ['STO', 'PORT ODP', 'PANEL ODP', 'SID'])) $w = 3.5;
            elseif (in_array($lbl, ['WITEL', 'VALINS ID', 'UPDATE', 'TANGGAL', 'PIC'])) $w = 5;
            elseif (in_array($lbl, ['NODE IP', 'NO INET VALINS', 'KETERANGAN'])) $w = 6.5;
            elseif (in_array($lbl, ['ONU SN', 'NODE ID'])) $w = 7.5;
            elseif (in_array($lbl, ['ODP NAME'])) $w = 9.5;

            $weights[$c['key']] = $w;
            $totalWeight += $w;
        }

        $colWidths = [];
        foreach ($weights as $k => $w) {
            $colWidths[$k] = round(($w / $totalWeight) * 97.5, 2) . '%';
        }

        // =========================================================================
        // 5. EXTRACT DATA PERSIS SESUAI LOGIKA <tbody> WEBSITE
        // =========================================================================
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

        $extractValue = function ($item, $namaKolom) use ($propMap) {
            $upperNama = strtoupper(trim((string)$namaKolom));
            $normK = preg_replace('/[^A-Z0-9]/', '', $upperNama);

            // A. Kolom Khusus Sistem (KETERANGAN, TANGGAL, PIC)
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

            // B. Cek Field Database berdasarkan Mapping Standar Web
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

            // C. Fallback default untuk TREG dan WITEL jika kosong di database (persis seperti tampilan web)
            if ($nilai === '-' || $nilai === '') {
                if ($normK === 'TREG') {
                    $nilai = $item->treg ?? '3';
                } elseif ($normK === 'WITEL') {
                    $nilai = $item->witel ?? 'SUKABUMI';
                }
            }

            // D. Jika di kolom database belum ada / bernilai '-', cari di dynamic_data (persis logika website)
            if ($nilai === '-' || $nilai === '') {
                $dyn = is_array($item->dynamic_data)
                    ? $item->dynamic_data
                    : (is_string($item->dynamic_data) ? json_decode($item->dynamic_data, true) : []);

                if (is_array($dyn)) {
                    // 1. Cek kunci nama persis (contoh: $dyn['ODP NAME'])
                    if (isset($dyn[$namaKolom]) && $dyn[$namaKolom] !== null && trim((string)$dyn[$namaKolom]) !== '' && trim((string)$dyn[$namaKolom]) !== '-') {
                        $nilai = trim((string)$dyn[$namaKolom]);
                    } else {
                        // 2. Cek kecocokan kunci dengan normalisasi huruf dan angka (case & spacing insensitive)
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
        };

        // 6. Siapkan Data Per Baris
        $processedRows = [];
        foreach ($rawData as $item) {
            $row = [];
            foreach ($columns as $col) {
                $row[$col['key']] = $extractValue($item, $col['nama']);
            }
            $row['_update_progress'] = !empty($item->update_progress) ? trim((string)$item->update_progress) : null;
            $processedRows[] = $row;
        }

        // 7. Render PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('valins.pdf', [
            'rows'        => $processedRows,
            'columns'     => $columns,
            'colWidths'   => $colWidths,
            'bagianAktif' => $bagianAktif,
            'waktuCetak'  => $waktuCetak,
        ])->setPaper('legal', 'landscape');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $namaFile
        );
    }

    /**
     * Placeholder dinamis untuk kotak pencarian yang adaptif terhadap kategori aktif
     */
    public function getSearchPlaceholderProperty()
    {
        if (empty($this->kategori)) {
            return 'Cari ONU SN, No Inet, ODP, IP, Keterangan...';
        }

        $upper = strtoupper($this->kategori);
        if (strpos($upper, 'KENDALA ODP') !== false) {
            return 'Cari STO, QR Code Valins, Keterangan, atau PIC...';
        }
        if (strpos($upper, 'NOT IN SERVICE') !== false) {
            return 'Cari ODP Name, Valins ID, Node IP, Update, PIC...';
        }
        return 'Cari ONU SN, No Inet, ODP Name, IP, Keterangan, PIC...';
    }

    /**
     * Resolusi Kolom Dinamis Cerdas (Zero Empty Column Bloat)
     * Menentukan daftar kolom yang relevan dan memiliki data untuk kategori yang sedang dipilih.
     */
    public function resolveActiveColumns($activeCategory, $pagedData = null)
    {
        // 1. Kumpulkan konfigurasi kolom dari kategori
        $konfigurasiKolom = $activeCategory?->konfigurasi_kolom;
        if (is_string($konfigurasiKolom)) {
            $konfigurasiKolom = json_decode($konfigurasiKolom, true);
        }

        $hasExplicitSchema = !empty($konfigurasiKolom) && is_array($konfigurasiKolom) && count($konfigurasiKolom) > 0;
        
        // JIKA KATEGORI MEMILIKI SKEMA EKSPLISIT (misal hasil Impor Excel/CSV atau Kategori Kustom):
        // Sajikan kolom 100% 1:1 persis urutan skema tanpa menyisipkan kolom sintetis WITEL & STO atau menduplikasi Keterangan
        if ($hasExplicitSchema) {
            $schemaColumns = [];
            foreach ($konfigurasiKolom as $idx => $col) {
                $colName = is_array($col) ? ($col['nama'] ?? '') : (is_object($col) ? ($col->nama ?? '') : (string)$col);
                $isHidden = is_array($col) ? (!empty($col['hidden'])) : (!empty($col->hidden));
                if ($isHidden || empty(trim($colName))) continue;

                $norm = strtoupper(preg_replace('/[^A-Z0-9]/', '', $colName));
                $tipe = is_array($col) ? ($col['tipe'] ?? 'text') : 'text';

                // Deteksi tipe dan penyelarasan teks
                $align = 'left';
                $isDate = ($tipe === 'date') || in_array($norm, ['TANGGAL', 'DATE', 'DBLASTUPDATEDATE', 'TANGGALUPDATEDATABASE']);
                $isPortOdp = in_array($norm, ['PORTODP', 'PORTOD', 'PORT_ODP', 'PORT_OD']);
                $isNumber = ($tipe === 'number') || in_array($norm, [
                    'AREANUM', 'NOMORAREA', 'VALINSID', 'SLOT', 'PORT', 
                    'NOINETVALINS', 'SIP1VALINS', 'SIP2VALINS', 'PORTODP', 'PORTOD', 'PANELODP', 'PANELO'
                ]);
                $isStatus = in_array($norm, ['KETERANGAN', 'STATUS', 'KETERANGANSTATUS']);
                $isPic = in_array($norm, ['PIC', 'PETUGAS', 'USER']);
                $isTreg = in_array($norm, ['TREG', 'REGIONAL', 'AREAREGIONAL', 'TELKOMREGIONAL']);

                if ($isDate || $isNumber || $isStatus || $isTreg || $isPortOdp) {
                    $align = 'center';
                }

                $schemaColumns[] = [
                    'key' => 'col_' . strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', $colName)) . '_' . $idx,
                    'nama' => $colName,
                    'norm' => $norm,
                    'label' => strtoupper($colName),
                    'align' => $align,
                    'is_date' => $isDate,
                    'is_status' => $isStatus,
                    'is_pic' => $isPic,
                    'is_treg' => $isTreg,
                    'is_port_odp' => $isPortOdp,
                ];
            }

            return [
                'mode' => 'schema',
                'columns' => $schemaColumns,
            ];
        }

        // JIKA TIDAK ADA SKEMA EKSPLISIT (Kategori Standar Sistem Tanpa Skema):
        // Gunakan layout standar hierarki wilayah berjenjang: TREG -> WITEL -> STO -> ODP NAME
        $standardCols = [
            'treg'           => true,
            'witel'          => true,
            'sto'            => true,
            'odp_name'       => true,
            'valins_id'      => true,
            'node_info'      => true,
            'slot_port'      => true,
            'onu_sn'         => true,
            'no_inet_valins' => true,
            'sip1_valins'    => true,
            'sip2_valins'    => true,
            'sid'            => true,
            'custom'         => [],
            'keterangan'     => true,
            'tanggal'        => true,
            'pic'            => true,
        ];

        if ($pagedData && $pagedData->isNotEmpty()) {
            $standardCols['valins_id']      = $pagedData->contains(fn($r) => !empty($r->valins_id) && $r->valins_id !== '-');
            $standardCols['node_info']      = $pagedData->contains(fn($r) => (!empty($r->node_id) && $r->node_id !== '-') || (!empty($r->node_ip) && $r->node_ip !== '-'));
            $standardCols['slot_port']      = $pagedData->contains(fn($r) => (!empty($r->slot) && $r->slot !== '-') || (!empty($r->port) && $r->port !== '-'));
            $standardCols['onu_sn']         = $pagedData->contains(fn($r) => !empty($r->onu_sn) && $r->onu_sn !== '-');
            $standardCols['no_inet_valins'] = $pagedData->contains(fn($r) => !empty($r->no_inet_valins) && $r->no_inet_valins !== '-');
            $standardCols['sip1_valins']    = $pagedData->contains(fn($r) => !empty($r->sip1_valins) && $r->sip1_valins !== '-');
            $standardCols['sip2_valins']    = $pagedData->contains(fn($r) => !empty($r->sip2_valins) && $r->sip2_valins !== '-');
            $standardCols['sid']            = $pagedData->contains(fn($r) => !empty($r->sid) && $r->sid !== '-');
        }

        return array_merge(['mode' => 'standard'], $standardCols);
    }

   // =========================================================================
    // 5. RENDER (BERSIH DARI QUERY UPDATE)
    // =========================================================================
    public function render()
    {
        $currentUser = auth()->check() ? auth()->user()->name : 'System';
        
        // Ambil kategori esensial secara langsung (sangat cepat & menghindari isu serialisasi objek pada cache)
        $categories = ValinsCategory::select('id', 'nama_kategori', 'slug', 'is_navbar', 'urutan', 'konfigurasi_kolom')
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'asc')
            ->get();
        $activeCategory = $categories->where('nama_kategori', $this->kategori)->first();

        // 1. Inisialisasi $query terlebih dahulu agar tidak undefined
        $query = ValinsService::query();

        // 2. Terapkan filter kategori dan pencarian dinamis
        if (!empty($this->kategori)) {
            $query->where('kategori', $this->kategori);
        }

        if (!empty($this->search)) {
            $searchTerm = trim($this->search);
            $query->where(function($q) use ($searchTerm) {
                $q->where('onu_sn', 'like', "%{$searchTerm}%")
                  ->orWhere('no_inet_valins', 'like', "%{$searchTerm}%")
                  ->orWhere('odp_name', 'like', "%{$searchTerm}%")
                  ->orWhere('valins_id', 'like', "%{$searchTerm}%")
                  ->orWhere('node_id', 'like', "%{$searchTerm}%")
                  ->orWhere('node_ip', 'like', "%{$searchTerm}%")
                  ->orWhere('sto', 'like', "%{$searchTerm}%")
                  ->orWhere('pic', 'like', "%{$searchTerm}%")
                  ->orWhere('keterangan', 'like', "%{$searchTerm}%")
                  ->orWhere('sid', 'like', "%{$searchTerm}%")
                  ->orWhere('treg', 'like', "%{$searchTerm}%")
                  ->orWhere('witel', 'like', "%{$searchTerm}%")
                  ->orWhereRaw("CAST(dynamic_data AS CHAR) LIKE ?", ["%{$searchTerm}%"]);
            });
        }

        // 3. Hitung data bebas setelah $query didefinisikan di atas
        $totalSelectable = (clone $query)->where(function($q) use ($currentUser) {
            $q->whereNull('locked_by')
              ->orWhere('locked_by', $currentUser);
        })->count();

        // 4. Eksekusi paginasi stabil
        $data = $query->orderBy('id', 'asc')->paginate(15);

        // 5. Hitung widget statistik dalam 1 QUERY TUNGGAL (Conditional Aggregation) + Cache 15 detik
        $stats = \Illuminate\Support\Facades\Cache::remember('valins_stats_counts', 15, function () {
            $row = ValinsService::selectRaw("
                COUNT(*) as total,
                COUNT(CASE WHEN keterangan IN ('DONE', 'DONE OLO') THEN 1 END) as done,
                COUNT(CASE WHEN keterangan = 'OTB' THEN 1 END) as otb,
                COUNT(CASE WHEN keterangan = 'Disconnected' THEN 1 END) as disconnected
            ")->first();

            return [
                'total' => (int) ($row->total ?? 0),
                'done' => (int) ($row->done ?? 0),
                'otb' => (int) ($row->otb ?? 0),
                'disconnected' => (int) ($row->disconnected ?? 0),
            ];
        });

        // 6. Hitung jumlah data aktual per kategori (Cached 15 detik)
        $categoryCounts = \Illuminate\Support\Facades\Cache::remember('valins_category_row_counts', 15, function () {
            return ValinsService::selectRaw('kategori, count(*) as count')
                ->whereNotNull('kategori')
                ->groupBy('kategori')
                ->pluck('count', 'kategori')
                ->toArray();
        });

        $activeColumns = $this->resolveActiveColumns($activeCategory, $data->getCollection());

        return view('livewire.valins-table', [
            'data' => $data,
            'categories' => $categories,
            'categoryCounts' => $categoryCounts,
            'activeCategory' => $activeCategory,
            'activeColumns' => $activeColumns,
            'searchPlaceholder' => $this->searchPlaceholder,
            'stats' => $stats,
            'totalSelectable' => $totalSelectable,
            'kategori' => $this->kategori,
            'search' => $this->search,
            'selectedRows' => $this->selectedRows,
            'bulkEditOpen' => $this->bulkEditOpen,
            'importModalOpen' => $this->importModalOpen,
        ]);
    }
}