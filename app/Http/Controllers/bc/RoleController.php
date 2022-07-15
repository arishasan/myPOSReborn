<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use Hash;
use File;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\HelperModel;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\RequesterModel;
use App\Models\AksesModel;

class RoleController extends Controller
{
    public function __construct(){

    }
    
    public function index(){
        $cekAkses = HelperModel::allowedAccess(3, 0);

        if($cekAkses == false){
            return view('admin.parts.404');
        }

        $data = [
            'array_akses' => HelperModel::arrayAkses()
        ];
        return view('admin.system.role.index')->with($data);
    }

    public function edit_index($id){

        $arr = HelperModel::arrayAkses();

        $da = RoleModel::where(DB::raw('md5(id)'), $id);
        $aks = ($da ? json_decode($da->first()->permission) : null);
        $data = [
            'data_akses' => $da->first(),
            'array_akses' => $arr,
            'akses_selected' => $aks
        ];

        return view('admin.system.role.edit')->with($data);
    }

    public function store(Request $req){

        $arr = HelperModel::arrayAkses();

        foreach($arr as $key => $val){
            $arr[$key]['enable'] = (null !== $req['parent_'.$key] ? $req['parent_'.$key] : 0);
            foreach($val['menu'] as $key2 => $val2){
                $arr[$key]['menu'][$key2]['enable'] = (null !== $req['child_'.$key.'_'.$key2] ? $req['child_'.$key.'_'.$key2] : 0);
            }
        }

        $json = json_encode($arr);

        $roles = new RoleModel;
        $roles->nama = $req->name;
        $roles->permission = $json;
        $roles->created_by = Auth()->user()->id;

        if($roles->save()){
            HelperModel::saveLog('role', 'Menambahkan role user baru.', $req->all(), '', '');
            Session::flash('success', 'Berhasil menyimpan role user.');
            return redirect()->route('roles');
        }else{
            Session::flash('error', 'Gagal menyimpan role user.');
            return redirect()->route('roles');
        }


    }

    public function update(Request $req){

        $arr = HelperModel::arrayAkses();

        foreach($arr as $key => $val){
            $arr[$key]['enable'] = (null !== $req['parent_'.$key] ? $req['parent_'.$key] : 0);
            foreach($val['menu'] as $key2 => $val2){
                $arr[$key]['menu'][$key2]['enable'] = (null !== $req['child_'.$key.'_'.$key2] ? $req['child_'.$key.'_'.$key2] : 0);
            }
        }

        $json = json_encode($arr);

        try {
            
            $roles = RoleModel::findOrFail($req->id);

            if($roles){

                $roles->nama = $req->name;
                $roles->permission = $json;
                $roles->edit_user = Auth()->user()->id;

                if($roles->save()){
                    HelperModel::saveLog('role', 'Mengupdate role user.', $req->all(), '', '');
                    Session::flash('success', 'Berhasil menyimpan role user.');
                    return redirect()->back();
                }else{
                    Session::flash('error', 'Gagal menyimpan role user.');
                    return redirect()->back();
                }

            }else{
                Session::flash('error', 'Gagal menyimpan role user.');
                return redirect()->route('roles');
            }

        } catch (Exception $e) {
            Session::flash('error', 'Gagal menyimpan role user.');
            return redirect()->route('roles');
        }


    }

    public function delete($id){
        $role = RoleModel::where(DB::raw('md5(id)'), $id);
        if($role->count() > 0){

            if($role->delete()){
                HelperModel::saveLog('role', 'Menghapus data role.', '', '', array('id' => $id));
                Session::flash('success', 'Berhasil menghapus data role!');
            }else{
                Session::flash('error', 'Gagal menghapus data role!');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data role!');
        }
    }

    public function get_data(Request $req){
        if($req->ajax()){
            $data = RoleModel::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                        <center>

                            <div class="row">
                            <div class="col-lg-12">
                                <a href="'.url('system/roles/edit').'/'.md5($row->id).'" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa fa-edit"></i></a>

                                <a href="javascript:;" class="btn btn-sm btn-danger delete_button" data-id="'.md5($row->id).'" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            </div>
                            </div>
                            </div>

                        </center>
                    ';

                    return $btn;
                })
                ->rawColumns(['action',])
                ->make(true);
        }
    }

}
