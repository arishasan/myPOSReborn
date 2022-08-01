@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<link href="{{ asset('assets') }}/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset('assets') }}/jstree/dist/themes/default/style.min.css" />

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
    <li class="breadcrumb-item"><a href="javascript:;">Laporan</a></li>
    <li class="breadcrumb-item active">Transaksi</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Laporan Transaksi</h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">
      
      <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
          <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active" id="tab_satu">Data</a>
        </li>
        <!-- <li class="nav-item">
          <a href="#default-tab-2" data-bs-toggle="tab" class="nav-link" id="tab_dua">Print Stiker</a>
        </li> -->
      </ul>
      <div class="tab-content bg-white p-3 rounded-bottom">
        <!-- TAB 1 -->
        <div class="tab-pane fade active show" id="default-tab-1">

          
          <div id="content_data">
              
              <div class="card">
                <div class="card-body">
                  <div class="row">

                    <div class="col-lg-3">
                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label" for="periodeDari">Periode Dari</label>
                        <div class="col-lg-12">
                          <input type="date" class="form-control" id="periode_dari" value="{{ date('Y-01-01') }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label" for="periodeKe">Periode Ke</label>
                        <div class="col-lg-12">
                          <input type="date" class="form-control" id="periode_ke" value="{{ date('Y-12-t') }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="statusCari">Status</label>
                          <div class="col-lg-12">
                            <select class="default-select2 form-control" id="statusCari">
                              <option value="all">[ Semua ]</option>
                              <option value="PAID">PAID</option>
                              <option value="PENDING/ORDER">PENDING/ORDER</option>
                              <option value="CANCEL">CANCEL</option>
                              <option value="VOID">VOID</option>
                            </select>
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

              
              <div id="div_single">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive" id="holder_table_single">
                      <table id="data_table_single" style="width: 100%" class="table table-bordered table-striped align-middle h4">
                        <thead>
                          <tr>
                            <th width="1%"></th>
                            <th ><label>Kode Transaksi</label></th>
                            <th ><label>Nama Pembeli</label></th>
                            <th width="10%"><center><b>Status</b></center></th>
                            <th width="10%"><label>Tgl. Transaksi</label></th>
                            <th width="10%" style="text-align: right"><label>Total Harga</label></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="5"><center><b>Total</b></center></td>
                            <td style="text-align: right;"><b id="total_nominal">Rp. 0</b></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

          </div>
          

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

<script src="{{ asset('assets') }}/jstree/dist/jstree.min.js"></script>

<script type="text/javascript">

    var user, from, to;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    function callResult(){

      let periode_dari = $('#periode_dari').val();
      let periode_ke = $('#periode_ke').val();
      let statusCari = $('#statusCari').val();
      
      $('#data_table_single').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        bDestroy: true,
        ajax: {
            'type': 'POST',
            'url': "{{ route('get-laporan-transaksi') }}",
            'data': {
               periode_dari: periode_dari,
               periode_ke: periode_ke,
               status: statusCari,
            },
        },
        "fnInitComplete": function(oSettings, json) {

          let tot = 0;

          $(document).find('.jml_terjual').each(function(){

            let nom = $(this).text().replace(",", "");
            let temp = parseFloat(tot) + parseFloat(nom);

            tot = temp;

          });
          
          $('#total_nominal').text("Rp. " + tot.toLocaleString('en-US'));

        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'kode_transaksi', name: 'kode_transaksi'},
            {data: 'nama_pembeli', name: 'nama_pembeli'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'jumlah_harga', name: 'jumlah_harga'},
        ],
        order: ['0', 'desc'],
        columnDefs: [
          { targets: [0], visible: false},        
        ],
        dom: 'lBfrtip',
        buttons: [
          { extend: 'copy', className: 'btn-sm', footer: true },
          { extend: 'csv', className: 'btn-sm', footer: true },
          { extend: 'excel', className: 'btn-sm', footer: true },
          { extend: 'pdf', className: 'btn-sm', footer: true },
          { extend: 'print', className: 'btn-sm', footer: true }
        ],
      });

    }

    $(function(){

      var kategoriID, kategoriName;

      $(".default-select2").select2();

      $(".date_picker").datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
      });

      $('#cariData').click(function(){
        callResult();
      });



    });
</script>


@endsection