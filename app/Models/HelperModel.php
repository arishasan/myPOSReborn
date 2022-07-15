<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AksesModel;
use App\Models\RoleModel;
use DateTime;

class HelperModel extends Model
{
    use HasFactory;

    static function saveLog($table, $action, $mainData = [], $dataDetail = [], $where = []){

    	try {
    		
    		$data = array(
    			'table' => $table,
    			'action' => $action,
    			'main_data' => json_encode($mainData),
    			'data_detail' => json_encode($dataDetail),
    			'where' => json_encode($where),
    			'created_by' => Auth()->user()->id,
    			'created_at' => \Carbon\Carbon::now()->timezone('Asia/Jakarta')
    		);

    		DB::table('tb_logs_activity')->insert($data);

    		return true;
    	} catch (Exception $e) {
    		return false;
    	}

    }

    static function allowedAccess($modul){

        if($modul == 'Master'){

            $array = array(
                'Admin'
            );

            if(in_array(Auth()->user()->role, $array)){
                return true;
            }else{
                return false;
            }

        }else if($modul == 'Transaksi'){

            $array = array(
                'Admin',
                'Pembeli',
            );

            if(in_array(Auth()->user()->role, $array)){
                return true;
            }else{
                return false;
            }

        }else if($modul == 'PO'){

            $array = array(
                'Admin',
                'Supplier',
            );

            if(in_array(Auth()->user()->role, $array)){
                return true;
            }else{
                return false;
            }

        }else if($modul == 'Laporan'){

            $array = array(
                'Admin',
                'Pemilik',
            );

            if(in_array(Auth()->user()->role, $array)){
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }

    }

    static function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
    }

}
