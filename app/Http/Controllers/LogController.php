<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use DataTables;
use App\Models\LogModel;
use App\Models\UserModel;
use App\Models\HelperModel;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    
    public function index(){
        $cekAkses = HelperModel::allowedAccess('Master');

        if($cekAkses == false){
            return view('admin.parts.404');
        }

        $data = [
            'data_user' => UserModel::all()
        ];
        return view('admin.system.activity.index')->with($data);
    }

    public function get_data(Request $req){

        if($req->ajax()){

            $from = date('Y-m-d', strtotime($req->from));
            $to = date('Y-m-d', strtotime($req->to));

            if($req->user == 'all'){

                $data = LogModel::leftJoin('users', 'users.id', '=', 'tb_logs_activity.created_by')
                ->select(DB::raw('tb_logs_activity.*, users.name as `nama_user`'))
                ->whereBetween(DB::raw('SUBSTR(tb_logs_activity.created_at, 1, 10)'), [$from, $to])
                ->get();

            }else{

                $data = LogModel::leftJoin('users', 'users.id', '=', 'tb_logs_activity.created_by')
                ->select(DB::raw('tb_logs_activity.*, users.name as `nama_user`'))
                ->where('tb_logs_activity.created_by', $req->user)
                ->whereBetween(DB::raw('SUBSTR(tb_logs_activity.created_at, 1, 10)'), [$from, $to])
                ->get();

            }


            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('table', function($row){
                    return '<center>'.$row->table.'</center>';
                })
                ->editColumn('created_at', function($row){
                    return '<center><b>'.date('d M Y', strtotime($row->created_at)).'</b></center>';
                })
                ->editColumn('nama_user', function($row){
                    return '<center>'.$row->nama_user.'</center>';
                })
                ->rawColumns(['table', 'created_at', 'nama_user'])
                ->make(true);
        }

    }

}
