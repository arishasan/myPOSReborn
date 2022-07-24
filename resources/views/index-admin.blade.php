@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<style>
.map_gan {
  height: 390px;  /* The height is 400 pixels */
  width: 100%;  /* The width is the width of the web page */
 }
</style>

@section('content')

@if(Auth()->user()->role == 'Admin' || Auth()->user()->role == 'Pemilik')

<div id="content" class="app-content">
  <!-- BEGIN breadcrumb -->
  <div class="row">
    <div class="col-lg-6">
      <h1 class="mb-3">Dashboard</h1>
    </div>
    <div class="col-lg-6">
      
      <div class="row">
        <div class="col-lg-4">
          <label for="">Bulan</label>
          <select name="" id="bulanNya" class="form-control">
            <option value="All">[ Semua ]</option>
            <option value="01" <?= date('m') == '01' ? 'selected' : '' ?>>Januari</option>
            <option value="02" <?= date('m') == '02' ? 'selected' : '' ?>>Februari</option>
            <option value="03" <?= date('m') == '03' ? 'selected' : '' ?>>Maret</option>
            <option value="04" <?= date('m') == '04' ? 'selected' : '' ?>>April</option>
            <option value="05" <?= date('m') == '05' ? 'selected' : '' ?>>Mei</option>
            <option value="06" <?= date('m') == '06' ? 'selected' : '' ?>>Juni</option>
            <option value="07" <?= date('m') == '07' ? 'selected' : '' ?>>Juli</option>
            <option value="08" <?= date('m') == '08' ? 'selected' : '' ?>>Agustus</option>
            <option value="09" <?= date('m') == '09' ? 'selected' : '' ?>>September</option>
            <option value="10" <?= date('m') == '10' ? 'selected' : '' ?>>Oktober</option>
            <option value="11" <?= date('m') == '11' ? 'selected' : '' ?>>November</option>
            <option value="12" <?= date('m') == '12' ? 'selected' : '' ?>>Desember</option>
          </select>
        </div>
        <div class="col-lg-4">
          <label for="">Tahun</label>
          <select name="" id="tahunNya" class="form-control">
            <option>{{ date('Y', strtotime('+2 years')) }}</option>
            <option>{{ date('Y', strtotime('+1 year')) }}</option>
            <option selected>{{ date('Y') }}</option>
            <option>{{ date('Y', strtotime('-1 year')) }}</option>
            <option>{{ date('Y', strtotime('-2 years')) }}</option>
          </select>
        </div>
        <div class="col-lg" style="text-align: right;">
          <label for="">&nbsp;</label><br/>
          <button class="btn btn-outline-primary form-control" id="btn_cari"><i class="fa fa-search"></i> Proses</button>
        </div>
      </div>

    </div>
  </div>
  <!-- END breadcrumb -->

  <br/>


    <div id="main_holder">
        
      <!-- BEGIN row -->
      <div class="row">
        <!-- BEGIN col-6 -->
        <div class="col-xl-6">
          <!-- BEGIN card -->
          <div class="card border-0 mb-3 overflow-hidden ">
            <!-- BEGIN card-body -->
            <div class="card-body">
              <!-- BEGIN row -->
              <div class="row">
                <!-- BEGIN col-7 -->
                <div class="col-xl-7 col-lg-8">
                  <!-- BEGIN title -->
                  <div class="mb-3 text-gray-500">
                    <b>RINGKASAN TRANSAKSI</b>
                    <span class="ms-2">
                      <i class="fa fa-info-circle" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="RINGKASAN TRANSAKSI" data-bs-placement="top" data-bs-content="Menampilkan informasi transaksi pada bulan tertentu."></i>
                    </span>
                  </div>
                  <!-- END title -->
                  <!-- BEGIN total-sales -->
                  <div class="d-flex mb-1">
                    <h2 class="mb-0">Rp. <span  id="tot_trx" data-value="5">0.00</span></h2>
                    <div class="ms-auto mt-n1 mb-n1"><div id="total-sales-sparkline"></div></div>
                  </div>
                  <!-- END total-sales -->
                  <!-- BEGIN percentage -->
                  <div class="mb-3 text-gray-500">
                    NOMINAL TRANSAKSI <small>(dalam rupiah)</small>
                  </div>
                  <!-- END percentage -->
                  <hr class="bg-white-transparent-5" />
                  <!-- BEGIN row -->
                  <div class="row text-truncate">
                    <!-- BEGIN col-6 -->
                    <div class="col">
                      <div class="fs-12px text-primary-500"><small>Nominal. Trx (PAID)</small></div>
                      <div class="fs-12px mb-5px fw-bold">
                        Rp. <span  id="tot_paid" data-value="100000000"></span>
                      </div>
                      <!-- <div class="progress h-5px rounded-3 bg-gray-900 mb-5px">
                        <div class="progress-bar progress-bar-striped rounded-right bg-teal" data-animation="width" data-value="55%" style="width: 0%"></div>
                      </div> -->
                    </div>
                    <!-- END col-6 -->
                    <!-- END col-6 -->
                    <div class="col">
                      <div class="fs-12px text-danger-500"><small>Nominal. Trx (VOID)</small></div>
                      <div class="fs-12px mb-5px fw-bold">
                        Rp. <span  id="tot_void" data-value="100000000"></span>
                      </div>
                      <!-- <div class="progress h-5px rounded-3 bg-gray-900 mb-5px">
                        <div class="progress-bar progress-bar-striped rounded-right" data-animation="width" data-value="55%" style="width: 0%"></div>
                      </div> -->
                    </div>
                  </div>
                  <!-- BEGIN row -->
                  <div class="row text-truncate">
                    <!-- BEGIN col-6 -->
                    <div class="col">
                      <div class="fs-12px text-warning-500"><small>Nominal. Trx (PENDING)</small></div>
                      <div class="fs-12px mb-5px fw-bold">
                        Rp. <span  id="tot_pending" data-value="100000000"></span>
                      </div>
                      <!-- <div class="progress h-5px rounded-3 bg-gray-900 mb-5px">
                        <div class="progress-bar progress-bar-striped rounded-right bg-teal" data-animation="width" data-value="55%" style="width: 0%"></div>
                      </div> -->
                    </div>
                    <!-- END col-6 -->
                    <!-- END col-6 -->
                    <div class="col">
                      <div class="fs-12px text-danger-500"><small>Nominal. Trx (CANCEL)</small></div>
                      <div class="fs-12px mb-5px fw-bold">
                        Rp. <span  id="tot_cancel" data-value="100000000"></span>
                      </div>
                      <!-- <div class="progress h-5px rounded-3 bg-gray-900 mb-5px">
                        <div class="progress-bar progress-bar-striped rounded-right" data-animation="width" data-value="55%" style="width: 0%"></div>
                      </div> -->
                    </div>
                  </div>
                  <!-- END row -->
                </div>
                <!-- END col-7 -->
                <!-- BEGIN col-5 -->
                <div class="col-xl-5 col-lg-4 align-items-center d-flex justify-content-center">
                  <img src="{{ asset('assets') }}/img/svg/img-1.svg" height="auto" class="d-none d-lg-block" />
                </div>
                <!-- END col-5 -->
              </div>
              <!-- END row -->
              <br/>
            </div>
            <!-- END card-body -->
          </div>
          <!-- END card -->
        </div>
        <!-- END col-6 -->
        <!-- BEGIN col-6 -->
        <div class="col-xl-6">
          <!-- BEGIN row -->
          <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-sm-6">
              <!-- BEGIN card -->
              <div class="card border-0 text-truncate mb-3 " style="height: 211px">
                <!-- BEGIN card-body -->
                <div class="card-body">
                  <!-- BEGIN title -->
                  <div class="mb-3 text-gray-500">
                    <b class="mb-3">RINGKASAN TRANSAKSI</b> 
                    <span class="ms-2"><i class="fa fa-info-circle" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="RINGKASAN TRANSAKSI" data-bs-placement="top" data-bs-content="Ringkasan transaksi." data-original-title="" title=""></i></span>
                  </div>
                  <!-- END title -->
                  <!-- BEGIN conversion-rate -->
                  <!-- <div class="d-flex align-items-center mb-2">
                    <h2 class="mb-0"><span data-animation="number" data-value="2.19">0.00</span>%</h2>
                    <div class="ms-auto">
                      <div id="conversion-rate-sparkline"></div>
                    </div>
                  </div> -->
                  <!-- END conversion-rate -->
                  <!-- BEGIN percentage -->
                  <!-- <div class="mb-4 text-gray-500"> -->
                    <!-- <i class="fa fa-caret-down"></i> <span data-animation="number" data-value="0.50">0.00</span>% dibandingkan bulan lalu -->
                  <!-- </div> -->
                  <!-- END percentage -->
                  <!-- BEGIN info-row -->
                  <div class="d-flex">
                    <div class="d-flex align-items-center">
                      <i class="fa fa-circle text-red fs-8px me-2"></i>
                      Jml. Transaksi (PAID)
                    </div>
                    <div class="d-flex align-items-center ms-auto">
                      <!-- <div class="text-gray-500 fs-11px"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="262">0</span>%</div> -->
                      <div class="w-50px text-end ps-2 fw-bold"><span id="jml_trx_paid" data-value="5">0</span></div>
                    </div>
                  </div>
                  <!-- END info-row -->
                  <!-- BEGIN info-row -->
                  <div class="d-flex">
                    <div class="d-flex align-items-center">
                      <i class="fa fa-circle text-warning fs-8px me-2"></i>
                      Jml. Transaksi (PENDING/ORDER)
                    </div>
                    <div class="d-flex align-items-center ms-auto">
                      <!-- <div class="text-gray-500 fs-11px"><i class="fa fa-caret-up"></i> <span data-value="11">0</span>%</div> -->
                      <div class="w-50px text-end ps-2 fw-bold"><span id="jml_trx_pending" data-value="3">0</span></div>
                    </div>
                  </div>
                  <!-- END info-row -->
                  <!-- BEGIN info-row -->
                  <div class="d-flex">
                    <div class="d-flex align-items-center">
                      <i class="fa fa-circle text-lime fs-8px me-2"></i>
                      Jml. Transaksi (VOID)
                    </div>
                    <div class="d-flex align-items-center ms-auto">
                      <!-- <div class="text-gray-500 fs-11px"><i class="fa fa-caret-up"></i> <span data-value="57">0</span>%</div> -->
                      <div class="w-50px text-end ps-2 fw-bold"><span id="jml_trx_void" data-value="1">0</span></div>
                    </div>
                  </div>
                  <!-- END info-row -->

                  <div class="d-flex">
                    <div class="d-flex align-items-center">
                      <i class="fa fa-circle text-lime fs-8px me-2"></i>
                      Jml. Transaksi (CANCEL)
                    </div>
                    <div class="d-flex align-items-center ms-auto">
                      <!-- <div class="text-gray-500 fs-11px"><i class="fa fa-caret-up"></i> <span data-value="57">0</span>%</div> -->
                      <div class="w-50px text-end ps-2 fw-bold"><span id="jml_trx_cancel" data-value="1">0</span></div>
                    </div>
                  </div>

                  <!-- BEGIN info-row -->
                  <div class="d-flex">
                    <div class="d-flex align-items-center">
                      <i class="fa fa-circle text-cyan fs-8px me-2"></i>
                      Jml. Purchase Order
                    </div>
                    <div class="d-flex align-items-center ms-auto">
                      <!-- <div class="text-gray-500 fs-11px"><i class="fa fa-caret-up"></i> <span data-value="57">0</span>%</div> -->
                      <div class="w-50px text-end ps-2 fw-bold"><span id="jml_trx_po" data-value="1">0</span></div>
                    </div>
                  </div>
                  <!-- END info-row -->

                  <br/>
                  <br/>
                  <br/>

                </div>
                <!-- END card-body -->
              </div>
              <!-- END card -->
            </div>
            <!-- END col-6 -->
            <!-- BEGIN col-6 -->
            <div class="col-sm-6">
              <!-- BEGIN card -->
              <div class="card border-0 text-truncate mb-3 " style="height: 211px">
                <!-- BEGIN card-body -->
                <div class="card-body">
                  <!-- BEGIN title -->
                  <div class="mb-3 text-gray-500">
                    <b class="mb-3">RINGKASAN DATA</b> 
                    <span class="ms-2"><i class="fa fa-info-circle" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="RINGKASAN DATA" data-bs-placement="top" data-bs-content="Rekap data master terbaru pada bulan ini." data-original-title="" title=""></i></span>
                  </div>
                  <!-- END title -->
                 
                  <!-- BEGIN conversion-rate -->
                  <!-- <div class="d-flex align-items-center mb-1">
                    <h4 class="text-white">{{ date('d M Y') }}</h4>
                    <div class="ms-auto">
                      <div id="conversion-rate-sparkline"></div>
                    </div>
                  </div> -->
                  <!-- END conversion-rate -->

                  <!-- BEGIN info-row -->
                  <div class="d-flex">
                    <div class="d-flex align-items-center">
                      <i class="fa fa-circle text-teal fs-8px me-2"></i>
                      Jml. Supplier
                    </div>
                    <div class="d-flex align-items-center ms-auto">
                      <div class="w-50px text-end ps-2 fw-bold"><span id="master_lokasi" data-value="200">{{ number_format($count_supplier) }}</span></div>
                    </div>
                  </div>
                  <!-- END info-row -->
                  <!-- BEGIN info-row -->
                  <div class="d-flex">
                    <div class="d-flex align-items-center">
                      <i class="fa fa-circle text-blue fs-8px me-2"></i>
                      Jml. User Supplier
                    </div>
                    <div class="d-flex align-items-center ms-auto">
                      <div class="w-50px text-end ps-2 fw-bold"><span id="master_requester" data-value="100">{{ number_format($count_user_supplier) }}</span></div>
                    </div>
                  </div>
                  <!-- END info-row -->
                  <!-- BEGIN info-row -->
                  <div class="d-flex">
                    <div class="d-flex align-items-center">
                      <i class="fa fa-circle text-cyan fs-8px me-2"></i>
                      Jml. User Pembeli
                    </div>
                    <div class="d-flex align-items-center ms-auto">
                      <div class="w-50px text-end ps-2 fw-bold"><span id="master_vendor" data-value="50">{{ number_format($count_user_pembeli) }}</span></div>
                    </div>
                  </div>
                  <!-- END info-row -->
                  <!-- BEGIN info-row -->
                  <div class="d-flex">
                    <div class="d-flex align-items-center">
                      <i class="fa fa-circle text-teal fs-8px me-2"></i>
                      Jml. Barang
                    </div>
                    <div class="d-flex align-items-center ms-auto">
                      <div class="w-50px text-end ps-2 fw-bold"><span id="master_kategori" data-value="200">{{ number_format($count_barang) }}</span></div>
                    </div>
                  </div>
                  <!-- END info-row -->


                </div>
                <!-- END card-body -->
              </div>
              <!-- END card -->
            </div>
            <!-- END col-6 -->
          </div>
          <!-- END row -->
        </div>
        <!-- END col-6 -->
      </div>
      <!-- END row -->

      <!-- BEGIN row -->
      <div class="row">
        <!-- BEGIN col-8 -->
        <div class="col-xl-8 col-lg-6">
          <!-- BEGIN card -->
          <div class="card border-0 mb-3" >
            <div class="card-body">
              <div class="mb-3 text-gray-500 "><b>CHART PENDAPATAN/TRANSAKSI</b> <span class="ms-2"><i class="fa fa-info-circle" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="CHART PENDAPATAN/TRANSAKSI" data-bs-content="Melihat jumlah pendapatan/transaksi yang terjadi pada setiap hari/bulan nya di bulan/tahun tertentu." data-original-title="" title=""></i></span></div>
            </div>
            <div class="card-body">
              <canvas id="chart_nya" width="100%" class="h-450px"></canvas>
            </div>
          </div>
          <!-- END card -->
        </div>
        <!-- END col-8 -->
        <!-- BEGIN col-4 -->
        <div class="col-xl-4 col-lg-6">
          <!-- BEGIN widget-map -->
          <div class="widget-map rounded mb-4" data-id="widget">
            <!-- BEGIN widget-input-container -->
            <div class="widget-input-container p-3">

              <div class="text-gray-500 "><b>5 Transaksi Terakhir</b> <span class="ms-2"><i class="fa fa-info-circle" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="5 Transaksi Terakhir" data-bs-placement="top" data-bs-content="5 Transaksi Terakhir" data-original-title="" title=""></i></span></div>

            </div>
            <!-- END widget-input-container -->
            <!-- BEGIN widget-map-body -->
            <div class="widget-map-body">

              <div id="holder_trx_terakhir" >

              </div>

            </div>
            <!-- END widget-map-body -->
            <!-- BEGIN widget-map-list -->
            <div class="widget-map-list" data-id="widget">
              <div class="widget-list bg-none">
                <!-- BEGIN widget-list-item -->
                <div class="widget-list-item">
                  <div class="widget-list-content">
                    <!-- <h4 class="widget-list-title text-gray-500">Lihat Detil</h4> -->
                  </div>
                  <!-- <div class="widget-list-action"> -->
                    <!-- <a href="#" data-bs-toggle="dropdown" class="text-gray-500"><i class="fa fa-angle-right fa-2x"></i></a> -->
                  <!-- </div> -->
                </div>
                <!-- END widget-list-item -->
              </div>
            </div>
            <!-- END widget-map-list -->
          </div>
         
        </div>
        <!-- END col-4 -->
       
      </div>
      <!-- END row -->

    </div>

