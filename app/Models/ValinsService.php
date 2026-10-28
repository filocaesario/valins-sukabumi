<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ValinsService extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi secara massal (berguna untuk import Excel)
   protected $guarded = [];

    // Casting format tanggal
    // Casting format
    protected $casts = [
        'dynamic_data' => 'array',
        'tanggal' => 'date', // <--- Tambahkan ini agar JSON terbaca otomatis
    ];

    // Tambahkan relasi ke kategori
    public function category()
    {
        return $this->belongsTo(ValinsCategory::class, 'valins_category_id');
    }
    
// ========================================================
    // SENSOR OTOMATIS: Pencatat Histori Perubahan (Audit Trail)
    // ========================================================
    protected static function booted()
    {
        // 1. Saat data baru dibuat (otomatis mencatat yang menginput)
        static::creating(function ($valins) {
            if (Auth::check()) {
                $valins->updated_by = Auth::user()->name;
            }
        });

        // 2. Saat data diedit / di-bulk update (otomatis mencatat yang mengedit)
        static::updating(function ($valins) {
            if (Auth::check()) {
                $valins->updated_by = Auth::user()->name;
            }
        });

        // 3. Sanitasi Otomatis: Bersihkan spasi liar dan ekstraksi angka murni pada PORT ODP
        static::saving(function ($valins) {
            if ($valins->port_od !== null && trim((string)$valins->port_od) !== '' && trim((string)$valins->port_od) !== '-') {
                $pTrim = trim((string)$valins->port_od);
                $valins->port_od = preg_match('/(\d+)/', $pTrim, $m) ? $m[1] : $pTrim;
            }

            if (is_array($valins->dynamic_data)) {
                $dyn = $valins->dynamic_data;
                $changed = false;
                foreach ($dyn as $k => $v) {
                    $normK = strtoupper(preg_replace('/[^A-Z0-9]/', '', (string)$k));
                    if (in_array($normK, ['PORTODP', 'PORTOD'])) {
                        if ($v !== null && trim((string)$v) !== '' && trim((string)$v) !== '-') {
                            $pTrim = trim((string)$v);
                            $cleanP = preg_match('/(\d+)/', $pTrim, $mP) ? $mP[1] : $pTrim;
                            if ($dyn[$k] !== $cleanP) {
                                $dyn[$k] = $cleanP;
                                $changed = true;
                            }
                        } else {
                            if ($dyn[$k] !== null) {
                                $dyn[$k] = null;
                                $changed = true;
                            }
                        }
                    } elseif (is_string($v)) {
                        $tV = trim($v);
                        if ($dyn[$k] !== $tV) {
                            $dyn[$k] = $tV;
                            $changed = true;
                        }
                    }
                }
                if ($changed) {
                    $valins->dynamic_data = $dyn;
                }
            }
        });

        // 3. Sinkronisasi Real-Time: Bersihkan cache dashboard & widget valins saat data berubah
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('dashboard_metrics');
            \Illuminate\Support\Facades\Cache::forget('dashboard_sto_chart');
            \Illuminate\Support\Facades\Cache::forget('dashboard_donut_chart');
            \Illuminate\Support\Facades\Cache::forget('dashboard_gpon_nodes');
            \Illuminate\Support\Facades\Cache::forget('dashboard_sto_matrix');
            \Illuminate\Support\Facades\Cache::forget('valins_stats_counts');
            \Illuminate\Support\Facades\Cache::forget('valins_category_row_counts');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('dashboard_metrics');
            \Illuminate\Support\Facades\Cache::forget('dashboard_sto_chart');
            \Illuminate\Support\Facades\Cache::forget('dashboard_donut_chart');
            \Illuminate\Support\Facades\Cache::forget('dashboard_gpon_nodes');
            \Illuminate\Support\Facades\Cache::forget('dashboard_sto_matrix');
            \Illuminate\Support\Facades\Cache::forget('valins_stats_counts');
            \Illuminate\Support\Facades\Cache::forget('valins_category_row_counts');
        });
    }
}
