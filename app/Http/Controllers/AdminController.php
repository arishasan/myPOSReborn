<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DashboardModel;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use App\Models\TransaksiModel;
use App\Models\PoModel;
// use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{	
	public function __construct(){

	}
    
    public function index(){

        $data = [
           'count_supplier' => SupplierModel::count(),
           'count_user_supplier' => UserModel::where('role', 'Supplier')->count(),
           'count_user_pembeli' => UserModel::where('role', 'Pembeli')->count(),
           'count_barang' => BarangModel::count() 
        ];

    	return view('index-admin')->with($data);
    }

    public function get_data($bulan, $tahun){

        $tot_trx = 0;
        $tot_paid = 0;
        $tot_pending = 0;
        $tot_void = 0;
        $tot_cancel = 0;

        $jml_trx_paid = 0;
        $jml_trx_pending = 0;
        $jml_trx_void = 0;
        $jml_trx_cancel = 0;
        $jml_trx_po = 0;

        $getTrx = TransaksiModel::select('*');

        if($bulan == 'All'){
            $getTrx->where(DB::raw('SUBSTR(created_at, 1, 4)'), $tahun);
        }else{
            $getTrx->where(DB::raw('SUBSTR(created_at, 1, 7)'), $tahun.'-'.$bulan);
        }

        $getTrx->orderBy('created_at', 'DESC');

        $data = $getTrx->get();

        $limit = 5;
        $i = 1;
        $array_trx_terakhir = array();

        foreach ($data as $key => $value) {
            
            $jml = ($value->jumlah_harga - $value->diskon_nominal);
            $tot_trx += $jml;

            if($value->status == 'PAID'){
                $tot_paid += $jml;
                $jml_trx_paid++;
            }else if($value->status == 'PENDING/ORDER'){
                $tot_pending += $jml;
                $jml_trx_pending++;
            }else if($value->status == 'VOID'){
                $tot_void += $jml;
                $jml_trx_void++;
            }else if($value->status == 'CANCEL'){
                $tot_cancel += $jml;
                $jml_trx_cancel++;
            }

            if($i <= $limit){
                array_push($array_trx_terakhir, $value);
                $i++;
            }

        }

        $getPO = PoModel::select('*');

        if($bulan == 'All'){
            $getPO->where(DB::raw('SUBSTR(tgl_po, 1, 4)'), $tahun);
        }else{
            $getPO->where(DB::raw('SUBSTR(tgl_po, 1, 7)'), $tahun.'-'.$bulan);
        }

        $jml_trx_po = $getPO->count();

        $chart_labels = array();
        $chart_isi = array();

        if($bulan == 'All'){

            $trx_transaksi = DB::select(DB::raw("SELECT DAY(created_at) as `hari`,MONTHNAME(created_at) as `bulan`,SUBSTR(created_at, 1, 7) as `ym`, SUBSTR(created_at, 1, 4) as `y`, SUM((jumlah_harga - diskon_nominal)) as `pendapatan` FROM tb_transaksi WHERE status = 'PAID' AND YEAR(created_at) = '".$tahun."' GROUP BY MONTH(created_at)"));

        }else{

            $trx_transaksi = DB::select(DB::raw("SELECT DAY(created_at) as `hari`,MONTHNAME(created_at) as `bulan`,SUBSTR(created_at, 1, 7) as `ym`, SUBSTR(created_at, 1, 4) as `y`, SUM((jumlah_harga - diskon_nominal)) as `pendapatan` FROM tb_transaksi WHERE status = 'PAID' AND (MONTH(created_at) = '".$bulan."' AND YEAR(created_at) = '".$tahun."') GROUP BY DAY(created_at)"));

        }

        $trx_transaksi = json_decode(json_encode($trx_transaksi), true);

        foreach($trx_transaksi as $kk => $v){

            if($bulan == 'All'){

                array_push($chart_labels, $v['bulan'] . ' '. $v['y']);
                array_push($chart_isi, $v['pendapatan']);

            }else{

                array_push($chart_labels, $v['hari'].' '. $v['bulan']);
                array_push($chart_isi, $v['pendapatan']);

            }

        }

        // echo "<pre>";

        $ret = array(
            'tot_trx' => $tot_trx,
            'tot_paid' => $tot_paid,
            'tot_pending' => $tot_pending,
            'tot_void' => $tot_void,
            'tot_cancel' => $tot_cancel,
            'jml_trx_paid' => $jml_trx_paid,
            'jml_trx_pending' => $jml_trx_pending,
            'jml_trx_void' => $jml_trx_void,
            'jml_trx_cancel' => $jml_trx_cancel,
            'jml_trx_po' => $jml_trx_po,
            'chart_labels' => $chart_labels,
            'chart_isi' => $chart_isi,
            'data_trx_terakhir' => $array_trx_terakhir
        );
        // print_r($ret);
        echo json_encode($ret);

    }

}