</div>

@else

<div id="content" class="app-content">
  <!-- BEGIN breadcrumb -->
  <div class="row">
    <div class="col-lg-6">
      <h1 class="mb-3">Dashboard</h1>
    </div>
  </div>
  <!-- END breadcrumb -->

  <br/>

  <div class="card">
    <div class="card-header">
      Welcome Message
    </div>
    <div class="card-body">
      <label style="font-size: 18px">Selamat Datang, <b>{{ Auth()->user()->name }}</b> di aplikasi MyPOS.</label>
    </div>
  </div>

</div>

@endif

<div class="modal fade" id="modal-detail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="title_requester"></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                  
                  <div class="row">
                    <div class="col-lg-6">

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label" for="vendor">Kode Requester </label>
                        <div class="col-lg-12">
                          <label id="kode_requester"></label>
                        </div>
                      </div>

                    </div>
                    <div class="col-lg-6">

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label" for="sewa">Nama Requester </label>
                        <div class="col-lg-12">
                          <label id="nama_requester"></label>
                        </div>
                      </div>

                    </div>

                  </div>

                  <div class="row">

                    <div class="col-lg-6">
                      <div class="form-group row">
                        <label class="col-lg-12 col-form-label form-label" for="catatan">Latitude</label>
                        <div class="col-lg-12">
                          <label id="lat_requester"></label>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Longitude </label>
                        <div class="col-lg-12">
                          <label id="long_requester"></label>
                        </div>
                      </div>
                    </div>

                  </div>

              </div>
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

