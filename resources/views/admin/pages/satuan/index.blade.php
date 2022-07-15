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
  font-size: 12px;
 }
 th {
  font-size: 12px;
 }
</style>

@section('content')

<div id="content" class="app-content">
  <!-- BEGIN breadcrumb -->
  <ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Master</a></li>
    <li class="breadcrumb-item active">Satuan</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Master Satuan </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">
      
      <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
          <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active" id="tab_satu">Data Tabel</a>
        </li>
        <li class="nav-item">
          <a href="#default-tab-3" data-bs-toggle="tab" class="nav-link" id="tab_tiga">Tambah Data Baru</a>
        </li>
      </ul>
      <div class="tab-content bg-white p-3 rounded-bottom">
        <!-- TAB 1 -->
        <div class="tab-pane fade active show" id="default-tab-1">

          <!-- Klik di <a href="javascript:void(0)" id="redirect_form_add">sini</a> untuk menambahkan data baru. -->
          
          <!-- BEGIN card -->
          <div class="card">
            <div class="card-body">

              <!-- html -->
              <div class="table-responsive">
                <table id="data_table" style="width: 100%" class="table table-bordered table-striped align-middle h4">
                  <thead>
                    <tr>
                      <th width="1%"></th>
                      <th><label>Nama</label></th>
                      <th width="10%"><center><label>Status</label></center></th>
                      <th width="8%" data-orderable="false"></th>
                    </tr>
                  </thead>
                  <tbody id="body_satuan">
                  </tbody>
                </table>
              </div>

            </div>
          </div>
          <!-- END card -->

          

        </div>
        <!-- END OF TAB 1 -->

        <!-- TAB 3 -->
        <div class="tab-pane fade" id="default-tab-3">
          
          <div class="card">
            <div class="card-body">
              <form action="{{ route('simpan-satuan') }}" method="POST" class="form-horizontal" data-parsley-validate="true">
                @csrf
                <div class="form-group row mb-3">
                  <label class="col-lg-3 col-form-label form-label" for="nama">Nama Satuan Barang <sup class="text-danger">*</sup> :</label>
                  <div class="col-lg-9">
                    <input class="form-control" type="text" name="nama" placeholder="Required" data-parsley-required="true" />
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
        <!-- END OF TAB 3 -->
      </div>

    </div>
  </div>

</div>

<div class="modal modal-message fade" id="modal-alert">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-body">
        <br/>
        <div class="alert alert-white">
          <h5><i class="fa fa-info-circle"></i> Perhatian</h5>
          <p id="alert_content"></p>
          <center>
            <a href="javascript:;" class="btn btn-outline-primary" data-bs-dismiss="modal" id="btn_submit"><i class="fa fa-save"></i> Ya</a>
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

      $('#data_table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('get-data-satuan') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'nama', name: 'nama'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: ['1', 'desc'],
        columnDefs: [
          { targets: [0], visible: false},        
        ],
        dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',
        buttons: [
          { extend: 'copy', className: 'btn-sm' },
          { extend: 'csv', className: 'btn-sm' },
          { extend: 'excel', className: 'btn-sm' },
          { extend: 'pdf', className: 'btn-sm' },
          { extend: 'print', className: 'btn-sm' }
        ],
      });

      $('#redirect_form_add').click(function(){
        $('#myTab a[href="#default-tab-3"]').tab("show");
      });

      $('#body_satuan').on('click', '.delete_button', function(){

        let dd = $(this).attr('data-id');
        id = dd;

        $('#alert_content').text("Apakah Anda yakin akan menghapus data ini?");
        $('#modal-alert').modal('show');

      });

      $('#btn_submit').click(function(){

        let link = '{{ url("master/satuan/delete") }}/'+id;
        $.get(link, function(res){
          location.reload();
        });

      });


    });
</script>


@endsection