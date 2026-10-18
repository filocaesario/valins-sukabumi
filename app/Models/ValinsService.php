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
    }
}
