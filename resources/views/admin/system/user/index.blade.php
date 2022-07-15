@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<link href="{{ asset('assets') }}/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />

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
    <li class="breadcrumb-item active">Users</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Data User </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">
      
      <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
          <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active" id="tab_satu">Data Tabel</a>
        </li>
        <li class="nav-item">
          <a href="#default-tab-3" data-bs-toggle="tab" class="nav-link" id="tab_tiga">Tambah Data Baru</a>
        </li>
      </ul>
      <div class="tab-content bg-white p-3 rounded-bottom">
        <!-- TAB 1 -->
        <div class="tab-pane fade active show" id="default-tab-1">

          <!-- BEGIN card -->
          <div class="card">
            <div class="card-body">

              <!-- html -->
              <table id="data_table" style="width: 100%" class="table table-bordered table-striped align-middle h4">
                  <thead>
                    <tr>
                      <th width="1%"></th>
                      <th><center><label>Foto</label></center></th>
                      <th width="13%"><label>Nama</label></th>
                      <th width="10%"><label>Email</label></th>
                      <th><label>HP</label></th>
                      <th><center><label>Role</label></center></th>
                      <th><label>Nama Supplier</label></th>
                      <th><center><label>Status</label></center></th>
                      <th><center><label>Login Terakhir</label></center></th>
                      <th width="8%" data-orderable="false"></th>
                    </tr>
                  </thead>
                  <tbody id="body_user">
                  </tbody>
                </table>

            </div>
          </div>
          <!-- END card -->

          

        </div>
        <!-- END OF TAB 1 -->

        <!-- TAB 3 -->
        <div class="tab-pane fade" id="default-tab-3">
          
          <div class="card">
            <div class="card-body">
              <form action="{{ route('simpan-user') }}" method="POST" class="form-horizontal" enctype="multipart/form-data" data-parsley-validate="true">
                @csrf
                
                <div class="row">
                    
                  <div class="col-lg-3">

                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="foto">Foto</label>
                          <div class="col-lg-12">
                            <center style="margin-bottom:10px;border:dashed 1px #ccc;padding:15px;background:#FFF"><img src="{{ asset('assets') }}/logo/nopreview.png" class="preview_gambar" style="width:200px;max-height:200px;" alt="NONE" /></center>
                          </div>
                          <div class="col-lg-12">
                            <input type="file" class="form-control" id="upload_gambar" name="foto" accept="image/x-png,image/jpeg">
                            <center><small><label class="text-danger"><b>Max file hanya 2MB</b></label></small></center>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                  </div>

                  <div class="col-lg-9">
                    
                    <div class="row">
                      <div class="col-lg-12">

                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="role">Role <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <select class="default-select2 form-control" name="role" id="role" data-parsley-required="true">
                              <option value="">[ Silahkan Pilih ]</option>
                              <option>Admin</option>
                              <option>Pemilik</option>
                              <option>Supplier</option>
                              <option>Pembeli</option>
                            </select>
                          </div>
                        </div>

                      </div>
                      <div class="col-lg-12" id="holder_supplier">

                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="requester">Supplier</label>
                          <div class="col-lg-12">
                            <select class="default-select2 form-control" name="id_supplier" id="supplier" >
                              <option value="0">[ Tidak Memilih ]</option>
                              @foreach($data_supplier as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                      </div>

                    </div>

                    <div class="row">

                      <div class="col-lg-6">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="name">Nama <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control" type="text" id="name" name="name" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="nohp">No HP <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input type="text" class="form-control" id="hp" name="mobile_number" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-lg-4">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="username">Username <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control" type="text" id="username" name="username" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="email">Email <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control" type="email" id="email" name="email" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="password">Password <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control" type="password" id="password" name="password" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>

                    </div>


                  </div>

                </div>
                <br/>
                

                <div style="text-align: right;">
                  <button type="submit" class="btn btn-outline-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>

              </form>
            </div>
          </div>

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

<div class="modal fade" id="modal_detail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="title_barang">Detail User</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        
        <div id="isi_detail"></div>

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
<script src="{{ asset('assets') }}/plugins/select2/dist/js/select2.min.js"></script>
<script src="{{ asset('assets') }}/plugins/parsleyjs/dist/parsley.min.js"></script>

<script type="text/javascript">

    $(function(){

      var id = '';

      var checked = false;

      $('#ceklis_semua').click(function(){
        if(checked == false){
          checked = true;
          $('#btn_judul').html('<i class="fa fa-times-circle"></i> Uncheck Semua');
        }else{
          checked = false;
          $('#btn_judul').html('<i class="fa fa-check"></i> Ceklis Semua');
        }

        $('input:checkbox').prop('checked', checked);
      });

      $('#holder_supplier').fadeOut();

      $('#role').on('change', function(){

        let val = $(this).val();
        if(val == "Supplier"){
          $('#supplier').val('0').trigger('change');
          $('#holder_supplier').fadeIn();
        }else{
          $('#supplier').val('0').trigger('change');
          $('#holder_supplier').fadeOut();
        }

      });

      $(".default-select2").select2();

      $('#data_table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('get-data-user') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'foto', name: 'foto', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'mobile_number', name: 'mobile_number'},
            {data: 'role', name: 'role'},
            {data: 'nama_supplier', name: 'nama_supplier'},
            {data: 'status', name: 'status'},
            {data: 'last_login', name: 'last_login'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: ['0', 'asc'],
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

      $('#body_user').on('click', '.delete_button', function(){

        let dd = $(this).attr('data-id');
        id = dd;

        $('#alert_content').text("Apakah Anda yakin akan menghapus data ini?");
        $('#modal-alert').modal('show');

      });

      $('#btn_submit').click(function(){

        let link = '{{ url("system/users/delete") }}/'+id;
        $.get(link, function(res){
          location.reload();
        });

      });


      $('#body_user').on('click', '.btn_detail', function(){
        let id = $(this).attr('data-id');
        let link = '{{ url("system/users/detail") }}/'+id;

        $.get(link, function(res){
          $('#isi_detail').html(res);
          $('#modal_detail').modal('show');
        });

      });

      function uploadPreviewImageEdit(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
       
          reader.onload = function (e) {
            $(document).find('.preview_gambar').attr('src', e.target.result);
          }
       
          reader.readAsDataURL(input.files[0]);
        }
      }

      $(document).on('change','#upload_gambar',function(){
        $(document).find('.preview_gambar').fadeIn();
        uploadPreviewImageEdit(this);
      });

      $('#redirect_form_add').click(function(){
        $('#myTab a[href="#default-tab-3"]').tab("show");
      });


    });
</script>


@endsection