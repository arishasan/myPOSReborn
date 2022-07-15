@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<link href="{{ asset('assets') }}/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />


<style>
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
    <li class="breadcrumb-item">Administrasi</li>
    <li class="breadcrumb-item"><a href="javascript:;">Data</a></li>
    <li class="breadcrumb-item active">Request Barang</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Data Request Barang </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">
      
      <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
          <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active" id="tab_satu">Data Tabel</a>
        </li>
        <li class="nav-item">
          <a href="#default-tab-3" data-bs-toggle="tab" class="nav-link" id="tab_tiga">Buat Request Barang</a>
        </li>
      </ul>
      <div class="tab-content bg-white p-3 rounded-bottom">
        <!-- TAB 1 -->
        <div class="tab-pane fade active show" id="default-tab-1">

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
                        <option value="DISETUJUI">DISETUJUI</option>
                        <option value="DITOLAK">DITOLAK</option>
                      </select>
                    </div>
                  </div>

                </div>
                <div class="col-lg-3">

                  <div class="form-group row mb-3">
                    <label class="col-lg-12 col-form-label form-label" for="date_from">Tampilkan Dari Tanggal</label>
                    <div class="col-lg-12">
                      <input type="text" class="form-control date_picker_ori" id="date_from" value="{{ date('d-m-Y', strtotime('first day of this month')) }}" readonly/>
                    </div>
                  </div>

                </div>
                <div class="col-lg-3">

                  <div class="form-group row mb-3">
                    <label class="col-lg-12 col-form-label form-label" for="date_to">Sampai</label>
                    <div class="col-lg-12">
                      <input type="text" class="form-control date_picker_ori" id="date_to" value="{{ date('d-m-Y', strtotime('last day of this month')) }}" readonly/>
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
                      <th width="15%"><label>Perihal</label></th>
                      <th width="10%"><center><label><b>No Agenda</b></label></center></th>
                      <th width="8%"><label>Oleh</label></th>
                      <th width="8%"><center><label>Tgl. Request</label></center></th>
                      <th width="15%"><label>Nama Barang</label></th>
                      <th width="8%"><label>Disposisi</label></th>
                      <th width="8%"><center><label>Lampiran</label></center></th>
                      <th width="5%"><center><label>Status</label></center></th>
                      <th width="8%" data-orderable="false"></th>
                    </tr>
                  </thead>
                  <tbody id="body_table">
                    
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

          <form action="{{ route('simpan-request-barang') }}" method="POST" class="form-horizontal" data-parsley-validate="true" name="demo-form" enctype="multipart/form-data">  
            @csrf
            <div class="card">
              <div class="card-body">
                  
                  <div class="row">
                    <div class="col-lg-12">

                      <div class="form-group row mb-3">
                        <label class="col-lg-6 col-form-label form-label">Perihal <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <input type="text" class="form-control" name="perihal" placeholder="Required" data-parsley-required="true"/>
                        </div>
                      </div>

                    </div>
                    <!-- <div class="col-lg-6">

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">No Agenda <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <input type="text" class="form-control" name="no_agenda" placeholder="Required" data-parsley-required="true"/>
                        </div>
                      </div>

                    </div> -->
                   
                   <div class="col-lg-6" hidden>

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Kode RAB / Anggaran <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <input type="text" class="form-control" name="kode_anggaran" placeholder="Required"/>
                        </div>
                      </div>

                    </div>

                  </div>

                  <div class="row">
                   
                    <div class="col-lg-4">

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Nama Barang <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <input type="text" class="form-control" name="nama_barang" placeholder="Required" data-parsley-required="true"/>
                        </div>
                      </div>

                    </div>

                    <div class="col-lg-4">

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Jumlah <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <input type="number" class="form-control" min="0" name="jumlah" value="0" placeholder="Required" data-parsley-required="true"/>
                        </div>
                      </div>

                    </div>

                    <div class="col-lg-4">
                      
                      <div class="form-group row mb-3">
                        <div class="col-lg-12">
                          <label class="col-form-label form-label">Lampiran <sup class="text-danger">*</sup></label>
                        </div>
                        <div class="col-lg-3">
                          <center>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="lampiran_link" value="1" id="lampiran_link_user" />
                              <label class="form-check-label" for="lampiran_link_user"><small>Berupa Link</small></label>
                            </div>
                          </center>
                        </div>
                        <div class="col-lg-9">
                          <div id="if_berupa_link_user" style="display: none">
                            <input type="text" class="form-control" name="lampiran" placeholder="Required" />
                          </div>
                          <div id="if_file_user">
                            <input type="file" class="form-control" name="lampiran" placeholder="Required" />
                          </div>
                        </div>
                      </div>

                    </div>
                   
                  </div>
                 
                  <div class="row">

                    <div class="col-lg-12">
                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label" for="catatan">Alasan <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <textarea class="form-control" id="keterangan" name="keterangan" rows="3" data-parsley-required="true" placeholder="Alasan ..."></textarea>
                        </div>
                      </div>
                    </div>

                  </div>

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

