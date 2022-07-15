<?php

namespace App\Http\Controllers\api;

use App\Models\PelaporanModel;
use App\Models\HelperApiModel;
use App\Models\LokasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function histori_laporan()
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

        $qbarang = PelaporanModel::select('id_barang', 'barang.id_lokasi', 'deskripsi as nama_barang', 'tgl_pelaporan', 'pelaporan_barang.photo_url', 'kondisi', 'keterangan', 'status_laporan', 'jawaban_laporan', 'latitude', 'longitude', 'pelaporan_barang.created_at')
        ->leftJoin('barang', 'pelaporan_barang.id_barang', 'barang.id')
        ->where('pelaporan_barang.created_by', $user_id)
        ->whereMonth('pelaporan_barang.created_at', date('m'))
        ->whereYear('pelaporan_barang.created_at', date('Y'))
        ->orderByDesc('pelaporan_barang.created_at');

        $barangs = $qbarang->get();

        $num_histori = count($barangs);

        if ($num_histori==0) {
            $hasil = [];
        } else {
            $j=0;
            foreach ($barangs as $barang) {
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
    
                $hasil[] = array('id_barang'=>$barang->id_barang,'lokasi'=>implode(' ', $nama_lokasi),'nama_barang'=>$barang->nama_barang,'photo_url'=>$barang->photo_url,'kondisi'=>$barang->kondisi,'keterangan'=>$barang->keterangan,'status_laporan'=>$barang->status_laporan,'jawaban_laporan'=>$barang->jawaban_laporan,'latitude'=>$barang->latitude,'longitude'=>$barang->longitude,'created_at'=>$barang->created_at->format('d M Y H:i:s'));
                $j++;
            }
        }

       
        

        return response()->json([
            'success' => true,
            'message' =>'List Laporan',
            'bulan'=>date('F'),
            'tahun'=>date('Y'),
            'data'    => $hasil,
            
        ], 200);
    }

    public function laporan(Request $request)
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
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' =>'Status required',
            ], 200);
        }

        $id_barang = $request->input('id_barang');
        $status = $request->input('status');
        $keterangan = $request->input('keterangan');
        $foto = $request->input('foto');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        

        if ($foto) {
            $file = base64_decode($foto);

            $f = finfo_open();
            $mime_type = finfo_buffer($f, $file, FILEINFO_MIME_TYPE);
            $split = explode('/', $mime_type);
            $type = $split[1];
            $imageName = Auth()->user()->id.'_'.$id_barang.'_'.date('ymdHis').'.'.$type;
            file_put_contents(public_path().'/uploads/pelaporan/'.$imageName, $file);
            $url_foto = 'uploads/pelaporan/'.$imageName;
        } else {
            $url_foto = asset('assets').'/logo/noimage.png';
        }
            
        $pelaporan = new PelaporanModel();
        $pelaporan->id_barang = $id_barang;
        $pelaporan->kondisi = $status;
        $pelaporan->keterangan = $keterangan;
        $pelaporan->tgl_pelaporan = date('Y-m-d');
        $pelaporan->photo_url = $url_foto;
        $pelaporan->latitude = $latitude;
        $pelaporan->longitude = $longitude;
        $pelaporan->status_laporan = 'BARU';
        $pelaporan->created_by = Auth()->user()->id;

        if ($pelaporan->save()) {
            return response()->json([
                'success' => true,
                'message' =>'Laporan berhasil',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' =>'Laporan failed',
            ], 200);
        }
    }
}
