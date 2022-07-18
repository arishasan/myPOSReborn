@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<link href="{{ asset('assets') }}/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />

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
    <li class="breadcrumb-item"><a href="javascript:;">Sistem Data</a></li>
    <li class="breadcrumb-item active">Log</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Log Aktivitas </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">
      
      <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
          <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active" id="tab_satu">Data Tabel</a>
        </li>
        <!-- <li class="nav-item">
          <a href="#default-tab-2" data-bs-toggle="tab" class="nav-link" id="tab_dua">Print Stiker</a>
        </li> -->
      </ul>
      <div class="tab-content bg-white p-3 rounded-bottom">
        <!-- TAB 1 -->
        <div class="tab-pane fade active show" id="default-tab-1">

          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-3">

                  <div class="form-group row mb-3">
                    <label class="col-lg-12 col-form-label form-label" for="userCari">User</label>
                    <div class="col-lg-12">
                      <select class="default-select2 form-control" id="userCari">
                        <option value="all">[ Semua ]</option>
                        @foreach($data_user as $val)
                          <option value="{{ $val->id }}">{{ $val->name }} - {{ $val->email }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                </div>
                <div class="col-lg-3">

                  <div class="form-group row mb-3">
                    <label class="col-lg-12 col-form-label form-label" for="date_from">Tampilkan Dari</label>
                    <div class="col-lg-12">
                      <input type="text" class="form-control date_picker" id="date_from" value="{{ date('d-m-Y') }}" readonly/>
                    </div>
                  </div>

                </div>
                <div class="col-lg-3">

                  <div class="form-group row mb-3">
                    <label class="col-lg-12 col-form-label form-label" for="date_to">Sampai</label>
                    <div class="col-lg-12">
                      <input type="text" class="form-control date_picker" id="date_to" value="{{ date('d-m-Y') }}" readonly/>
                    </div>
                  </div>

                </div>
                <div class="col-lg-3">
                  
                  <div class="form-group row mb-3">
                    <label class="col-lg-12 col-form-label form-label">Aksi</label>
                    <div class="col-lg-12">
                      <button type="button" class="btn btn-outline-primary form-control" id="cariData"><i class="fa fa-search"></i> Cari</button>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <br/>

          <!-- BEGIN card -->
          <div class="card">
            <div class="card-body">

              <!-- html -->
              <div class="table-responsive">
                <table id="data_table" style="width: 100%" class="table table-bordered table-striped align-middle h4">
                  <thead>
                    <tr>
                      <th width="1%"><label>#</label></th>
                      <th width="10%"><center><label>Tabel</label></center></th>
                      <th><label>Aksi</label></th>
                      <th width="10%"><center><label><b>Tanggal</b></label></center></th>
                      <th width="10%"><center><label>Oleh</label></center></th>
                    </tr>
                  </thead>
                  <tbody id="body_result">
                  </tbody>
                </table>
              </div>

            </div>
          </div>
          <!-- END card -->

          

        </div>
        <!-- END OF TAB 1 -->
      
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
<script src="{{ asset('assets') }}/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
<script src="{{ asset('assets') }}/plugins/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

    var user, from, to;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function callTable(){
      user = $('#userCari').val();
      from = $('#date_from').val();
      to = $('#date_to').val();

      $('#data_table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        bDestroy: true,
        ajax: {
            'type': 'POST',
            'url': "{{ route('get-data-log') }}",
            'data': {
               user: user,
               from: from,
               to: to,
            },
        },
        columns: [
            {data: 'id_log', name: 'id_log'},
            {data: 'table', name: 'table'},
            {data: 'action', name: 'action'},
            {data: 'created_at', name: 'created_at'},
            {data: 'nama_user', name: 'nama_user'},
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
    }

    $(function(){

      $(".default-select2").select2();

      $(".date_picker").datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
      });

      $('#cariData').click(function(){
        callTable();
      });

      callTable();


    });
</script>


@endsection