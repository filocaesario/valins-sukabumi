<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ValinsService;
use App\Models\ValinsCategory;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class ValinsTable extends Component
{
    use WithPagination, WithFileUploads; // TAMBAHAN: WithFileUploads

    public $kategori = '';
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
            ['nama' => 'PORT ODP', 'tipe' => 'text', 'hidden' => false],
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
        if (empty($this->kategori)) {
            $firstCat = ValinsCategory::orderBy('urutan', 'asc')->orderBy('id', 'asc')->first();
            $this->kategori = $firstCat ? $firstCat->nama_kategori : '';
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->selectedRows = [];
    }

    public function setKategori($kat)
    {
        $this->kategori = $kat;
        $this->search = ''; 
        $this->resetPage();
        $this->selectedRows = [];
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
                  ->orWhereRaw("CAST(dynamic_data AS CHAR) LIKE ?", ["%{$searchTerm}%"]);
            });
        } else {
            if (!empty($this->kategori)) {
                $query->where('kategori', $this->kategori);
            }
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
        $item = ValinsService::findOrFail($id);
        $userName = auth()->check() ? auth()->user()->name : 'System';
        $lockedByName = explode('|', $item->locked_by ?? '')[0];
        $expireTime = now()->subMinutes(15);

        // Tolak jika dikunci orang lain DAN belum kedaluwarsa
        if (!empty($item->locked_by) && $lockedByName !== $userName && $item->locked_at >= $expireTime) {
            session()->flash('error', "Gagal! Data ini sedang diproses oleh {$lockedByName}.");
            return;
        }

        $item->delete();
        if (($key = array_search($id, $this->selectedRows)) !== false) {
            unset($this->selectedRows[$key]);
            $this->selectedRows = array_values($this->selectedRows);
        }
        $this->dispatch('clear-checkboxes');
        session()->flash('success', 'Data berhasil dihapus!');
    }

    public function bulkDelete()
    {
        if (count($this->selectedRows) > 0) {
            $userName = auth()->check() ? auth()->user()->name : 'System';
            $expireTime = now()->subMinutes(15);

            $deletedCount = ValinsService::whereIn('id', $this->selectedRows)
                ->where(function($q) use ($userName, $expireTime) {
                    $q->whereNull('locked_by')
                      ->orWhere('locked_by', 'like', $userName . '|%')
                      ->orWhere('locked_at', '<', $expireTime);
                })->delete();

            $this->selectedRows = [];
            $this->resetPage();
            $this->dispatch('clear-checkboxes');
            session()->flash('success', "{$deletedCount} data berhasil dihapus!");
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
            $this->dispatch('clear-checkboxes'); // Bersihkan centang UI
            $this->clearSelection();
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
        }

        $this->closeBulkEdit();
    }

    // ==========================================
    // TAMBAHAN: FUNGSI IMPORT DATA (DINAMIS)
    // ==========================================
    public function openImportModal()
    {
        $this->importModalOpen = true;
    }

    public function closeImportModal()
    {
        $this->importModalOpen = false;
        $this->reset('importFile');
        $this->resetErrorBag('importFile');
    }

   // =========================================================================
    // FITUR IMPORT EXCEL / CSV DENGAN PROTEKSI FORMULA ERROR & MULTI-SHEET SCAN
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
        $allCategories = ValinsCategory::all();
        $importedCount = 0;

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

        $detectCategory = function($sheetTitle, $rowAssocNorm, $rawRow) use ($allCategories) {
            $candidates = [
                $sheetTitle,
                $rowAssocNorm['KATEGORI'] ?? '',
                $rowAssocNorm['CATEGORY'] ?? '',
                $rowAssocNorm['CONNECTIVITYCOMPAREREF'] ?? '',
                $rowAssocNorm['ANOMALI'] ?? '',
                $rowAssocNorm['KENDALA'] ?? '',
                $rowAssocNorm['STATUS'] ?? '',
                $rowAssocNorm['NOTES'] ?? '',
            ];
            
            $textToScan = strtoupper(str_replace(['&', '_', '-'], ['DAN', ' ', ' '], implode(' ', $candidates) . ' ' . implode(' ', $rawRow)));

            if (strpos($textToScan, 'ODP DAN DATEK') !== false || strpos($textToScan, 'ODP AND DATEK') !== false) {
                return 'ODP DAN DATEK TIDAK SAMA';
            }
            if (strpos($textToScan, 'DATEK TIDAK SAMA') !== false || strpos($textToScan, 'DATEK NOT EQUAL') !== false) {
                return 'DATEK TIDAK SAMA';
            }
            if (strpos($textToScan, 'ODP TIDAK SAMA') !== false || strpos($textToScan, 'ODP NOT EQUAL') !== false) {
                return 'ODP TIDAK SAMA';
            }
            if (strpos($textToScan, 'NOT IN SERVICE') !== false || strpos($textToScan, 'NOTINSERVICE') !== false || strpos($textToScan, ' NIS ') !== false) {
                return 'Not In Service';
            }

            foreach ($allCategories as $c) {
                $normC = strtoupper(preg_replace('/[^A-Z0-9]/', '', str_replace('&', 'DAN', $c->nama_kategori)));
                if (strpos(preg_replace('/[^A-Z0-9]/', '', $textToScan), $normC) !== false) {
                    return $c->nama_kategori;
                }
            }

            return $sheetTitle ?: $this->kategori;
        };

        $limitStr = function($str, $maxLen) {
            if ($str === null || $str === '') return null;
            $str = (string) $str;
            if (strpos($str, '=') === 0 && strlen($str) > 10) return '-';
            return mb_strlen($str) > $maxLen ? mb_substr($str, 0, $maxLen) : $str;
        };

        $processRow = function($headersNorm, $headersOrig, $row, $sheetTitle) use ($parseConn, $detectCategory, $allCategories, $limitStr, &$importedCount) {
            $assocNorm = [];
            $assocOrig = [];
            foreach ($row as $i => $val) {
                $hN = $headersNorm[$i] ?? "COL_{$i}";
                $hO = $headersOrig[$i] ?? "COL_{$i}";
                
                $v = is_string($val) ? trim($val) : $val;
                if (is_string($v) && strpos($v, '=') === 0 && strlen($v) > 10) $v = '-';
                
                $assocNorm[$hN] = $v;
                $assocOrig[$hO] = $v;
            }

            if (count(array_filter($assocNorm)) === 0) return;

            $catName = $detectCategory($sheetTitle, $assocNorm, $row);
            $catTarget = $allCategories->first(function($c) use ($catName) {
                $n1 = strtoupper(preg_replace('/[^A-Z0-9]/', '', str_replace('&', 'DAN', $c->nama_kategori)));
                $n2 = strtoupper(preg_replace('/[^A-Z0-9]/', '', str_replace('&', 'DAN', $catName)));
                return $n1 === $n2;
            });

            if (!$catTarget && !empty($catName) && $catName !== '-') {
                $catTarget = ValinsCategory::create([
                    'nama_kategori' => $limitStr($catName, 100),
                    'slug' => \Illuminate\Support\Str::slug($catName),
                    'urutan' => ($allCategories->max('urutan') ?? 0) + 1,
                    'konfigurasi_kolom' => [], // Akan diisi di logika Auto-Adapt bawah
                ]);
                $allCategories->push($catTarget);
            }

            // ==============================================================
            // FITUR AUTO-ADAPT: Tangkap Header Excel ke Kolom Kategori 
            // ==============================================================
            if ($catTarget) {
                $existingCols = is_array($catTarget->konfigurasi_kolom) ? $catTarget->konfigurasi_kolom : [];
                $existingColNames = array_map(function($c) {
                    return strtoupper(preg_replace('/[^A-Z0-9]/', '', $c['nama'] ?? ''));
                }, $existingCols);

                $excludeNorm = [
                    'KATEGORI', 'CATEGORY', 'CONNECTIVITYCOMPAREREF', 'ANOMALI', 'KENDALA', 
                    'KETERANGAN', 'STATUS', 'TANGGAL', 'DATE', 'DBLASTUPDATEDATE', 
                    'DBLASTUPDATE', 'PIC', 'PETUGAS', 'USER', 'UPDATEPROGRESS', 'NOTES', 'CATATAN', 'ID'
                ];
                $hasNewCols = false;

                foreach($headersOrig as $idx => $hOrigName) {
                    if (empty(trim($hOrigName))) continue;
                    $hNormName = $headersNorm[$idx] ?? '';
                    
                    if (in_array($hNormName, $excludeNorm)) continue;
                    
                    if (!in_array($hNormName, $existingColNames)) {
                        $existingCols[] = [
                            'nama' => $limitStr(trim($hOrigName), 50),
                            'tipe' => 'text',
                            'hidden' => false,
                        ];
                        $existingColNames[] = $hNormName;
                        $hasNewCols = true;
                    }
                }

                if (empty($existingCols)) {
                    $existingCols = $this->getTemplateKolomStandar();
                    $hasNewCols = true;
                }

                if ($hasNewCols) {
                    $catTarget->update(['konfigurasi_kolom' => $existingCols]);
                    $catTarget->konfigurasi_kolom = $existingCols; // Sinkronkan memori koleksi
                }
            }

            $catName = $catTarget ? $catTarget->nama_kategori : ($catName ?: $this->kategori);
            $catId = $catTarget ? $catTarget->id : null;

            $connRaw = $assocNorm['UIMCONNECTIVITY'] ?? ($assocNorm['VALINSCONNECTIVITY'] ?? ($assocNorm['NMSCONNECTIVITY'] ?? ''));
            $conn = $parseConn($connRaw);

            $odpName = $assocNorm['ODPNAME'] ?? ($assocNorm['ODPLOCATION'] ?? ($assocNorm['ODP'] ?? null));
            $sto = $assocNorm['STO'] ?? null;
            if (empty($sto) && !empty($odpName) && preg_match('/ODP-([A-Z0-9]+)-/i', $odpName, $mSto)) {
                $sto = strtoupper($mSto[1]);
            }

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

            $tgl = null;
            $rawTgl = $assocNorm['TANGGAL'] ?? ($assocNorm['DBLASTUPDATEDATE'] ?? ($assocNorm['DBLASTUPDATE'] ?? null));
            if (!empty($rawTgl)) {
                try { $tgl = \Carbon\Carbon::parse($rawTgl)->format('Y-m-d'); } catch (\Exception $e) {}
            }

            $dbData = [
                'kategori' => $limitStr($catName, 100),
                'valins_category_id' => $catId,
                'treg' => $limitStr($assocNorm['TREG'] ?? ($assocNorm['AREANUM'] ?? '3'), 20),
                'witel' => $limitStr($assocNorm['WITEL'] ?? ($assocNorm['DISTRICT'] ?? 'SUKABUMI'), 100),
                'sto' => $limitStr($sto ?: '-', 50),
                'odp_name' => $limitStr($odpName ?: ($sto ? "ODP-{$sto}" : $catName), 150),
                'panel_o' => $limitStr($assocNorm['PANELODP'] ?? ($assocNorm['PANELO'] ?? ($conn['ODP_PANEL'] ?? '-')), 50),
                'port_od' => $limitStr($assocNorm['PORTODP'] ?? ($assocNorm['PORTOD'] ?? ($conn['ODP_PORT'] ?? null)), 50),
                'valins_id' => $limitStr($assocNorm['VALINSID'] ?? ($conn['ODP_ID'] ?? ($conn['VALINS_ID'] ?? null)), 50),
                'node_id' => $limitStr($nodeId ?: '-', 100),
                'node_ip' => $limitStr($nodeIp ?: '-', 50),
                'slot' => $limitStr($slot ?: null, 20),
                'port' => $limitStr($port ?: null, 20),
                'onu_sn' => $limitStr($assocNorm['ONUSN'] ?? ($assocNorm['SN'] ?? ($conn['ONU_SN'] ?? '-')), 100),
                'no_inet_valins' => $limitStr($assocNorm['NOINETVALINS'] ?? ($assocNorm['NOINET'] ?? ($conn['NO_INET'] ?? '-')), 50),
                'sip1_valins' => $limitStr($assocNorm['SIP1VALINS'] ?? ($assocNorm['SIP1'] ?? '-'), 50),
                'sip2_valins' => $limitStr($assocNorm['SIP2VALINS'] ?? ($assocNorm['SIP2'] ?? '-'), 50),
                'sid' => $limitStr($assocNorm['SID'] ?? ($conn['SID'] ?? '-'), 50),
                'keterangan' => $limitStr(rtrim($assocNorm['KETERANGAN'] ?? ($assocNorm['STATUS'] ?? 'NO STATUS'), '^'), 150),
                'tanggal' => $tgl,
                'pic' => $limitStr($assocNorm['PIC'] ?? ($assocNorm['PETUGAS'] ?? ($assocNorm['USER'] ?? auth()->user()->name ?? 'System')), 100),
                'update_progress' => $limitStr($assocNorm['UPDATEPROGRESS'] ?? ($assocNorm['NOTES'] ?? null), 1000),
            ];

            $dyn = $assocOrig;
            $dyn['TREG'] = $dbData['treg'];
            $dyn['WITEL'] = $dbData['witel'];
            $dyn['STO'] = $dbData['sto'];
            $dyn['ODP NAME'] = $dbData['odp_name'];
            $dyn['PANEL ODP'] = $dbData['panel_o'];
            $dyn['PORT ODP'] = $dbData['port_od'];
            $dyn['VALINS ID'] = $dbData['valins_id'];
            $dyn['NODE ID'] = $dbData['node_id'];
            $dyn['NODE IP'] = $dbData['node_ip'];
            $dyn['SLOT'] = $dbData['slot'];
            $dyn['PORT'] = $dbData['port'];
            $dyn['ONU SN'] = $dbData['onu_sn'];
            $dyn['NO INET VALINS'] = $dbData['no_inet_valins'];
            $dyn['SIP 1 VALINS'] = $dbData['sip1_valins'];
            $dyn['SIP 2 VALINS'] = $dbData['sip2_valins'];
            $dyn['SID'] = $dbData['sid'];
            $dbData['dynamic_data'] = $dyn;

            if (\Illuminate\Support\Facades\Schema::hasColumn('valins_services', 'updated_by')) {
                $dbData['updated_by'] = auth()->check() ? auth()->user()->name : 'System Import';
            }

            ValinsService::create($dbData);
            $importedCount++;
        };

        DB::beginTransaction();
        try {
            if ($ext === 'xlsx' || $ext === 'xls') {
                $sheetsData = $this->readExcelSheetsRaw($filePath);
                foreach ($sheetsData as $sheetTitle => $sheetRows) {
                    if (empty($sheetRows) || count($sheetRows) < 2) continue;
                    
                    $rawHeader = array_shift($sheetRows);
                    $hOrig = array_map(fn($h) => is_string($h) ? trim($h) : (string)$h, $rawHeader);
                    $hNorm = array_map(fn($h) => strtoupper(preg_replace('/[^A-Z0-9]/', '', $h)), $hOrig);

                    foreach ($sheetRows as $r) {
                        $processRow($hNorm, $hOrig, $r, $sheetTitle);
                    }
                }
            } else {
                $file = fopen($filePath, 'r');
                $firstLine = fgets($file);
                $delimiter = strpos($firstLine, ';') !== false ? ';' : (strpos($firstLine, "\t") !== false ? "\t" : ',');
                rewind($file);

                $rawHeader = fgetcsv($file, 10000, $delimiter);
                $rawHeader[0] = ltrim($rawHeader[0], "\xEF\xBB\xBF");
                $hOrig = array_map('trim', $rawHeader);
                $hNorm = array_map(fn($h) => strtoupper(preg_replace('/[^A-Z0-9]/', '', $h)), $hOrig);

                while ($r = fgetcsv($file, 10000, $delimiter)) {
                    if (count($rawHeader) !== count($r)) continue;
                    $targetCat = $this->kategori;
                    $processRow($hNorm, $hOrig, $r, $targetCat);
                }
                fclose($file);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal memproses file: ' . $e->getMessage());
            $this->closeImportModal();
            return;
        }

        $this->closeImportModal();
        
        // Memancarkan sinyal refresh ke tabel dan modal "Kelola Kategori"
        $this->dispatch('refreshKategori');
        
        session()->flash('success', "Berhasil memindai dan mengimpor {$importedCount} data ke kategori masing-masing!");
    }

    // =========================================================================
    // Ekstraktor File Excel (Bebas dari Formula Calculation Error)
    // =========================================================================
    protected function readExcelSheetsRaw($filePath)
    {
        // 1. Jika server menggunakan PhpSpreadsheet
        if (class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filePath);
            
            // KUNCI PENTING: Matikan kalkulasi formula agar tidak terjadi crash 'Formula Error'
            $reader->setReadDataOnly(true);
            $reader->setReadEmptyCells(false);
            
            $spreadsheet = $reader->load($filePath);
            $res = [];
            foreach ($spreadsheet->getAllSheets() as $sheet) {
                // Parameter ke-2 (calculateFormulas = false) mencegah kalkulasi formula di sel
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
                  ->orWhereRaw("CAST(dynamic_data AS CHAR) LIKE ?", ["%{$searchTerm}%"]);
            });
        } else {
            if (!empty($this->kategori)) {
                $query->where('kategori', $this->kategori);
            }
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

        // 1. Terapkan Filter Pencarian atau Kategori Aktif
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
                  ->orWhereRaw("CAST(dynamic_data AS CHAR) LIKE ?", ["%{$searchTerm}%"]);
            });
        } else {
            if (!empty($this->kategori)) {
                $query->where('kategori', $this->kategori);
            }
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

        // 2. Terapkan filter pencarian atau kategori
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
                  ->orWhereRaw("CAST(dynamic_data AS CHAR) LIKE ?", ["%{$searchTerm}%"]);
            });
        } else {
            if (!empty($this->kategori)) {
                $query->where('kategori', $this->kategori);
            }
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

        return view('livewire.valins-table', [
            'data' => $data,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'stats' => $stats,
            'totalSelectable' => $totalSelectable,
        ]);
    }
}