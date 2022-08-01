<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App\Models\BarangModel;
use App\Models\HelperModel;
use App\Models\SupplierModel;
use App\Models\PoModel;
use App\Models\BarangStokModel;
use App\Models\BarangAktivitasModel;
// use App\Models\PengaturanSuratModel;
use App\Models\DetPoModel;
use DataTables;
use Illuminate\Support\Facades\DB;
use PDF;

class TrxPoController extends Controller
{
    
    public function __construct(){

    }

    public function index(){
        $cekAkses = HelperModel::allowedAccess('PO');

        if($cekAkses == false){
            return view('admin.parts.404');
        }

        $data = [
            'data_supplier' => SupplierModel::all(),
            'data_barang' => BarangModel::select(DB::raw('tb_barang.*, satuan.nama as `nama_satuan`'))->join('satuan', 'tb_barang.id_satuan', '=', 'satuan.id')->get()
        ];

        return view('admin.pages.adm_po.index')->with($data);
    }

    public function detail_index($id){
        $dPo = PoModel::where(DB::raw('md5(id)'), $id);
        if($dPo->count() > 0){
            $data = [
                'data_po' => $dPo->first(),
                'data_detail_po' => DetPoModel::where('id_po', $dPo->first()->id)
            ];

            return view('admin.pages.adm_po.detail')->with($data);
        }else{
            echo "<center>Data Tidak Ada!</center>";
        }
    }

    public function edit_index($id){
        $dPo = PoModel::where(DB::raw('md5(id)'), $id);
        if($dPo->count() > 0){
            $data = [
                'data_po' => $dPo->first(),
                'data_detail_po' => DetPoModel::where('id_po', $dPo->first()->id),
                'data_supplier' => SupplierModel::get(),
                'data_barang' => BarangModel::select(DB::raw('tb_barang.*, satuan.nama as `nama_satuan`'))->join('satuan', 'tb_barang.id_satuan', '=', 'satuan.id')->get()
            ];

            return view('admin.pages.adm_po.edit')->with($data);
        }else{
            Session::flash('error', 'Data tidak ada!');
            return redirect()->route('transaksi-po');
        }
    }

