<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiModel extends Model
{
    use HasFactory;
    protected $table = 'tb_transaksi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_transaksi',
        'nama_pembeli',
        'keterangan',
        'jumlah_harga',
        'diskon_nominal',
        'nominal_bayar',
        'status',
        'created_by'
    ];

    static function generate_kodeTrx(){

        $bulan = date('Ym');
        $randomString = strtoupper(Str::random(6));
        $default = 'TRX-'.$bulan.'-'.$randomString;

        $getExistingData = TransaksiModel::where(DB::raw('kode_transaksi'), $default);
        $temp = '';

        if($getExistingData->count() > 0){

            $susun = $default.($getExistingData->count() + 1);
            return $susun;

        }else{
            return $default;
        }

    }
    
}
