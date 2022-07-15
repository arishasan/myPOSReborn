@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<link href="{{ asset('assets') }}/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />

<style>
 .map_ganselect {
  height: 300px;  /* The height is 400 pixels */
  width: 100%;  /* The width is the width of the web page */
 }
 td {
  font-size: 10px;
 }
</style>

@section('content')

<div id="content" class="app-content">
  <!-- BEGIN breadcrumb -->
  <ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Master</a></li>
    <li class="breadcrumb-item"><a href="{{ route('master-supplier') }}">Supplier</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Edit</a></li>
    <li class="breadcrumb-item active"><a href="javascript:;">{{ $data_supplier->nama }}</a></li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Edit Data Supplier </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">
      
      <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
          <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active" id="tab_satu">Edit Data</a>
        </li>
      </ul>
      <div class="tab-content bg-white p-3 rounded-bottom">
        <!-- TAB 1 -->
        <div class="tab-pane fade active show" id="default-tab-1">

          
          <div class="card">
            <div class="card-body">
              <form action="{{ route('update-supplier') }}" method="POST" class="form-horizontal" data-parsley-validate="true">
                @csrf
                <input type="hidden" name="id" value="{{ $data_supplier->id }}">
                <div class="form-group row mb-3">
                  <label class="col-lg-3 col-form-label form-label" for="nama">Nama Supplier <sup class="text-danger">*</sup> :</label>
                  <div class="col-lg-9">
                    <input class="form-control" value="{{ $data_supplier->nama }}" type="text" id="nama" name="nama" placeholder="Required" data-parsley-required="true" />
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label class="col-lg-3 col-form-label form-label" for="alamat">Alamat Supplier :</label>
                  <div class="col-lg-9">
                    <textarea class="form-control" id="alamat" name="alamat" rows="7" placeholder="Alamat Supplier ...">{{ $data_supplier->alamat }}</textarea>
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label class="col-lg-3 col-form-label form-label" for="telepon">Telepon :</label>
                  <div class="col-lg-9">
                    <input class="form-control" value="{{ $data_supplier->telepon }}" type="text" id="telepon" name="telepon" placeholder="Boleh dilewat.." />
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label class="col-lg-3 col-form-label form-label" for="hp">No HP :</label>
                  <div class="col-lg-9">
                    <input class="form-control" value="{{ $data_supplier->mobile_phone }}" type="text" id="hp" name="hp" placeholder="Boleh dilewat.." />
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label class="col-lg-3 col-form-label form-label" for="email">Email :</label>
                  <div class="col-lg-9">
                    <input class="form-control" value="{{ $data_supplier->email }}" type="email" id="email" name="email" placeholder="Boleh dilewat.." />
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label class="col-lg-3 col-form-label form-label" for="pic">PIC :</label>
                  <div class="col-lg-9">
                    <input class="form-control" value="{{ $data_supplier->pic }}" type="text" id="pic" name="pic" placeholder="Boleh dilewat.." />
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label class="col-lg-3 col-form-label form-label" for="catatan">Catatan :</label>
                  <div class="col-lg-9">
                    <textarea class="form-control" id="catatan" name="catatan" rows="7" placeholder="Catatan ...">{{ $data_supplier->catatan }}</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-label">&nbsp;</label>
                  <div class="col-lg-9">
                    <button type="submit" class="btn btn-outline-primary"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          

        </div>
        <!-- END OF TAB 1 -->
      </div>

    </div>
  </div>

</div>

<div class="modal modal-message fade" id="modal-alert">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-body">
        <br/>
        <div class="alert alert-warning">
          <h5><i class="fa fa-info-circle"></i> Perhatian</h5>
          <p id="alert_content"></p>
          <center>
            <a href="javascript:;" class="btn btn-outline-primary" data-bs-dismiss="modal"><i class="fa fa-save"></i> Ya</a>
            <a href="javascript:;" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> Tidak</a>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scriptplus')

<script src="{{ asset('assets') }}/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('assets') }}/plugins/pdfmake/build/pdfmake.min.js"></script>
<script src="{{ asset('assets') }}/plugins/pdfmake/build/vfs_fonts.js"></script>
<script src="{{ asset('assets') }}/plugins/jszip/dist/jszip.min.js"></script>
<script src="{{ asset('assets') }}/plugins/select2/dist/js/select2.min.js"></script>
<script src="{{ asset('assets') }}/plugins/parsleyjs/dist/parsley.min.js"></script>

<script type="text/javascript">


    $(function(){


    });
</script>


@endsection