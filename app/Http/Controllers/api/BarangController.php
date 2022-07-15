<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use App\Models\LokasiModel;
use App\Models\KategoriModel;
use App\Models\HelperApiModel;
use App\Models\AksesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }
    
    public function index()
    {
        $barangs = Barang::where('id', '2')->first();
        // $barangs = Barang::all();

        return response()->json([
            'success' => true,
            'message' =>'List Semua Barang',
            'data'    => $barangs
        ], 200);
    }

    public function dashboard(Request $request)
    {
        $s = HelperApiModel::arrayAksesThisUser();
        $cekAkses = HelperApiModel::allowedAccess(4, 0);

        if ($cekAkses==false) {
            return response()->json([
                'success' => false,
                'message' =>'Unauthorized access',
            ], 200);
        }

        $user = Auth::user();

        $json_decode = json_decode($user, true);

        $user_id = $json_decode['user_id'];

        $akses = AksesModel::select('akses_wilayah')->where('user_id', $user_id)->first();

        $json = json_decode($akses['akses_wilayah'], true);

        $akses_wilayah = array();

        $i=0;
        foreach ($json as $wilayah) {
            if ($wilayah['enable']=="1") {
                $akses_wilayah[$i]['nama'] = $wilayah['name'] ;
                $akses_wilayah[$i]['id'] = $wilayah['id'] ;
                $i++;
            }
        }

        $num_akses_wilayah = count($akses_wilayah);
        if ($num_akses_wilayah==0) {
            $akses_wilayah = [];
            $default_nama_wilayah = "";
            $data = [];
        } else {
            // $akses = json_encode($akses_wilayah);
            $id_selected = $request->input('id');
            if ($id_selected=="") {
                $id_selected = $akses_wilayah[0]['id'];
            }

            $wilayah = LokasiModel::select('nama')->where('id', $id_selected)->first();
            $default_nama_wilayah = $wilayah->nama;
        
            //142 = kby baru
            $lokasi = DB::select("SELECT id, nama
        FROM lokasi
        WHERE parent = '$id_selected'
        UNION
        SELECT id,nama
        FROM lokasi
        WHERE parent IN
            (SELECT id FROM lokasi WHERE parent = '$id_selected')");

            $i=0;
            foreach ($lokasi as $data_lokasi) {
                $kategori = KategoriModel::select('id', 'nama')->where('parent', '0')->get();

                $j=0;
                foreach ($kategori  as $kategori_parent) {
                    $data_lokasi_kategori = DB::select("SELECT count(*) AS total FROM barang WHERE id_lokasi = '$data_lokasi->id' AND id_kategori IN (SELECT id
                FROM kategori
                WHERE parent = '$kategori_parent->id'
                UNION
                SELECT id
                FROM kategori
                WHERE parent IN
                    (SELECT id FROM kategori WHERE parent = '$kategori_parent->id'));");
                
                    $data[$j]['id']=$kategori_parent->id;
                    $data[$j]['nama']=$kategori_parent->nama;
                    $data[$j]['lokasi'][$i]['id']=$data_lokasi->id;
                    $data[$j]['lokasi'][$i]['nama']=$data_lokasi->nama;
                    $data[$j]['lokasi'][$i]['total']=$data_lokasi_kategori[0]->total;
                
                    $j++;
                }
                $i++;
            }
        }

       

        return response()->json([
            'success' => true,
            'selected_nama_wilayah'=>$default_nama_wilayah,
            'akses_wilayah'=>$akses_wilayah,
            'data' =>$data,
        ], 200);
    }

    public function get_barang_lokasi(Request $request)
    {
        $s = HelperApiModel::arrayAksesThisUser();
        $cekAkses = HelperApiModel::allowedAccess(4, 0);

        if ($cekAkses==false) {
            return response()->json([
                'success' => false,
                'message' =>'Unauthorized access',
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'id_lokasi' => 'required',
            'id_kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' =>'Lokasi and Kategori required',
            ], 200);
        }

        $id_parent_lokasi = $request->input('id_lokasi');
        $id_parent_kategori = $request->input('id_kategori');
        $page = $request->input('page');

        if ($page=="") {
            $page=1;
        }

        $limit = 10;

        $offset = $page-1;
        $skip = $limit*$offset;

        $lokasi = DB::select("SELECT id, nama
        FROM lokasi
        WHERE parent = '$id_parent_lokasi'
        UNION
        SELECT id,nama
        FROM lokasi
        WHERE parent IN
            (SELECT id FROM lokasi WHERE parent = '$id_parent_lokasi')");

        $i=0;
        foreach ($lokasi as $data_lokasi) {
            $kategori = KategoriModel::select('id', 'nama')->where('path', 'like', '/'.$id_parent_kategori.'/%')->get();

            $j=0;
            foreach ($kategori  as $data_kategori) {
                $data_barang[$i][$j] = BarangModel::select('deskripsi', 'kode_barang', 'photo_url', 'status', 'harga_perolehan', 'tanggal_perolehan', 'sumber_pendanaan')
                ->where('id_lokasi', $data_lokasi->id)
                ->where('id_kategori', $data_kategori->id)
                ->orderBy('deskripsi', 'DESC')
                ->take($limit)
                ->skip($skip)
                ->get();
                
                $num_data_barang = count($data_barang[$i][$j]);

                if ($num_data_barang>0) {
                    $hasil[]=$data_barang[$i][$j];
                }
                
                $j++;
            }
            $i++;
        }

        return response()->json([
            'success' => true,
            'data' =>$hasil,
        ], 200);
    }

    public function barang_lokasi(Request $request)
    {
        $s = HelperApiModel::arrayAksesThisUser();
        $cekAkses = HelperApiModel::allowedAccess(4, 0);

        if ($cekAkses==false) {
            return response()->json([
                'success' => false,
                'message' =>'Unauthorized access',
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'id_lokasi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' =>'Id lokasi required',
            ], 200);
        }

        $id_lokasi = $request->input('id_lokasi');
        $parent_kategori = $request->input('parent_kategori');
        $page = $request->input('page');

        if ($page=="") {
            $page=1;
        }

        $limit = 10;

        $offset = $page-1;
        $skip = $limit*$offset;

        $d = DB::select(
            "SELECT kode_barang, barang.id, deskripsi, id_kategori, photo_url, status, id_lokasi FROM `barang`,kategori WHERE `id_lokasi` = '$id_lokasi' AND barang.id_kategori = kategori.id AND id_kategori IN (SELECT id_kategori FROM kategori WHERE path like '/$parent_kategori%' AND id = barang.id_kategori)"
        );

        return response()->json([
            'success' => true,
            'message' =>'Data',
            "s"=>"SELECT kode_barang, barang.id, deskripsi, id_kategori, photo_url, status, id_lokasi
            FROM `barang`,kategori
            WHERE `id_lokasi` = '$id_lokasi' 
            AND barang.id_kategori = kategori.id
            AND id_kategori IN (SELECT id_kategori FROM kategori WHERE path like '/$parent_kategori%' AND id = barang.id_kategori)",
            'data'    => $d,
            
        ], 200);
    }

    public function scan(Request $request)
    {
        $s = HelperApiModel::arrayAksesThisUser();
        $cekAkses = HelperApiModel::allowedAccess(4, 0);

        if ($cekAkses==false) {
            return response()->json([
                'success' => false,
                'message' =>'Unauthorized access',
            ], 200);
        }
        
        $validator = Validator::make($request->all(), [
            'kode' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' =>'Kode required',
            ], 200);
        }

      

        $kode = $request->input('kode');
        $barang = BarangModel::select('barang.id', 'kode_barang', 'deskripsi', 'photo_url', 'lokasi.nama as nama_lokasi', 'status', 'id_lokasi')->
        leftJoin('lokasi', 'barang.id_lokasi', 'lokasi.id')->
        where('kode_barang', $kode)->first();

        if (is_null($barang)) {
            return response()->json([
                'success' => false,
                'message' =>'Barang tidak ada',
            ], 200);
        } else {
            $lokasi = LokasiModel::select('*')->where('id', $barang->id_lokasi)->first();
        
            $parent_id = $lokasi->parent;
            $path = $lokasi->path;
            $explode = explode("/", $path);

            $i=1;
            $num_path = count($explode);
            while ($i<=$num_path-1) {
                $data = LokasiModel::select('nama')->where('id', $explode[$i])->first();
                $nama_lokasi[$i] = $data->nama;
                $i++;
            }

            $hasil['id']=$barang->id;
            $hasil['nama_barang']=$barang->deskripsi;
            $hasil['photo_url']=$barang->photo_url;
            $hasil['lokasi'] = implode(' ', $nama_lokasi);

            return response()->json([
            'success' => true,
            'message' =>'Hasil scan',
            'data'    => $hasil
        ], 200);
        }
    }
}
