<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BarangHargaModel extends Model
{
    use HasFactory;
    protected $table = 'tb_harga_barang';
    protected $primaryKey = 'id_harga_barang';

    protected $fillable = [
        'id_barang',
        'harga_beli',
        'harga_jual_eceran',
        'harga_jual_grosir',
        'created_by'
    ];
}
