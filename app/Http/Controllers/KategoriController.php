<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App\Models\HelperModel;
use App\Models\KategoriModel;

class KategoriController extends Controller
{
    public function __construct(){

    }

    public function index(){
        $cekAkses = HelperModel::allowedAccess('Master');

        if($cekAkses == false){
            return view('admin.parts.404');
        }

        $data = [
            'data_kategori' => KategoriModel::all()
        ];
        return view('admin.pages.kategori.index')->with($data);
    }

    public function get_tree(){

        $result = KategoriModel::get_custom_data();

        $itemsByReference = array();

        foreach($result as $key => &$item) {
            $itemsByReference[$item['id']] = &$item;
            $itemsByReference[$item['id']]['children'] = array();
            $itemsByReference[$item['id']]['data'] = array(
                'id' => $item['id'],
                'text' => $item['text'],
                'parent_id' => $item['parent_id'],
                'kode' => $item['kode'],
                'parent_name' => KategoriModel::getParentName($item['parent_id']),
            );
        }

        foreach($result as $key => &$item){
            if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                $itemsByReference [$item['parent_id']]['children'][] = &$item;
        }

        foreach($result as $key => &$item) {
            if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                unset($result[$key]);
        }
        
        $data_push = [];
        foreach ($result as $row) {
            $data_push[] = $row;
        }

        echo json_encode($data_push);

    }

    public function get_kategori(){
        $data = KategoriModel::all();

        $return = array();
        foreach($data as $item){
            $return[] = array(
                "id" => $item->id,
                "text" => '('.KategoriModel::getParentName($item->parent).') '.$item->kode.' - '.$item->nama
            );
        }
        echo json_encode($return);
    }

    public function store(Request $req){

        if($req->method == 'new'){

            $kategori = new KategoriModel;
            $kategori->kode = $req->kode_kategori;
            $kategori->nama = $req->nama_kategori;
            $kategori->parent = $req->parent_kategori;
            $kategori->created_by = Auth()->user()->id;

            if($kategori->save()){
                HelperModel::saveLog('kategori', 'Menyimpan data kategori baru.', $req->all(), '', '');

                $getID = $kategori->id;
                $d_kat = KategoriModel::find($getID);
                
                if($d_kat->parent == 0){
                    $d_kat->path = '/'.$getID;
                }else{

                    $parent_path = KategoriModel::find($d_kat->parent);
                    $d_kat->path = $parent_path->path.'/'.$getID;
                }

                $d_kat->save();

                $ret = array(
                    'status' => 1,
                    'message' => 'Berhasil menambahkan data kategori.'
                );
            }else{
                $ret = array(
                    'status' => 0,
                    'message' => 'Gagal menambahkan data kategori.'
                );
            }

            echo json_encode($ret);

        }else if($req->method == 'edit'){

            try {
                
                $kategori = KategoriModel::findOrFail($req->id_kategori);

                if($kategori){

                    if($req->parent_kategori == $req->id_kategori){
                        $ret = array(
                            'status' => 0,
                            'message' => 'Parent kategori ini tidak bisa dijadikan parent.'
                        );
                        echo json_encode($ret);
                        exit();
                    }

                    if($kategori->parent != $req->parent_kategori){

                        $check_child = KategoriModel::where('parent','=',$kategori->id)->count();

                        if($check_child > 0){
                            $ret = array(
                                'status' => 0,
                                'message' => 'Gagal update data kategori. Hapus / Pindahkan data turunannya terlebih dahulu.'
                            );
                            echo json_encode($ret);
                            exit();
                        }

                        if($req->parent_kategori == 0){
                            $kategori->path = '/'.$kategori->id;
                        }else{
                            $parent_path = KategoriModel::find($req->parent_kategori);
                            $kategori->path = $parent_path->path.'/'.$kategori->id;
                        }

                    }

                    $kategori->kode = $req->kode_kategori;
                    $kategori->nama = $req->nama_kategori;
                    $kategori->parent = $req->parent_kategori;

                    if($kategori->save()){
                        HelperModel::saveLog('kategori', 'Mengubah data kategori.', $req->all(), '', array('id' => $req->id_kategori));

                        $getID = $req->id_kategori;
                        $d_kat = KategoriModel::find($getID);
                        
                        if($d_kat->parent == 0){
                            $d_kat->path = '/'.$getID;
                        }else{
                            $parent_path = KategoriModel::find($d_kat->parent);
                            $d_kat->path = $parent_path->path.'/'.$getID;
                        }

                        $d_kat->save();

                        $ret = array(
                            'status' => 1,
                            'message' => 'Berhasil update data kategori.'
                        );
                    }else{
                        $ret = array(
                            'status' => 0,
                            'message' => 'Gagal update data kategori.'
                        );
                    }

                }else{
                    $ret = array(
                        'status' => 0,
                        'message' => 'Gagal update data kategori.'
                    );
                }

            } catch (Exception $e) {
                $ret = array(
                    'status' => 0,
                    'message' => 'Gagal update data kategori.'
                );
            }

            echo json_encode($ret);

        }else{

            $check = KategoriModel::where('parent','=',$req->id_kategori)->count();
            if($check > 0){
                $ret = array(
                    'status' => 0,
                    'message' => 'Kategori tersebut gagal dihapus, karena masih memiliki sub kategori.'
                );
                echo json_encode($ret);
                exit();
            }

            try {
                
                $kategori = KategoriModel::findOrFail($req->id_kategori);

                if($kategori->delete()){
                    HelperModel::saveLog('kategori', 'Menghapus data kategori.', '', '', array('id' => $req->id_kategori));
                    $ret = array(
                        'status' => 1,
                        'message' => 'Berhasil menghapus data kategori.'
                    );
                }else{
                    $ret = array(
                        'status' => 0,
                        'message' => 'Gagal menghapus data kategori.'
                    );
                }

            } catch (Exception $e) {
                $ret = array(
                    'status' => 0,
                    'message' => 'Gagal menghapus data kategori.'
                );
            }

            echo json_encode($ret);

        }

    }

   
}
