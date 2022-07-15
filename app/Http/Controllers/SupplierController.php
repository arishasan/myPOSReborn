<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App\Models\SupplierModel;
use App\Models\HelperModel;
use DataTables;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
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
        return view('admin.pages.supplier.index')->with($data);
    }

    public function edit_index($id)
    {
        $data = [
            'data_supplier' => SupplierModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.supplier.edit')->with($data);
    }

    public function get_data_json($id)
    {
        $data = SupplierModel::where(DB::raw('md5(id)'), $id)->first();
        echo json_encode($data);
    }

    public function store(Request $req)
    {
        $supplier = new SupplierModel;
        $supplier->nama = $req->nama;
        $supplier->alamat = $req->alamat;
        $supplier->telepon = $req->telepon;
        $supplier->mobile_phone = $req->hp;
        $supplier->email = $req->email;
        $supplier->pic = $req->pic;
        $supplier->catatan = $req->catatan;
        $supplier->created_by = Auth()->user()->id;


        if ($supplier->save()) {
            HelperModel::saveLog('supplier', 'Menambahkan supplier baru.', $req->all(), '', '');
            Session::flash('success', 'Berhasil menambahkan data supplier baru!');
            return redirect()->route('master-supplier');
        } else {
            Session::flash('error', 'Gagal menambahkan data supplier baru!');
            return redirect()->route('master-supplier');
        }
    }

    public function update(Request $req)
    {
        try {
            $supplier = SupplierModel::findOrFail($req->id);

            if ($supplier) {
                $supplier->nama = $req->nama;
                $supplier->alamat = $req->alamat;
                $supplier->telepon = $req->telepon;
                $supplier->mobile_phone = $req->hp;
                $supplier->email = $req->email;
                $supplier->pic = $req->pic;
                $supplier->catatan = $req->catatan;
                $supplier->edited_by = Auth()->user()->id;


                if ($supplier->save()) {
                    HelperModel::saveLog('supplier', 'Update data supplier.', $req->all(), '', array('id' => $req->id));
                    Session::flash('success', 'Berhasil mengubah data supplier!');
                    return redirect()->route('master-supplier');
                } else {
                    Session::flash('error', 'Gagal mengubah data supplier!');
                    return redirect()->route('master-supplier');
                }
            } else {
                Session::flash('error', 'Gagal mengubah data supplier!');
                return redirect()->route('master-supplier');
            }
        } catch (Exception $e) {
            Session::flash('error', 'Gagal mengubah data supplier!');
            return redirect()->route('master-supplier');
        }
    }

    public function delete($id)
    {
        $supplier = SupplierModel::where(DB::raw('md5(id)'), $id);
        if ($supplier->count() > 0) {
            if ($supplier->delete()) {
                HelperModel::saveLog('supplier', 'Menghapus data supplier.', '', '', array('id' => $id));
                Session::flash('success', 'Berhasil menghapus data supplier!');
            } else {
                Session::flash('error', 'Gagal menghapus data supplier!');
            }
        } else {
            Session::flash('error', 'Gagal menghapus data supplier!');
        }
    }

    public function get_data(Request $req)
    {
        if ($req->ajax()) {
            $data = SupplierModel::select('*')->orderby('nama', 'asc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('nama', function ($row) {
                    return '<div class="text-center">'.$row->nama.'</div>';
                })
                ->editColumn('catatan', function ($row) {
                    return '<div class="text-center">'.substr($row->catatan, 0, 40).'... <br/><br/> <a href="javascript:;" data-id="'.md5($row->id).'" class="text-primary detil_supplier" style="text-decoration: none"><i class="fa fa-eye"></i> Lihat Detail</a></div>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '
                        <center>

                          <div class="btn-group me-1 mb-1">
                              <a href="javascript:;" class="btn btn-primary">Aksi</a>
                              <a href="#" data-bs-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="fa fa-caret-down"></i></a>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a href="'.url('master/supplier/edit').'/'.md5($row->id).'" class="dropdown-item text-primary"><i class="fa fa-edit"></i> Edit</a>
                                <a href="javascript:;" class="dropdown-item text-primary delete_button" data-id="'.md5($row->id).'"><i class="fa fa-trash"></i> Hapus</a>
                            </div>
                          </div>

                        </center>
                    ';

                    return $btn;
                })
                ->rawColumns(['action', 'nama', 'alamat', 'catatan'])
                ->make(true);
        }
    }
}
