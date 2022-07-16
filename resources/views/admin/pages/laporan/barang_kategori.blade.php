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
    <li class="breadcrumb-item"><a href="javascript:;">Penjualan</a></li>
    <li class="breadcrumb-item active">Barang</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Laporan Penjualan Barang</h1>
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
                          <input type="date" class="form-control" id="periodeDari" value="{{ date('Y-01-01') }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label" for="periodeKe">Periode Ke</label>
                        <div class="col-lg-12">
                          <input type="date" class="form-control" id="periodeKe" value="{{ date('Y-12-t') }}">
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-lg-4">

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label" for="kategoriCari">Kategori</label>
                        <div class="col-lg-12">
                          
                          <div class="row">
                            <div class="col-lg-10">
                              <input type="hidden" name="id_kategori" value="all" id="kategoriCari">
                              <input class="form-control" type="text" value="" placeholder="[ Semua ]" id="label_kategori_cari" readonly />
                            </div>
                            <div class="col-lg-2">
                              <button type="button" id="btn_search_kategori" class="btn btn-lg btn-outline-primary form-control" title="Pilih Kategori"><i class="fa fa-search"></i></button>
                            </div>
                          </div>

                        </div>
                      </div>

                    </div>
                    <div class="col-lg-2">
                      
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
                            <th width="10%"><center><label>Thumbnail</label></center></th>
                            <th width="15%"><label><b>Kode Barang</b></label></th>
                            <th><label>Nama Barang</label></th>
                            <th width="15%"><label>Kategori</label></th>
                            <th class="text-center" width="8%"><label>Jumlah Terjual</label></th>
                            <th class="text-end" width="15%"><label>Nominal Terjual</label></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="6"><center><b>Total</b></center></td>
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


<div class="modal fade" id="modal_detail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> List Transaksi</h4>
        <h4 clas><span class="badge bg-primary" id="dari_barang"></span></h4>
      </div>
      <div class="modal-body">

        <div id="holder_detail"></div>

      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modal_pilih_kategori_cari">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pilih Kategori</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        
        <div class="row">
          
          <div class="col-lg-12">
            <div id="dataTree_kategori_cari" class="dataTree_kategori"></div>
          </div>

        </div>

      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white" id="semua_kategori_cari">Semua Kategori</a>
        <a href="javascript:;" class="btn btn-primary" id="ya_kategori_cari">Tutup</a>
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
      
      $('#data_table_single').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        bDestroy: true,
        ajax: {
            'type': 'POST',
            'url': "{{ route('get-laporan-barang') }}",
            'data': {
               periode_dari: $('#periodeDari').val(),
               periode_ke: $('#periodeKe').val(),
               kategori: $('#kategoriCari').val()
            },
        },
        "fnInitComplete": function(oSettings, json) {

          let tot = 0;

          $(document).find('.jml_terjual').each(function(){

            let nom = $(this).text().replace(",", "");
            let temp = parseFloat(tot) + parseFloat(nom);

            tot = temp;

          });
          
          $('#total_nominal').text("Rp. " + tot.toLocaleString());

        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'foto', name: 'foto', orderable: false, searchable: false},
            {data: 'kode_barang', name: 'kode_barang'},
            {data: 'nama_barang', name: 'nama_barang'},
            {data: 'id_kategori', name: 'id_kategori', orderable: false, searchable: false},
            {data: 'jml_terjual', name: 'jml_terjual', orderable: false, searchable: false},
            {data: 'nominal_terjual', name: 'nominal_terjual', orderable: false, searchable: false},
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

      $('#dataTree_kategori_cari')
          .on("changed.jstree", function (e, data) {
            if(data.selected.length) {

              // let id = data.instance.get_node(data.selected[0]).data.id;
              // let nama = data.instance.get_node(data.selected[0]).data.text;
              // let kode = data.instance.get_node(data.selected[0]).data.kode;
              // let parent = data.instance.get_node(data.selected[0]).data.parent_id;
              // let parent_name = data.instance.get_node(data.selected[0]).data.parent_name;

              var i, j, r = [];
              for(i = 0, j = data.selected.length; i < j; i++) {
                r.push(data.instance.get_node(data.selected[i]).data.id);
              }

              $('#kategoriCari').val(r.join(','));
              $('#label_kategori_cari').val(r.length + " kategori dipilih");

            }else{
              $('#kategoriCari').val('all');
              $('#label_kategori_cari').val("[ Semua ]");
            }
          })
          .jstree({
            "checkbox" : {
              "keep_selected_style" : false
            },
            "plugins" : [ "wholerow", "checkbox" ],
            'core' : {
              'multiple' : true,
              'data' : {
                  "url" : '{{ route("get-tree-kategori") }}',
                  "dataType" : "json" 
              }
            }
          });

      $('#btn_search_kategori').click(function(){
        $('#modal_pilih_kategori_cari').modal('show');
      });

      $('#semua_kategori_cari').click(function(){
        $("#dataTree_kategori_cari").jstree("deselect_all");
        $("#dataTree_kategori_cari").jstree("close_all");
        kategoriID = '';
        kategoriName = '';
        $('#kategoriCari').val('all');
        $('#label_kategori_cari').val('[ Semua ]');
        $('#modal_pilih_kategori_cari').modal('hide');
      });

      $('#ya_kategori_cari').click(function(){
        $('#modal_pilih_kategori_cari').modal('hide');
      });

      $(document).on('click', '.btn_detail', function(){

       let id = $(this).attr('data-id');
       let nama = $(this).attr('data-nama');

       $('#dari_barang').text(nama);

       $('body').addClass('loading');

       let link = '{{ url("laporan/get_list_transaksi") }}';
       let data = {
        id: id,
        periode_dari: $('#periodeDari').val(),
        periode_ke: $('#periodeKe').val(),
        kategori: $('#kategoriCari').val()
       };

       $.post(link, data, function(res){
        $('body').removeClass('loading');
        $('#holder_detail').html(res);
        $('#holder_detail').find('#det_table_trx').DataTable(
          {
            dom: 'lBfrtip',
            buttons: [
              { extend: 'copy', className: 'btn-sm', footer: true },
              { extend: 'csv', className: 'btn-sm', footer: true },
              { extend: 'excel', className: 'btn-sm', footer: true },
              { extend: 'pdf', className: 'btn-sm', footer: true },
              { extend: 'print', className: 'btn-sm', footer: true }
            ],
          }
        );
        $('#modal_detail').modal('show');
       });

      });

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