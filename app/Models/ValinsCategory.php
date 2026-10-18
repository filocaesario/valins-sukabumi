<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValinsCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Ubah JSON menjadi Array secara otomatis
    protected $casts = [
        'konfigurasi_kolom' => 'array',
    ];

    public function valinsServices()
    {
        return $this->hasMany(ValinsService::class);
    }
}