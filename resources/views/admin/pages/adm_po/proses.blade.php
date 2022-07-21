@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<link href="{{ asset('assets') }}/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />

<link href="{{ asset('assets') }}/summernote/summernote.css" rel="stylesheet" />

<style>
 .map_ganselect {
  height: 300px;  /* The height is 400 pixels */
  width: 100%;  /* The width is the width of the web page */
 }
 td {
  font-size: 10px;
 }
 .note-group-select-from-files {
    display: none;
  }
  .select2-container--open {
      z-index: 9999999
  }
</style>

@section('content')

<div id="content" class="app-content">
  <!-- BEGIN breadcrumb -->
  <ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item">Transaksi</li>
    <li class="breadcrumb-item"><a href="javascript:;">Data</a></li>
    <li class="breadcrumb-item"><a href="{{ route('transaksi-po') }}">Purchase Order</a></li>
    <li class="breadcrumb-item">Proses</li>
    <li class="breadcrumb-item active">{{ $data_po->kode_po }}</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Proses Data Purchase Order </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">
      
      <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
          <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active" id="tab_satu">Proses PO</a>
        </li>
        
      </ul>
      <div class="tab-content bg-white p-3 rounded-bottom">

        <!-- TAB 1 -->
        <div class="tab-pane fade active show" id="default-tab-1">

          
          <form method="POST" action="{{ route('proses-po') }}" class="form-horizontal" data-parsley-validate="true" name="demo-form">  
            @csrf
            <input type="hidden" name="id" value="{{ $data_po->id }}">
            <input type="hidden" name="status" id="stat_nya" value="{{ $status }}">
            <div class="row">
              
              <div class="col-lg-7">
                
                <div class="card">
                  <div class="card-body">
                      
                      <div class="row">
                        <div class="col-lg-3">

                          <div class="form-group row mb-3">
                            <label class="col-lg-12 col-form-label form-label" for="sewa">Tanggal PO <sup class="text-danger">*</sup></label>
                            <div class="col-lg-12">
                              <h5>{{ date('d M Y', strtotime($data_po->tgl_po)) }}</h5>
                            </div>
                          </div>

                        </div>
                        <div class="col-lg-3">

                          <div class="form-group row mb-3">
                            <label class="col-lg-12 col-form-label form-label" for="sewa">Oleh</label>
                            <div class="col-lg-12">
                              @php

                              $namaUser = '';
                              $getUser = \App\Models\UserModel::find($data_po->created_by);
                              if(null !== $getUser){
                                $namaUser = $getUser->name;
                              }

                              @endphp
                              <h5>{{ @$namaUser }}</h5>
                            </div>
                          </div>

                        </div>

                      </div>

                      @if($status == 'SELESAI')

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label" for="sewa">Apakah pesanan sudah sesuai?<sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <select class="form-control" name="apakah_sesuai" id="select_sesuai" required>
                            <option value="">[ Silahkan Pilih ]</option>
                            <option value="1">Ya, Sesuai</option>
                            <option value="2">Tidak, Lakukan Retur</option>
                          </select>
                        </div>
                      </div>

                      @endif

                      <div class="card mb-3">
                        <div class="card-header">
                          Catatan dari <b>Admin</b>
                        </div>
                        <div class="card-body">
                          {!! $data_po->catatan_admin !!}
                        </div>
                      </div>

                        @if($data_po->status == 'BARU')

                          <div class="col-lg-12" <?= Auth()->user()->role == 'Supplier' ? '' : 'hidden' ?>>
                            <div class="form-group row mb-3">
                              <label class="col-lg-12 col-form-label form-label" for="catatan">Catatan dari <b>Supplier</b></label>
                              <div class="col-lg-12">
                                <div class="table-responsive">
                                  <textarea class="form-control catatan" id="catatan" name="catatan_supplier" rows="3" placeholder="Catatan ...">{{ $data_po->catatan_supplier }}</textarea>
                                </div>
                              </div>
                            </div>
                          </div>

                        @else

                        <div class="card mb-3">
                          <div class="card-header">
                            Catatan dari <b>Supplier</b>
                          </div>
                          <div class="card-body">
                            {!! $data_po->catatan_supplier !!}
                          </div>
                        </div>

                        @endif


                        @if($status == 'SELESAI')

                          <div class="col-lg-12 txt_catatan_retur" <?= Auth()->user()->role == 'Supplier' ? 'hidden' : 'hidden' ?>>
                            <div class="form-group row mb-3">
                              <label class="col-lg-12 col-form-label form-label" for="catatan">Catatan Retur dari <b>Admin</b></label>
                              <div class="col-lg-12">
                                <div class="table-responsive">
                                  <textarea class="form-control catatan" id="catatan" name="catatan_retur" rows="3" placeholder="Catatan ...">{{ $data_po->catatan_retur }}</textarea>
                                </div>
                              </div>
                            </div>
                          </div>

                        @else

                        <div class="card mb-3">
                          <div class="card-header">
                            Catatan Retur dari <b>Admin</b>
                          </div>
                          <div class="card-body">
                            {!! $data_po->catatan_retur !!}
                          </div>
                        </div>

                        @endif



                  </div>
                </div>

              </div>

              <div class="col-lg-5">
                
                <!-- BEGIN nav-tabs -->
                <ul class="nav nav-tabs" id="tabDetil">
                  <li class="nav-item">
                    <a href="#tab_det1" data-bs-toggle="tab" class="nav-link active">
                      <span class="d-sm-none">Tab 1</span>
                      <span class="d-sm-block d-none">List Item</span>
                    </a>
                  </li>
                </ul>
                <!-- END nav-tabs -->
                <!-- BEGIN tab-content -->
                <div class="tab-content bg-white p-3">
                  <!-- BEGIN tab-pane -->
                  <div class="tab-pane fade active show" id="tab_det1">
                    
                    <div data-scrollbar="true" data-height="600px">
                      <div id="body_detail_po">
                        

                        @php

                        $sum = 0;

                        if($data_detail_po->count() > 0){

                          foreach($data_detail_po->get() as $key => $val){
                            $getBarang = \App\Models\BarangModel::find($val->id_barang);
                            $satuan = '';

                            if(null !== $getBarang){

                              $getSatuan = \App\Models\SatuanModel::find($getBarang->id_satuan);
                              $satuan = $getSatuan->nama;

                            }
                            @endphp

                            <div class="baris"><div class="card">
                              <input type="hidden" name="id_det[]" value="{{ $val->id }}">
                              <div class="card-body">
                                <div class="d-flex ">
                                  <div class="flex-1 ps-3">
                                    <label style="" class="mb-1"><b>{{ @$getBarang->kode_barang }}</b> - {{ @$getBarang->nama_barang }} <br/>QTY Dipesan (Admin) <b>x{{ $val->qty_dipesan }} {{ $satuan }}</b>

                                      @if($status == 'RETUR')

                                      <br/>QTY Tersedia (Supplier) <b>x{{ $val->qty_tersedia }} {{ $satuan }}</b>
                                      <br/>QTY Retur (Admin) <b>x{{ $val->qty_retur }} {{ $satuan }}</b>

                                      @endif

                                    </label>
                                    <hr>
                                    <div class="row">
                                      <div class="col-lg-6">
                                        <label>Harga Satuan</label><br/><br/>
                                        <input type="text" class="form-control currency" name="harga_satuan[]" value="{{ number_format($val->harga_satuan) }}" {{ $status == 'SELESAI' || $status == 'RETUR' ? 'readonly' : '' }}>
                                      </div>
                                      <div class="col-lg-6 text-end">
                                        @if($status == 'SELESAI')

                                        <label>QTY (Tersedia/Retur) Max: <b>{{ $val->qty_tersedia }}</b></label>
                                        <br/><br/>
                                        <input type="number" class="form-control qty_tersedia" name="qty_tersedia[]" min="1" step="0.1" max="{{ $val->qty_tersedia }}" value="{{ $val->qty_tersedia }}" readonly>

                                        @elseif($status == 'RETUR')

                                        <label>QTY (Diretur) Max: <b>{{ $val->qty_retur }}</b></label>
                                        <br/><br/>
                                        <input type="number" class="form-control qty_tersedia" name="qty_tersedia[]" min="1" step="0.1" max="{{ $val->qty_retur }}" value="{{ $val->qty_retur }}" readonly>
                                        
                                        @else

                                        <label>QTY (Tersedia) Max: <b>{{ $val->qty_dipesan }}</b></label>
                                        <br/><br/>
                                        <input type="number" class="form-control qty_tersedia" name="qty_tersedia[]" min="1" step="0.1" max="{{ $val->qty_dipesan }}" value="{{ ($val->qty_tersedia != 0 ? $val->qty_tersedia : $val->qty_dipesan) }}" {{ $status == 'SELESAI' ? 'readonly' : '' }}>

                                        @endif
                                      </div>
                                    </div>
                                    <br/>
                                    <div class="row" <?= $val->is_exp_date == 0 ? 'hidden' : '' ?>>
                                      <div class="col-lg-12">
                                        Tanggal Kadaluarsa
                                        @if($status == 'SELESAI' || $status == 'RETUR')
                                        <br/>
                                        <b>{{ date('d M Y', strtotime($val->exp_date)) }}</b>
                                        @endif

                                        <br/><br/>
                                        <input type="date" class="form-control" name="tgl_kadaluarsa[]" value="{{ date('Y-m-d', strtotime($val->exp_date)) }}" {{ $status == 'SELESAI' || $status == 'RETUR' ? 'hidden' : '' }}>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div><br/></div>

                            @php


                          }

                        }else{

                        }

                        @endphp

                      </div>
                      <br/>
                      

                    </div>

                    <br/>
                    <br/>


                  </div>
                  <!-- END tab-pane -->
                </div>
                <!-- END tab-content -->

              </div>

            </div>


            <br/>

            <div style="text-align: right;">
              <div class="row">
                <div class="col-lg-12">
                  <a href="{{ route('transaksi-po') }}" class="btn btn-outline-warning"><i class="fa fa-arrow-left"></i> KEMBALI</a>
                  <button type="submit" id="btn_real" hidden>Submit</button>
                  <button type="button" class="btn btn-outline-primary" id="are_you_sure"><i class="fa fa-save"></i> {{ $status }}</button>
                </div>
              </div>
            </div>

          </form>


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
<script src="{{ asset('assets') }}/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
<script src="{{ asset('assets') }}/plugins/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('assets') }}/summernote/summernote.js"></script>