@endsection

@section('scriptplus')

<script src="{{ asset('assets') }}/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/plugins/select2/dist/js/select2.min.js"></script>

<script type="text/javascript">
  var marker = null,map = null;

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    function callData(){

      $('body').addClass('loading');

      let bulan = $('#bulanNya').val();
      let tahun = $('#tahunNya').val();

      let link = '{{ url("dashboard/get_data/") }}/'+bulan+'/'+tahun;

      $.get(link, function(res){
        let parse = JSON.parse(res);

        $('#tot_trx').text(parse.tot_trx.toLocaleString('en-US'));
        $('#tot_paid').text(parse.tot_paid.toLocaleString('en-US'));
        $('#tot_pending').text(parse.tot_pending.toLocaleString('en-US'));
        $('#tot_void').text(parse.tot_void.toLocaleString('en-US'));
        $('#tot_cancel').text(parse.tot_cancel.toLocaleString('en-US'));
        $('#jml_trx_paid').text(parse.jml_trx_paid.toLocaleString('en-US'));
        $('#jml_trx_pending').text(parse.jml_trx_pending.toLocaleString('en-US'));
        $('#jml_trx_void').text(parse.jml_trx_void.toLocaleString('en-US'));
        $('#jml_trx_cancel').text(parse.jml_trx_cancel.toLocaleString('en-US'));
        $('#jml_trx_po').text(parse.jml_trx_po.toLocaleString('en-US'));

        let str = '';

        $.each(parse.data_trx_terakhir, function(idx, val){
          console.log(val);

          let stat = '';

          if(val.status == 'PAID'){
            stat = 'text-success';
          }else if(val.status == 'PENDING/ORDER'){
            stat = 'text-warning';
          }else if(val.status == 'VOID'){
            stat = 'text-danger';
          }else if(val.status == 'CANCEL'){
            stat = 'text-danger';
          }

          let tgl = new Date(val.created_at).toString();

          let temp = '<div class="card m-3">'+
                  '<div class="card-body">'+
                    '<div class="row vertical-align">'+
                      '<div class="col-lg-1">'+
                        '<i class="fa fa-database text-primary"></i>'+
                      '</div>'+
                      '<div class="col-lg-7">'+
                        '<b class="text-primary">'+val.kode_transaksi+'</b> <br/>'+
                        val.nama_pembeli+'<br/>'+
                        '<small><i>'+tgl+'</i></small>'+
                      '</div>'+
                      '<div class="col-lg-4 text-end">'+
                        '<b class="'+stat+'">'+val.status+'</b>'+
                        '<br/>'+
                        'Rp. '+(parseFloat(val.jumlah_harga) - parseFloat(val.diskon_nominal)).toLocaleString('en-US')+
                      '</div>'+
                    '</div>'+
                  '</div>'+
                '</div>';

          str += temp;

        });

        var d_labels = [];
        var d_isi = [];

        $.each(parse.chart_labels, function(i, v){
          d_labels.push(v);
        });

        $.each(parse.chart_isi, function(i, v){
          d_isi.push(v);
        });

        let chartStatus = Chart.getChart("chart_nya");
        if (chartStatus != undefined) {
          chartStatus.destroy();
        }

        const ctx = document.getElementById('chart_nya').getContext('2d');

        const chart_nya = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: d_labels,
                datasets: [{
                    label: 'Nominal Transaksi',
                    data: d_isi,
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

        $('#holder_trx_terakhir').html(str);

        $('body').removeClass('loading');

      });

    }

    $(function(){

      $('#btn_cari').click(function(){
        callData();
      });

      @if(Auth()->user()->role == 'Admin' || Auth()->user()->role == 'Pemilik')
      callData();
      @endif

    });
</script>


@endsection