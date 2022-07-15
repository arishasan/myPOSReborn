<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BarangModel extends Model
{
    use HasFactory;
    protected $table = 'tb_barang';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_kategori',
        'id_satuan',
        'photo_url',
        'kode_barang',
        'nama_barang',
        'keterangan',
        'status',
        'expired_date_status',
        'qty_min_grosir',
        'created_by'
    ];

    static function generate_kodeBarang(){

        $bulan = date('m');
        $default = 'BR.'.$bulan.'.001';

        $getExistingData = BarangModel::where(DB::raw('SUBSTR(kode_barang, 4, 2)'), $bulan)->orderBy('created_at', 'desc');
        $temp = '';

        if($getExistingData->count() > 0){

            $last_data = $getExistingData->first();
            $temp = $last_data->kode_barang;

            $boom = explode(".", $temp);
            $increment = $boom[2] + 1;

            $susun = 'BR.'.$bulan.'.'.str_pad($increment, 3, '0', STR_PAD_LEFT);
            return $susun;

        }else{
            return $default;
        }

    }
    
}
