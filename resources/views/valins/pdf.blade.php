<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Valins Services</title>
    <style>
        @page {
            margin: 6mm 4mm;
            size: legal landscape;
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: {{ count($columns ?? []) > 16 ? '5.2px' : (count($columns ?? []) > 10 ? '6.5px' : '8px') }};
            color: #0f172a;
            line-height: 1.15;
        }
        .header {
            text-align: center;
            margin-bottom: 6px;
            border-bottom: 1.5px solid #dc2626;
            padding-bottom: 3px;
        }
        .header h2 {
            margin: 0;
            font-size: 11px;
            font-weight: bold;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 2px 0 0 0;
            font-size: 6.5px;
            color: #475569;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 3px;
        }
        th, td {
            border: 0.5px solid #cbd5e1;
            padding: 2.5px 1.5px;
            text-align: left;
            vertical-align: middle;
            word-wrap: break-word;
            word-break: break-word;
            overflow: hidden;
        }
        th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            line-height: 1.1;
        }
        tr:nth-child(even) { background-color: #f8fafc; }
        
        .text-center { text-align: center; }
        .font-mono { font-family: monospace; font-size: {{ count($columns ?? []) > 16 ? '4.8px' : '6px' }}; }

        /* Badge Status Keterangan */
        .badge {
            display: inline-block;
            padding: 1px 2px;
            border-radius: 2px;
            font-weight: bold;
            font-size: {{ count($columns ?? []) > 16 ? '4.5px' : '5.5px' }};
            text-align: center;
        }
        .badge-done { background: #dcfce7; color: #15803d; }
        .badge-otb { background: #fef9c3; color: #854d0e; }
        .badge-dc { background: #fee2e2; color: #b91c1c; }
        .badge-pending { background: #e0f2fe; color: #0369a1; }
        .badge-cancelled { background: #f1f5f9; color: #475569; }
        .badge-default { background: #f1f5f9; color: #334155; }
    </style>
</head>
<body>

    <!-- Header Dokumen -->
    <div class="header">
        <h2>LAPORAN DATA VALINS SERVICES</h2>
        <p>PT Telkom Akses Witel Sukabumi &bull; Dicetak pada: {{ $waktuCetak ?? date('d F Y - H:i:s') . ' WIB' }}</p>
    </div>

    <!-- Informasi Ringkas -->
    <table style="width: 100%; border: none; margin-bottom: 3px;">
        <tr>
            <td style="border: none; padding: 0; text-align: left; font-size: 7px;">
                <strong>Kategori Data:</strong> 
                <span style="color: #dc2626; font-weight: bold; text-transform: uppercase;">{{ $bagianAktif ?? 'SEMUA DATA' }}</span>
            </td>
            <td style="border: none; padding: 0; text-align: right; font-size: 7px;">
                <strong>Total:</strong> {{ count($rows ?? []) }} Data
            </td>
        </tr>
    </table>

    <!-- Tabel Data Utama -->
    <table>
        <thead>
            <tr>
                <th style="width: 2.5%;">NO</th>
                @foreach(($columns ?? []) as $col)
                    <th style="width: {{ $colWidths[$col['key']] ?? 'auto' }};">{{ $col['label'] ?? ($col['nama'] ?? '') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse(($rows ?? []) as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    
                    @foreach(($columns ?? []) as $col)
                        @php 
                            $key = $col['key'] ?? '';
                            $label = strtoupper(trim($col['label'] ?? ($col['nama'] ?? '')));
                            $val = is_array($row) ? ($row[$key] ?? ($row[$col['nama'] ?? ''] ?? '-')) : ($row->{$key} ?? '-');
                            if ($val === null || $val === '') {
                                $val = '-';
                            }
                        @endphp

                        @if($label === 'KETERANGAN')
                            <td class="text-center">
                                @if($val !== '-')
                                    @php
                                        $ket = strtoupper(trim((string)$val));
                                        $class = 'badge-default';
                                        if (str_contains($ket, 'CANCELLED')) $class = 'badge-cancelled';
                                        elseif (str_contains($ket, 'DISCONNECT') || str_contains($ket, 'KENDALA')) $class = 'badge-dc';
                                        elseif (str_contains($ket, 'PENDING')) $class = 'badge-pending';
                                        elseif (str_contains($ket, 'DONE')) $class = 'badge-done';
                                        elseif (str_contains($ket, 'OTB')) $class = 'badge-otb';
                                    @endphp
                                    <span class="badge {{ $class }}">{{ $val }}</span>
                                @else
                                    -
                                @endif

                                @if(!empty($row['_update_progress']))
                                    <div style="font-size: {{ count($columns ?? []) > 16 ? '4.2px' : '5px' }}; color: #1e40af; margin-top: 1.5px; text-align: left; line-height: 1.1; word-wrap: break-word;">
                                        <strong>Update:</strong> {{ $row['_update_progress'] }}
                                    </div>
                                @endif
                            </td>

                        @elseif(in_array($label, ['TREG', 'SLOT', 'PORT', 'PANEL ODP', 'PORT ODP', 'TANGGAL']))
                            <td class="text-center">{{ $val }}</td>

                        @elseif($label === 'STO')
                            <td><strong>{{ $val }}</strong></td>

                        @elseif($label === 'ODP NAME')
                            <td style="color: #1d4ed8; font-weight: bold;">{{ $val }}</td>

                        @elseif(in_array($label, ['ONU SN', 'NO INET VALINS', 'VALINS ID', 'NODE ID', 'NODE IP', 'SIP 1 VALINS', 'SIP 2 VALINS', 'SID']))
                            <td class="font-mono">{{ $val }}</td>

                        @else
                            <td>{{ $val }}</td>
                        @endif
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns ?? []) + 1 }}" class="text-center" style="padding: 12px; color: #94a3b8;">
                        Tidak ada data yang tersedia di kategori ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>