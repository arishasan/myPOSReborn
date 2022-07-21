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
  font-size: 12px;
 }
 th {
  font-size: 12px;
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
    <li class="breadcrumb-item active">Purchase Order</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Data Purchase Order </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">
      
      <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
          <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active" id="tab_satu">Data Tabel</a>
        </li>
        <li class="nav-item" {{ Auth()->user()->role == 'Pemilik' ? 'hidden' : '' }}>
          <a href="#default-tab-3" data-bs-toggle="tab" class="nav-link" id="tab_tiga">Tambah Data Baru</a>
        </li>
      </ul>
      <div class="tab-content bg-white p-3 rounded-bottom">
        <!-- TAB 1 -->
        <div class="tab-pane fade active show" id="default-tab-1">

          <!-- Klik di <a href="javascript:void(0)" id="redirect_form_add">sini</a> untuk menambahkan data baru. -->

          <div class="card">
            <div class="card-body">

              <div class="row">
                <div class="col-lg-3">
                  
                  <div class="form-group row mb-3">
                    <label class="col-lg-12 col-form-label form-label">Status</label>
                    <div class="col-lg-12">
                      <select class="form-control default-select2" id="statusCari">
                        <option value="all">[ Semua ]</option>
                        <option value="BARU">BARU</option>
                        <option value="DIPROSES">DIPROSES</option>
                        <option value="SELESAI">SELESAI</option>
                        <option value="RETUR">RETUR</option>
                        <option value="RETUR SELESAI">RETUR SELESAI</option>
                      </select>
                    </div>
                  </div>

                </div>
                <div class="col-lg-3">

                  <div class="form-group row mb-3">
                    <label class="col-lg-12 col-form-label form-label" for="date_from">Tampilkan Dari Tanggal</label>
                    <div class="col-lg-12">
                      <input type="text" class="form-control date_picker" id="date_from" value="{{ date('d-m-Y', strtotime('first day of this month')) }}" readonly/>
                    </div>
                  </div>

                </div>
                <div class="col-lg-3">

                  <div class="form-group row mb-3">
                    <label class="col-lg-12 col-form-label form-label" for="date_to">Sampai</label>
                    <div class="col-lg-12">
                      <input type="text" class="form-control date_picker" id="date_to" value="{{ date('d-m-Y', strtotime('last day of this month')) }}" readonly/>
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
                      <th width="5%">No.</th>
                      <th width="10%"><label><b>Kode PO</b></label></th>
                      <th width="10%"><center>Tgl. Po</center></th>
                      <th ><label>Supplier</label></th>
                      <th width="10%"><center><label>Status</label></center></th>
                      <th width="8%" data-orderable="false"></th>
                    </tr>
                  </thead>
                  <tbody id="body_po">
                    
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

          <form method="POST" action="{{ route('simpan-po') }}" class="form-horizontal" data-parsley-validate="true" name="demo-form">  
            @csrf

            <div class="row">
              
              <div class="col-lg-8">
                
                <div class="card">
                  <div class="card-body">
                      
                      <div class="row">
                        <div class="col-lg-6">

                          <div class="form-group row mb-3">
                            <label class="col-lg-12 col-form-label form-label" for="vendor">Supplier <sup class="text-danger">*</sup></label>
                            <div class="col-lg-12">
                              <select class="default-select2 form-control" name="id_vendor" id="vendor" data-parsley-required="true">
                                <option value="">[ Silahkan Pilih ]</option>
                                @foreach($data_supplier as $val)
                                  <option value="{{ $val->id }}">{{ $val->nama }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>

                        </div>
                        <div class="col-lg-6">

                          <div class="form-group row mb-3">
                            <label class="col-lg-12 col-form-label form-label" for="sewa">Tanggal PO <sup class="text-danger">*</sup></label>
                            <div class="col-lg-12">
                              <input type="text" class="form-control date_picker" name="tanggal_po" value="{{ date('d-m-Y') }}" data-parsley-required="true"/>
                            </div>
                          </div>

                        </div>

                      </div>


                      <div class="row">

                        <div class="col-lg-12">
                          <div class="form-group row mb-3">
                            <label class="col-lg-12 col-form-label form-label" for="catatan">Catatan</label>
                            <div class="col-lg-12">
                              <div class="table-responsive">
                                <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Catatan ..."></textarea>
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
                      <div id="body_detail_po"></div>
                      <br/>

                    </div>

                    <button type="button" id="redirect_tambah_item" class="btn btn-outline-primary form-control"><i class="fa fa-plus"></i> Tambah Item</button>

                  </div>
                  <!-- END tab-pane -->
                  
                </div>
                <!-- END tab-content -->

              </div>

            </div>


            <br/>

            <div class="form-group row text-end">
              <div class="col-lg-12">
                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-save"></i> Simpan</button>
              </div>
            </div>

          </form>

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

<div class="modal modal-message fade" id="alert_two" style="z-index: 90000;">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-body">
        <br/>
        <div class="alert alert-white">
          <h5><i class="fa fa-info-circle"></i> Perhatian</h5>
          <p id="alert_content">Anda yakin akan menyelesaikan Purchase Order ini ?</p>
          <center>
            <a href="javascript:;" class="btn btn-outline-primary" data-bs-dismiss="modal" id="btn_sub_po"><i class="fa fa-save"></i> Ya</a>
            <a href="javascript:;" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> Tidak</a>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_detail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> Detail Purchase Order</h4>
        <h4 clas><span class="badge bg-primary" id="nopo"></span></h4>
      </div>
      <div class="modal-body">

        <div id="holder_detail_po"></div>

      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
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
                <input type="number" class="form-control" id="qty_item" value="1" min="1" step="0.1">
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-primary" id="tambahkan_item">Tambahkan</a>
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

    var sum = 0;

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function callTable(){
      statusCari = $('#statusCari').val();
      date_from = $('#date_from').val();
      date_to = $('#date_to').val();

      $('#data_table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        bDestroy: true,
        ajax: {
            'type': 'POST',
            'url': "{{ route('get-data-po') }}",
            'data': {
               status: statusCari,
               from: date_from,
               to: date_to,
            },
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'kode_po', name: 'kode_po'},
            {data: 'tgl_po', name: 'tgl_po'},
            {data: 'nama_supplier', name: 'supplier.nama'},
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

    }

    $(document).on("keydown", "form", function(event) { 
        return event.key != "Enter";
    });

    $(function(){

      $('#catatan').summernote({
        height: "200px"
      });

      $('.dropdown-toggle').dropdown();

      $('#holder_detail_po').on('click', '#execute_save_detail', function(){
        $('#alert_two').modal('show');
      });

      $('#btn_sub_po').click(function(){
        $("#form_terima_po").submit();
      });

      $('#cariData').click(function(){
        callTable();
      });

      $(".default-select2").select2();

      $(".date_picker").datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
      });

      $('#body_po').on('click','.detil_po', function(){
        let id = $(this).attr('data-id');
        let link = '{{ url("transaksi/po/detail") }}/'+id;
        let nopo = $(this).attr('data-nopo');

        $.get(link, function(res){
          $('#nopo').text(nopo);
          $('#holder_detail_po').html(res);
          $('#modal_detail').modal('show');
          $('.table_det').DataTable();
        });
        
      });

      $('#body_po').on('click', '.delete_button', function(){

        let dd = $(this).attr('data-id');
        id = dd;

        $('#alert_content').text("Apakah Anda yakin akan menghapus data ini?");
        $('#modal-alert').modal('show');

      });

      $('#btn_submit').click(function(){

        let link = '{{ url("transaksi/po/delete/") }}/'+id;
        $.get(link, function(res){
          location.reload();
        });

      });

      callTable();

      $('#redirect_form_add').click(function(){
        $('#myTab a[href="#default-tab-3"]').tab("show");
      });

      $('#redirect_tambah_item').click(function(){
        // $('#tabDetil a[href="#tab_det1"]').tab("show");
        $('#modal_tambah_item').modal('show');
      });

      $('#body_detail_po').on('click', '.remove_item', function(){
        let tempSum = $(this).attr('data-sum');
        sum = sum - parseInt(tempSum);

        $('#subtotal_detail').text("Rp. "+numberWithCommas(sum));

        $('#quotation').val(sum);

        $(this).closest('div.baris').remove();
      });

      $('#tambahkan_item').click(function(){
        let holder = $('#body_detail_po');

        let barang = $('#barangSelected option:selected');
        let qty = $('#qty_item');

        if(barang.val() == "" || qty.val() == ""){
          swal({
            title: 'Perhatian',
            text: 'Barang dan QTY tidak boleh kosong!',
            icon: 'error',
          });
        }else{

          let kode_baris = $('.kode_'+barang.val());
          if(kode_baris.length > 0){

              let exist = $('.inp_qty_'+barang.val()).val();
              let tambahkan = parseFloat(exist) + parseFloat(qty.val());

              $('.inp_qty_'+barang.val()).val(tambahkan);
              $('.txt_qty_'+barang.val()).text(tambahkan);

              $('#tabDetil a[href="#tab_det2"]').tab("show");

              $('#barangSelected').val('').trigger('change');
              qty.val('1');

              $('#modal_tambah_item').modal('hide');

          }else{

              let str = '<div class="baris kode_'+barang.val()+'"><div class="card">'+
                        '<div class="card-body">'+
                          '<div class="d-flex ">'+
                            '<div class="flex-1 ps-3">'+
                              '<label class="mb-1">'+barang.text()+'<input type="hidden" name="det_nama[]" value="'+barang.text()+'"><input type="hidden" name="id_barang[]" value="'+barang.val()+'"></label>'+
                              '<div class="row">'+
                              '<div class="col-lg-7">'+
                              '<b><label style="font-size: 13px">QTY x<label class="txt_qty_'+barang.val()+'">'+qty.val()+'</label><input type="hidden" step="0.1" class="inp_qty_'+barang.val()+'" name="qty[]" value="'+qty.val()+'"></label></b>'+
                              '</div>'+
                              '<div class="col-lg-5 text-end">'+
                                '<a href="javascript:;" class="btn btn-sm btn-danger me-5px remove_item"><i class="fa fa-trash"></i> Hapus</a>'+
                              '</div>'+
                              '</div>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                      '</div><br/></div>';

              $('#tabDetil a[href="#tab_det2"]').tab("show");

              holder.append(str);


              $('#barangSelected').val('').trigger('change');
              qty.val('1');

              $('#modal_tambah_item').modal('hide');

            }

        }

      });

    });
</script>


@endsection