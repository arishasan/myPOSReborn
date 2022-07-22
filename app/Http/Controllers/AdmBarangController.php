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
use DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdmBarangController extends Controller
{
    public function __construct(){

    }

    public function index(){
        $cekAkses = HelperModel::allowedAccess('Master');

        if($cekAkses == false){
            return view('admin.parts.404');
        }

        $data = [
            'data_satuan' => SatuanModel::where('status', 1)->get(),
            'data_kategori' => KategoriModel::all(),
        ];
        return view('admin.pages.adm_barang.index')->with($data);
    }

    public function edit_index($id){
        $data = [
            'data_satuan' => SatuanModel::where('status', 1)->get(),
            'data_kategori' => KategoriModel::all(),
            'data_barang' => BarangModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.adm_barang.edit')->with($data);
    }

    public function print_index($id){
        $data = [
            'data_kategori' => KategoriModel::all(),
            'data_barang' => BarangModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.adm_barang.print')->with($data);
    }

    public function store(Request $req){

        $rules = [
            'foto' => 'max:2120', //2MB
            'kode_barang' => 'unique:tb_barang,kode_barang'
        ];

        $messages = [
            'foto.max' => 'Maksimal upload foto hanya 2MB!',
            'kode_barang.unique' => 'Kode Barang sudah ada di database! Gunakan kode yang lain.'
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }

        $slug = Str::slug($req->nama_barang, '-');

        $kode_barang = "-";
        
        $rakitKodeBarang = BarangModel::generate_kodeBarang();
        $kode_barang = $req->kode_barang;


        $url_foto = '';
        $location = public_path('/uploads/barang');

        if($req->foto){

            $imageName = 'thumb_'.$req->id_kategori.'_'.$slug.'.'.$req->foto->getClientOriginalExtension();
            $req->foto->move($location, $imageName);
            // $url_foto = asset('uploads').'/barang/'.$imageName;
            $url_foto = 'uploads/barang/'.$imageName;

        }else{
            // $url_foto = asset('assets').'/logo/noimage.png';
            $url_foto = 'assets/logo/noimage.png';
        }

        $barang = new BarangModel;
        $barang->id_kategori = $req->id_kategori;
        $barang->id_satuan = $req->id_satuan;
        $barang->photo_url = $url_foto;
        $barang->kode_barang = $kode_barang;
        $barang->nama_barang = $req->nama_barang;
        $barang->keterangan = $req->deskripsi;
        $barang->status = $req->status;
        $barang->expired_date_status = $req->is_expiracy;
        $barang->qty_min_grosir = str_replace(",", "", $req->qty_grosir);
        $barang->created_by = Auth()->user()->id;

        if($barang->save()){
            HelperModel::saveLog('barang', 'Menambahkan barang baru.', $req->all(), '', '');

            $uid = $barang->id;

            $hargaBarang = new BarangHargaModel;
            $hargaBarang->id_barang = $uid;
            $hargaBarang->harga_beli = str_replace(",", "", $req->harga_beli);
            $hargaBarang->harga_jual_eceran = str_replace(",", "", $req->harga_eceran);
            $hargaBarang->harga_jual_grosir = str_replace(",", "", $req->harga_grosir);
            $hargaBarang->created_by = Auth()->user()->id;
            $hargaBarang->save();

            $stok = str_replace(",", "", $req->stok);
            if($stok > 0){

                $aktBarang = new BarangAktivitasModel;
                $aktBarang->id_barang = $uid;
                $aktBarang->status = "Masuk";
                $aktBarang->qty = $stok;
                $aktBarang->created_by = Auth()->user()->id;
                $aktBarang->save();

            }

            $stokBarang = new BarangStokModel;
            $stokBarang->id_barang = $uid;
            $stokBarang->stok = $stok;
            $stokBarang->tgl_kadaluarsa = date('Y-m-d', strtotime($req->tgl_kadaluarsa));
            $stokBarang->created_by = Auth()->user()->id;
            $stokBarang->save();

            Session::flash('success', 'Berhasil menambahkan data barang baru!');
            return redirect()->route('adm-barang');
        }else{
            Session::flash('error', 'Gagal menambahkan data barang baru!');
            return redirect()->route('adm-barang');
        }

    }

    public function update(Request $req){

        try {
            
            $data = BarangModel::find($req->id);

            if($data){

                $kode_barang = "-";

                if($req->kode_barang == $data->kode_barang){
                    $rules = [
                        'foto' => 'max:2120', //2MB
                    ];

                    $messages = [
                        'foto.max' => 'Maksimal upload foto hanya 2MB!',
                    ];
                }else{

                    $rules = [
                        'foto' => 'max:2120', //2MB
                        'kode_barang' => 'unique:tb_barang,kode_barang'
                    ];

                    $messages = [
                        'foto.max' => 'Maksimal upload foto hanya 2MB!',
                        'kode_barang.unique' => 'Kode Barang sudah ada di database! Gunakan kode yang lain.'
                    ];

                }

                $validator = Validator::make($req->all(), $rules, $messages);

                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput($req->all());
                }

                $url_foto = '';
                $location = public_path('/uploads/barang');

                if($req->foto){

                    $str = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $req->deskripsi)));

                    $imageName = $data->created_by.'_'.str_replace('.','',$str).'_'.$data->id.'.'.$req->foto->getClientOriginalExtension();
                    $req->foto->move($location, $imageName);
                    $url_foto = asset('uploads').'/barang/'.$imageName;
                    $url_foto = 'uploads/barang/'.$imageName;

                }else{
                    $url_foto = $data->photo_url;
                }

                $barang = $data;
                $barang->kode_barang = $req->kode_barang;
                $barang->id_kategori = $req->id_kategori;
                $barang->id_satuan = $req->id_satuan;
                $barang->photo_url = $url_foto;
                $barang->nama_barang = $req->nama_barang;
                $barang->keterangan = $req->deskripsi;
                $barang->status = $req->status;
                $barang->expired_date_status = $req->is_expiracy;
                $barang->qty_min_grosir = str_replace(",", "", $req->qty_grosir);

                if($barang->save()){
                    HelperModel::saveLog('barang', 'Mengupdate data barang.', $req->all(), '', '');
                    Session::flash('success', 'Berhasil mengubah data barang!');
                    return redirect()->back();
                }else{
                    Session::flash('error', 'Gagal mengubah data barang!');
                    return redirect()->back();
                }
                
            }else{
                Session::flash('error', 'Data barang tidak ditemukan!');
                return redirect()->route('adm-barang');
            }

        } catch (Exception $e) {
            Session::flash('error', 'Data barang tidak ditemukan!');
            return redirect()->route('adm-barang');
        }

    }

    public function deleteHarga($id_harga, $id_barang){

        try {

            $getData = BarangHargaModel::find($id_harga);

            // print_r($getData);
            // exit();

            if($getData->delete()){
                HelperModel::saveLog('tb_harga_barang', 'Delete harga barang.', '', '', array('id_harga_barang' => $id_harga));
                Session::flash('success', 'Berhasil delete harga barang!');
                return redirect('master/barang/edit/'.$id_barang);
            }else{
                Session::flash('error', 'Gagal delete harga barang!');
                return redirect('master/barang/edit/'.$id_barang);
            }
            
        } catch (Exception $e) {
            Session::flash('error', 'Gagal delete harga barang!');
            return redirect('master/barang/edit/'.$id_barang);
        }

    }

    public function simpanHarga(Request $req){

        try {

            $hargaBarang = new BarangHargaModel;
            $hargaBarang->id_barang = $req->id_barang;
            $hargaBarang->harga_beli = str_replace(",", "", $req->harga_beli);
            $hargaBarang->harga_jual_eceran = str_replace(",", "", $req->harga_eceran);
            $hargaBarang->harga_jual_grosir = str_replace(",", "", $req->harga_grosir);
            $hargaBarang->created_by = Auth()->user()->id;
            
            if($hargaBarang->save()){
                HelperModel::saveLog('tb_harga_barang', 'Add harga barang.', $req->all(), '', '');
                Session::flash('success', 'Berhasil simpan data harga barang!');
                return redirect()->back();
            }else{
                Session::flash('error', 'Gagal simpan data harga barang!');
                return redirect()->back();
            }
            
        } catch (Exception $e) {
            Session::flash('error', 'Gagal simpan data harga barang!');
            return redirect()->back();
        }

    }

    public function deleteStok($id_stok, $id_barang){

        try {

            $getData = BarangStokModel::find($id_stok);

            $uid = $getData->id_barang;
            $stok = $getData->stok ?? 0;

            // print_r($getData);
            // exit();

            if($getData->delete()){

                if($stok > 0){

                    $aktBarang = new BarangAktivitasModel;
                    $aktBarang->id_barang = $uid;
                    $aktBarang->status = "Keluar";
                    $aktBarang->qty = $stok;
                    $aktBarang->created_by = Auth()->user()->id;
                    $aktBarang->save();

                }

                HelperModel::saveLog('tb_stok_barang', 'Delete stok barang.', '', '', array('id_stok_barang' => $id_stok));
                Session::flash('success', 'Berhasil delete stok barang!');
                return redirect('master/barang/edit/'.$id_barang);
            }else{
                Session::flash('error', 'Gagal delete stok barang!');
                return redirect('master/barang/edit/'.$id_barang);
            }
            
        } catch (Exception $e) {
            Session::flash('error', 'Gagal delete stok barang!');
            return redirect('master/barang/edit/'.$id_barang);
        }

    }

    public function simpanKeluarBarang(Request $req){

        try {

            $uid = $req->id_barang;
            $stok = str_replace(",", "", $req->stok);

            if($stok <= 0){
                Session::flash('error', 'Tidak ada yang diproses!');
                return redirect()->back();
            }

            $getData = BarangStokModel::find($req->id);

            // print_r($getData);
            // exit();
            if(null !== $getData){

                if($stok > $getData->stok){
                    Session::flash('error', 'QTY yang dikeluarkan melebihi stok yang tersedia.');
                    return redirect()->back();
                }else{

                    if($stok > 0){

                        $aktBarang = new BarangAktivitasModel;
                        $aktBarang->id_barang = $uid;
                        $aktBarang->status = "Keluar";
                        $aktBarang->qty = $stok;
                        $aktBarang->created_by = Auth()->user()->id;
                        $aktBarang->save();

                    }

                    $stokBarang = $getData;
                    $stokBarang->stok = $stokBarang->stok - $stok;

                    if($stokBarang->save()){
                        HelperModel::saveLog('tb_stok_barang', 'Mengeluarkan stok barang.', $req->all(), '', array('id_stok_barang' => $req->id));
                        Session::flash('success', 'Berhasil mengeluarkan stok barang!');
                        return redirect()->back();

                    }else{
                        Session::flash('error', 'Gagal mengeluarkan stok barang!');
                        return redirect()->back();
                    }

                }

            }else{

                Session::flash('error', 'Gagal mengeluarkan stok barang!');
                return redirect()->back();

            }
            
        } catch (Exception $e) {
            Session::flash('error', 'Gagal mengeluarkan stok barang!');
            return redirect()->back();
        }

    }

    public function simpanStok(Request $req){

        try {

            $uid = $req->id_barang;
            $stok = str_replace(",", "", $req->stok);
            if($stok > 0){

                $aktBarang = new BarangAktivitasModel;
                $aktBarang->id_barang = $uid;
                $aktBarang->status = "Masuk";
                $aktBarang->qty = $stok;
                $aktBarang->created_by = Auth()->user()->id;
                $aktBarang->save();

            }

            $stokBarang = null;

            if($req->is_kadaluarsa_active == 1){

                $getDataExisting = BarangStokModel::where('id_barang', $uid)
                ->where('tgl_kadaluarsa', date('Y-m-d', strtotime($req->tgl_kadaluarsa)))
                ->first();

                if(null !== $getDataExisting){

                    $stokBarang = $getDataExisting;
                    $stokBarang->stok = $stokBarang->stok + $stok;

                }else{

                    $stokBarang = new BarangStokModel;
                    $stokBarang->id_barang = $uid;
                    $stokBarang->stok = $stok;
                    $stokBarang->tgl_kadaluarsa = date('Y-m-d', strtotime($req->tgl_kadaluarsa));
                    $stokBarang->created_by = Auth()->user()->id;

                }
                

            }else{
                $stokBarang = new BarangStokModel;
                $stokBarang->id_barang = $uid;
                $stokBarang->stok = $stok;
                $stokBarang->tgl_kadaluarsa = date('Y-m-d', strtotime($req->tgl_kadaluarsa));
                $stokBarang->created_by = Auth()->user()->id;
            }
            
            if($stokBarang->save()){
                HelperModel::saveLog('tb_stok_barang', 'Add stok barang.', $req->all(), '', '');
                Session::flash('success', 'Berhasil simpan data stok barang!');
                return redirect()->back();
            }else{
                Session::flash('error', 'Gagal simpan data stok barang!');
                return redirect()->back();
            }
            
        } catch (Exception $e) {
            Session::flash('error', 'Gagal simpan data stok barang!');
            return redirect()->back();
        }

    }

    public function delete($id){
        $barang = BarangModel::where(DB::raw('md5(id)'), $id);
        if($barang->count() > 0){

            $data = $barang->first();

            if($data->photo_url != null){

                $boom = explode("/", $data->photo_url);
                $img = $boom[count($boom) - 1];

                if(strtolower($img) == 'noimage.png'){}else{

                    $location = public_path('uploads/barang/'.$img);

                    if (File::exists($location)) {
                        File::delete($location);
                    }

                }

            }

            $uid = $data->id;

            if($barang->delete()){

                BarangHargaModel::where('id_barang', $uid)->delete();
                BarangStokModel::where('id_barang', $uid)->delete();
                BarangAktivitasModel::where('id_barang', $uid)->delete();

                HelperModel::saveLog('barang', 'Menghapus data barang.', '', '', array('id' => $id));
                Session::flash('success', 'Berhasil menghapus data barang!');
            }else{
                Session::flash('error', 'Gagal menghapus data barang!');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data barang!');
        }
    }

    public function get_data(Request $req){
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

            if($req->status != 'all'){
                $data->where('status', $req->status);
            }


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
                    $detil = '<a href="javascript:;"
                                data-kode="'.$row->kode_barang.'"
                                data-deskripsi="'.$row->nama_barang.'"
                                data-id="'.md5($row->id).'" class="text-info detil_barang"><i class="fa fa-info-circle"></i></a>';

                    return '<b>'.$row->kode_barang.'</b> '.$detil;
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

                    $action = '';


                    $action = '
                            <a href="'.url("master/barang/print").'/'.md5($row->id).'" class="dropdown-item text-primary" target="_blank"><i class="fa fa-print"></i> Cetak Barcode</a>
                            <a href="'.url("master/barang/edit").'/'.md5($row->id).'" class="dropdown-item text-primary" target="_blank"><i class="fa fa-edit"></i> Edit</a>
                            <a href="javascript:;" class="dropdown-item text-primary delete_button" data-id="'.md5($row->id).'"><i class="fa fa-trash"></i> Hapus</a>';


                    $btn = '
                        <center>

                          <div class="btn-group me-1 mb-1">
                              <a href="javascript:;" class="btn btn-primary">Aksi</a>
                              <a href="#" data-bs-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="fa fa-caret-down"></i></a>
                              <div class="dropdown-menu dropdown-menu-end">
                                
                                <a href="javascript:;"
                                data-kode="'.$row->kode_barang.'"
                                data-deskripsi="'.$row->nama_barang.'"
                                data-id="'.md5($row->id).'" class="dropdown-item text-primary detil_barang"><i class="fa fa-eye"></i> Lihat Detail</a>

                                '.$action.'
                            </div>
                          </div>

                        </center>
                    ';

                    return $btn;
                })
                ->rawColumns(['action', 'foto', 'harga_jual', 'tanggal_perolehan', 'kode_barang', 'id_kategori', 'stok', 'harga_grosir', 'harga_eceran', 'status'])
                ->make(true);
        }
    }

    public function get_detail_barang($id){

        $data = [
            'data_barang' => BarangModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.adm_barang.detail')->with($data);

    }

    public function getSelect(Request $req){

        $rolenya = Auth()->user()->role;

        if(!isset($req->searchTerm)){ 

            $data = BarangModel::all();

        }else{ 
            if($req->searchTerm == ""){
                
                $data = BarangModel::all();

            }else{

                $search = $req->searchTerm;
                $data = BarangModel::where('kode_barang', 'LIKE', "%$search%")->orWhere('deskripsi', 'LIKE', "%$search%")->get();

            }
        } 

        $ret = array();

        
        foreach($data as $val){
            $ret[] = array(
                "id"    => $val->id, 
                "text"  => $val->kode_barang.' - '.$val->deskripsi);
        }
        echo json_encode($ret);

    }



}