<div class="modal fade" id="modal-detail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Disposisi <sub>(singkat)</sub></h4>
        <h4><span class="badge bg-primary" id="title_agenda"></span></h4>
      </div>
      <div class="modal-body">
        
        <div id="content_holder"></div>

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
<script src="{{ asset('assets') }}/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('assets') }}/plugins/pdfmake/build/pdfmake.min.js"></script>
<script src="{{ asset('assets') }}/plugins/pdfmake/build/vfs_fonts.js"></script>
<script src="{{ asset('assets') }}/plugins/jszip/dist/jszip.min.js"></script>
<script src="{{ asset('assets') }}/plugins/parsleyjs/dist/parsley.min.js"></script>
<script src="{{ asset('assets') }}/plugins/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('assets') }}/plugins/select2/dist/js/select2.min.js"></script>

<script src="{{ asset('assets') }}/plugins/jquery-migrate/dist/jquery-migrate.min.js"></script>
<script src="{{ asset('assets') }}/plugins/tag-it/js/tag-it.min.js"></script>


<script type="text/javascript">

    var id;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

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
            'url': "{{ route('get-data-request-barang') }}",
            'data': {
               status: statusCari,
               from: date_from,
               to: date_to,
            },
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'perihal', name: 'perihal'},
            {data: 'no_agenda', name: 'no_agenda'},
            {data: 'nama_user', name: 'nama_user'},
            {data: 'created_at', name: 'created_at'},
            {data: 'nama_barang', name: 'nama_barang'},
            {data: 'tujuan', name: 'tujuan', orderable: false, searchable: false},
            {data: 'lampiran_file', name: 'lampiran_file', orderable: false, searchable: false},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: ['0', 'desc'],
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

    $(function(){

      $('#cariData').click(function(){
        callTable();
      });

      $(".date_picker_ori").datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
      });

      $('.default-select2').select2();

      callTable();

      $('#body_table').on('click', '.delete_button', function(){

        let dd = $(this).attr('data-id');
        id = dd;

        $('#alert_content').text("Apakah Anda yakin akan menghapus data ini?");
        $('#modal-alert').modal('show');

      });

      $('#btn_submit').click(function(){

        let link = '{{ url("administrasi/request_barang/delete/") }}/'+id;
        $.get(link, function(res){
          location.reload();
        });

      });

      $('#content_holder').on('click', '.btn_reply_disposisi', function(){

        let id_disp = $(this).attr('data-id');
        let tgl = $(this).attr('data-tgl');
        let isi = $(this).attr('data-isi');

        let tgl_last = $(this).attr('data-tgl-last');
        let isi_last = $(this).attr('data-isi-last');

        $('#content_holder').find('#id_disposisi_balas').val(id_disp);
        $('#content_holder').find('#detdis_tgl').text(tgl);
        $('#content_holder').find('#detdis_isi').text(isi);
        $('#content_holder').find('#detdis_tgl_last').text(tgl_last);
        $('#content_holder').find('#detdis_isi_last').text(isi_last);

        $('#form_balas_disposisi').css('display', 'block');

      });

      $('#lampiran_link_user').on('change', function(){
        if(this.checked) {
            $('#if_berupa_link_user').css('display', 'block');
            $('#if_file_user').css('display', 'none');
        }else{
          $('#if_berupa_link_user').css('display', 'none');
          $('#if_file_user').css('display', 'block');
        }
      });

      $('#content_holder').on('change', '#lampiran_link_disposisi', function(){
        if(this.checked) {
            $('#content_holder').find('#if_berupa_link_disposisi').css('display', 'block');
            $('#content_holder').find('#if_file_disposisi').css('display', 'none');
        }else{
          $('#content_holder').find('#if_berupa_link_disposisi').css('display', 'none');
          $('#content_holder').find('#if_file_disposisi').css('display', 'block');
        }
      });

      // $('#content_holder').on('click')

      $('#redirect_form_add').click(function(){
        $('#myTab a[href="#default-tab-3"]').tab("show");
      });

      $('#body_table').on('click', '.detail_disposisi', function(){

        let id = $(this).attr('data-id');
        let agenda = $(this).attr('data-agenda');

        let link = "{{ url('administrasi/request_barang/detail_disposisi') }}/"+id;

        $.get(link, function(res){

          $('#title_agenda').text(agenda);

          $('#content_holder').html(res);

          $('#form_balas_disposisi').css('display', 'none');
          $('#modal-detail').modal('show');

        });

        
      });

      

    });
</script>


@endsection