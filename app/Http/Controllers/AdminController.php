<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DashboardModel;
use App\Models\RequesterModel;
use App\Models\BarangModel;
use App\Models\LokasiModel;
use App\Models\KategoriModel;
use App\Models\AksesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{	
	public function __construct(){

	}
    
    public function index(){
    	
        // $data = [
        //     'total_assets' => DashboardModel::widget_assets('total'),
        //     'jumlah_assets' => DashboardModel::widget_assets('jumlah'),
        //     'dalam_perbaikan' => DashboardModel::widget_assets('perbaikan'),
        //     'asset_baru_bulan_ini' => DashboardModel::widget_growth('bulan_ini'),
        //     'asset_baru_bulan_kemarin' => DashboardModel::widget_growth('bulan_kemarin'),
        // ];

        $data = [
            'total_assets' => 0,
            'jumlah_assets' => 0,
            'dalam_perbaikan' => 0,
            'asset_baru_bulan_ini' => 0,
            'asset_baru_bulan_kemarin' => 0,
        ];

    	return view('index-admin')->with($data);
    }

    public function load_adm(){

    	$request = DashboardModel::widget_adm('request');
    	$po = DashboardModel::widget_adm('po');
    	$mutasi = DashboardModel::widget_adm('mutasi');
    	$maintenance = DashboardModel::widget_adm('maintenance');
    	$pelaporan = DashboardModel::widget_adm('pelaporan');

    	echo json_encode(
    		array(
    			'request' => $request,
    			'po' => $po,
    			'mutasi' => $mutasi,
    			'maintenance' => $maintenance,
    			'pelaporan' => $pelaporan,
    		)
    	);

    }

    public function load_master(){

    	$lokasi = DashboardModel::widget_master('lokasi');
    	$requester = DashboardModel::widget_master('requester');
    	$vendor = DashboardModel::widget_master('vendor');
    	$kategori = DashboardModel::widget_master('kategori');
    	$merk = DashboardModel::widget_master('merk');

    	echo json_encode(
    		array(
    			'lokasi' => $lokasi,
    			'requester' => $requester,
    			'vendor' => $vendor,
    			'kategori' => $kategori,
    			'merk' => $merk,
    		)
    	);

    }

    public function load_chart_asset(){

    	echo json_encode(DashboardModel::widget_growth('chart'));

    }

    public function load_pin_requester(){

    	echo json_encode(RequesterModel::all());

    }

}
