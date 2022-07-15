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
use App\Models\SupplierModel;
use App\Models\AksesModel;

class UserController extends Controller
{
    public function __construct(){

    }
    
    public function index(){
        $cekAkses = HelperModel::allowedAccess('Master');

        if($cekAkses == false){
            return view('admin.parts.404');
        }

        $data = [
            'data_supplier' => SupplierModel::all()
        ];
        return view('admin.system.user.index')->with($data);
    }

    public function edit_index($id){

        $data = [
            'data_user' => UserModel::where(DB::raw('md5(id)'), $id)->first(),
            'data_supplier' => SupplierModel::all(),
        ];
        return view('admin.system.user.edit')->with($data);
    }

    public function detail_index($id){
        $data = [
            'data_user' => UserModel::where(DB::raw('md5(id)'), $id)->first(),
            'data_supplier' => SupplierModel::all(),
        ];
        return view('admin.system.user.detail')->with($data);
    }

    public function akses_index($id){

        $arr = HelperModel::arrayAkses();

        $data_akses = AksesModel::where(DB::raw('md5(id)'), $id);

        $data = [
            'data_user' => UserModel::where(DB::raw('md5(id)'), $id)->first(),
            'data_supplier' => SupplierModel::all(),
            'array_akses' => $arr,
            'akses_selected' => ($data_akses->count() > 0 ? json_decode($data_akses->first()->akses) : null),
            'akses_wilayah' => ($data_akses->count() > 0 ? json_decode($data_akses->first()->akses_wilayah) : null),
            'akses_requester' => ($data_akses->count() > 0 ? json_decode($data_akses->first()->akses_requester) : null),
            'array_requester' => HelperModel::arrayRequester()
        ];
        return view('admin.system.user.akses')->with($data);
    }

    public function myacc_index(){

        $data = [
            'data_user' => Auth()->user(),
        ];
        return view('admin.system.user.akun_saya')->with($data);
    }

