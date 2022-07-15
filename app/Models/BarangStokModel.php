<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BarangStokModel extends Model
{
    use HasFactory;
    protected $table = 'tb_stok_barang';
    protected $primaryKey = 'id_stok_barang';

    protected $fillable = [
        'id_barang',
        'stok',
        'tgl_kadaluarsa',
        'created_by'
    ];
}
