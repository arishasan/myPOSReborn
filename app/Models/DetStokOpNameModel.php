<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetStokOpNameModel extends Model
{
    use HasFactory;
    protected $table = 'tb_det_stok_opname';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_stok_opname',
        'id_barang',
        'jml_stok_nyata',
        'stok_system',
        'akumulasi',
        'catatan'
    ];

}
