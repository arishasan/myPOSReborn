@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<link href="{{ asset('assets') }}/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />


<style>
 td {
  font-size: 10px;
 }
</style>

@section('content')

<div id="content" class="app-content">
  <!-- BEGIN breadcrumb -->
  <ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item">Administrasi</li>
    <li class="breadcrumb-item">Data</li>
    <li class="breadcrumb-item"><a href="{{ route('adm-request-barang') }}">Request Barang</a></li>
    <li class="breadcrumb-item">Edit</li>
    <li class="breadcrumb-item">{{ $data_request->no_agenda }}</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Edit Data Request Barang </h1>
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

          <form action="{{ route('update-request-barang') }}" method="POST" class="form-horizontal" data-parsley-validate="true" name="demo-form" enctype="multipart/form-data">  
            @csrf
            <input type="hidden" value="{{ $data_request->id }}" name="id">
            <div class="card">
              <div class="card-body">
                  
                  <div class="row">
                    <div class="col-lg-<?= Auth()->user()->id_requester != 0 ? '12' : '6' ?>">

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Perihal <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <input type="text" class="form-control" name="perihal" value="{{ $data_request->perihal }}" placeholder="Required" data-parsley-required="true"/>
                        </div>
                      </div>

                    </div>

                    <div class="col-lg-6" <?= Auth()->user()->id_requester != 0 ? 'hidden' : '' ?>>

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Kode RAB / Anggaran <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <input type="text" class="form-control" name="kode_anggaran" value="{{ $data_request->kode_anggaran }}" placeholder="Required" data-parsley-required="true"/>
                        </div>
                      </div>

                    </div>

                    <!-- <div class="col-lg-6">

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">No Agenda <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <input type="text" class="form-control" name="no_agenda" value="{{ $data_request->no_agenda }}" placeholder="Required" data-parsley-required="true"/>
                        </div>
                      </div>

                    </div> -->
                   

                  </div>

                  <div class="row">
                   
                    <div class="col-lg-4">

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Nama Barang <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <input type="text" class="form-control" name="nama_barang" value="{{ $data_request->nama_barang }}" placeholder="Required" data-parsley-required="true"/>
                        </div>
                      </div>

                    </div>

                    <div class="col-lg-4">

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Jumlah <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <input type="number" class="form-control" min="0" name="jumlah" value="{{ $data_request->jumlah }}" placeholder="Required" data-parsley-required="true"/>
                        </div>
                      </div>

                    </div>

                    <div class="col-lg-4">
                      
                      <div class="form-group row mb-3">
                        <div class="col-lg-12">
                          <label class="col-form-label form-label">Lampiran</label>
                          <small style="font-size: 9px;"> *Biarkan apabila tidak diubah</small>
                        </div>
                        <div class="col-lg-3">
                          <center>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="lampiran_link" value="1" id="lampiran_link_user" <?= ($data_request->lampiran_link == 1 ? 'checked' : '') ?> />
                              <label class="form-check-label" for="lampiran_link_user"><small>Berupa Link</small></label>
                            </div>
                          </center>
                        </div>
                        <div class="col-lg-9">
                          <div id="if_berupa_link_user" style="display: <?= $data_request->lampiran_link == 1 ? 'block' : 'none' ?>">
                            <input type="text" class="form-control" name="lampiran" value="<?= $data_request->lampiran_link == 1 ? $data_request->lampiran_file : '' ?>" placeholder="Required" />
                          </div>
                          <div id="if_file_user" style="display: <?= $data_request->lampiran_link == 1 ? 'none' : 'block' ?>">
                            <input type="file" class="form-control" name="lampiran" placeholder="Required" />
                          </div>

                          <br/>

                          @if($data_request->lampiran_link == 1)

                            <a href="{{ $data_request->lampiran_file }}" target="_blank" class="btn btn-outline-primary form-control"><i class="fa fa-link"></i> Buka</a>

                          @else

                            @php

                              $location = asset('uploads/lampiran/request').'/'.$data_request->lampiran_file;

                            @endphp

                            <a href="{{ $location }}" class="btn btn-outline-primary form-control" download><i class="fa fa-file-alt"></i> Unduh</a>

                          @endif

                        </div>
                      </div>

                    </div>
                   
                  </div>
                 
                  <div class="row">

                    <div class="col-lg-12">
                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label" for="catatan">Alasan <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <textarea class="form-control" id="keterangan" name="keterangan" rows="3" data-parsley-required="true" placeholder="Alasan ...">{{ $data_request->keterangan }}</textarea>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="row" <?= (Auth()->user()->id_requester == 0 && App\Models\HelperModel::allowedAccess(4, 6) ? '' : 'hidden') ?>>
                    <div class="col-lg-12">
                        
                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label" for="status">Status</label>
                        <div class="col-lg-12">
                          <select class="default-select2 form-control" id="status" name="status" data-parsley-required="true">
                            <option value="BARU" <?= ($data_request->status == 'BARU' ? 'selected' : '') ?>>BARU</option>
                            <option value="DIPROSES" <?= ($data_request->status == 'DIPROSES' ? 'selected' : '') ?>>DIPROSES</option>
                            <option value="DISETUJUI" <?= ($data_request->status == 'DISETUJUI' ? 'selected' : '') ?>>DISETUJUI</option>
                            <option value="DITOLAK" <?= ($data_request->status == 'DITOLAK' ? 'selected' : '') ?>>DITOLAK</option>
                            
                          </select>
                        </div>
                      </div>

                    </div>
                  </div>

              </div>
            </div>

            <br/>

            <div style="text-align: right;">
                  <div class="row">
                    <div class="col-lg-12">
                      <a href="{{ route('adm-request-barang') }}" class="btn btn-outline-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
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
        <div class="alert alert-warning">
          <h5><i class="fa fa-info-circle"></i> Perhatian</h5>
          <p id="alert_content"></p>
          <center>
            <a href="javascript:;" class="btn btn-outline-primary" data-bs-dismiss="modal"><i class="fa fa-save"></i> Ya</a>
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
<script src="{{ asset('assets') }}/plugins/parsleyjs/dist/parsley.min.js"></script>
<script src="{{ asset('assets') }}/plugins/sweetalert/dist/sweetalert.min.js"></script>

<script src="{{ asset('assets') }}/plugins/jquery-migrate/dist/jquery-migrate.min.js"></script>
<script src="{{ asset('assets') }}/plugins/tag-it/js/tag-it.min.js"></script>


<script type="text/javascript">

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    $(function(){

      $('#badan_disposisi').on('click', '.btn_reply_disposisi', function(){

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

      $('#lampiran_link_disposisi').on('change', function(){
        if(this.checked) {
            $('#if_berupa_link_disposisi').css('display', 'block');
            $('#if_file_disposisi').css('display', 'none');
        }else{
          $('#if_berupa_link_disposisi').css('display', 'none');
          $('#if_file_disposisi').css('display', 'block');
        }
      });

      $('#redirect_form_add').click(function(){
        $('#myTab a[href="#default-tab-3"]').tab("show");
      });

      $('#body_table').on('click', '.detail_disposisi', function(){
        $('#form_balas_disposisi').css('display', 'none');
        $('#modal-detail').modal('show');
      });

      

    });
</script>


@endsection