<script type="text/javascript">
    var id;
    var sum;

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    $(document).on("keydown", "form", function(event) { 
        return event.key != "Enter";
    });

    $(function(){

      $('#select_sesuai').on('change', function(){

        if($(this).val() == '2'){

          $(document).find('.qty_tersedia').removeAttr('readonly');
          $('.txt_catatan_retur').removeAttr('hidden');

        }else{
          $(document).find('.qty_tersedia').attr('readonly', true);
          $('.txt_catatan_retur').attr('hidden', true);
        }

      });

      $('.catatan').summernote({
        height: "200px"
      });

      $("form").bind("keypress", function(e) {
          if (e.keyCode == 13) {
              return false;
          }
      });

      $('.dropdown-toggle').dropdown();

      $(".default-select2").select2();

      $('#redirect_tambah_item').click(function(){
        // $('#tabDetil a[href="#tab_det1"]').tab("show");
        $('#modal_tambah_item').modal('show');
      });

      $("#date_picker").datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
      });

      $('#are_you_sure').click(function(){

        swal({
          title: "Informasi",
          text: "Apakah anda yakin?",
          icon: "info",
          buttons: true,
        })
        .then((willDo) => {
          if (willDo) {
            
           $('#btn_real').trigger('click');

          }
        });

      });

    });
</script>


@endsection