    public function myacc_update(Request $req){

        try {
            
            $data = UserModel::find($req->id);

            if($data){

                if($data->mobile_number != $req->mobile_number){
                    $rules = [
                        'foto' => 'max:2120', //2MB
                        'mobile_number' => 'required|unique:users,mobile_number',
                    ];

                    $messages = [
                        'foto.max' => 'Maksimal upload foto hanya 2MB!',
                        'mobile_number.unique' => 'No HP sudah digunakan!',
                    ];
                }else{
                    $rules = [
                        'foto' => 'max:2120', //2MB
                    ];

                    $messages = [
                        'foto.max' => 'Maksimal upload foto hanya 2MB!',
                    ];
                }

                $validator = Validator::make($req->all(), $rules, $messages);

                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput($req->all());
                }

                $url_foto = '';
                $location = public_path('/uploads/foto');

                if($req->foto){
                    $imageName = $data->id.'_'.$data->mobile_number.'.'.$req->foto->getClientOriginalExtension();
                    $req->foto->move($location, $imageName);
                    // $url_foto = asset('uploads').'/foto/'.$imageName;
                    $url_foto = 'uploads/foto/'.$imageName;
                }else{
                    $url_foto = $data->photo_url;
                }
                

                $user = $data;
                $user->name = ucwords(strtolower($req->name));
                
                if($req->password == null || $req->password == ""){}else{
                    $user->password = Hash::make($req->password);
                }

                $user->mobile_number = $req->mobile_number;
                $user->photo_url = $url_foto;

                if($user->save()){
                    HelperModel::saveLog('users', 'Mengubah user.', $req->all(), '', array('id' => $req->id));
                    Session::flash('success', 'Berhasil mengubah data user!');
                    return redirect()->back();
                }else{
                    Session::flash('error', 'Gagal mengubah data user!');
                    return redirect()->back();
                }
            }else{
                Session::flash('error', 'Data user tidak ditemukan!');
                return redirect()->route('landing-admin');
            }

        } catch (Exception $e) {
            Session::flash('error', 'Data user tidak ditemukan!');
            return redirect()->route('landing-admin');
        }

    }

    public function save_access(Request $req){

        $arr_requester = HelperModel::arrayRequester();

        foreach($arr_requester as $key => $val){
            $arr_requester[$key]['enable'] = (null !== $req['requester_'.$val['id']] ? $req['requester_'.$val['id']] : 0);
        }

        $json_requester = json_encode($arr_requester);
        // REQUESTER

        $arr_lokasi = HelperModel::arrayLokasi();

        foreach($arr_lokasi as $key => $val){
            $arr_lokasi[$key]['enable'] = (null !== $req['wilayah_'.$val['id']] ? $req['wilayah_'.$val['id']] : 0);
        }

        $json_lokasi = json_encode($arr_lokasi);
        // LOKASI / WILAYAH

        $arr = HelperModel::arrayAkses();

        foreach($arr as $key => $val){
            $arr[$key]['enable'] = (null !== $req['parent_'.$key] ? $req['parent_'.$key] : 0);
            foreach($val['menu'] as $key2 => $val2){
                $arr[$key]['menu'][$key2]['enable'] = (null !== $req['child_'.$key.'_'.$key2] ? $req['child_'.$key.'_'.$key2] : 0);
            }
        }

        $json = json_encode($arr);
        // AKSES

        $user = $req->id;

        $check = AksesModel::where('id', $user);

        if($check->count() > 0){

            $akses = $check->first();
            $akses->akses = $json;
            $akses->akses_wilayah = $json_lokasi;
            $akses->akses_requester = $json_requester;

            if($akses->save()){
                HelperModel::saveLog('akses', 'Mengubah akses user.', $req->all(), '', '');
                Session::flash('success', 'Berhasil menyimpan akses user.');
                return redirect()->back()->withInput($req->all());
            }else{
                Session::flash('error', 'Gagal menyimpan akses user.');
                return redirect()->back()->withInput($req->all());
            }
            
        }else{

            $akses = new AksesModel;
            $akses->id = $user;
            $akses->akses = $json;
            $akses->akses_wilayah = $json_lokasi;
            $akses->akses_requester = $json_requester;

            if($akses->save()){
                HelperModel::saveLog('akses', 'Menambahkan akses user baru.', $req->all(), '', '');
                Session::flash('success', 'Berhasil menyimpan akses user.');
                return redirect()->back()->withInput($req->all());
            }else{
                Session::flash('error', 'Gagal menyimpan akses user.');
                return redirect()->back()->withInput($req->all());
            }

        }
        
    }

    public function store(Request $req){

        $rules = [
            'foto' => 'max:2120', //2MB
            'mobile_number' => 'required|unique:users,mobile_number',
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
        ];

        $messages = [
            'foto.max' => 'Maksimal upload foto hanya 2MB!',
            'mobile_number.unique' => 'No HP sudah digunakan!',
            'email.unique' => 'Alamat Email sudah digunakan!',
            'username.unique' => 'Username sudah digunakan!',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }

        $url_foto = '';
        $location = public_path('/uploads/foto');

        if($req->foto){
            $imageName = Auth()->user()->id.'_'.$req->mobile_number.'.'.$req->foto->getClientOriginalExtension();
            $req->foto->move($location, $imageName);
            // $url_foto = asset('uploads').'/foto/'.$imageName;
            $url_foto = 'uploads/foto/'.$imageName;
        }else{
            // $url_foto = asset('assets').'/logo/user.png';
            $url_foto = 'assets/logo/noimage.png';
        }
        $idkamp = ($req->role == 'Supplier' ? $req->id_supplier : 0);
        // $idkamp = 0;
        // if($req->role == 5){
        //     if($req->id_supplier == 0){
        //         Session::flash('error', 'Anda belum memilih requester!');
        //         return redirect()->route('users')->withInput($req->all());
        //     }else{
        //         $idkamp = $req->id_supplier;
        //     }
        // }

        $user = new UserModel;
        $user->id_supplier = $idkamp;
        $user->role = $req->role;
        $user->name = ucwords(strtolower($req->name));
        $user->password = Hash::make($req->password);
        $user->username = $req->username;
        $user->email = $req->email;
        $user->mobile_number = $req->mobile_number;
        $user->photo_url = $url_foto;
        $user->status = 'Aktif';
        $user->last_login = Carbon::now()->timezone('Asia/Jakarta');
        $user->created_by = Auth()->user()->id;

        if($user->save()){
            HelperModel::saveLog('users', 'Menambahkan user baru.', $req->all(), '', '');
            Session::flash('success', 'Berhasil menambahkan data user baru!');
            return redirect()->route('users');
        }else{
            Session::flash('error', 'Gagal menambahkan data user baru!');
            return redirect()->route('users');
        }

    }

    public function update(Request $req){

        try {
            
            $data = UserModel::find($req->user_id);

            if($data){

                $rules = [
                    'foto' => 'max:2120',
                ];
                $messages = [
                    'foto.max' => 'Maksimal upload foto hanya 2MB!',
                ];

                if($data->email != $req->email){

                    $rules['email'] = 'required|unique:users,email';
                    $messages['email.unique']  = 'Alamat Email sudah digunakan!';
                }

                if($data->username != $req->username){
                    
                    $rules['username'] = 'required|unique:users,username';
                    $messages['username.unique'] = 'Username sudah digunakan!';
                }

                if($data->mobile_number != $req->mobile_number){

                    $rules['mobile_number'] = 'required|unique:users,mobile_number';
                    $messages['mobile_number.unique'] = 'No HP sudah digunakan!';
                }

                // echo "<pre>";
                // print_r($rules);
                // echo "<br/>";
                // print_r($messages);
                // exit();

                $validator = Validator::make($req->all(), $rules, $messages);

                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput($req->all());
                }

                $url_foto = '';
                $location = public_path('/uploads/foto');

                if($req->foto){
                    $imageName = $data->created_by.'_'.$req->mobile_number.'.'.$req->foto->getClientOriginalExtension();
                    $req->foto->move($location, $imageName);
                    // $url_foto = asset('uploads').'/foto/'.$imageName;
                    $url_foto = 'uploads/foto/'.$imageName;
                }else{
                    $url_foto = $data->photo_url;
                }
                // $idkamp = 0;
                // if($req->role == 5){
                //     if($req->id_requester == 0){
                //         Session::flash('error', 'Anda belum memilih requester!');
                //         return redirect()->back()->withInput($req->all());
                //     }else{
                //         $idkamp = $req->id_requester;
                //     }
                // }

                $idkamp = ($req->role == 'Supplier' ? $req->id_supplier : 0);

                $user = $data;
                $user->id_supplier = $idkamp;
                $user->role = $req->role;
                $user->name = ucwords(strtolower($req->name));
                
                if($req->password == null || $req->password == ""){}else{
                    $user->password = Hash::make($req->password);
                }

                $user->username = $req->username;
                $user->email = $req->email;
                $user->mobile_number = $req->mobile_number;
                $user->photo_url = $url_foto;
                $user->status = $req->status;

                if($user->save()){

                    HelperModel::saveLog('users', 'Mengubah user.', $req->all(), '', array('id' => $req->id));
                    Session::flash('success', 'Berhasil mengubah data user!');
                    return redirect()->back();
                }else{
                    Session::flash('error', 'Gagal mengubah data user!');
                    return redirect()->back();
                }
            }else{
                Session::flash('error', 'Data user tidak ditemukan!');
                return redirect()->route('users');
            }

        } catch (Exception $e) {
            Session::flash('error', 'Data user tidak ditemukan!');
            return redirect()->route('users');
        }

    }

    public function delete($id){

        if(md5(Auth()->user()->id) == $id){
            Session::flash('error', 'User sedang digunakan! tidak dapat dihapus.');
        }else{

            $user = UserModel::where(DB::raw('md5(id)'), $id);
            if($user->count() > 0){

                $data = $user->first();
                $uid = $data->id;

                if($data->role == "Admin"){
                    Session::flash('error', 'Gagal menghapus data user!');
                }else{

                    if($data->photo_url != null){

                        $boom = explode("/", $data->photo_url);
                        $img = $boom[count($boom) - 1];

                        if(strtolower($img) == 'noimage.png'){}else{

                            $location = public_path('uploads/foto/'.$img);

                            if (File::exists($location)) {
                                File::delete($location);
                            }

                        }

                    }

                    if($user->delete()){
                        HelperModel::saveLog('users', 'Menghapus data user.', '', '', array('id' => $id));
                        Session::flash('success', 'Berhasil menghapus data user!');
                    }else{
                        Session::flash('error', 'Gagal menghapus data user!');
                    }

                }

            }else{
                Session::flash('error', 'Gagal menghapus data user!');
            }
        }
        
    }

    public function get_data(Request $req){
        if($req->ajax()){

            $query = UserModel::select(DB::raw('users.*, IF(users.id_supplier = 0, "-", supplier.nama) as `nama_supplier`'))
                    ->leftJoin('supplier', 'users.id_supplier', '=', 'supplier.id')
                    ->get();

            $data = $query;
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('role', function($row){
                    // $getRole = '';

                    // if($row->role == 0){
                    //     $getRole = 'SUPER ADMIN';
                    // }else{
                    //     $temp = RoleModel::find($row->role);
                    //     $getRole = @$temp->nama;
                    // }

                    return '<center><b>'.$row->role.'</b></center>';
                })
                ->editColumn('nama_supplier', function($row){
                    // $getRequester = '';

                    // if($row->id_requester == 0){
                    //     $getRequester = '-';
                    // }else{
                    //     $temp = SupplierModel::find($row->id_requester);
                    //     $getRequester = @$temp->nama;
                    // }

                    return $row->nama_supplier;
                })
                ->editColumn('status', function($row){
                    return '<center><label class="'.($row->status == 'Aktif' ? 'text-success' : 'text-danger').'">'.$row->status.'</label></center>';
                })
                ->editColumn('last_login', function($row){
                    return '<center>'.date('d M Y, H:i:s', strtotime($row->last_login)).'</center>';
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

                          <a href="'.$img.'" target="_blank"><img style="width:50px;max-height:50px;" alt="NONE" src="'.$img.'" /></a>

                        </center>
                    ';

                    return $btn;
                })
                ->addColumn('action', function($row){
                    $btn = '
                        <center>

                            <div class="row">
                            <div class="col-lg-12">

                                <a href="javascript:;" class="btn btn-sm btn-outline-primary btn_detail" data-id="'.md5($row->id).'" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"><i class="fa fa-info"></i></a>
                            </div>
                            </div>
                            <br/>
                            <div class="row" '.(Auth()->user()->id == $row->id ? "" : "").'>
                            <div class="col-lg-12">
                                <a href="'.url('system/users/edit').'/'.md5($row->id).'" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa fa-edit"></i></a>

                                <a href="javascript:;" class="btn btn-sm btn-outline-danger delete_button" data-id="'.md5($row->id).'" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                            </div>
                            </div>
                            </div>

                        </center>
                    ';

                    return $btn;
                })
                ->rawColumns(['action', 'role', 'status', 'last_login', 'foto', 'nama_supplier'])
                ->make(true);
        }
    }

}
