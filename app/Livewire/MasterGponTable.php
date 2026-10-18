<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MasterGpon;

class MasterGponTable extends Component
{
    use WithPagination;

    // Filter Pencarian Terpisah
    public $searchNode = '';
    public $searchSlot = '';
    public $searchPort = '';

    public $activeSto = '';

    public $isOpen = false;
    public $isEdit = false;
    public $gponId;

    public $formSto, $formNodeId, $formNodeIp, $formLogicalId, $formTypeGpon, $formSlot, $formPort;

    public function mount()
    {
        $firstSto = MasterGpon::whereNotNull('sto')->where('sto', '!=', '')->orderBy('sto')->value('sto');
        $this->activeSto = trim($firstSto ?? '');
    }

    public function updatingSearchNode() { $this->resetPage(); }
    public function updatingSearchSlot() { $this->resetPage(); }
    public function updatingSearchPort() { $this->resetPage(); }

    public function resetSearch()
    {
        $this->searchNode = '';
        $this->searchSlot = '';
        $this->searchPort = '';
        $this->resetPage();
    }

    public function setSto($sto)
    {
        $this->activeSto = trim($sto);
        $this->resetSearch();
    }

    public function hapusData($id)
    {
        MasterGpon::find($id)->delete();
        session()->flash('success', 'Data Port berhasil dihapus!');
    }

    public function openModalTambah()
    {
        $this->resetFields();
        $this->isEdit = false;
        $this->formSto = $this->activeSto;
        $this->isOpen = true;
    }

    public function openModalEdit($id)
    {
        $this->resetFields();
        $data = MasterGpon::findOrFail($id);

        $this->gponId = $data->id;
        $this->formSto = $data->sto;
        $this->formNodeId = $data->node_id;
        $this->formNodeIp = $data->node_ip;
        $this->formLogicalId = $data->id_logical_device;
        $this->formTypeGpon = $data->type_gpon;
        $this->formSlot = $data->slot;
        $this->formPort = $data->port;

        $this->isEdit = true;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->formSto = '';
        $this->formNodeId = '';
        $this->formNodeIp = '';
        $this->formLogicalId = '';
        $this->formTypeGpon = '';
        $this->formSlot = '';
        $this->formPort = '';
        $this->gponId = null;
        $this->resetErrorBag();
    }

    public function simpanData()
    {
        $this->validate([
            'formSto' => 'required',
            'formNodeId' => 'required',
            'formNodeIp' => 'required',
            'formSlot' => 'required',
            'formPort' => 'required',
        ]);

        $inputNodeId = strtoupper(trim($this->formNodeId));
        $inputSlot = strtoupper(trim($this->formSlot));
        $inputPort = trim($this->formPort);

        $existingNode = MasterGpon::where('node_id', 'LIKE', $inputNodeId)->first();
        $finalNodeId = $existingNode ? $existingNode->node_id : $inputNodeId;

        $existingSlot = MasterGpon::where('node_id', $finalNodeId)
                                  ->where('slot', 'LIKE', $inputSlot)
                                  ->first();
        $finalSlot = $existingSlot ? $existingSlot->slot : $inputSlot;

        $cekDuplikat = MasterGpon::where('node_id', $finalNodeId)
                                 ->where('port', $inputPort);

        if ($this->isEdit) {
            $cekDuplikat->where('id', '!=', $this->gponId);
        }

        if ($cekDuplikat->exists()) {
            $this->addError('formPort', 'Gagal: Port "' . $inputPort . '" sudah ada di OLT ini!');
            return;
        }

        MasterGpon::updateOrCreate(
            ['id' => $this->gponId],
            [
                'sto'               => strtoupper(trim($this->formSto)),
                'node_id'           => $finalNodeId,
                'node_ip'           => trim($this->formNodeIp),
                'id_logical_device' => trim($this->formLogicalId),
                'type_gpon'         => strtoupper(trim($this->formTypeGpon)),
                'slot'              => $finalSlot,
                'port'              => $inputPort,
            ]
        );

        session()->flash('success', $this->isEdit ? 'Data Port berhasil diupdate!' : 'Data Port baru berhasil ditambahkan!');
        $this->closeModal();

        if (!$this->isEdit) {
            $this->activeSto = strtoupper(trim($this->formSto));
        }
    }

