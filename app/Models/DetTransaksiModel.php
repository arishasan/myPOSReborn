<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetTransaksiModel extends Model
{
    use HasFactory;
    protected $table = 'tb_det_transaksi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_barang',
        'id_transaksi',
        'id_stok_barang',
        'qty',
        'harga_satuan_barang',
        'created_by'
    ];
    
}
