<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    
    public function __construct(){

    }

    public function showFormLogin(){
    	if(Auth::check()) {
    		return redirect()->route('landing-admin');
    	}
    	return view('admin.login');
    }

    public function showLupaPassword(){
        if(Auth::check()) {
            return redirect()->route('landing-admin');
        }
        return view('admin.lupa_password');
    }

    public function lupa_password(Request $req){

        $cek = UserModel::where('email', $req->email);

        if($cek->count() > 0){

            $otp = Str::random(6);

            $user = $cek->first();
            $user->otp = strtoupper($otp);
            $user->save();

            session()->put('email', $user->email);
            session()->put('name', $user->name);

            $data = array(
                'name' => $user->nama,
                'email' => $user->email,
                'otp' => strtoupper($otp)
            );
       
              Mail::send(['text'=>'admin.parts.kode_login'], $data, function($message) use ($data) {

                 $message->to($data['email'], $data['name'])->subject
                    ('MyPOS: Kode Verifikasi Login');
                 $message->from('arishasan4@yahoo.com','MyPOS: Basic');

              });

            Session::flash('success', 'Berhasil mengirimkan kode verifikasi. Silahkan cek email anda.');
            return redirect()->route('verif');

        }else{

            Session::flash('error', 'Tidak dapat menemukan user dengan email tersebut!');
            return redirect()->back()->withInput($req->all());

        }

    }

    public function verif_kode(){

        $data = array(
            'email' => session()->get('email'),
            'nama' => session()->get('name')
        );

        return view('admin.verif')->with($data);

    }

    public function kode_verif(Request $req){

        $cek = UserModel::where('email', $req->email)->where('otp', $req->kode_verif);

        if($cek->count() > 0){

            $user = $cek->first();

            session()->put('userID', $user->id);
            return redirect()->route('verif_final');

        }else{

            Session::flash('error', 'Kode verifikasi salah! Silahkan ulangi');
            return redirect()->back()->withInput($req->all());

        }

    }

    public function verif_final(){

        $data = array(
            'id' => session()->get('userID'),
            'email' => session()->get('email'),
            'nama' => session()->get('name')
        );

        return view('admin.verif_final')->with($data);

    }

    public function verif_final_execute(Request $req){

        $rules = [
            'password' => 'required|confirmed|min:6'
        ];

        $messages = [];

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }

        $user = UserModel::find($req->id);
        $user->password = Hash::make($req->password);
        $user->status = 'Aktif';
        $user->otp = '';

        if($user->save()){
            Session::flash('success', 'Berhasil melakukan pengubahan kata sandi! Silahkan masuk.');
            return redirect()->route('login');
        }else{
            Session::flash('error', 'Gagal mengubah kata sandi. Silahkan ulangi.');
            return redirect()->back()->withInput($req->all());
        }

    }

    public function showRegister(){
        if(Auth::check()) {
            return redirect()->route('landing-admin');
        }

        $data = array(
            'data_supplier' => SupplierModel::all()
        );

        return view('admin.register')->with($data);
    }

    public function register(Request $req){

        $rules = [
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed|min:6'
        ];

        $messages = [
            'email.unique' => 'Alamat Email sudah digunakan!',
            'username.unique' => 'Username sudah digunakan!',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }

        $url_foto = 'assets/logo/noimage.png';
        $idkamp = ($req->role == 'Supplier' ? $req->supplier : 0);

        $user = new UserModel;
        $user->id_supplier = $idkamp;
        $user->role = $req->role;
        $user->name = ucwords(strtolower($req->nama));
        $user->password = Hash::make($req->password);
        $user->username = $req->username;
        $user->email = $req->email;
        $user->photo_url = $url_foto;
        $user->status = 'Aktif';
        $user->last_login = Carbon::now()->timezone('Asia/Jakarta');
        $user->created_by = 0;

        if($user->save()){

            Session::flash('success', 'Berhasil mendaftarkan pengguna baru! Silahkan masuk.');
            return redirect()->route('login');
        }else{
            Session::flash('error', 'Gagal mendaftarkan pengguna baru!');
            return redirect()->back()->withInput($req->all());
        }

    }

    public function login(Request $req){
    	$rules = [
    		'username' => 'required|string',
    		'password' => 'required|string'
    	];

    	$messages = [
    		'username.required' => 'Nama pengguna wajib diisi!',
    		'password.required' => 'Kata sandi wajib diisi!',
    	];

    	$validator = Validator::make($req->all(), $rules, $messages);

    	if($validator->fails()){
    		return redirect()->back()->withErrors($validator)->withInput($req->all());
    	}

        $remember_me = $req->has('remember_me') ? true : false;

    	$data = [
    		'username' => $req->input('username'),
    		'password' => $req->input('password')
    	];

        $fieldType = filter_var($req->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    	Auth::attempt(array($fieldType => $req->input('username'), 'password' => $req->input('password'), 'status' => 'Aktif'));

    	if(Auth::check()){

            $user = User::find(Auth()->user()->id);
            $user->last_login = Carbon::now()->timezone('Asia/Jakarta');
            $user->save();

    		return redirect()->route('landing-admin');

    	}else{
    		Session::flash('error', 'Nama pengguna atau kata sandi salah. Atau akun anda dinonaktifkan.');
    		return redirect()->route('login');
    	}
    }

    public function logout(){
    	Auth::logout();
    	return redirect()->route('login');
    }


}
