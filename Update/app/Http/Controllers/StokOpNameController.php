<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App\Models\BarangModel;
use App\Models\BarangAktivitasModel;
use App\Models\BarangHargaModel;
use App\Models\BarangStokModel;
use App\Models\HelperModel;
use App\Models\KategoriModel;
use App\Models\SatuanModel;
use App\Models\StokOpNameModel;
use App\Models\DetStokOpNameModel;

use DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StokOpNameController extends Controller
{
    public function __construct(){

    }

    public function index(){
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

    public function detail($id){

        $data = [
            'data_opname' => DetStokOpNameModel::where('id_stok_opname', $id)->get()
        ];
        return view('admin.pages.stok_opname.detail')->with($data);

    }

    public function delete($id){
        $opname = StokOpNameModel::where(DB::raw('md5(id)'), $id);
        if($opname->count() > 0){

            $data = $opname->first();
            $uid = $data->id;

            if($opname->delete()){

                DetStokOpNameModel::where('id_stok_opname', $uid)->delete();

                HelperModel::saveLog('tb_stok_opname', 'Menghapus data stok opname.', '', '', array('id' => $id));
                Session::flash('success', 'Berhasil menghapus data stok opname!');
            }else{
                Session::flash('error', 'Gagal menghapus data stok opname!');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data stok opname!');
        }
    }

    public function store(Request $req){

        try {

            $id_barang = $req->id_barang;

            if(!isset($id_barang)){

                Session::flash('error', 'Tidak ada yang diproses!');
                return redirect()->route('stok-opname');

            }

            $op = new StokOpNameModel;
            $op->tgl_opname = $req->tgl_opname;
            $op->created_by = Auth()->user()->id;

            if($op->save()){

                $uid = $op->id;

                $id_barang = $req->id_barang;
                $qty_system = $req->qty_system;
                $qty_real = $req->qty_real;
                $qty_varian = $req->qty_varian;
                $keterangan = $req->keterangan;

                foreach ($id_barang as $key => $value) {
                    
                    $dop = new DetStokOpNameModel;
                    $dop->id_stok_opname = $uid;
                    $dop->id_barang = $id_barang[$key];
                    $dop->jml_stok_nyata = $qty_real[$key];
                    $dop->stok_system = $qty_system[$key];
                    $dop->akumulasi = $qty_varian[$key];
                    $dop->catatan = $keterangan[$key];
                    $dop->save();

                    // NEW

                    // DELETE SEMUA DATA STOK
                    $brg = BarangStokModel::where('id_barang', $id_barang[$key]);
                    $counted = 0;
                    foreach ($brg->get() as $kkk => $vv) {
                        $counted += $vv->stok;
                    }

                    $brg->delete();

                    if($counted > 0){

                        $aktBarang = new BarangAktivitasModel;
                        $aktBarang->id_barang = $id_barang[$key];
                        $aktBarang->status = "Keluar";
                        $aktBarang->qty = $counted;
                        $aktBarang->created_by = Auth()->user()->id;
                        $aktBarang->save();

                    }

                    $stokBarang = new BarangStokModel;
                    $stokBarang->id_barang = $id_barang[$key];
                    $stokBarang->stok = $qty_real[$key];
                    $stokBarang->tgl_kadaluarsa = date('Y-m-d');
                    $stokBarang->created_by = Auth()->user()->id;
                    $stokBarang->save();


                    if($qty_real[$key] > 0){

                        $aktBarang = new BarangAktivitasModel;
                        $aktBarang->id_barang = $id_barang[$key];
                        $aktBarang->status = "Masuk";
                        $aktBarang->qty = $qty_real[$key];
                        $aktBarang->created_by = Auth()->user()->id;
                        $aktBarang->save();

                    }


                }

                HelperModel::saveLog('tb_stok_opname', 'Menambahkan data stok opname baru.', $req->all(), '', '');

                Session::flash('success', 'Berhasil menambahkan data stok opname baru!');
                return redirect()->route('stok-opname');

            }else{
                Session::flash('error', 'Gagal menambahkan data stok opname baru!');
                return redirect()->route('stok-opname');
            }
            
        } catch (Exception $e) {
            
            Session::flash('error', 'Gagal menambahkan data stok opname baru!');
            return redirect()->route('stok-opname');

        }

    }


    function get_data(Request $req){

        if($req->ajax()){

            $data = StokOpNameModel::select(DB::raw('tb_stok_opname.*, users.name as `oleh`'));
            $data->join('users', 'tb_stok_opname.created_by','=','users.id');

            $data->whereBetween(DB::raw('SUBSTR(tb_stok_opname.created_at, 1, 10)'), array($req->periode_dari, $req->periode_ke));

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('oleh', function($row){

                    $detail = '<a href="javascript:;"
                                data-kode="'.$row->oleh.'"
                                data-id="'.md5($row->id).'" class="text-info detil_transaksi"><i class="fa fa-info-circle"></i></a>';

                    return '<center>'.$row->oleh.'</center>';

                })
                ->editColumn('created_at', function($row){

                    return '<center>'.date('d M Y, H:i:s', strtotime($row->created_at)).'</center>';

                })
                ->editColumn('tgl_opname', function($row){

                    return date('d M Y', strtotime($row->tgl_opname));

                })
                ->addColumn('action', function ($row) use($req) {
                    $det = '';

                    if(Auth()->user()->role != 'Pemilik'){

                        if($req->type == 'laporan'){}else{
                            $det = '<button class="btn btn-outline-danger delete_button" data-id="'.md5($row->id).'"><i class="fa fa-trash"></i></button>';
                        }

                    }

                    $btn = '
                        <center>
                          <button class="btn btn-outline-info detail_opname" data-id="'.$row->id.'" data-kode="'.date('d M Y', strtotime($row->tgl_opname)).'"><i class="fa fa-info"></i></button>
                            '.$det.'
                        </center>
                    ';

                    return $btn;
                })
                ->rawColumns(['action', 'tgl_opname', 'status', 'created_at', 'oleh'])
                ->make(true);
        }

    }


}
