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
use App\Models\DetTransaksiModel;
use App\Models\PoModel;
use App\Models\LaporanModel;
use App\Models\AksesModel;
use App\Models\SatuanModel;
use App\Models\StokOpNameModel;
use App\Models\DetStokOpNameModel;
use App\Models\SupplierModel;
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

    public function index_opname(){
        $cekAkses = HelperModel::allowedAccess('Laporan');

        if($cekAkses == false){
            return view('admin.parts.404');
        }

        $data = [
            'data_op' => StokOpNameModel::select(DB::raw('tb_stok_opname.*, users.name'))->leftJoin('users', 'users.id','=','tb_stok_opname.created_by')->get(),
            'data_barang' => BarangModel::select(DB::raw('tb_barang.*, satuan.nama as `nama_satuan`'))->join('satuan', 'tb_barang.id_satuan', '=', 'satuan.id')->get()
        ];
        return view('admin.pages.stok_opname.index')->with($data);
    }

    public function index_po(){
        $cekAkses = HelperModel::allowedAccess('Laporan');

        if($cekAkses == false){
            return view('admin.parts.404');
        }

        $data = [
            'data_supplier' => SupplierModel::all(),
            'data_barang' => BarangModel::select(DB::raw('tb_barang.*, satuan.nama as `nama_satuan`'))->join('satuan', 'tb_barang.id_satuan', '=', 'satuan.id')->get()
        ];

        return view('admin.pages.adm_po.index')->with($data);
    }

    public function get_list_transaksi(Request $req){

        $ret = DB::select(DB::raw("SELECT tb_transaksi.kode_transaksi, tb_transaksi.nama_pembeli, (tb_transaksi.jumlah_harga - tb_transaksi.diskon_nominal) as `tot_harga`, tb_transaksi.created_at, tb_barang.kode_barang, tb_barang.nama_barang, tb_det_transaksi.harga_satuan_barang, tb_det_transaksi.qty, (tb_det_transaksi.harga_satuan_barang * tb_det_transaksi.qty) as `jml_harga` FROM tb_transaksi LEFT JOIN tb_det_transaksi ON(tb_transaksi.id = tb_det_transaksi.id_transaksi) LEFT JOIN tb_barang ON(tb_barang.id = tb_det_transaksi.id_barang) WHERE tb_transaksi.status = 'PAID' AND tb_det_transaksi.id_barang = ".$req->id." AND SUBSTR(tb_transaksi.created_at, 1, 10) BETWEEN '".$req->periode_dari."' AND '".$req->periode_ke."'"));

        $ret = json_decode(json_encode($ret), true);

        $data = [
            'ret' => $ret
        ];

        return view('admin.pages.laporan.detail_transaksi')->with($data);

    }

    public function get_penjualan(Request $req){
        if($req->ajax()){

            $data = BarangModel::select('tb_barang.*');

            if($req->kategori != 'all'){

                $arr = explode(",", $req->kategori);
                $data->whereIn('id_kategori', $arr);
                
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('kode_barang', function($row){
                    $btn = '<button type="button" class="btn btn-outline-primary form-control btn_detail" data-id="'.$row->id.'" data-nama="'.$row->kode_barang.' - '.$row->nama_barang.'"><i class="fa fa-eye"></i> Detail Transaksi</button>';
                    return '<b>'.$row->kode_barang.'</b> <br/><br/> '.$btn;
                })
                ->editColumn('id_kategori', function($row){
                    
                    try {
                        $getKategori = KategoriModel::findOrFail($row->id_kategori);

                        if($getKategori){
                            $data = $getKategori;
                            $retKategori = KategoriModel::getParentName($data->parent).' - <b>'.$data->nama.'</b>';
                            return $retKategori;
                        }else{
                            return '<label>-</label>';
                        }
                    } catch (Exception $e) {
                        return '<label>-</label>';
                    }

                })
                ->addColumn('foto', function($row){

                    $img = '';

                    if($row->photo_url == null || $row->photo_url == ""){
                        $img = asset('assets').'/logo/noimage.png';
                    }else{
                        $img = asset('/').$row->photo_url;
                    }

                    $btn = '
                        <center>

                          <a href="'.$img.'" target="_blank"><img style="width:100px;max-height:100px;" alt="NONE" src="'.$img.'" /></a>

                        </center>
                    ';

                    return $btn;
                })
                ->addColumn('jml_terjual', function($row) use($req){

                    $getSatuan = SatuanModel::find($row->id_satuan);

                    $jml_terjual = 0;

                    $getBarangTerjual = DB::select(DB::raw("SELECT tb_det_transaksi.id_barang, SUBSTR(tb_transaksi.created_at, 1, 10) as `tgl_trx`, SUM((tb_det_transaksi.harga_satuan_barang * tb_det_transaksi.qty)) as `nominal`, SUM(tb_det_transaksi.qty) as `qty_terjual` FROM tb_transaksi LEFT JOIN tb_det_transaksi ON(tb_transaksi.id = tb_det_transaksi.id_transaksi) LEFT JOIN tb_barang ON(tb_det_transaksi.id_barang = tb_barang.id) WHERE tb_transaksi.status = 'PAID' AND tb_det_transaksi.id_barang = ".$row->id." AND SUBSTR(tb_transaksi.created_at, 1, 10) BETWEEN '".$req->periode_dari."' AND '".$req->periode_ke."' GROUP BY tb_det_transaksi.id_barang, tgl_trx
                        "));

                    $getBarangTerjual = json_decode(json_encode($getBarangTerjual), true);

                    if(null !== $getBarangTerjual){
                        foreach ($getBarangTerjual as $key => $value) {
                            $jml_terjual += $value['qty_terjual'];
                        }
                    }

                    return '<b><center>'.$jml_terjual.'</b> '.(null !== $getSatuan ? $getSatuan->nama : '').'</center>';
                })
                ->addColumn('nominal_terjual', function($row) use($req){

                    $nominal_terjual = 0;

                    $getBarangTerjual = DB::select(DB::raw("SELECT tb_det_transaksi.id_barang, SUBSTR(tb_transaksi.created_at, 1, 10) as `tgl_trx`, SUM((tb_det_transaksi.harga_satuan_barang * tb_det_transaksi.qty)) as `nominal`, SUM(tb_det_transaksi.qty) as `qty_terjual` FROM tb_transaksi LEFT JOIN tb_det_transaksi ON(tb_transaksi.id = tb_det_transaksi.id_transaksi) LEFT JOIN tb_barang ON(tb_det_transaksi.id_barang = tb_barang.id) WHERE tb_transaksi.status = 'PAID' AND tb_det_transaksi.id_barang = ".$row->id." AND SUBSTR(tb_transaksi.created_at, 1, 10) BETWEEN '".$req->periode_dari."' AND '".$req->periode_ke."' GROUP BY tb_det_transaksi.id_barang, tgl_trx
                        "));

                    $getBarangTerjual = json_decode(json_encode($getBarangTerjual), true);

                    if(null !== $getBarangTerjual){
                        foreach ($getBarangTerjual as $key => $value) {
                            $nominal_terjual += $value['nominal'];
                        }
                    }

                    return '<div style="text-align: right"><b>Rp. <label class="jml_terjual">'.number_format($nominal_terjual).'</label></b></div>';
                })
                ->rawColumns(['action', 'foto','kode_barang', 'id_kategori', 'jml_terjual', 'nominal_terjual'])
                ->make(true);
        }
    }


}
