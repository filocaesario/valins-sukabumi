<?php

namespace App\Http\Controllers;

use App\Models\MasterGpon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MasterGponController extends Controller
{
    public function index()
    {
        return view('master-gpon.index');
    }

    public function create()
    {
        return view('master-gpon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sto' => 'required',
            'node_id' => 'required',
            'node_ip' => 'required',
            'slot' => 'required',
            'port' => 'required',
        ]);

        MasterGpon::create($request->all());
        return redirect()->route('master-gpon.index')->with('success', 'Data ditambahkan!');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        MasterGpon::truncate();

        $file = $request->file('file_excel')->getPathname();
        $spreadsheet = IOFactory::load($file);
        $sheetNames = $spreadsheet->getSheetNames();

        $insertData = [];
        $now = now();

        foreach ($sheetNames as $sheetName) {
            $sheet = $spreadsheet->getSheetByName($sheetName);
            $rows = $sheet->toArray();

            if (empty($rows)) continue;

            // 1. CARI BARIS NODE ID (Jangkar Utama)
            $nodeRowIdx = -1;
            for ($i = 0; $i < min(15, count($rows)); $i++) {
                foreach ($rows[$i] as $cellVal) {
                    $val = strtoupper(trim($cellVal ?? ''));
                    if (str_contains($val, 'GPON') && str_contains($val, '(')) {
                        $nodeRowIdx = $i;
                        break 2;
                    }
                }
            }

            if ($nodeRowIdx === -1) continue;

            $logicalRowIdx = max(0, $nodeRowIdx - 1);
            $typeRowIdx    = $nodeRowIdx + 1;
            $dataStartIdx  = $nodeRowIdx + 2;

            $maxColumns = 0;
            foreach ($rows as $r) {
                $maxColumns = max($maxColumns, count($r));
            }

            // 2. KELILINGI SETIAP OLT
            for ($c = 0; $c < $maxColumns; $c++) {
                $nodeRaw = trim($rows[$nodeRowIdx][$c] ?? '');

                if (!empty($nodeRaw) && (stripos($nodeRaw, 'GPON') !== false || strpos($nodeRaw, '(') !== false)) {

                    $startCol = $c;

                    // A. Cari Batas Kolom OLT Selanjutnya
                    $boundaryCol = $maxColumns - 1;
                    for ($next = $startCol + 1; $next < $maxColumns; $next++) {
                        $nextNodeRaw = trim($rows[$nodeRowIdx][$next] ?? '');
                        if (!empty($nextNodeRaw) && (stripos($nextNodeRaw, 'GPON') !== false || strpos($nextNodeRaw, '(') !== false)) {
                            $boundaryCol = $next - 1;
                            break;
                        }
                    }

                    // B. DETEKSI OTOMATIS: Berapa kolom yang dipakai OLT ini? (Huawei=2, ZTE=3)
                    $endCol = $startCol;
                    for ($x = $startCol; $x <= $boundaryCol; $x++) {
                        $hasData = false;
                        // Cek 5 baris pertama untuk melihat apakah kolom ini terisi data
                        for ($testRow = $dataStartIdx; $testRow <= min($dataStartIdx + 5, count($rows) - 1); $testRow++) {
                            if (trim($rows[$testRow][$x] ?? '') !== '') {
                                $hasData = true;
                                break;
                            }
                        }
                        if ($hasData) {
                            $endCol = $x;
                        } else {
                            break; // Stop jika menemukan kolom kosong pembatas
                        }
                    }

                    // C. Tarik Metadata (Razia semua kolom OLT agar kebal Merge Cell)
                    $idLogical = '-';
                    for ($xt = $startCol; $xt <= $endCol; $xt++) {
                        $val = trim($rows[$logicalRowIdx][$xt] ?? '');
                        if ($val !== '' && $val !== '-') { $idLogical = $val; break; }
                    }

                    $typeGpon = '-';
                    for ($xt = $startCol; $xt <= $endCol; $xt++) {
                        $val = trim($rows[$typeRowIdx][$xt] ?? '');
                        if ($val !== '' && $val !== '-') { $typeGpon = $val; break; }
                    }

                    // Pisahkan Node ID & IP
                    $nodeId = $nodeRaw;
                    $nodeIp = '-';
                    if (str_contains($nodeRaw, '(')) {
                        $parts = explode('(', $nodeRaw);
                        $nodeId = trim($parts[0]);
                        $nodeIp = trim(str_replace(')', '', $parts[1] ?? ''));
                    }

                    $sto = strtoupper(trim($sheetName));

                    // D. SCAN DATA PORT KE BAWAH (Multi-Kolom Fleksibel)
                    $slotMemory = [];
                    for ($r = $dataStartIdx; $r < count($rows); $r++) {

                        // Kolom paling kanan ($endCol) PASTI adalah Port
                        $portCell = trim($rows[$r][$endCol] ?? '');

                        // Kolom sisanya sebelum $endCol adalah RACK / SLOT
                        $slotParts = [];
                        for ($sc = $startCol; $sc < $endCol; $sc++) {
                            $cell = trim($rows[$r][$sc] ?? '');
                            if ($cell !== '') {
                                $slotMemory[$sc] = $cell; // Simpan ke ingatan jika tidak kosong
                            }
                            if (isset($slotMemory[$sc])) {
                                $slotParts[] = $slotMemory[$sc];
                            }
                        }

                        if ($portCell !== '') {
                            // Gabungkan Rack & Slot (Contoh: "RACK 1 / SLOT 2")
                            $currentSlot = empty($slotParts) ? 'SLOT 1' : implode(' / ', array_unique($slotParts));

                            $insertData[] = [
                                'sto'               => $sto,
                                'id_logical_device' => $idLogical,
                                'node_id'           => $nodeId,
                                'node_ip'           => $nodeIp,
                                'type_gpon'         => $typeGpon,
                                'slot'              => $currentSlot,
                                'port'              => $portCell,
                                'created_at'        => $now,
                                'updated_at'        => $now,
                            ];
                        }
                    }

                    // Lompat ke OLT berikutnya
                    $c = $boundaryCol;
                }
            }
        }

        if (count($insertData) > 0) {
            foreach (array_chunk($insertData, 1000) as $chunk) {
                MasterGpon::insert($chunk);
            }
        }

        return back()->with('success', 'SUKSES ' . count($insertData) . ' berhasil dipindai dengan sempurna!');
    }
}
