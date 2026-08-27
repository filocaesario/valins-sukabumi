<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValinsService extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi secara massal (berguna untuk import Excel)
    protected $guarded = ['id'];

    // Casting format tanggal
    protected $casts = [
        'tanggal' => 'date',
    ];
}
