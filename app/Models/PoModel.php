<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoModel extends Model
{
    use HasFactory;
    protected $table = 'tb_po';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_po',
        'id_supplier',
        'tgl_po',
        'catatan_admin',
        'catatan_supplier',
        'catatan_retur',
        'status',
        'created_by'
    ];

    static function nomor_otomatis(){

        try {
            
            $data = PoModel::all()->last();
            if($data){

                $prefix = 'PO';
                $number = str_replace("PO","", $data->kode_po);
                $susun = $prefix.str_pad(((int)$number + 1), 3, '0', STR_PAD_LEFT);
                return $susun;

            }else{
                return 'PO001';
            }

        } catch (Exception $e) {
            return 'PO001';
        }

    }

}