    public function detail_delete($id){
        $detPO = DetPoModel::where(DB::raw('md5(id)'), $id);
        if($detPO->count() > 0){

            $data = $detPO->first();

            if($detPO->delete()){
                HelperModel::saveLog('tb_det_po', 'Menghapus data item PO.', '', '', array('id' => $id));
                Session::flash('success', 'Berhasil menghapus data item PO!');
            }else{
                Session::flash('error', 'Gagal menghapus data item PO!');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data item PO!');
        }
    }

    public function add_item(Request $req){

        try {

            if($req->qty_item <= 0){
                Session::flash('error', 'QTY tidak boleh minus atau kosong!');
                return redirect("transaksi/po/edit".'/'.md5($req->id_po));
            }

            $cekItem = DetPoModel::where('id_barang', $req->id_barang)->where('id_po', $req->id_po)->first();

            if(null !== $cekItem){

                $dataItem = $cekItem;
                $dataItem->qty_dipesan = $dataItem->qty_dipesan + $req->qty_item;

            }else{

                $dBarang = BarangModel::find($req->id_barang);
                $is_exp = 0;

                if(null !== $dBarang){
                    $is_exp = $dBarang->expired_date_status;
                }

                $dataItem = new DetPoModel;
                $dataItem->id_po = $req->id_po;
                $dataItem->id_barang = $req->id_barang;
                $dataItem->qty_dipesan = $req->qty_item;
                $dataItem->harga_satuan = 0;
                $dataItem->exp_date = date('Y-m-d');
                $dataItem->created_by = Auth()->user()->id;
                $dataItem->is_exp_date = $is_exp;

            }

            if($dataItem->save()){
                Session::flash('success', 'Berhasil menambahkan data item PO!');
                return redirect("transaksi/po/edit".'/'.md5($req->id_po));
            }else{
                Session::flash('error', 'Gagal menambahkan data item PO!');
                return redirect("transaksi/po/edit".'/'.md5($req->id_po));
            }
            
        } catch (Exception $e) {
            
            Session::flash('error', 'Gagal menambahkan data item PO!');
            return redirect("transaksi/po/edit".'/'.md5($req->id_po));

        }

    }

    public function store(Request $req){

        $noOtomatis = PoModel::nomor_otomatis();

        // echo "<pre>";
        // echo $noOtomatis;
        // print_r($req->all());
        // exit();

        $po = new PoModel;
        $po->kode_po = $noOtomatis;
        $po->id_supplier = $req->id_vendor;
        $po->tgl_po = date('Y-m-d', strtotime($req->tanggal_po));
        $po->catatan_admin = $req->catatan;
        $po->status = 'BARU';
        $po->created_by = Auth()->user()->id;

        if($po->save()){

            $lastID = $po->id;

            $detID = $req->id_barang;
            $qty = $req->qty;

            if(isset($detID)){

                foreach($detID as $key => $dd){

                    $dBarang = BarangModel::find($detID[$key]);
                    $is_exp = 0;

                    if(null !== $dBarang){
                        $is_exp = $dBarang->expired_date_status;
                    }

                    $dpo = new DetPoModel;
                    $dpo->id_po = $lastID;
                    $dpo->id_barang = $detID[$key];
                    $dpo->qty_dipesan = $qty[$key];
                    $dpo->harga_satuan = 0;
                    $dpo->exp_date = date('Y-m-d');
                    $dpo->created_by = Auth()->user()->id;
                    $dpo->is_exp_date = $is_exp;
                    $dpo->save();
                }

            }

            HelperModel::saveLog('tb_po', 'Menambahkan PO baru.', $req->all(), '', '');

            Session::flash('success', 'Berhasil menambahkan data PO baru!');
            return redirect()->route('transaksi-po');
        }else{
            Session::flash('error', 'Gagal menambahkan data PO baru!');
            return redirect()->route('transaksi-po');
        }

    }

    public function po_selesai(Request $req){

        $data = PoModel::find($req->po_id);
        if($data){

            $po = $data;
            $po->status = 'SELESAI';
            if($po->save()){

                HelperModel::saveLog('tb_po', 'Mengupdate status PO.', array('status' => 'SELESAI'), '', array('id' => 'id'));

                $id_det_po = $req->id_det_po;
                $qty = $req->qty;

                foreach ($id_det_po as $key => $value) {
                    
                    $detPO = DetPoModel::find($value);
                    if($detPO){
                        $detPO->quantity = $qty[$key];
                        $detPO->quantity_tersedia = $qty[$key];
                        $detPO->save();
                    }

                }

                Session::flash('success', 'Berhasil menyimpan perubahan!');
                return redirect()->route('transaksi-po');

            }else{
                Session::flash('error', 'Gagal menyimpan perubahan!');
                return redirect()->route('transaksi-po');
            }

        }else{
            Session::flash('error', 'Data PO tidak ada!');
            return redirect()->route('transaksi-po');
        }

    }

    public function update(Request $req){

        $data = PoModel::find($req->id);

        if($data){

            $po = $data;
            $po->id_supplier = $req->id_supplier;
            $po->tgl_po = date('Y-m-d', strtotime($req->tanggal_po));
            $po->catatan_admin = $req->catatan;
            $po->catatan_supplier = $req->catatan_supplier;
            
            if($po->save()){

                HelperModel::saveLog('tb_po', 'Mengupdate PO.', $req->all(), '', '');
                Session::flash('success', 'Berhasil mengubah data PO!');
                return redirect()->back();
            }else{
                Session::flash('error', 'Gagal mengubah data PO!');
                return redirect()->back();
            }
        }else{
            Session::flash('error', 'Data tidak ada!');
            return redirect()->route('transaksi-po');
        }

    }

    public function delete($id){
        $po = PoModel::where(DB::raw('md5(id)'), $id);
        if($po->count() > 0){

            $data = $po->first();

            if($po->delete()){

                $detPO = DetPoModel::where(DB::raw('md5(id_po)'), $id);
                $detPO->delete();

                HelperModel::saveLog('tb_po', 'Menghapus data PO.', '', '', array('id' => $id));
                Session::flash('success', 'Berhasil menghapus data PO!');
            }else{
                Session::flash('error', 'Gagal menghapus data PO!');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data PO!');
        }
    }

    public function cetak_surat($id){

        $po = PoModel::where(DB::raw('md5(id)'), $id);
        if($po->count() > 0){

            $data = [
                'data_po' => $po->first(),
                'data_detail_po' => DetPoModel::where('id_po', $po->first()->id),
                'data_supplier' => SupplierModel::find($po->first()->id_supplier),
            ];

            $pdf = PDF::loadview('admin.pages.adm_po.pdf', $data)->setPaper('A4','potrait');
            return $pdf->stream();

        }else{
            echo "Tidak ada data PO!";
        }

    }

    public function proses_lanjut(Request $req){

        try {
            
            // echo "<pre>";
            // print_r($req->all());

            $getPO = PoModel::find($req->id);
            if(isset($req->catatan_supplier)){
                $getPO->catatan_supplier = $req->catatan_supplier;
            }

            if(isset($req->catatan_retur)){
                $getPO->catatan_retur = $req->catatan_retur;
            }

            $stat = '';

            if($req->status == 'SELESAI'){

                if($req->apakah_sesuai == '1'){
                    $stat = 'SELESAI';
                }else{
                    $stat = 'RETUR';
                }

            }else if($req->status == 'RETUR'){
                $stat = 'RETUR SELESAI';
            }else{
                $stat = $req->status;
            }

            $getPO->status = $stat;
            $getPO->save();

            $id_det = $req->id_det;
            $harga_satuan = $req->harga_satuan;
            $qty_tersedia = $req->qty_tersedia;
            $tgl_kadaluarsa = $req->tgl_kadaluarsa;

            foreach ($id_det as $key => $value) {
                
                if($req->status == 'SELESAI'){

                    if($req->apakah_sesuai == '1'){

                        $getDetPo = DetPoModel::find($id_det[$key]);
                        if(null !== $getDetPo){

                            $dBarang = BarangModel::find($getDetPo->id_barang);

                            if(null !== $dBarang){

                                // if($dBarang->expired_date_status == 0){

                                    $stokBarang = new BarangStokModel;
                                    $stokBarang->id_barang = $dBarang->id;
                                    $stokBarang->stok = $getDetPo->qty_tersedia;
                                    $stokBarang->tgl_kadaluarsa = date('Y-m-d');
                                    $stokBarang->created_by = Auth()->user()->id;
                                    $stokBarang->save();

                                // }else{

                                //     $stokBarang = BarangStokModel::where('id_barang', $dBarang->id)
                                //     ->where('tgl_kadaluarsa', $getDetPo->exp_date)->first();

                                //     if(null !== $stokBarang){
                                //         $stokBarang->stok = $stokBarang->stok + $getDetPo->qty_tersedia;
                                //         $stokBarang->save();
                                //     }else{

                                //         $stokBarang = new BarangStokModel;
                                //         $stokBarang->id_barang = $dBarang->id;
                                //         $stokBarang->stok = $getDetPo->qty_tersedia;
                                //         $stokBarang->tgl_kadaluarsa = date('Y-m-d', strtotime($getDetPo->exp_date));
                                //         $stokBarang->created_by = Auth()->user()->id;
                                //         $stokBarang->save();

                                //     }

                                // }

                                if($getDetPo->qty_tersedia > 0){

                                    $aktBarang = new BarangAktivitasModel;
                                    $aktBarang->id_barang = $dBarang->id;
                                    $aktBarang->status = "Masuk";
                                    $aktBarang->qty = $getDetPo->qty_tersedia;
                                    $aktBarang->created_by = Auth()->user()->id;
                                    $aktBarang->save();

                                }

                            }

                        }

                    }else{

                        $getDetPo = DetPoModel::find($id_det[$key]);
                        $getDetPo->qty_retur = $qty_tersedia[$key];
                        $getDetPo->save();

                    }


                }else if($req->status == 'RETUR'){

                    $getDetPo = DetPoModel::find($id_det[$key]);
                    $getDetPo->qty_retur = $qty_tersedia[$key];
                    $getDetPo->save();

                    if(null !== $getDetPo){

                        $dBarang = BarangModel::find($getDetPo->id_barang);

                        if(null !== $dBarang){

                            $stokBarang = new BarangStokModel;
                            $stokBarang->id_barang = $dBarang->id;
                            $stokBarang->stok = ($getDetPo->qty_tersedia - $getDetPo->qty_retur);
                            $stokBarang->tgl_kadaluarsa = date('Y-m-d');
                            $stokBarang->created_by = Auth()->user()->id;
                            $stokBarang->save();

                            if(($getDetPo->qty_tersedia - $getDetPo->qty_retur) > 0){

                                $aktBarang = new BarangAktivitasModel;
                                $aktBarang->id_barang = $dBarang->id;
                                $aktBarang->status = "Masuk";
                                $aktBarang->qty = ($getDetPo->qty_tersedia - $getDetPo->qty_retur);
                                $aktBarang->created_by = Auth()->user()->id;
                                $aktBarang->save();

                            }

                        }

                        // if(null !== $dBarang){

                        //     if($dBarang->expired_date_status == 0){

                        //         $temp_stok_inp = $getDetPo->qty_retur;
                        //         do {
                                    
                        //             $getStokTerakhir = BarangStokModel::where('id_barang', $dBarang->id)
                        //             ->whereRaw('stok > 0')
                        //             ->orderBy('created_at', 'DESC')
                        //             ->first();

                        //             if(null !== $getStokTerakhir){

                        //                 if($getStokTerakhir->stok <= $temp_stok_inp){

                        //                     $temp_stok_inp = $temp_stok_inp - $getStokTerakhir->stok;

                        //                     $getStokTerakhir->stok = 0;
                        //                     $getStokTerakhir->save();

                        //                 }else{

                        //                     $getStokTerakhir->stok = $getStokTerakhir->stok - $temp_stok_inp;
                        //                     $getStokTerakhir->save();

                        //                     $temp_stok_inp = 0;

                        //                 }


                        //             }else{
                        //                 $temp_stok_inp = 0;
                        //             }

                        //         } while ($temp_stok_inp != 0);

                        //     }else{

                        //         $stokBarang = BarangStokModel::where('id_barang', $dBarang->id)
                        //         ->where('tgl_kadaluarsa', $getDetPo->exp_date)->first();

                        //         if(null !== $stokBarang){
                        //             $stokBarang->stok = $stokBarang->stok - $getDetPo->qty_retur;
                        //             $stokBarang->save();
                        //         }

                        //     }

                        //     if($getDetPo->qty_retur > 0){

                        //         $aktBarang = new BarangAktivitasModel;
                        //         $aktBarang->id_barang = $dBarang->id;
                        //         $aktBarang->status = "Keluar";
                        //         $aktBarang->qty = $getDetPo->qty_retur;
                        //         $aktBarang->created_by = Auth()->user()->id;
                        //         $aktBarang->save();

                        //     }

                        // }

                    }



                }else{

                    $getDetPo = DetPoModel::find($id_det[$key]);
                    $getDetPo->harga_satuan = $harga_satuan[$key] == null || $harga_satuan[$key] == '' ? 0 : (int) str_replace(",", "", $harga_satuan[$key]);
                    $getDetPo->qty_tersedia = $qty_tersedia[$key];
                    $getDetPo->exp_date = $tgl_kadaluarsa[$key];
                    $getDetPo->save();

                }

            }

            HelperModel::saveLog('tb_po', 'Memproses permintaan barang dengan status '.$stat, $req->all(), '', '');

            Session::flash('success', 'Berhasil memproses data PO!');
            return redirect()->route('transaksi-po');

        } catch (Exception $e) {

            Session::flash('error', 'Gagal memproses data PO!');
            return redirect()->route('transaksi-po');
            
        }

    }

    public function lanjut_po($stat, $id){

        $status = '';

        if($stat == 'PROSES'){
            $status = 'DIPROSES';
        }else if($stat == 'TERIMA_BARANG'){
            $status = 'SELESAI';
        }else if($stat == 'RETUR'){
            $status = 'RETUR';
        }else{
            Session::flash('error', 'Tidak ada yang diproses!');
            return redirect()->route('transaksi-po');
        }

        $po = PoModel::where(DB::raw('md5(id)'), $id);

        if($po->count() > 0){
            $data = [
                'data_po' => $po->first(),
                'status' => $status,
                'data_detail_po' => DetPoModel::where('id_po', $po->first()->id)
            ];

            return view('admin.pages.adm_po.proses')->with($data);
        }else{

            Session::flash('error', 'Tidak ada yang diproses!');
            return redirect()->route('transaksi-po');

        }

    }

    public function get_data(Request $req){

        if($req->ajax()){

            $inp_status = $req->status;
            $inp_from = date('Y-m-d', strtotime($req->from));
            $inp_to = date('Y-m-d', strtotime($req->to));

            $data = PoModel::leftJoin('supplier', 'supplier.id', '=', 'tb_po.id_supplier');
            $data->leftJoin('users', 'users.id', '=', 'tb_po.created_by');
            $data->select(DB::raw('tb_po.*, supplier.nama as `nama_supplier`'));

            if($inp_status != 'all'){
                $data->where('tb_po.status', '=' , $inp_status);
            }

            $data->whereBetween('tb_po.tgl_po', [$inp_from , $inp_to]);

            if(Auth()->user()->role == 'Supplier'){
                $data->where('tb_po.id_supplier', Auth()->user()->id_supplier);
            }

            $data->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('kode_po', function($row){
                    $btn = '<a href="javascript:;" data-id="'.md5($row->id).'" data-nopo="'.$row->kode_po.'" class="text-primary detil_po"><i class="fa fa-info-circle"></i></a>';
                    return '<b>'.$row->kode_po.'</b> '.$btn;
                })
                ->editColumn('tgl_po', function($row){
                    return '<center>'.date('d M Y', strtotime($row->tgl_po)).'</center>';
                })
                ->editColumn('status', function($row) use ($req){
                    $btn = '';
                    if(Auth()->user()->role == 'Supplier' && $row->status == 'BARU'){
                        $btn = '<br/><a href="'.url('transaksi/po/lanjut/PROSES').'/'.md5($row->id).'" target="_blank" class="form-control btn btn-outline-success">PROSES <i class="fa fa-arrow-right"></i></a>';
                    }else if(Auth()->user()->role == 'Admin' && $row->status == 'DIPROSES'){
                        $btn = '<br/><a href="'.url('transaksi/po/lanjut/TERIMA_BARANG').'/'.md5($row->id).'" target="_blank" class="form-control btn btn-outline-primary">TERIMA BARANG <i class="fa fa-arrow-right"></i></a>';
                    }else if(Auth()->user()->role == 'Supplier' && $row->status == 'RETUR'){
                        $btn = '<br/><a href="'.url('transaksi/po/lanjut/RETUR').'/'.md5($row->id).'" target="_blank" class="form-control btn btn-outline-danger"><i class="fa fa-arrow-left"></i> KONFIRMASI RETUR</a>';
                    }

                    if($req->type == 'laporan'){
                        $btn = '';
                    }

                    return '<center><b class="text-primary">'.$row->status.'</b> <br/> '.$btn.'</center>';
                })
                ->addColumn('action', function($row) use($req){
                    $push = '';

                    $tombolCetak = '<a href="'.url("transaksi/po/cetak_surat").'/'.md5($row->id).'" target="_blank" class="dropdown-item text-primary"><i class="fa fa-print"></i> Cetak Surat</a>';
                    $tombolDetail = '<a href="javascript:;" data-id="'.md5($row->id).'" data-nopo="'.$row->kode_po.'" class="dropdown-item text-primary detil_po"><i class="fa fa-eye"></i> Lihat Detail</a>';
                    $tombolEdit = '<a href="'.url("transaksi/po/edit").'/'.md5($row->id).'" class="dropdown-item text-primary"><i class="fa fa-edit"></i> Edit</a>';
                    $tombolHapus = '<a href="javascript:;" class="dropdown-item text-primary delete_button" data-id="'.md5($row->id).'"><i class="fa fa-trash"></i> Hapus</a>';

                    if($row->status == 'BARU'){
                    }else if($row->status == 'DIPROSES'){
                        $tombolEdit = '';
                        $tombolHapus = '';
                    }else if($row->status == 'SELESAI'){
                        $tombolEdit = '';
                        $tombolCetak = '';
                        $tombolHapus = '';
                    }else if($row->status == 'RETUR' || $row->status == 'RETUR SELESAI'){
                        $tombolCetak = '';
                        $tombolEdit = '';
                        $tombolHapus = '';
                    }

                    if(Auth()->user()->role != 'Admin'){
                        $tombolEdit = '';
                        $tombolHapus = '';
                    }

                    if(Auth()->user()->role == 'Pemilik'){
                        $push = $tombolDetail;
                    }else{
                        $push = $tombolCetak.$tombolDetail.$tombolEdit.$tombolHapus;
                    }

                    if($req->type == 'laporan'){
                        $btn = '
                        <center>
                            <a href="javascript:;" data-id="'.md5($row->id).'" data-nopo="'.$row->kode_po.'" class="btn btn-outline-primary detil_po"><i class="fa fa-eye"></i> Lihat Detail</a>
                        </center>
                        ';
                    }else{

                        $btn = '
                            <center>

                              <div class="btn-group me-1 mb-1">
                                  <a href="javascript:;" class="btn btn-primary">Aksi</a>
                                  <a href="#" data-bs-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="fa fa-caret-down"></i></a>
                                  <div class="dropdown-menu dropdown-menu-end">
                                    '.$push.'
                                </div>
                              </div>

                            </center>
                        ';

                    }

                    return $btn;
                })
                ->rawColumns(['action', 'kode_po', 'tgl_po', 'status'])
                ->make(true);
        }

    }

}
