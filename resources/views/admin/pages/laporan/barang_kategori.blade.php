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
    <li class="breadcrumb-item"><a href="javascript:;">Laporan</a></li>
    <li class="breadcrumb-item active">Barang</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Laporan Data Barang </h1>
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
                    <div class="col-lg-9">

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label" for="kategoriBarang">Kategori</label>
                        <div class="col-lg-12">
                          <select class="default-select2 form-control" id="kategoriBarang">
                            <option value="all">[ Semua ]</option>
                            @foreach($data_kategori as $val)
                              <option value="{{ $val->id }}">{{ $val->nama }}</option>
                            @endforeach
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
                                <th class="text-end"><label>Jumlah</label></th>
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

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    function callResult(){
      $('#content_data').prop('hidden', true);
      $('#loading').prop('hidden', false);
      kategori = $('#kategoriBarang').val();

      let link = '{{ url("laporan/barang/kategori") }}/'+kategori;
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
                      '<td><center><label>'+e.text+'</label></center></td>'+
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

    }

    $(function(){

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