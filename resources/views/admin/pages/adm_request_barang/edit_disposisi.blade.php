@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

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
    <li class="breadcrumb-item"><a href="javascript:;">Data</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Request Barang</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Disposisi</a></li>
    <li class="breadcrumb-item active">{{ $data_request->no_agenda }}</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Edit Disposisi Data Request Barang </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">

      <div class="card">
        <div class="card-body">
            
            <div class="row">
              <div class="col-lg-9">

                <div class="card" style="height: 100%">
                  <div class="card-body">
                    
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Perihal</label>
                          <div class="col-lg-12">
                            <label>{{ $data_request->perihal }}</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Oleh</label>
                          <div class="col-lg-12">
                            <label>{{ $data_request->nama_user }}</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Nama Barang</label>
                          <div class="col-lg-12">
                            <label>{{ $data_request->nama_barang }}</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Jumlah</label>
                          <div class="col-lg-12">
                            <label>{{ number_format($data_request->jumlah) }}</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="catatan">Alasan</label>
                          <div class="col-lg-12">
                            <p>{{ $data_request->keterangan }}</p>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                
              </div>
              <div class="col-lg-3">
                
                <div class="card" style="height: 100%">
                  <div class="card-body">
                    <div class="form-group row mb-3">
                      <label class="col-lg-12 col-form-label form-label">No Agenda</label>
                      <div class="col-lg-12">
                        <label>{{ $data_request->no_agenda }}</label>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <label class="col-lg-12 col-form-label form-label">Kode RAB / Anggaran</label>
                      <div class="col-lg-12">
                        <label>{{ $data_request->kode_anggaran }}</label>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <label class="col-lg-12 col-form-label form-label">Tanggal Request</label>
                      <div class="col-lg-12">
                        <label>{{ date('d M Y', strtotime($data_request->created_at)) }}</label>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <label class="col-lg-12 col-form-label form-label">Status</label>
                      <div class="col-lg-12">
                        <h4><span class="badge bg-primary">{{ $data_request->status }}</span></h4>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <label class="col-lg-12 col-form-label form-label">Lampiran</label>
                      <div class="col-lg-12">
                        
                        @if($data_request->lampiran_link == 1)

                          @php
                            $urlStr = $data_request->lampiran_file;
                            $parsed = parse_url($urlStr);
                            if (empty($parsed['scheme'])) {
                                $urlStr = 'https://' . ltrim($urlStr, '/');
                            }
                          @endphp

                          <a href="{{ $urlStr }}" target="_blank" class="btn btn-outline-primary form-control"><i class="fa fa-link"></i> Buka Lampiran</a>

                        @else

                          @php

                            $location = asset('uploads/lampiran/request').'/'.$data_request->lampiran_file;

                          @endphp

                          <a href="{{ $location }}" class="btn btn-outline-primary form-control" download><i class="fa fa-file-alt"></i> Unduh Lampiran</a>

                        @endif

                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <br/>

            @php

            $dataDisposisi = App\Models\DetRequestBarangModel::where('id_barang_permintaan', $data_request->id)->first();

            @endphp

            <form method="POST" action="{{ route('simpan-edit-disposisi') }}" class="form-horizontal" data-parsley-validate="true">
              @csrf
              <input type="hidden" value="{{ $data_request->id }}" name="id_barang_permintaan">
              <input type="hidden" value="{{ $dataDisposisi->id }}" name="id_disposisi">
              <div class="card">
                <div class="card-body">

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group row mb-3">
                        <label class="col-lg-6 col-form-label form-label">No Agenda <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <input type="text" class="form-control" name="no_agenda" value="{{ $data_request->no_agenda }}" placeholder="Required" data-parsley-required="true"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Isi Disposisi <sup class="text-danger">*</sup></label>
                        <div class="col-lg-12">
                          <textarea class="form-control" id="isi_disposisi" name="isi_disposisi" rows="5" data-parsley-required="true" placeholder="Isi Disposisi ...">{{ $dataDisposisi->isi_disposisi }}</textarea>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row" <?= App\Models\HelperModel::allowedAccess(4, 6) ? '' : 'hidden' ?>>
                    <div class="col-lg-3">
                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label" for="status">Status</label>
                        <div class="col-lg-12">
                          <select class="default-select2 form-control" id="status" name="status" data-parsley-required="true">
                            <option value="DIPROSES" <?= ($data_request->status == 'DIPROSES' ? 'selected' : '') ?> >DIPROSES</option>
                            <option value="DISETUJUI" <?= ($data_request->status == 'DISETUJUI' ? 'selected' : '') ?> >DISETUJUI</option>
                            <option value="DITOLAK" <?= ($data_request->status == 'DITOLAK' ? 'selected' : '') ?> >DITOLAK</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div style="text-align: right;">
                    <div class="row">
                      <div class="col-lg-12">
                        <a href="{{ route('adm-request-barang') }}" class="btn btn-outline-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
                        <a href="javascript:;" data-id="{{ md5($dataDisposisi->id) }}" class="btn btn-outline-danger" id="delete_button"><i class="fa fa-trash"></i> Hapus</a>
                        <button type="submit" class="btn btn-outline-primary"><i class="fa fa-save"></i> Simpan</button>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </form>

        </div>
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
            <a href='{{ url("administrasi/request_barang/disposisi/delete/") }}/{{ md5($dataDisposisi->id) }}' class="btn btn-outline-primary"><i class="fa fa-save"></i> Ya</a>
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
<script src="{{ asset('assets') }}/plugins/parsleyjs/dist/parsley.min.js"></script>
<script src="{{ asset('assets') }}/plugins/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    var id;
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    $(function(){

      $('#delete_button').click(function(){

        let dd = $(this).attr('data-id');
        id = dd;

        $('#alert_content').text("Apakah Anda yakin akan menghapus data ini?");
        $('#modal-alert').modal('show');

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

      var checkboxes = $("input[type='checkbox']"),
          submitButt = $("#btn_save");

      checkboxes.click(function() {
          submitButt.attr("disabled", !checkboxes.is(":checked"));
      });

    });
</script>


@endsection