<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardModel extends Model
{
    use HasFactory;

    static function widget_assets($get){

        if($get == 'total'){

            $getBarang = BarangModel::sum('harga_perolehan');
            return (int)$getBarang;

        }else if($get == 'jumlah'){
            
            $getBarang = BarangModel::get()->count();
            return (int)$getBarang;

        }else{
            
            $getBarang = BarangModel::where('status', 'MAINTENANCE')->get()->count();
            return (int)$getBarang;

        }

    }

    static function widget_adm($get){

        if($get == 'request'){

            $getData = RequestBarangModel::whereMonth('created_at', date('m'))
                        ->whereYear('created_at', date('Y'))
                        ->get();

            return $getData->count();

        }else if($get == 'po'){
            
            $getData = PoModel::whereMonth('created_at', date('m'))
                        ->whereYear('created_at', date('Y'))
                        ->get();

            return $getData->count();

        }else if($get == 'mutasi'){
            
            $getData = MutasiModel::whereMonth('created_at', date('m'))
                        ->whereYear('created_at', date('Y'))
                        ->get();

            return $getData->count();

        }else if($get == 'maintenance'){
            
            $getData = MaintenanceModel::whereMonth('created_at', date('m'))
                        ->whereYear('created_at', date('Y'))
                        ->get();

            return $getData->count();

        }else if($get == 'pelaporan'){
            
            $getData = PelaporanModel::whereMonth('created_at', date('m'))
                        ->whereYear('created_at', date('Y'))
                        ->get();

            return $getData->count();

        }

    }

    static function widget_master($get){

        if($get == 'lokasi'){
            
            $getData = LokasiModel::get()->count();
            return $getData;

        }else if($get == 'requester'){
            
            $getData = RequesterModel::get()->count();
            return $getData;

        }else if($get == 'vendor'){
            
            $getData = VendorModel::get()->count();
            return $getData;

        }else if($get == 'kategori'){
            
            $getData = KategoriModel::get()->count();
            return $getData;

        }else if($get == 'merk'){
            
            $getData = MerkModel::get()->count();
            return $getData;

        }

    }

    static function widget_growth($get){

        if($get == 'bulan_ini'){

            $getData = BarangModel::whereMonth('created_at', date('m'))
                        ->whereYear('created_at', date('Y'))
                        ->get();

            return $getData->count();

        }else if($get == 'bulan_kemarin'){

            $getData = BarangModel::whereMonth('created_at', date('m', strtotime('-1 month')))
                        ->whereYear('created_at', date('Y', strtotime('-1 month')))
                        ->get();

            return $getData->count();

        }else if($get == 'chart'){
            $temp = array();

            for ($i=1; $i <= 12 ; $i++) { 
                
                $month = ($i < 10 ? '0' : '').$i;
                $year = date('Y');
                
                $getData = BarangModel::whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->get();

                array_push($temp, $getData->count());

            }

            return $temp;
        }

    }

    static function widget_notif_po_baru(){

        $data_po = PoModel::where('status', 'BARU')->where('id_supplier', Auth()->user()->id_supplier)->get();

        $array_notif_po_baru = array();

        foreach ($data_po as $key => $val) {
            
            $temp = array(
                'id' => $val->id,
                'created_at' => $val->created_at
            );

            array_push($array_notif_po_baru, $temp);

        }

        return $array_notif_po_baru;

    }

    static function widget_barang_kurang(){

        if(Auth()->user()->role == 'Admin'){

            $data_barang = BarangModel::all();

            $array_notif_barang = array();

            foreach ($data_barang as $key => $val) {

                $stok_akumulasi = 0;

                $getStokTerakhir = BarangStokModel::where('id_barang', $val->id)->get();
                foreach ($getStokTerakhir as $key => $value) {
                    $stok_akumulasi += $value->stok;
                }

                if($stok_akumulasi <= 10){

                    $temp = array(
                        'id' => $val->id,
                        'kode' => $val->kode_barang,
                        'nama' => $val->nama_barang,
                        'stok' => $stok_akumulasi,
                        'created_at' => $val->created_at
                    );

                    array_push($array_notif_barang, $temp);

                }

            }

            return $array_notif_barang;

        }else{
            return [];
        }

    }

}
