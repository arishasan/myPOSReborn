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

              
              <div id="div_single" hidden>
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive" id="holder_table_single" hidden>
                      <table id="data_table_single" style="width: 100%" class="table table-bordered table-striped align-middle h4">
                        <thead>
                          <tr>
                            <th width="1%"></th>
                            <th width="10%"><center><label>Foto</label></center></th>
                            <th width="15%"><label><b>Kode Barang</b></label></th>
                            <th><label>Deskripsi</label></th>
                            <th width="10%"><label>Kategori</label></th>
                            <th class="text-end" width="10%"><label>Harga Perolehan</label></th>
                            <th width="8%"><center><label>Tanggal Perolehan</label></center></th>
                            <th width="5%"><center><label>Status</label></center></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                    <div id="tree_single" hidden></div>
                  </div>
                </div>
              </div>

              <div id="div_all" hidden>
                <div class="row">
                  <div class="col-lg-4">
                    
                    <!-- BEGIN card -->
                      <div class="card">
                        <div class="card-body">

                          <!-- html -->
                          <div class="table-responsive">
                            <table style="width: 100%" class="table table-bordered table-striped align-middle h4">
                              <thead>
                                <tr>
                                  <th width="1%"><center><label>No.</label></center></th>
                                  <th><center><label>Lokasi</label></center></th>
                                  <th class="text-end"><label>Jumlah Barang</label></th>
                                  <th class="text-end"><label>Nominal <label>(Rp)</label></label></th>
                                </tr>
                              </thead>
                              <tbody id="body_result">
                              </tbody>
                              <tfoot>
                                <th></th>
                                <th><center><b>TOTAL</b></center></th>
                                <th class="text-end"><b><label id="jumlah_barang">0</label></b></th>
                                <th class="text-end"><b><label id="nominal_barang">0</label></b></th>
                              </tfoot>
                            </table>
                          </div>

                        </div>
                      </div>
                      <!-- END card -->

                  </div>
                  <div class="col-lg-8">
                    <div class="card">
                      <div class="card-body" id="holder_chart">
                        <canvas id="chart_asset" width="100%"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

          </div>

          <div id="loading" hidden>
            <center><i class="fas fa-circle-notch fa-spin text-primary" style="font-size: 20px"></i></center>
            <center>Memuat..</center>
          </div>

          

        </div>
        <!-- END OF TAB 1 -->
      
      </div>

    </div>
  </div>

</div>


