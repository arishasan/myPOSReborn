<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App\Models\BarangModel;
use App\Models\HelperModel;
use App\Models\LokasiModel;
use App\Models\KategoriModel;
use App\Models\MerkModel;
use App\Models\DetPoModel;
use App\Models\PoModel;
use App\Models\LaporanModel;
use App\Models\AksesModel;
use DataTables;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    
    public function __construct(){

    }

    public function index(){
        $cekAkses = HelperModel::allowedAccess('Laporan');

        if($cekAkses == false){
            return view('admin.parts.404');
        }

        $data = [
            'data_kategori' => KategoriModel::where('parent', 0)->get()
        ];
        return view('admin.pages.laporan.barang_kategori')->with($data);
    }

    public function get_laporan_kategori_barang($id){

        $user_id = Auth()->user()->id;

        $akses = AksesModel::select('akses_wilayah')->where('user_id', $user_id)->first();

        $json = json_decode($akses['akses_wilayah'], true);

        $wilayah_avail = array();

        $i=0;
        foreach ($json as $wilayah) {
            if ($wilayah['enable']=="1") {
                $wilayah_avail[] = $wilayah['id'];
                $i++;
            }
        }

        $jumlah_parent_wilayah = LokasiModel::where('parent', 0)->count();

        if($jumlah_parent_wilayah == count($wilayah_avail)){
            echo json_encode(LaporanModel::get_kategori_barang_fixed($id));
        }else{
            echo json_encode(LaporanModel::get_kategori_barang_fixed($id, $wilayah_avail));
        }

    }

}
