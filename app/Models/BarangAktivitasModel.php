<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BarangAktivitasModel extends Model
{
    use HasFactory;
    protected $table = 'tb_aktivitas_barang';
    protected $primaryKey = 'id_aktivitas_barang ';

    protected $fillable = [
        'id_barang',
        'status',
        'qty',
        'created_by'
    ];
}