    public function render()
    {
        // Optimasi: Cache daftar STO unik selama 60 detik agar tidak scanning seluruh tabel setiap render
        $stosArray = \Illuminate\Support\Facades\Cache::remember('master_gpon_stos_list', 60, function () {
            return MasterGpon::select('sto')->distinct()->whereNotNull('sto')->where('sto', '!=', '')->orderBy('sto')->pluck('sto')->toArray();
        });
        $stos = collect($stosArray);

        if (empty($this->activeSto) && $stos->count() > 0) {
            $this->activeSto = $stos->first();
        }

        $nodeQuery = MasterGpon::select('node_id')->distinct();

        $hasSearch = !empty($this->searchNode) || !empty($this->searchSlot) || !empty($this->searchPort);

        if ($hasSearch) {
            // Pencarian Node / IP
            if (!empty($this->searchNode)) {
                $term = trim($this->searchNode);
                $nodeQuery->where(function($q) use ($term) {
                    $q->where('node_id', 'like', "%{$term}%")
                      ->orWhere('node_ip', 'like', "%{$term}%");
                });
            }

            // Pencarian Slot
            if (!empty($this->searchSlot)) {
                $term = trim($this->searchSlot);
                $nodeQuery->where(function($q) use ($term) {
                    if (is_numeric($term)) {
                        $q->where('slot', 'LIKE', "%SLOT {$term}")
                          ->orWhere('slot', 'LIKE', "%SLOT 0{$term}")
                          ->orWhere('slot', 'LIKE', "%SLOT {$term} %")
                          ->orWhere('slot', $term)
                          ->orWhere('slot', "0{$term}");
                    } else {
                        $q->where('slot', 'LIKE', "%{$term}%");
                    }
                });
            }

            // Pencarian Port
            if (!empty($this->searchPort)) {
                $term = trim($this->searchPort);
                $nodeQuery->where(function($q) use ($term) {
                    $q->where('port', 'like', "%{$term}%")
                      ->orWhere('port', 'like', "%:{$term}")
                      ->orWhere('port', 'like', "%:0{$term}")
                      ->orWhere('port', 'like', "%-{$term}")
                      ->orWhere('port', 'like', "%-0{$term}");
                });
            }
        } else {
            // Mode Normal (Tab STO)
            if ($this->activeSto) {
                $nodeQuery->where('sto', $this->activeSto);
            }
        }

       $paginatedNodes = $nodeQuery->orderBy('node_id', 'asc')->simplePaginate(5);
        $nodeIds = $paginatedNodes->pluck('node_id');

        $data = collect();
        if ($nodeIds->count() > 0) {
            $portsQuery = MasterGpon::whereIn('node_id', $nodeIds);

            // Filter Tampilan 1: Jangan tampilkan slot yang tidak dicari
            if (!empty($this->searchSlot)) {
                $term = trim($this->searchSlot);
                $portsQuery->where(function($q) use ($term) {
                    if (is_numeric($term)) {
                        $q->where('slot', 'LIKE', "%SLOT {$term}")
                          ->orWhere('slot', 'LIKE', "%SLOT 0{$term}")
                          ->orWhere('slot', 'LIKE', "%SLOT {$term} %")
                          ->orWhere('slot', $term)
                          ->orWhere('slot', "0{$term}");
                    } else {
                        $q->where('slot', 'LIKE', "%{$term}%");
                    }
                });
            }

            // FILTER ANTI-TERBAWA: Hanya tampilkan Slot yang BENAR-BENAR mengandung Port yang dicari!
            if (!empty($this->searchPort)) {
                $term = trim($this->searchPort);

                $matchingSlots = MasterGpon::whereIn('node_id', $nodeIds)
                    ->where(function($q) use ($term) {
                        $q->where('port', 'like', "%{$term}%")
                          ->orWhere('port', 'like', "%:{$term}")
                          ->orWhere('port', 'like', "%:0{$term}")
                          ->orWhere('port', 'like', "%-{$term}")
                          ->orWhere('port', 'like', "%-0{$term}");
                    })->pluck('slot')->unique();

                $portsQuery->whereIn('slot', $matchingSlots);
            }

            $data = $portsQuery->select('id', 'sto', 'node_id', 'node_ip', 'id_logical_device', 'type_gpon', 'slot', 'port')
                        ->orderBy('node_id', 'asc')
                        ->orderBy('id', 'asc')
                        ->get()
                        ->groupBy('node_id')
                        ->map(function ($ports) {
                            return $ports->groupBy('slot')->sortBy(function ($slotPorts, $key) {
                                preg_match('/\d+/', $key, $matches);
                                return isset($matches[0]) ? (int)$matches[0] : 999;
                            }, SORT_NATURAL);
                        });
        }

        return view('livewire.master-gpon-table', compact('data', 'stos', 'paginatedNodes', 'hasSearch'));
    }
}
