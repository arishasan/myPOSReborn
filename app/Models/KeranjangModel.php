<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KeranjangModel extends Model
{
    use HasFactory;
    protected $table = 'tb_keranjang_belanja';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_barang',
        'is_barang_has_expired_date',
        'id_stok_barang',
        'qty',
        'created_by'
    ];
    
}
