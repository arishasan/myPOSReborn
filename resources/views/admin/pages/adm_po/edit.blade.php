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
    <li class="breadcrumb-item">Edit</li>
    <li class="breadcrumb-item active">{{ $data_po->kode_po }}</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Edit Data Purchase Order </h1>
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

          
          <form method="POST" action="{{ route('update-po') }}" class="form-horizontal" data-parsley-validate="true" name="demo-form">  
            @csrf
            <input type="hidden" name="id" value="{{ $data_po->id }}">
            <div class="row">
              
              <div class="col-lg-8">
                
                <div class="card">
                  <div class="card-body">
                      
                      <div class="row">
                        <div class="col-lg-6">

                          <div class="form-group row mb-3">
                            <label class="col-lg-12 col-form-label form-label" for="supplier">Supplier <sup class="text-danger">*</sup></label>
                            <div class="col-lg-12">
                              <select class="default-select2 form-control" name="id_supplier" id="supplier" data-parsley-required="true">
                                <option value="">[ Silahkan Pilih ]</option>
                                @foreach($data_supplier as $val)
                                  <option value="{{ $val->id }}" <?= ($val->id == $data_po->id_supplier ? 'selected' : '') ?>>{{ $val->nama }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>

                        </div>
                        <div class="col-lg-6">

                          <div class="form-group row mb-3">
                            <label class="col-lg-12 col-form-label form-label" for="sewa">Tanggal PO <sup class="text-danger">*</sup></label>
                            <div class="col-lg-12">
                              <input type="text" class="form-control" id="date_picker" name="tanggal_po" value="{{ date('d-m-Y', strtotime($data_po->tgl_po)) }}" data-parsley-required="true"/>
                            </div>
                          </div>

                        </div>

                      </div>
                     
                      <div class="row">

                        <div class="col-lg-12" <?= Auth()->user()->role == 'Admin' ? '' : 'hidden' ?>>
                          <div class="form-group row mb-3">
                            <label class="col-lg-12 col-form-label form-label" for="catatan">Catatan</label>
                            <div class="col-lg-12">
                              <div class="table-responsive">
                                <textarea class="form-control catatan" id="catatan" name="catatan" rows="3" placeholder="Catatan ...">{{ $data_po->catatan_admin }}</textarea>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-lg-12" <?= Auth()->user()->role == 'Supplier' ? '' : 'hidden' ?>>
                          <div class="form-group row mb-3">
                            <label class="col-lg-12 col-form-label form-label" for="catatan">Catatan</label>
                            <div class="col-lg-12">
                              <div class="table-responsive">
                                <textarea class="form-control catatan" id="catatan" name="catatan_supplier" rows="3" placeholder="Catatan ...">{{ $data_po->catatan_supplier }}</textarea>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>

                  </div>
                </div>

              </div>

              <div class="col-lg-4">
                
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
                    
                    
                    <div data-scrollbar="true" data-height="400px">
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
                              <div class="card-body">
                                <div class="d-flex ">
                                  <div class="flex-1 ps-3">
                                    <label style="font-weight: bold" class="mb-1">{{ @$getBarang->kode_barang }} - {{ @$getBarang->nama_barang }}</label>
                                    <div class="row">
                                      <div class="col-lg-7">
                                      <b><label style="font-size: 13px">QTY x{{ $val->qty_dipesan }}</label></b>
                                      </div>
                                      <div class="col-lg-5 text-end">
                                        <a href="javascript:;" class="btn btn-sm btn-danger me-5px remove_detail" data-id="{{ md5($val->id) }}"><i class="fa fa-trash"></i> Hapus</a>
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

                    <button type="button" id="redirect_tambah_item" class="btn btn-outline-primary form-control"><i class="fa fa-plus"></i> Tambah Item</button>

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
                  <a href="{{ route('transaksi-po') }}" class="btn btn-outline-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
                  <button type="submit" class="btn btn-outline-primary"><i class="fa fa-save"></i> Simpan</button>
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

<div class="modal fade" id="modal_tambah_item">
  <div class="modal-dialog modal-s">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Tambah Item</h4>
        <h4 clas><span class="badge bg-primary" id="nopo"></span></h4>
      </div>
      
      <form action="{{ route('po-tambah-item') }}" method="POST">
        @csrf
        <input type="hidden" name="id_po" value="{{ $data_po->id }}">
        <div class="modal-body">

          <div class="row">
            <div class="col-lg-8">
              <div class="form-group row mb-3">
                <label class="col-lg-12 col-form-label form-label" for="vendor">Barang</label>
                <div class="col-lg-12">
                  <select class="default-select2 form-control" name="id_barang" id="barangSelected">
                    <option value="">[ Silahkan Pilih ]</option>
                    @foreach($data_barang as $val)
                      <option value="{{ $val->id }}">{{ $val->kode_barang }} - {{ $val->nama_barang }} <small>({{ $val->nama_satuan }})</small></option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group row mb-3">
                <label class="col-lg-12 col-form-label form-label">QTY</label>
                <div class="col-lg-12">
                  <input type="number" class="form-control" name="qty_item" value="1" min="1" step="0.1">
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tambahkan</button>
          <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
      </form>

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

      $('.catatan').summernote({
        height: "200px"
      });

      $('.dropdown-toggle').dropdown();

      sum = parseInt($('#subtotal_detail').attr('data-awal'));

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

      $('#body_detail_po').on('click', '.remove_item', function(){
        let tempSum = $(this).attr('data-sum');
        sum = sum - parseInt(tempSum);

        $('#subtotal_detail').text("Rp. "+numberWithCommas(sum));
        $(this).closest('div.baris').remove();
      });

      $('#body_detail_po').on('click', '.remove_detail', function(){
        let dd = $(this).attr('data-id');
        id = dd;

        $('#alert_content').text("Apakah Anda yakin akan menghapus data ini?");
        $('#modal-alert').modal('show');
      });

      $('#btn_submit').click(function(){

        let link = '{{ url("transaksi/po/det_delete/") }}/'+id;
        $.get(link, function(res){
          location.reload();
        });

      });

      $('#tambahkan_item').click(function(){
        let holder = $('#body_detail_po');

        let nama = $('#nama_item');
        let deskripsi = $('#deskripsi_item');
        let qty = $('#qty_item');
        let satuan = $('#satuan_item');
        let diskon = $('#diskon_item');

        if(nama.val() == "" || qty.val() == "" || qty.val() == 0 || satuan.val() == "" || satuan.val() == 0 || diskon.val() == ""){
          swal({
            title: 'Perhatian',
            text: 'Nama Item, QTY, Harga Satuan, Diskon tidak boleh kosong!',
            icon: 'error',
          });
        }else{

          let tempSum = (parseInt(satuan.val()) * parseInt(qty.val())) - parseInt(diskon.val());

          let str = '<div class="baris"><div class="card">'+
                        '<div class="card-body">'+
                          '<div class="d-flex ">'+
                            '<div class="flex-1 ps-3">'+
                              '<label style="font-weight: bold" class="mb-1">'+nama.val()+'<input type="hidden" name="det_nama[]" value="'+nama.val()+'"></label>'+
                              '<p class="">'+deskripsi.val()+'<input type="hidden" name="det_deskripsi[]" value="'+deskripsi.val()+'"> <br/>'+
                                '<div class="text-end">Rp. '+numberWithCommas(satuan.val())+' <input type="hidden" name="det_qty[]" value="'+qty.val()+'"> <b class="text-primary">x'+numberWithCommas(qty.val())+'</b> <input type="hidden" name="det_satuan[]" value="'+satuan.val()+'"></div>'+
                              '</p>'+
                              '<div class="row">'+
                              '<div class="col-lg-7">'+
                              '<label style="font-size: 10px">Total : Rp. '+numberWithCommas((parseInt(satuan.val()) * parseInt(qty.val())))+'</label>'+
                              '<br/>'+
                              '<label style="font-size: 10px; color: red">Diskon : Rp. '+numberWithCommas(diskon.val())+'</label>'+
                              '<br/><input type="hidden" name="det_diskon[]" value="'+diskon.val()+'">'+
                              '<b><label style="font-size: 13px">Rp. '+numberWithCommas(tempSum)+'</label></b>'+
                              '</div>'+
                              '<div class="col-lg-5 text-end">'+
                                '<a href="javascript:;" class="btn btn-sm btn-danger me-5px remove_item" data-sum="'+tempSum+'"><i class="fa fa-trash"></i> Hapus</a>'+
                              '</div>'+
                              '</div>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                      '</div><br/></div>';

          $('#tabDetil a[href="#tab_det2"]').tab("show");

          holder.append(str);

          sum += tempSum;

          $('#subtotal_detail').text("Rp. "+numberWithCommas(sum));
          $('#quotation').val(sum);

          nama.val('');
          deskripsi.val('');
          qty.val('1');
          satuan.val('0');
          diskon.val('0');

          $('#modal_tambah_item').modal('hide');

        }

      });

    });
</script>


@endsection