<div class="modal fade" id="modal_detail">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Detail Lokasi</h4>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-lg-12">
            <h4><span class="badge bg-primary" id="lokasi_cek"></span></h4>            
          </div>
          <div class="col-lg-6" style="text-align: right;" hidden>
            <h4><span class="badge bg-primary" id="kategori_cek"></span></h4>
          </div>
        </div>

        <br/>

        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <div id="holder_detail"></div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_detail_barang">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> List Barang</h4>
        <h4 clas><span class="badge bg-primary" id="lokasi_barang">1231231</span></h4>
      </div>
      <div class="modal-body">

        <div class="table-responsive">
          <table id="data_table" style="width: 100%" class="table table-bordered table-striped align-middle h4">
            <thead>
              <tr>
                <th width="1%"></th>
                <th width="10%"><center><label>Foto</label></center></th>
                <th width="15%"><label><b>Kode Barang</b></label></th>
                <th><label>Deskripsi</label></th>
                <th width="10%"><label>Kategori</label></th>
                <th class="text-end" width="10%"><label>Harga Perolehan</label></th>
                <th width="8%"><center><label>Tanggal Perolehan</label></center></th>
                <th width="5%"><center><label>Status</label></center></th>
              </tr>
            </thead>
            <tbody id="body_barang">
            </tbody>
          </table>
        </div>

      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modal_pilih_lokasi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pilih Lokasi</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        
        <div class="row">
          
          <div class="col-lg-8">
            <div id="dataTree_lokasi" class="dataTree_lokasi"></div>
          </div>

          <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <label>Selected Node</label><br/>
                <label id="selected_node" style="font-weight: bold"></label> <br/><br/>
                <label>Node Parent</label><br/>
                <label id="selected_parent" style="font-weight: bold"></label>
              </div>
            </div>
          </div>

        </div>

      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white" id="semua_lokasi" hidden>Semua Lokasi</a>
        <a href="javascript:;" class="btn btn-outline-primary" id="pusat_lokasi" {{ Auth()->user()->id_requester == 0 ? "" : "hidden" }}>Pusat</a>
        <a href="javascript:;" class="btn btn-primary" id="ya_lokasi">Pilih</a>
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
      $('#content_data').prop('hidden', true);
      $('#loading').prop('hidden', false);
      let lokasi = $('#lokasiCari').val();
      kategori = $('#kategoriCari').val();

      let link = '{{ url("laporan/barang/kategori") }}/'+kategori+'/'+lokasi;

      if(lokasi == 'all'){

        $('#div_all').attr('hidden', false);
        $('#div_single').attr('hidden', true);

        $('#body_result').html('');
        $('#jumlah_barang').text('0');
        $('#nominal_barang').text('0');

        $("#chart_asset").remove();

        $('#holder_chart').append('<canvas id="chart_asset" width="100%"></canvas>');

        const ctx = document.getElementById('chart_asset').getContext('2d');

        $.get(link, function(res){

          let parse = JSON.parse(res);
          let jml = 0;
          let nom = 0;

          var labelArray = [];
          var dataArray = [];

          $.each(parse, function(i, e){

            let str = '<tr>'+
                        '<td><center><label>'+(i + 1)+'.</label></center></td>'+
                        '<td><center><label><a href="javascript:void(0)" class="text-primary btn_detail" data-text="'+e.text+'" data-lokasi="'+e.id+'" data-kategori="'+kategori+'" data-kategori-text="'+$('#kategoriCari option:selected').text()+'">'+e.text+'</a></label></center></td>'+
                        '<td class="text-end"><label>'+numberWithCommas(parseInt(e.count))+'</label></td>'+
                        '<td class="text-end"><label>'+numberWithCommas(parseInt(e.nominal))+'</label></td>'+
                      '</tr>';

            $('#body_result').append(str);

            jml += parseInt(e.count);
            nom += parseInt(e.nominal);

            labelArray.push(e.text);
            dataArray.push(e.count);

          });

          const chart_asset = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: labelArray,
                  datasets: [{
                      label: 'Jumlah Barang',
                      data: dataArray,
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(255, 206, 86, 0.2)',
                          'rgba(75, 192, 192, 0.2)',
                          'rgba(153, 102, 255, 0.2)',
                          'rgba(255, 159, 64, 0.2)'
                      ],
                      borderColor: [
                          'rgba(255, 99, 132, 1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(255, 206, 86, 1)',
                          'rgba(75, 192, 192, 1)',
                          'rgba(153, 102, 255, 1)',
                          'rgba(255, 159, 64, 1)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          });

          $('#jumlah_barang').text(numberWithCommas(jml));
          $('#nominal_barang').text(numberWithCommas(nom));
          $('#content_data').prop('hidden', false);
          $('#loading').prop('hidden', true);

        });

      }else if(lokasi == 0){

        $('#div_all').attr('hidden', true);
        $('#div_single').attr('hidden', false);
        $('#loading').prop('hidden', true);
        $('#content_data').prop('hidden', false);

        $('#holder_table_single').attr('hidden', false);
        $('#tree_single').attr('hidden', true);

        $('#data_table_single').DataTable({
          responsive: true,
          processing: true,
          serverSide: true,
          bDestroy: true,
          ajax: {
              'type': 'POST',
              'url': "{{ '123' }}",
              'data': {
                 kategori: kategori,
                 lokasi: lokasi,
              },
          },
          columns: [
              {data: 'id', name: 'id'},
              {data: 'foto', name: 'foto', orderable: false, searchable: false},
              {data: 'kode_barang', name: 'kode_barang'},
              {data: 'deskripsi', name: 'deskripsi'},
              {data: 'id_kategori', name: 'id_kategori', orderable: false, searchable: false},
              {data: 'harga_perolehan', name: 'harga_perolehan'},
              {data: 'tanggal_perolehan', name: 'tanggal_perolehan'},
              {data: 'status', name: 'status'},
          ],
          order: ['0', 'desc'],
          columnDefs: [
            { targets: [0], visible: false},        
          ],
        });

      }else{

        $('#div_all').attr('hidden', true);
        $('#div_single').attr('hidden', false);
        $('#loading').prop('hidden', true);
        $('#content_data').prop('hidden', false);

        $('#holder_table_single').attr('hidden', true);
        $('#tree_single').attr('hidden', false);

        $('#tree_single')
        .on("changed.jstree", function (e, data) {
          if(data.selected.length) {

          }
        })
        .jstree({
          'core' : {
            'multiple' : false,
            'data' : {
                "url" : link,
                "dataType" : "json" 
            }
          }
        });

        $('#tree_single').jstree(true).settings.core.data.url = link;
        $('#tree_single').jstree(true).refresh();


      }

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

      $(document).on('click', '.detail_barang', function(){

        let lokasi = $(this).attr('id-lokasi');
        let kategori = $(this).attr('id-kategori');
        let txt = $(this).attr('text-lokasi');

        $('#lokasi_barang').text(txt);

        $('#data_table').DataTable({
          responsive: true,
          processing: true,
          serverSide: true,
          bDestroy: true,
          ajax: {
              'type': 'POST',
              'url': "{{ '123' }}",
              'data': {
                 kategori: kategori,
                 lokasi: lokasi,
              },
          },
          columns: [
              {data: 'id', name: 'id'},
              {data: 'foto', name: 'foto', orderable: false, searchable: false},
              {data: 'kode_barang', name: 'kode_barang'},
              {data: 'deskripsi', name: 'deskripsi'},
              {data: 'id_kategori', name: 'id_kategori', orderable: false, searchable: false},
              {data: 'harga_perolehan', name: 'harga_perolehan'},
              {data: 'tanggal_perolehan', name: 'tanggal_perolehan'},
              {data: 'status', name: 'status'},
          ],
          order: ['0', 'desc'],
          columnDefs: [
            { targets: [0], visible: false},        
          ],
        });

        $('#modal_detail_barang').modal('show');

      });

      $(document).on('click', '.btn_detail', function(){

        let lokasi = $(this).attr('data-lokasi');
        let kategori = $(this).attr('data-kategori');
        let kategori_text = $(this).attr('data-kategori-text');
        let text = $(this).attr('data-text');

        if(lokasi == 0){

          $('#lokasi_barang').text(text);

          $('#data_table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            bDestroy: true,
            ajax: {
                'type': 'POST',
                'url': "{{ '123' }}",
                'data': {
                   kategori: kategori,
                   lokasi: lokasi,
                },
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'foto', name: 'foto', orderable: false, searchable: false},
                {data: 'kode_barang', name: 'kode_barang'},
                {data: 'deskripsi', name: 'deskripsi'},
                {data: 'id_kategori', name: 'id_kategori', orderable: false, searchable: false},
                {data: 'harga_perolehan', name: 'harga_perolehan'},
                {data: 'tanggal_perolehan', name: 'tanggal_perolehan'},
                {data: 'status', name: 'status'},
            ],
            order: ['0', 'desc'],
            columnDefs: [
              { targets: [0], visible: false},        
            ],
          });

          $('#modal_detail_barang').modal('show');

        }else{

          $('#lokasi_cek').text(text);
          $('#kategori_cek').text((kategori_text == '[ Semua ]' ? "Semua" : kategori_text));

          // let holder = $('#holder_detail');

          let link = "{{ url('laporan/barang/kategori_sublokasi') }}/"+lokasi+'/'+kategori;

          $('#holder_detail')
            .on("changed.jstree", function (e, data) {
              if(data.selected.length) {

              }
            })
            .jstree({
              'core' : {
                'multiple' : false,
                'data' : {
                    "url" : link,
                    "dataType" : "json" 
                }
              }
            });

            $('#holder_detail').jstree(true).settings.core.data.url = link;
            $('#holder_detail').jstree(true).refresh();

          $('#modal_detail').modal('show');

        }

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