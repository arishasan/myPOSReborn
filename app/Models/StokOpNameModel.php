<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpNameModel extends Model
{
    use HasFactory;
    protected $table = 'tb_stok_opname';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tgl_opname',
        'created_by'
    ];

}
