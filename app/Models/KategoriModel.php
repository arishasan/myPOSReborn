<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KategoriModel extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $primaryKey = 'id';

    protected $fillable = ['kode','nama', 'path', 'created_by'];

    static function get_custom_data(){
        $array = [];
        $res = KategoriModel::all();
        foreach($res as $row){
            $array[] = array(
                'id' => $row->id,
                'text' => $row->nama,
                'parent_id' => $row->parent,
                'kode' => $row->kode
            );
        }
        return $array;
    }

    static function get_custom_data_jumlah(){
        $array = [];
        $res = KategoriModel::all();
        foreach($res as $row){
            $array[] = array(
                'id' => $row->id,
                'text' => $row->nama,
                'parent_id' => $row->parent,
                'kode' => $row->kode,
                'count' => 0
            );
        }
        return $array;
    }

    static function get_custom_data_jumlah_by_parentID($parent){
        $array = [];
        // $res = KategoriModel::all();
        $res = DB::select(DB::raw("SELECT id, nama, parent, kode from kategori WHERE find_in_set('".$parent."', TRIM(LEADING ',' FROM replace(path, '/', ','))) <> 0"));
        foreach($res as $row){

            // $boom = explode("/", $row->path);

            // if(isset($boom[1])){

            //     if($boom[1] == $parent){

            //         $array[] = array(
            //             'id' => $row->id,
            //             'text' => $row->nama,
            //             'parent_id' => $row->parent,
            //             'kode' => $row->kode,
            //             'count' => 0,
            //             'nominal' => 0
            //         );

            //     }

            // }

            $array[] = array(
                'id' => $row->id,
                'text' => $row->nama,
                'parent_id' => $row->parent,
                'kode' => $row->kode,
                'count' => 0,
                'nominal' => 0
            );

            
        }
        return $array;
    }

    static function getParentName($parent_id){

        try {
            if($parent_id == 0){
                return 'UTAMA';
            }else{
                $search = KategoriModel::findOrFail($parent_id);
                if($search){
                    return $search->nama;
                }else{
                    return 'NULL';
                }
            }
        } catch (Exception $e) {
            return 'NULL';
        }

    }

}
