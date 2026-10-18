<?php

namespace App\Imports;

use App\Models\MasterGpon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MasterGponImport implements ToCollection
{
    // Tambahan ": void" ada di baris bawah ini
    public function collection(Collection $rows): void
    {
        $maxColumns = count($rows[0]);

        for ($c = 0; $c < $maxColumns; $c += 2) {

            $idLogical = $rows[0][$c] ?? null;
            $nodeRaw   = $rows[1][$c] ?? null;
            $typeGpon  = $rows[2][$c] ?? null;

            if (empty(trim($nodeRaw))) {
                continue;
            }

            $nodeId = $nodeRaw;
            $nodeIp = null;
            if (preg_match('/^(.*?)\((.*?)\)$/', $nodeRaw, $matches)) {
                $nodeId = trim($matches[1]);
                $nodeIp = trim($matches[2]);
            }

            $sto = null;
            $parts = explode('-', $nodeId);
            if (isset($parts[2])) {
                $sto = trim($parts[2]);
            }

            $currentSlot = null;

            for ($r = 3; $r < count($rows); $r++) {
                $slotCell = $rows[$r][$c] ?? null;
                $portCell = $rows[$r][$c + 1] ?? null;

                if (!empty(trim($slotCell))) {
                    $currentSlot = trim($slotCell);
                }

                if (!empty(trim($portCell))) {
                    MasterGpon::create([
                        'sto'               => $sto,
                        'id_logical_device' => trim($idLogical),
                        'node_id'           => $nodeId,
                        'node_ip'           => $nodeIp,
                        'type_gpon'         => trim($typeGpon),
                        'slot'              => $currentSlot,
                        'port'              => trim($portCell),
                    ]);
                }
            }
        }
    }
}
