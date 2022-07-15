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
use App\Models\KeranjangModel;
use App\Models\TransaksiModel;
use App\Models\DetTransaksiModel;
use App\Models\UserModel;
use DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    public function __construct(){

    }

    public function index(){
        $cekAkses = HelperModel::allowedAccess('Transaksi');

        if($cekAkses == false){
            return view('admin.parts.404');
        }

        $data = [
            'data_satuan' => SatuanModel::where('status', 1)->get(),
            'data_kategori' => KategoriModel::all(),
        ];
        return view('admin.pages.transaksi.index')->with($data);
    }

    public function get_detail_barang($id){

        $data = BarangModel::find($id);
        if(null !== $data){

            $ret = [];

            $stok_akumulasi = 0;
            $stok_det = [];

            $getStokTerakhir = BarangStokModel::where('id_barang', $id)->get();
            foreach ($getStokTerakhir as $key => $value) {
                $stok_akumulasi += $value->stok;
                array_push($stok_det, array(
                    'id' => $value->id_stok_barang,
                    'stok' => $value->stok,
                    'tgl_kadaluarsa' => $value->tgl_kadaluarsa
                ));
            }

            $h_eceran = 0;
            $h_grosir = 0;

            $getHargaTerakhir = BarangHargaModel::where('id_barang', $id)->orderBy('id_harga_barang', 'DESC')->first();
            if(null !== $getHargaTerakhir){
                $h_grosir = $getHargaTerakhir->harga_jual_grosir;
                $h_eceran = $getHargaTerakhir->harga_jual_eceran;
            }


            $ret = array(
                'id_barang' => $data->id,
                'kode_barang' => $data->kode_barang,
                'nama_barang' => $data->nama_barang,
                'is_expire_date' => $data->expired_date_status,
                'qty_min_grosir' => $data->qty_min_grosir,
                'stok_akumulasi' => $stok_akumulasi,
                'det_stok' => $stok_det,
                'harga_eceran' => $h_eceran,
                'harga_grosir' => $h_grosir
            );

            echo json_encode($ret);

        }else{
            echo null;
        }

    }

    public function get_detail_trx($id){

        $keranjang = TransaksiModel::select(DB::raw('tb_det_transaksi.harga_satuan_barang as `det_harga`, tb_det_transaksi.id as `id_det`, tb_det_transaksi.id_stok_barang, tb_det_transaksi.qty, tb_det_transaksi.created_at as `det_trx_date`, tb_barang.*, satuan.nama as `satuan`'))
        ->join('tb_det_transaksi', 'tb_det_transaksi.id_transaksi', '=', 'tb_transaksi.id')
        ->leftJoin('tb_barang', 'tb_det_transaksi.id_barang', '=', 'tb_barang.id')
        ->leftJoin('satuan', 'tb_barang.id_satuan', '=', 'satuan.id')
        ->where(DB::raw('md5(tb_transaksi.id)'), $id)->orderBy('tb_det_transaksi.id', 'ASC')->get();

        $ret = array();

        foreach ($keranjang as $key => $row) {

            $img = '';

            if($row->photo_url == null || $row->photo_url == ""){
                $img = asset('assets').'/logo/noimage.png';
            }else{
                $img = asset('/').$row->photo_url;
            }

            $is_avail = 1;

            $hgrosir = 0;
            $heceran = 0;
            $getHargaTerakhir = BarangHargaModel::where('id_barang', $row->id)->orderBy('id_harga_barang', 'DESC')->first();
            if(null !== $getHargaTerakhir){
                $hgrosir = $getHargaTerakhir->harga_jual_grosir;
                $heceran = $getHargaTerakhir->harga_jual_eceran;
            }


            $stok_akumulasi = 0;
            $getStokTerakhir = '';
            $exp = '';

            if($row->expired_date_status == 1){
                $getStokTerakhir = BarangStokModel::where('id_barang', $row->id)->where('id_stok_barang', $row->id_stok_barang)->get();
            }else{
                $getStokTerakhir = BarangStokModel::where('id_barang', $row->id)->get();
            }

            foreach ($getStokTerakhir as $key => $value) {
                $stok_akumulasi += $value->stok;
                $exp = date('d M Y', strtotime($value->tgl_kadaluarsa));
            }

            if($row->qty > $stok_akumulasi){
                $is_avail = 0;
            }

            
            $temp = array(
                'id_det' => $row->id_det,
                'image' => $img,
                'kode_barang' => $row->kode_barang,
                'nama_barang' => $row->nama_barang,
                'satuan' => $row->satuan,
                'id_barang' => $row->id,
                'is_barang_has_expired_date' => $row->expired_date_status,
                'id_stok_barang' => $row->id_stok_barang,
                'qty_min_grosir' => $row->qty_min_grosir,
                'stok' => $stok_akumulasi,
                'qty_input' => $row->qty,
                'det_trx_date' => $row->det_trx_date,
                'harga_grosir' => $hgrosir,
                'harga_eceran' => $heceran,
                'is_avail' => $is_avail,
                'expired_date' => $exp,
                'det_harga' => $row->det_harga
            );

            array_push($ret, $temp);

        }

        // echo "<pre>";
        // print_r($ret);

        echo json_encode($ret);

    }

    public function get_keranjang(){

        $keranjang = KeranjangModel::select(DB::raw('tb_keranjang_belanja.id as `id_keranjang`, tb_keranjang_belanja.id_stok_barang, tb_keranjang_belanja.qty, tb_keranjang_belanja.created_at as `keranjang_date`, tb_barang.*, satuan.nama as `satuan`'))
        ->join('tb_barang', 'tb_keranjang_belanja.id_barang', '=', 'tb_barang.id')
        ->leftJoin('satuan', 'tb_barang.id_satuan', '=', 'satuan.id')
        ->where('tb_keranjang_belanja.created_by', Auth()->user()->id)->orderBy('tb_keranjang_belanja.id', 'ASC')->get();

        $ret = array();

        foreach ($keranjang as $key => $row) {

            $img = '';

            if($row->photo_url == null || $row->photo_url == ""){
                $img = asset('assets').'/logo/noimage.png';
            }else{
                $img = asset('/').$row->photo_url;
            }

            $is_avail = 1;

            $hgrosir = 0;
            $heceran = 0;
            $getHargaTerakhir = BarangHargaModel::where('id_barang', $row->id)->orderBy('id_harga_barang', 'DESC')->first();
            if(null !== $getHargaTerakhir){
                $hgrosir = $getHargaTerakhir->harga_jual_grosir;
                $heceran = $getHargaTerakhir->harga_jual_eceran;
            }


            $stok_akumulasi = 0;
            $getStokTerakhir = '';
            $exp = '';

            if($row->expired_date_status == 1){
                $getStokTerakhir = BarangStokModel::where('id_barang', $row->id)->where('id_stok_barang', $row->id_stok_barang)->get();
            }else{
                $getStokTerakhir = BarangStokModel::where('id_barang', $row->id)->get();
            }

            foreach ($getStokTerakhir as $key => $value) {
                $stok_akumulasi += $value->stok;
                $exp = date('d M Y', strtotime($value->tgl_kadaluarsa));
            }

            if($row->qty > $stok_akumulasi){
                $is_avail = 0;
            }

            
            $temp = array(
                'id_keranjang' => $row->id_keranjang,
                'image' => $img,
                'kode_barang' => $row->kode_barang,
                'nama_barang' => $row->nama_barang,
                'satuan' => $row->satuan,
                'id_barang' => $row->id,
                'is_barang_has_expired_date' => $row->expired_date_status,
                'id_stok_barang' => $row->id_stok_barang,
                'qty_min_grosir' => $row->qty_min_grosir,
                'stok' => $stok_akumulasi,
                'qty_input' => $row->qty,
                'keranjang_date' => $row->keranjang_date,
                'harga_grosir' => $hgrosir,
                'harga_eceran' => $heceran,
                'is_avail' => $is_avail,
                'expired_date' => $exp
            );

            array_push($ret, $temp);

        }

        // echo "<pre>";
        // print_r($ret);

        echo json_encode($ret);

    }

    public function kosongkan_detail_transaksi($id){

        $getData = DetTransaksiModel::where(DB::raw('md5(id_transaksi)'), $id);

        if($getData->count() > 0){

            foreach($getData->get() as $val){
                $item = DetTransaksiModel::find($val->id);
                $item->delete();
            }

            echo "yes";
        }else{
            echo "no";
        }

    }

    public function kosongkan_keranjang(){

        $getData = KeranjangModel::where('created_by', Auth()->user()->id);

        if($getData->count() > 0){

            foreach($getData->get() as $val){
                $item = KeranjangModel::find($val->id);
                $item->delete();
            }

            echo "yes";
        }else{
            echo "no";
        }

    }

    public function delete_det_item($id){

        $getData = DetTransaksiModel::find($id);

        if(null !== $getData){

            if($getData->delete()){
                HelperModel::saveLog('tb_det_transaksi', 'Delete item dari list detail transaksi.', '', '', array('id' => $id));
                echo "yes";
            }else{
                echo "no";
            }

        }else{
            echo 'no';
        }

    }

    public function delete_keranjang($id){

        $getData = KeranjangModel::find($id);

        if(null !== $getData){

            if($getData->delete()){
                HelperModel::saveLog('tb_keranjang_belanja', 'Delete item dari keranjang belanja.', '', '', array('id' => $id));
                echo "yes";
            }else{
                echo "no";
            }

        }else{
            echo 'no';
        }

    }

    public function add_detail($id, Request $req){

        try {
            
            // echo "<pre>";
            // print_r($req->all());

            $getData = DetTransaksiModel::where(DB::raw('id_transaksi'), $id)
            ->where('id_barang', $req->id_barang)
            ->where('id_stok_barang', $req->id_stok_barang)
            ->first();

            $hgrosir = 0;
            $heceran = 0;
            $mingrosir = 0;

            $getBarang = BarangModel::find($req->id_barang);
            if(null !== $getBarang){
                $mingrosir = $getBarang->qty_min_grosir;
            }

            $getHargaTerakhir = BarangHargaModel::where('id_barang', $req->id_barang)->orderBy('id_harga_barang', 'DESC')->first();
            if(null !== $getHargaTerakhir){
                $hgrosir = $getHargaTerakhir->harga_jual_grosir;
                $heceran = $getHargaTerakhir->harga_jual_eceran;
            }

            if(null !== $getData){

                $stok_akumulasi = 0;
                $getStokTerakhir = '';

                if($req->is_barang_has_expired_date == 1){
                    $getStokTerakhir = BarangStokModel::where('id_barang', $getData->id_barang)->where('id_stok_barang', $req->id_stok_barang)->get();
                }else{
                    $getStokTerakhir = BarangStokModel::where('id_barang', $getData->id_barang)->get();
                }

                foreach ($getStokTerakhir as $key => $value) {
                    $stok_akumulasi += $value->stok;
                }


                $qtyInput = $getData->qty + $req->qty;

                if($qtyInput > $stok_akumulasi){
                    echo "QTY (".$qtyInput.") yang diinputkan melebihi stok yang tersedia (".$stok_akumulasi.").";
                }else{

                    $getData->qty = $getData->qty + $req->qty;

                    $harga_selected = 0;

                    if(($getData->qty + $req->qty) >= $mingrosir){
                        $harga_selected = $hgrosir;
                    }else{
                        $harga_selected = $heceran;
                    }

                    $getData->harga_satuan_barang = $harga_selected;

                    if($getData->save()){
                        HelperModel::saveLog('tb_det_transaksi', 'Menambahkan item ke detail transaksi.', $req->all(), '', '');
                        echo "Berhasil menambahkan item ke detail transaksi.";
                    }else{
                        echo "Gagal menambahkan item ke detail transaksi. Silahkan ulangi lagi.";
                    }

                }




            }else{

                $keranjang = new DetTransaksiModel;
                $keranjang->id_transaksi = $id;
                $keranjang->id_barang = $req->id_barang;
                $keranjang->id_stok_barang = $req->id_stok_barang;
                $keranjang->qty = $req->qty;
                
                $harga_selected = 0;

                if($req->qty >= $mingrosir){
                    $harga_selected = $hgrosir;
                }else{
                    $harga_selected = $heceran;
                }

                $keranjang->harga_satuan_barang = $harga_selected;

                $keranjang->created_by = Auth()->user()->id;

                if($keranjang->save()){
                    HelperModel::saveLog('tb_det_transaksi', 'Menambahkan item ke detail transaksi.', $req->all(), '', '');
                    echo "Berhasil menambahkan item ke detail transaksi.";
                }else{
                    echo "Gagal menambahkan item ke detail transaksi. Silahkan ulangi lagi.";
                }

            }

        } catch (Exception $e) {
            echo 'no';
        }

    }

    public function add_keranjang(Request $req){

        try {
            
            // echo "<pre>";
            // print_r($req->all());

            $getData = KeranjangModel::where('created_by', Auth()->user()->id)
            ->where('id_barang', $req->id_barang)
            ->where('id_stok_barang', $req->id_stok_barang)
            ->first();

            if(null !== $getData){

                $stok_akumulasi = 0;
                $getStokTerakhir = '';

                if($req->is_barang_has_expired_date == 1){
                    $getStokTerakhir = BarangStokModel::where('id_barang', $getData->id_barang)->where('id_stok_barang', $req->id_stok_barang)->get();
                }else{
                    $getStokTerakhir = BarangStokModel::where('id_barang', $getData->id_barang)->get();
                }

                foreach ($getStokTerakhir as $key => $value) {
                    $stok_akumulasi += $value->stok;
                }


                $qtyInput = $getData->qty + $req->qty;

                if($qtyInput > $stok_akumulasi){
                    echo "QTY (".$qtyInput.") yang diinputkan melebihi stok yang tersedia (".$stok_akumulasi.").";
                }else{

                    $getData->qty = $getData->qty + $req->qty;

                    if($getData->save()){
                        HelperModel::saveLog('tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', $req->all(), '', '');
                        echo "Berhasil menambahkan item ke keranjang belanja.";
                    }else{
                        echo "Gagal menambahkan item ke keranjang belanja. Silahkan ulangi lagi.";
                    }

                }




            }else{

                $keranjang = new KeranjangModel;
                $keranjang->id_barang = $req->id_barang;
                $keranjang->is_barang_has_expired_date = $req->is_barang_has_expired_date;
                $keranjang->id_stok_barang = $req->id_stok_barang;
                $keranjang->qty = $req->qty;
                $keranjang->created_by = Auth()->user()->id;

                if($keranjang->save()){
                    HelperModel::saveLog('tb_keranjang_belanja', 'Menambahkan item ke keranjang belanja.', $req->all(), '', '');
                    echo "Berhasil menambahkan item ke keranjang belanja.";
                }else{
                    echo "Gagal menambahkan item ke keranjang belanja. Silahkan ulangi lagi.";
                }

            }

        } catch (Exception $e) {
            echo 'no';
        }

    }

    public function store_trx(Request $req){

        try {

            $status = 'PAID';

            if(strtolower(Auth()->user()->role) == 'pembeli'){
                $status = 'PENDING/ORDER';
            }

            $kode = TransaksiModel::generate_kodeTrx();

            $trx = new TransaksiModel;
            $trx->kode_transaksi = $kode;
            $trx->nama_pembeli = $req->nama_pembeli;
            $trx->keterangan = $req->keterangan;
            $trx->jumlah_harga = (int) str_replace(",", "", $req->cart_total);
            $trx->diskon_nominal = (int) str_replace(",", "", $req->cart_diskon);
            $trx->nominal_bayar = (int) str_replace(",", "", $req->cart_dibayarkan);
            $trx->status = $status;
            $trx->created_at = date('Y-m-d H:i:s', strtotime($req->tgl_trx));
            $trx->created_by = Auth()->user()->id;
            
            $trx->save();

            $uid = $trx->id;
            // $uid = 0;

            // echo "<pre>";

            // CALL KERANJANG
            $keranjang = KeranjangModel::select(DB::raw('tb_keranjang_belanja.id as `id_keranjang`, tb_keranjang_belanja.id_stok_barang, tb_keranjang_belanja.qty, tb_keranjang_belanja.created_at as `keranjang_date`, tb_barang.*, satuan.nama as `satuan`'))
            ->join('tb_barang', 'tb_keranjang_belanja.id_barang', '=', 'tb_barang.id')
            ->leftJoin('satuan', 'tb_barang.id_satuan', '=', 'satuan.id')
            ->where('tb_keranjang_belanja.created_by', Auth()->user()->id)->orderBy('tb_keranjang_belanja.id', 'ASC')->get();

            foreach ($keranjang as $key => $value) {

                $hgrosir = 0;
                $heceran = 0;
                $getHargaTerakhir = BarangHargaModel::where('id_barang', $value->id)->orderBy('id_harga_barang', 'DESC')->first();
                if(null !== $getHargaTerakhir){
                    $hgrosir = $getHargaTerakhir->harga_jual_grosir;
                    $heceran = $getHargaTerakhir->harga_jual_eceran;
                }

                $harga_selected = 0;

                if($value->qty >= $value->qty_min_grosir){
                    $harga_selected = $hgrosir;
                }else{
                    $harga_selected = $heceran;
                }
                
                $detail = new DetTransaksiModel;
                $detail->id_barang = $value->id;
                $detail->id_transaksi = $uid;
                $detail->id_stok_barang = $value->id_stok_barang;
                $detail->qty = $value->qty;
                $detail->harga_satuan_barang = $harga_selected;
                $detail->created_by = Auth()->user()->id;

                $detail->save();

                // DETAIL SAVE

                if($status == 'PAID'){

                    if($value->expired_date_status == 1){

                        $detStok = BarangStokModel::find($value->id_stok_barang);
                        if($detStok){
                            $detStok->stok = $detStok->stok - $value->qty;
                            $detStok->save();
                            // SAVE
                        }

                    }else{

                        $temp_stok_inp = $value->qty;
                        do {
                            
                            $getStokTerakhir = BarangStokModel::where('id_barang', $value->id)
                            ->whereRaw('stok > 0')
                            ->orderBy('created_at', 'DESC')
                            ->first();

                            // echo "STOK TERAKHIR";
                            // print_r($getStokTerakhir);
                            // echo "<hr>";

                            if(null !== $getStokTerakhir){

                                if($getStokTerakhir->stok <= $temp_stok_inp){

                                    // echo "<br/> STOK ".$getStokTerakhir->id_stok_barang.' kurang. AMBIL SEMUA.';

                                    $temp_stok_inp = $temp_stok_inp - $getStokTerakhir->stok;

                                    $getStokTerakhir->stok = 0;
                                    $getStokTerakhir->save();

                                }else{

                                    // echo "<br/> STOK ".$getStokTerakhir->id_stok_barang.' cukup. AMBIL SEBAGIAN.';

                                    $getStokTerakhir->stok = $getStokTerakhir->stok - $temp_stok_inp;
                                    $getStokTerakhir->save();

                                    $temp_stok_inp = 0;

                                }


                            }else{
                                $temp_stok_inp = 0;
                            }

                        } while ($temp_stok_inp != 0);

                    }

                    $aktBarang = new BarangAktivitasModel;
                    $aktBarang->id_barang = $value->id;
                    $aktBarang->status = "Keluar";
                    $aktBarang->qty = $value->qty;
                    $aktBarang->created_by = Auth()->user()->id;
                    $aktBarang->save();

                }

                // print_r($detail);
                // echo "<hr>";

            }

            $dKeranjang = KeranjangModel::where('created_by', Auth()->user()->id);

            if($dKeranjang->count() > 0){

                foreach($dKeranjang->get() as $val){
                    $item = KeranjangModel::find($val->id);
                    $item->delete();
                }

            }

            HelperModel::saveLog('tb_transaksi', 'Menambahkan transaksi baru.', $req->all(), '', '');

            Session::flash('success', 'Berhasil membuat transaksi!');
            return redirect()->route('transaksi');

            // print_r($req->all());

        } catch (Exception $e) {
            Session::flash('error', 'Gagal membuat transaksi!');
            return redirect()->route('transaksi');
        }

    }

    public function update_subtotal_trx($id, $sub){

        $dataTrx = TransaksiModel::find($id);
        if(null !== $dataTrx){

            $dataTrx->jumlah_harga = $sub;
            $dataTrx->save();

        }

    }

    public function update_trx(Request $req){

        try {

            $status = 'PAID';

            if(strtolower(Auth()->user()->role) == 'pembeli'){
                $status = 'PENDING/ORDER';
            }

            $trx = TransaksiModel::find($req->id_transaksi);
            $trx->nama_pembeli = $req->nama_pembeli;
            $trx->keterangan = $req->keterangan;
            $trx->jumlah_harga = (int) str_replace(",", "", $req->cart_total);
            $trx->diskon_nominal = (int) str_replace(",", "", $req->cart_diskon);
            $trx->nominal_bayar = (int) str_replace(",", "", $req->cart_dibayarkan);
            $trx->created_at = date('Y-m-d H:i:s', strtotime($req->tgl_trx));
            $trx->status = $status;
            
            $trx->save();

            $uid = $trx->id;
            // $uid = 0;

            // echo "<pre>";

            if($status == 'PAID'){

                $keranjang = TransaksiModel::select(DB::raw('tb_det_transaksi.harga_satuan_barang as `det_harga`, tb_det_transaksi.id as `id_det`, tb_det_transaksi.id_stok_barang, tb_det_transaksi.qty, tb_det_transaksi.created_at as `det_trx_date`, tb_barang.*, satuan.nama as `satuan`'))
                ->join('tb_det_transaksi', 'tb_det_transaksi.id_transaksi', '=', 'tb_transaksi.id')
                ->leftJoin('tb_barang', 'tb_det_transaksi.id_barang', '=', 'tb_barang.id')
                ->leftJoin('satuan', 'tb_barang.id_satuan', '=', 'satuan.id')
                ->where(DB::raw('tb_transaksi.id'), $req->id_transaksi)->orderBy('tb_det_transaksi.id', 'ASC')->get();

                foreach ($keranjang as $key => $value) {


                    if($value->expired_date_status == 1){

                        $detStok = BarangStokModel::find($value->id_stok_barang);
                        if($detStok){
                            $detStok->stok = $detStok->stok - $value->qty;
                            $detStok->save();
                            // SAVE
                        }

                    }else{

                        $temp_stok_inp = $value->qty;
                        do {
                            
                            $getStokTerakhir = BarangStokModel::where('id_barang', $value->id)
                            ->whereRaw('stok > 0')
                            ->orderBy('created_at', 'DESC')
                            ->first();

                            // echo "STOK TERAKHIR";
                            // print_r($getStokTerakhir);
                            // echo "<hr>";

                            if(null !== $getStokTerakhir){

                                if($getStokTerakhir->stok <= $temp_stok_inp){

                                    // echo "<br/> STOK ".$getStokTerakhir->id_stok_barang.' kurang. AMBIL SEMUA.';

                                    $temp_stok_inp = $temp_stok_inp - $getStokTerakhir->stok;

                                    $getStokTerakhir->stok = 0;
                                    $getStokTerakhir->save();

                                }else{

                                    // echo "<br/> STOK ".$getStokTerakhir->id_stok_barang.' cukup. AMBIL SEBAGIAN.';

                                    $getStokTerakhir->stok = $getStokTerakhir->stok - $temp_stok_inp;
                                    $getStokTerakhir->save();

                                    $temp_stok_inp = 0;

                                }


                            }else{
                                $temp_stok_inp = 0;
                            }

                        } while ($temp_stok_inp != 0);

                    }

                    $aktBarang = new BarangAktivitasModel;
                    $aktBarang->id_barang = $value->id;
                    $aktBarang->status = "Keluar";
                    $aktBarang->qty = $value->qty;
                    $aktBarang->created_by = Auth()->user()->id;
                    $aktBarang->save();


                }

            }

            HelperModel::saveLog('tb_transaksi', 'Update transaksi.', $req->all(), '', array('id' => $req->id_transaksi));

            Session::flash('success', 'Berhasil update transaksi!');
            return redirect()->route('transaksi');

            // print_r($req->all());

        } catch (Exception $e) {
            Session::flash('error', 'Gagal update transaksi!');
            return redirect()->route('transaksi');
        }

    }

    public function get_detail($id){

        $data = [
            'data_trx' => TransaksiModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.transaksi.detail')->with($data);

    }

    public function edit_trx($id){

        $data = [
            'data_trx' => TransaksiModel::where(DB::raw('md5(id)'), $id)->first(),
            'data_satuan' => SatuanModel::where('status', 1)->get(),
            'data_kategori' => KategoriModel::all(),
        ];
        return view('admin.pages.transaksi.edit')->with($data);

    }

    public function cetak_struk($id){

        $data = [
            'data_trx' => TransaksiModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.transaksi.cetak')->with($data);

    }
    
    public function do_void_cancel($type, $id){

        try {
            
            $stat = '';
            if($type == 'void'){
                $stat = 'VOID';
            }else{
                $stat = 'CANCEL';
            }

            $dataTrx = TransaksiModel::where(DB::raw('md5(id)'), $id)->first();
            $dataTrx->status = $stat;

            if($dataTrx->save()){

                HelperModel::saveLog('tb_transaksi', 'Update status transaksi.', array('status' => $stat), '', array('id' => $dataTrx->id));

                if($stat = 'VOID'){

                    $detTransaksi = DetTransaksiModel::where('id_transaksi', $dataTrx->id)->get();
                    foreach ($detTransaksi as $key => $value) {
                        
                        if($value->id_stok_barang == 0){

                            $stokBarang = new BarangStokModel;
                            $stokBarang->id_barang = $value->id_barang;
                            $stokBarang->stok = $value->qty;
                            $stokBarang->tgl_kadaluarsa = date('Y-m-d');
                            $stokBarang->created_by = Auth()->user()->id;
                            $stokBarang->save();

                        }else{

                            $stokBarang = BarangStokModel::find($value->id_stok_barang);
                            $stokBarang->stok = $stokBarang->stok + $value->qty;
                            $stokBarang->save();

                        }

                        if($value->qty > 0){

                            $aktBarang = new BarangAktivitasModel;
                            $aktBarang->id_barang = $value->id_barang;
                            $aktBarang->status = "Masuk";
                            $aktBarang->qty = $value->qty;
                            $aktBarang->created_by = Auth()->user()->id;
                            $aktBarang->save();

                        }

                    }

                }

                echo "yes";
            }else{
                echo "no";
            }

        } catch (Exception $e) {
            echo "no";
        }

    }

    public function delete_trx($id){
        $transaksi = TransaksiModel::where(DB::raw('md5(id)'), $id);
        if($transaksi->count() > 0){

            $data = $transaksi->first();

            DetTransaksiModel::where('id_transaksi', $data->id)->delete();

            if($transaksi->delete()){
                HelperModel::saveLog('tb_transaksi', 'Menghapus data transaksi.', '', '', array('id' => $id));
                Session::flash('success', 'Berhasil menghapus data transaksi!');
            }else{
                Session::flash('error', 'Gagal menghapus data transaksi!');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data transaksi!');
        }
    }

    public function barang_get_data(Request $req){
        if($req->ajax()){

            $data = BarangModel::select('tb_barang.*');
            $data->join('kategori', 'tb_barang.id_kategori', '=', 'kategori.id');

            if($req->kategori != 'all'){

                // select *
                // from barang
                // join lokasi on barang.id_lokasi = lokasi.id
                // where lokasi.id = 35 or lokasi.path like "/26/35/%"

                $get_kategori = KategoriModel::find($req->kategori);

                $par_id = $get_kategori->id;
                $path_id = $get_kategori->path.'/%';

                $data->where(function ($query) use ($par_id, $path_id) {
                    $query->where('kategori.id', '=', $par_id)
                          ->orWhere('kategori.path', 'LIKE', $path_id);
                });
            }

            // if($req->sumber != 'all'){
            //     $data->where('sumber_pendanaan', $req->sumber);
            // }

            // if($req->sewa != 'all'){
            //     $data->where('sewa', $req->sewa);
            // }

            if($req->satuan != 'all'){
                $data->where('id_satuan', $req->satuan);
            }

            $data->where('status', 1);


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('stok', function($row){

                    $est = 0;
                    $getStokTerakhir = BarangStokModel::where('id_barang', $row->id)->get();
                    foreach ($getStokTerakhir as $key => $value) {
                        $est += $value->stok;
                    }

                    return '<div class="text-center '.($est <= 10 ? 'text-danger' : '').'"><b>'.$est.'</b></div>';
                })
                ->addColumn('nama_satuan', function($row){

                    $getSatuan = SatuanModel::find($row->id_satuan);


                    return (null !== $getSatuan ? $getSatuan->nama : '');
                })
                ->addColumn('harga_grosir', function($row){

                    $est = 0;
                    $getHargaTerakhir = BarangHargaModel::where('id_barang', $row->id)->orderBy('id_harga_barang', 'DESC')->first();
                    if(null !== $getHargaTerakhir){
                        $est = $getHargaTerakhir->harga_jual_grosir;
                    }

                    return '<div class="text-end"><b>Rp. '.number_format($est).'</b></div>';
                })
                ->addColumn('harga_eceran', function($row){

                    $est = 0;
                    $getHargaTerakhir = BarangHargaModel::where('id_barang', $row->id)->orderBy('id_harga_barang', 'DESC')->first();
                    if(null !== $getHargaTerakhir){
                        $est = $getHargaTerakhir->harga_jual_eceran;
                    }

                    return '<div class="text-end"><b>Rp. '.number_format($est).'</b></div>';
                })
                ->editColumn('kode_barang', function($row){

                    return '<b>'.$row->kode_barang.'</b>';
                })
                ->editColumn('status', function($row){
                    return '<center><b class="'.($row->status == 1 ? 'text-success' : 'text-danger').'">'.($row->status == 1 ? 'Aktif' : 'Non-Aktif').'</b></center>';
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
                ->addColumn('action', function($row){

                    $getSatuan = SatuanModel::find($row->id_satuan);
                    $sat = (null !== $getSatuan ? $getSatuan->nama : '');

                    $btn = '
                        <center>

                          <button 
                          data-id="'.$row->id.'"
                          data-nama="'.$row->nama_barang.'"
                          data-kode="'.$row->kode_barang.'"
                          data-satuan="'.$sat.'"
                          type="button" class="btn btn-outline-primary add_cart"><i class="fa fa-cart-plus"></i></button>

                        </center>
                    ';

                    return $btn;
                })
                ->rawColumns(['action', 'foto', 'harga_jual', 'tanggal_perolehan', 'kode_barang', 'id_kategori', 'stok', 'harga_grosir', 'harga_eceran', 'status'])
                ->make(true);
        }
    }

    public function get_main_data(Request $req){

        if($req->ajax()){

            $data = TransaksiModel::select('*');

            $data->whereBetween(DB::raw('SUBSTR(created_at, 1, 10)'), array($req->periode_dari, $req->periode_ke));

            if($req->status != 'all'){
                $data->where('status', $req->status);
            }

            if(strtolower(Auth()->user()->role) == 'pembeli'){
                $data->where('created_by', Auth()->user()->id);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('kode_transaksi', function($row){

                    $detail = '<a href="javascript:;"
                                data-kode="'.$row->kode_transaksi.'"
                                data-id="'.md5($row->id).'" class="text-info detil_transaksi"><i class="fa fa-info-circle"></i></a>';

                    return '<b>'.$row->kode_transaksi.'</b> '.$detail;

                })
                ->editColumn('jumlah_harga', function($row){

                    return '<div style="text-align: right"><b>Rp. '.number_format(($row->jumlah_harga - $row->diskon_nominal)).'</b></div>';

                })
                ->editColumn('status', function($row){

                    $color = 'text-success';

                    if(strtolower($row->status) == 'paid'){

                    }else if(strtolower($row->status) == 'void' || strtolower($row->status) == 'cancel'){
                       $color = 'text-danger'; 
                    }else{
                        $color = 'text-primary';
                    }

                    return '<center><b class="'.$color.'">'.$row->status.'</b></center>';

                })
                ->editColumn('created_at', function($row){

                    return '<center>'.date('d M Y, H:i:s', strtotime($row->created_at)).'</center>';

                })
                ->addColumn('action', function($row){

                    $action = '';

                    if(Auth()->user()->role == 'Pembeli'){

                        if($row->status == 'PENDING/ORDER'){
                            $action = '
                            <a href="'.url("transaksi/edit").'/'.md5($row->id).'" class="dropdown-item text-primary" target="_blank"><i class="fa fa-edit"></i> Edit</a>
                            <a href="javascript:;" class="dropdown-item text-primary delete_button" data-id="'.md5($row->id).'"><i class="fa fa-trash"></i> Hapus</a>';
                        }

                    }else{

                        if($row->status == 'PENDING/ORDER'){
                            $action = '
                            <a href="'.url("transaksi/edit").'/'.md5($row->id).'" class="dropdown-item text-primary" target="_blank"><i class="fa fa-edit"></i> Proses</a>';
                        }

                        if($row->status != 'PAID'){
                            $action .= '
                            <a href="javascript:;" class="dropdown-item text-primary delete_button" data-id="'.md5($row->id).'"><i class="fa fa-trash"></i> Hapus</a>';
                        }

                    }

                    $btn = '
                        <center>

                          <div class="btn-group me-1 mb-1">
                              <a href="javascript:;" class="btn btn-primary">Aksi</a>
                              <a href="#" data-bs-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="fa fa-caret-down"></i></a>
                              <div class="dropdown-menu dropdown-menu-end">

                                <a href="javascript:;"
                                data-kode="'.$row->kode_transaksi.'"
                                data-id="'.md5($row->id).'" class="dropdown-item text-primary detil_transaksi"><i class="fa fa-eye"></i> Lihat Detail</a>

                                '.$action.'
                            </div>
                          </div>

                        </center>
                    ';

                    return $btn;
                })
                ->rawColumns(['action', 'jumlah_harga', 'status', 'created_at', 'kode_transaksi'])
                ->make(true);
        }

    }

}
