<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetPoModel extends Model
{
    use HasFactory;
    protected $table = 'tb_det_po';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_po',
        'id_barang',
        'qty_dipesan',
        'qty_tersedia',
        'qty_retur',
        'harga_satuan',
        'is_exp_date',
        'exp_date',
        'created_by'
    ];
}
