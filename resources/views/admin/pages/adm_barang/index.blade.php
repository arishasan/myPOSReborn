@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<link href="{{ asset('assets') }}/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset('assets') }}/jstree/dist/themes/default/style.min.css" />
<link href="{{ asset('assets') }}/plugins/superbox/superbox.min.css" rel="stylesheet" />

<style>
 .map_ganselect {
  height: 300px;  /* The height is 400 pixels */
  width: 100%;  /* The width is the width of the web page */
 }
 td {
  font-size: 13px;
 }
 th {
  font-size: 13px;
 }
</style>

@section('content')

<div id="content" class="app-content">
  <!-- BEGIN breadcrumb -->
  <ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item"><a href="javascript:;">Data</a></li>
    <li class="breadcrumb-item active">Barang</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Data Barang </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">
      
      <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
          <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active" id="tab_satu">Data Tabel</a>
        </li>
        <!-- <li class="nav-item">
          <a href="#default-tab-2" data-bs-toggle="tab" class="nav-link" id="tab_dua">Print Stiker</a>
        </li> -->

        <li class="nav-item">
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
                <div class="col-lg-12">

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
              </div>

              <div class="row">

                <div class="col-lg-5">
                  <div class="form-group row mb-3">
                    <label class="col-lg-12 col-form-label form-label" for="satuanCari">Satuan Barang</label>
                    <div class="col-lg-12">
                      <select class="default-select2 form-control" id="satuanCari">
                        <option value="all">[ Semua ]</option>
                        @foreach($data_satuan as $val)
                          <option value="{{ $val->id }}">{{ $val->nama }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-lg-5">
                  <div class="form-group row mb-3">
                    <label class="col-lg-12 col-form-label form-label" for="statusCari">Status</label>
                    <div class="col-lg-12">
                      <select class="default-select2 form-control" id="statusCari">
                        <option value="all">[ Semua ]</option>
                        <option value="1">AKTIF</option>
                        <option value="0">NON-AKTIF</option>
                      </select>
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

          <!-- BEGIN card -->
          <div class="card">
            <div class="card-body">

              <!-- html -->
              <div class="table-responsive">
                <table id="data_table" style="width: 100%" class="table table-bordered table-striped align-middle h4">
                  <thead>
                    <tr>
                      <th width="1%"></th>
                      <th width="10%"><center><label>Thumbnail</label></center></th>
                      <th width="5%"><center><label>Stok</label></center></th>
                      <th width="5%"><label>Satuan</label></th>
                      <th width="10%"><label><b>Kode Barang</b></label></th>
                      <th><label>Nama Barang</label></th>
                      <th width="10%"><label>Kategori</label></th>
                      <th class="text-end" width="10%"><label>Harga Jual Grosir</label></th>
                      <th class="text-end" width="10%"><label>Harga Jual Eceran</label></th>
                      <th width="5%"><center><label>Status</label></center></th>
                      <th width="8%" data-orderable="false"></th>
                    </tr>
                  </thead>
                  <tbody id="body_barang">
                  </tbody>
                </table>
              </div>

            </div>
          </div>
          <!-- END card -->

          

        </div>
        <!-- END OF TAB 1 -->

        <!-- TAB 2 -->
        <div class="tab-pane fade" id="default-tab-2">

          <p>PRINT GOES HERE</p>

        </div>
        <!-- END OF TAB 2 -->

        <!-- TAB 3 -->
        <div class="tab-pane fade" id="default-tab-3">

          <form method="POST" id="form_tambah" action="{{ route('simpan-adm-barang') }}" class="form-horizontal" data-parsley-validate="true" name="demo-form" enctype="multipart/form-data">  
          @csrf
          
            <div class="row">
              
              <div class="col-lg-3">
                
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group row mb-3">
                      <label class="col-lg-12 col-form-label form-label" for="foto">Thumbnail</label>
                      <div class="col-lg-12">
                        <center style="margin-bottom:10px;border:dashed 1px #ccc;padding:15px;background:#FFF"><img src="{{ asset('assets') }}/logo/nopreview.png" class="preview_gambar" style="width:200px;max-height:200px;" alt="NONE" /></center>
                      </div>
                      <div class="col-lg-12">
                        <input type="file" class="form-control" id="upload_gambar" name="foto" accept="image/x-png,image/jpeg">
                        <center><small class="text-danger">*Maksimal size 2 MB</small></center>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="col-lg-9">
                
                <div class="card">
                  <div class="card-body">

                    <div class="row">
                      <div class="col-lg-6">

                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="satuan">Satuan <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <select class="default-select2 form-control" name="id_satuan" id="satuan" data-parsley-required="true">
                              <option value="">[ Silahkan Pilih ]</option>
                              @foreach($data_satuan as $val)
                                <option value="{{ $val->id }}">{{ $val->nama }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                      </div>
                      <div class="col-lg-6">

                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="kategori">Kategori <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">

                            <div class="row">
                              <div class="col-lg-10">
                                <input type="hidden" name="id_kategori" value="0" id="parent_kategori">
                                <input class="form-control" type="text" value="" placeholder="[ Silahkan Pilih ]" id="label_parent_kategori" data-parsley-required="true" readonly />
                              </div>
                              <div class="col-lg-2">
                                <button type="button" id="btn_pilih_kategori" class="btn btn-lg btn-outline-primary form-control" title="Pilih Kategori"><i class="fa fa-search"></i></button>
                              </div>
                            </div>

                          </div>
                        </div>

                      </div>

                    </div>

                    <div class="row">

                      <div class="col-lg-12">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="nama_barang">Nama Barang <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control" type="text" id="nama_barang" name="nama_barang" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-lg-12">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="deskripsi">Deskripsi <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-lg-3">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Harga Beli <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control currency" type="text" value="0" id="harga_beli" name="harga_beli" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Harga Jual Grosir <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control currency" type="text" value="0" id="harga_grosir" name="harga_grosir" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Harga Jual Eceran<sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control currency" type="text" value="0" id="harga_eceran" name="harga_eceran" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Harga Grosir Saat QTY Lebih Dari<sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control currency" type="text" value="0" id="qty_grosir" name="qty_grosir" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-lg-4">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Barang Memiliki Tanggal Kadaluarsa? <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <select class="default-select2 form-control" id="is_expiracy" name="is_expiracy" data-parsley-required="true">
                              <option value="0">Tidak</option>
                              <option value="1">Ya</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-3">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Tanggal Kadaluarsa <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input type="date" class="form-control" id="tgl_kadaluarsa" name="tgl_kadaluarsa" value="{{ date('Y-m-d') }}" readonly/>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="stok">Stok Awal<sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control" type="number" value="0" min="0" step="0.1" id="stok" name="stok" placeholder="Required" data-parsley-required="true"/>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="status">Status</label>
                          <div class="col-lg-12">
                            <select class="default-select2 form-control" id="status" name="status" data-parsley-required="true">
                              <option value="1">AKTIF</option>
                              <option value="0">NON-AKTIF</option>
                            </select>
                          </div>
                        </div>
                      </div>

                    </div>


                    <div style="text-align: right;">
                      <button type="submit" class="btn btn-outline-primary" id="btn_tambah_data"><i class="fa fa-save"></i> Simpan</button>
                    </div>

                    
                  </div>
                </div>

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
            <a href="javascript:;" class="btn btn-outline-primary" id="btn_submit" data-bs-dismiss="modal"><i class="fa fa-save"></i> Ya</a>
            <a href="javascript:;" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> Tidak</a>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-message fade" id="modal_print">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-body">
        <br/>
        <div class="alert alert-white">
          <h5><i class="fa fa-info-circle"></i> Print Stiker</h5>
          <p>
              


          </p>
          <center>
            <a href="javascript:;" class="btn btn-outline-primary" id="btn_print" data-bs-dismiss="modal"><i class="fa fa-save"></i> Print</a>
            <a href="javascript:;" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> Tutup</a>
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
        <h5 class="modal-title" id="title_barang"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
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

<div class="modal fade" id="modal_pilih_kategori">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pilih Kategori</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        
        <div class="row">
          
          <div class="col-lg-8">
            <div id="dataTree_kategori" class="dataTree_kategori"></div>
          </div>

          <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <label>Selected Node</label><br/>
                <label id="selected_node_kategori" style="font-weight: bold"></label> <br/><br/>
                <label>Node Parent</label><br/>
                <label id="selected_parent_kategori" style="font-weight: bold"></label>
              </div>
            </div>
          </div>

        </div>

      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white" id="semua_kategori" hidden>Semua Kategori</a>
        <a href="javascript:;" class="btn btn-primary" id="ya_kategori">Pilih</a>
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
<script src="{{ asset('assets') }}/plugins/superbox/jquery.superbox.min.js"></script>

<script type="text/javascript">

    var kategori, lokasi, sumber, sewa, status;
    var lokasiID, lokasiName;
    var kategoriID, kategoriName;
    var methodBtn, methodBtnKategori;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function callTable(){
      kategori = $('#kategoriCari').val();
      satuan = $('#satuanCari').val();
      status = $('#statusCari').val();
      
      $('#data_table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        bDestroy: true,
        ajax: {
            'type': 'POST',
            'url': "{{ route('get-data-barang') }}",
            'data': {
               kategori: kategori,
               satuan: satuan,
               status: status,
            },
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'foto', name: 'foto', orderable: false, searchable: false},
            {data: 'stok', name: 'stok', orderable: false, searchable: false},
            {data: 'nama_satuan', name: 'nama_satuan', orderable: false, searchable: false},
            {data: 'kode_barang', name: 'kode_barang'},
            {data: 'nama_barang', name: 'nama_barang'},
            {data: 'id_kategori', name: 'id_kategori', orderable: false, searchable: false},
            {data: 'harga_grosir', name: 'harga_grosir', orderable: false, searchable: false},
            {data: 'harga_eceran', name: 'harga_eceran', orderable: false, searchable: false},
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

      $('#is_expiracy').change(function(){

        let ini = $(this);

        if(ini.val() == 1){
          $('#tgl_kadaluarsa').prop('readonly', false);
        }else{
          $('#tgl_kadaluarsa').prop('readonly', true);
        }

      });

      $('#dataTree_kategori')
          .on("changed.jstree", function (e, data) {
            if(data.selected.length) {

              let id = data.instance.get_node(data.selected[0]).data.id;
              let nama = data.instance.get_node(data.selected[0]).data.text;
              let kode = data.instance.get_node(data.selected[0]).data.kode;
              let parent = data.instance.get_node(data.selected[0]).data.parent_id;
              let parent_name = data.instance.get_node(data.selected[0]).data.parent_name;
              
              kategoriID = id;
              kategoriName = parent_name + ' - ' + nama;

              $('#selected_node_kategori').text(nama);
              $('#selected_parent_kategori').text(parent_name);

            }
          })
          .jstree({
            'core' : {
              'multiple' : false,
              'data' : {
                  "url" : '{{ route("get-tree-kategori") }}',
                  "dataType" : "json" 
              }
            }
          });

      $('#btn_pilih_kategori').click(function(){
        
        if(methodBtnKategori == 'search'){
          $("#dataTree_kategori").jstree("deselect_all");
          $("#dataTree_kategori").jstree("close_all");

          $('#selected_node_kategori').text('');
          $('#selected_parent_kategori').text('');
        }

        methodBtnKategori = 'create';
        $('#semua_kategori').attr('hidden', true);

        $('#modal_pilih_kategori').modal('show');
      });

      $('#btn_search_kategori').click(function(){
        if(methodBtnKategori == 'create'){
          $("#dataTree_kategori").jstree("deselect_all");
          $("#dataTree_kategori").jstree("close_all");

          $('#selected_node_kategori').text('');
          $('#selected_parent_kategori').text('');
        }

        methodBtnKategori = 'search';
        $('#semua_kategori').attr('hidden', false);

        $('#modal_pilih_kategori').modal('show');
      });

      $('#semua_kategori').click(function(){
        $("#dataTree_kategori").jstree("deselect_all");
        $("#dataTree_kategori").jstree("close_all");
        kategoriID = '';
        kategoriName = '';
        $('#selected_node_kategori').text('');
        $('#selected_parent_kategori').text('');
        $('#kategoriCari').val('all');
        $('#label_kategori_cari').val('[ Semua ]');
        $('#modal_pilih_kategori').modal('hide');
      });

      $('#ya_kategori').click(function(){

        if(methodBtnKategori == 'search'){

          if(kategoriID == null){
            swal({
              title: 'Perhatian',
              text: 'Anda belum memilih kategori!',
              icon: 'error',
            });
          }else{
            $('#kategoriCari').val(kategoriID);
            $('#label_kategori_cari').val(kategoriName);
          }

        }else{

          if(kategoriID == null){
            swal({
              title: 'Perhatian',
              text: 'Anda belum memilih kategori!',
              icon: 'error',
            });
          }else{
            $('#parent_kategori').val(kategoriID);
            $('#label_parent_kategori').val(kategoriName);
          }

        }


        $('#modal_pilih_kategori').modal('hide');
      });

      $("#det_po").select2({
        ajax: { 
         url: "{{ route('get-select-po-barang') }}",
         type: "post",
         dataType: 'json',
         delay: 250,
         data: function (params) {
          return {
            searchTerm: params.term // search term
          };
         },
         processResults: function (response) {
           return {
              results: response
           };
         },
         cache: true
        }
      });

      $('#det_po').on('change', function(){

        let id = $(this).val();
        let link = '{{ url("master/barang/get_data_det_po") }}/'+id;
        $.get(link, function(res){

          if(res == null){}else{
            let parse = JSON.parse(res);
            $('#deskripsi').val(parse.item);
            $('#harga_perolehan').val(parse.harga_satuan);
          }

        });

      });

      $(".default-select2").select2();

      $(".date_picker").datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
      });

      $('#cariData').click(function(){
        callTable();
      });

      $('#body_barang').on('click','.detil_barang', function(){

        let data = $(this).attr('data-id');
        let kode = $(this).attr('data-kode');
        let deskripsi = $(this).attr('data-deskripsi');
        let link = "{{ url('master/barang/get_detail_barang') }}/" + data;

        $.get(link, function(res){
          $('#title_barang').text(kode + " - " + deskripsi);
          $('#holder_detail').html(res);
          $('#modal_detail').modal('show');

          $('.detail_table').DataTable();

        });

        
      });

      $('#body_barang').on('click', '.delete_button', function(){

        let dd = $(this).attr('data-id');
        id = dd;

        $('#alert_content').text("Apakah Anda yakin akan menghapus data ini?");
        $('#modal-alert').modal('show');

      });

      $('#btn_submit').click(function(){

        let link = '{{ url("master/barang/delete/") }}/'+id;
        $.get(link, function(res){
          location.reload();
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

      callTable();

      $('#redirect_form_add').click(function(){
        $('#myTab a[href="#default-tab-3"]').tab("show");
      });


    });
</script>


@endsection