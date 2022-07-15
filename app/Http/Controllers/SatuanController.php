<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App\Models\SatuanModel;
use App\Models\HelperModel;
use DataTables;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $cekAkses = HelperModel::allowedAccess('Master');

        if ($cekAkses == false) {
            return view('admin.parts.404');
        }

        $data = [
            
        ];
        return view('admin.pages.satuan.index')->with($data);
    }

    public function edit_index($id)
    {
        $data = [
            'data_satuan' => SatuanModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.satuan.edit')->with($data);
    }

    public function get_data_json($id)
    {
        $data = SatuanModel::where(DB::raw('md5(id)'), $id)->first();
        echo json_encode($data);
    }

    public function store(Request $req)
    {
        $satuan = new SatuanModel;
        $satuan->nama = $req->nama;
        $satuan->status = 1;
        $satuan->created_by = Auth()->user()->id;


        if ($satuan->save()) {
            HelperModel::saveLog('satuan', 'Menambahkan satuan baru.', $req->all(), '', '');
            Session::flash('success', 'Berhasil menambahkan data satuan baru!');
            return redirect()->route('master-satuan');
        } else {
            Session::flash('error', 'Gagal menambahkan data satuan baru!');
            return redirect()->route('master-satuan');
        }
    }

    public function update(Request $req)
    {
        try {
            $satuan = SatuanModel::findOrFail($req->id);

            if ($satuan) {
                $satuan->nama = $req->nama;
                $satuan->status = $req->status;

                if ($satuan->save()) {
                    HelperModel::saveLog('satuan', 'Update data satuan.', $req->all(), '', array('id' => $req->id));
                    Session::flash('success', 'Berhasil mengubah data satuan!');
                    return redirect()->route('master-satuan');
                } else {
                    Session::flash('error', 'Gagal mengubah data satuan!');
                    return redirect()->route('master-satuan');
                }
            } else {
                Session::flash('error', 'Gagal mengubah data satuan!');
                return redirect()->route('master-satuan');
            }
        } catch (Exception $e) {
            Session::flash('error', 'Gagal mengubah data satuan!');
            return redirect()->route('master-satuan');
        }
    }

    public function delete($id)
    {
        $satuan = SatuanModel::where(DB::raw('md5(id)'), $id);
        if ($satuan->count() > 0) {
            if ($satuan->delete()) {
                HelperModel::saveLog('satuan', 'Menghapus data satuan.', '', '', array('id' => $id));
                Session::flash('success', 'Berhasil menghapus data satuan!');
            } else {
                Session::flash('error', 'Gagal menghapus data satuan!');
            }
        } else {
            Session::flash('error', 'Gagal menghapus data satuan!');
        }
    }

    public function get_data(Request $req)
    {
        if ($req->ajax()) {
            $data = SatuanModel::select('*')->orderby('nama', 'asc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('nama', function ($row) {
                    return '<div class="">'.$row->nama.'</div>';
                })
                ->editColumn('status', function ($row) {
                    return '<center><b class="'.($row->status == 1 ? 'text-success' : 'text-danger').'">'.($row->status == 1 ? 'Aktif' : 'Non-Aktif').'</b></center>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '
                        <center>

                          <div class="btn-group me-1 mb-1">
                              <a href="javascript:;" class="btn btn-primary">Aksi</a>
                              <a href="#" data-bs-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="fa fa-caret-down"></i></a>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a href="'.url('master/satuan/edit').'/'.md5($row->id).'" class="dropdown-item text-primary"><i class="fa fa-edit"></i> Edit</a>
                                <a href="javascript:;" class="dropdown-item text-primary delete_button" data-id="'.md5($row->id).'"><i class="fa fa-trash"></i> Hapus</a>
                            </div>
                          </div>

                        </center>
                    ';

                    return $btn;
                })
                ->rawColumns(['action', 'nama', 'status'])
                ->make(true);
        }
    }
}
