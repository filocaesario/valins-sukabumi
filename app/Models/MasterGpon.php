<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterGpon extends Model
{
    use HasFactory;

    protected $table = 'master_gpons';

    // Sesuaikan dengan kolom migrasi terbaru
    protected $fillable = [
        'sto',
        'id_logical_device',
        'node_id',
        'node_ip',
        'type_gpon',
        'slot',
        'port'
    ];
}
