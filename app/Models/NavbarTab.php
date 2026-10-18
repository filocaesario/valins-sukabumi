<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NavbarTab extends Model
{
   protected $fillable = ['nama_tab', 'slug', 'route_name', 'deskripsi', 'urutan', 'is_active'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($tab) {
            if (empty($tab->slug)) {
                $tab->slug = Str::slug($tab->nama_tab);
            }
        });
    }
}