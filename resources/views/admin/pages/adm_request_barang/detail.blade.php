@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

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
    <li class="breadcrumb-item"><a href="javascript:;">Request Barang</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Detail</a></li>
    <li class="breadcrumb-item active">{{ $data_request->no_agenda }}</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Detail Data Request Barang </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row" id="full_content">
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

            $dataDisposisi = App\Models\DetRequestBarangModel::where('id_barang_permintaan', $data_request->id);

            @endphp

            @if(App\Models\HelperModel::allowedAccess(4, 5))

              @if($dataDisposisi->count() > 0)

                @foreach($dataDisposisi->get() as $key => $val)

                  <div class="card">
                    <div class="card-body">

                      <div class="row">
                        <div class="col-lg-6">
                          <h4>Disposisi</h4>
                        </div>
                        <div class="col-lg-6 text-end">
                          @if($tombolBalasAktif = App\Models\DetDisposisiModel::checkAuthBalas(Auth()->user()->role, $val->tujuan))
                          <button type="button" class="btn btn-outline-primary buka_modal" data-id="{{ $val->id }}"><i class="fa fa-reply"></i> Balas</button>
                          @endif
                        </div>
                      </div>

                      <hr>

                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group row mb-3">
                            <label class="col-lg-12 col-form-label form-label">Ditujukan ke</label>
                            <div class="col-lg-12">
                              <label>
                                @php

                                  $temp_str = '';

                                  $detailDisposisi = explode(",", $val->tujuan);

                                  foreach($detailDisposisi as $key => $item){

                                      $getRole = App\Models\RoleModel::find($item);
                                      if($getRole){
                                          $temp_str .= ($key+1).'. '.$getRole->nama.(count($detailDisposisi) == $key+1 ? '' : '<br/>');
                                      }

                                  }

                                  echo $temp_str;

                                @endphp
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group row mb-3">
                            <label class="col-lg-12 col-form-label form-label" for="catatan">Isi Disposisi Awal <sub>(dari Sekretariat)</sub></label>
                            <div class="col-lg-12">
                              <p>{{ $val->isi_disposisi }}</p>
                            </div>
                          </div>
                        </div>

                        @php

                        $detailDisposisi = App\Models\DetDisposisiModel::where(DB::raw('id_barang_permintaan_disposisi'), $val->id)->orderBy('created_at' , 'ASC');

                        $last_date = '-';
                        $last_isi = '-';
                        $last_oleh = '-';

                        foreach($detailDisposisi->get() as $m => $me){
                          
                          if($m+1 == $detailDisposisi->count()){

                            $last_date = date('d M Y, H:i:s', strtotime($me->created_at));
                            $last_isi = $me->isi_disposisi;

                            $guser = App\Models\UserModel::find($me->create_user);

                            if($guser){

                              $getRole = App\Models\RoleModel::find($guser->role);
                              $last_oleh = $getRole ? $getRole->nama : '-';

                            }else{
                              $last_oleh = '-';
                            }

                            break;

                          }

                        }

                        @endphp

                        <div class="col-lg-6">
                          <div class="form-group row mb-3">
                            <label class="col-lg-12 col-form-label form-label" for="catatan">Balasan Disposisi Terakhir <sub>({{ $last_oleh }} - {{ $last_date }})</sub></label>
                            <div class="col-lg-12">
                              <p>{{ $last_isi }}</p>
                            </div>
                          </div>
                        </div>
                      </div>


                      <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th width="10%"><center><label style="font-size: 12px">Tanggal</label></center></th>
                              <th width="5%"><center><label style="font-size: 12px">Waktu</label></center></th>
                              <th width="15%"><center><label style="font-size: 12px">Dari</label></center></th>
                              <th width="10%"><center><label style="font-size: 12px">Role</label></center></th>
                              <th><center><label style="font-size: 12px">Isi Disposisi</label></center></th>
                              <th width="10%"><center><label style="font-size: 12px">Lampiran</label></center></th>
                            </tr>
                          </thead>
                          <tbody id="badan_disposisi">

                            @foreach($detailDisposisi->get() as $kk => $item)

                            @php

                              $getUser = App\Models\UserModel::find($item->create_user);
                              $namaUser = $getUser ? $getUser->name : '-';

                              if($getUser){

                                $getRole = App\Models\RoleModel::find($getUser->role);
                                $namaRole = $getRole ? $getRole->nama : '-';

                              }else{
                                $namaRole = '';
                              }

                            @endphp

                              <tr>
                                <td><center>{{ date('d M Y', strtotime($item->created_at)) }}</center></td>
                                <td><center>{{ date('H:i', strtotime($item->created_at)) }}</center></td>
                                <td><center>{{ $namaUser }}</center></td>
                                <td><center>{{ $namaRole }}</center></td>
                                <td><center>{{ $item->isi_disposisi }}</center></td>
                                <td><center>
                                  
                                  @if($item->lampiran_link == 1)

                                    @php
                                      $urlStr = $item->lampiran_file;
                                      $parsed = parse_url($urlStr);
                                      if (empty($parsed['scheme'])) {
                                          $urlStr = 'https://' . ltrim($urlStr, '/');
                                      }
                                    @endphp

                                    <a href="{{ $urlStr }}" target="_blank" class="btn btn-xs btn-outline-primary "><small><i class="fa fa-link"></i> Buka</small></a>

                                  @else

                                    @php

                                      $location = asset('uploads/lampiran/balasan').'/'.$item->lampiran_file;

                                    @endphp

                                    @if($item->lampiran_file != null)

                                    <a href="{{ $location }}" class="btn btn-xs btn-outline-primary " download><small><i class="fa fa-file-alt"></i> Unduh</small></a>

                                    @endif

                                  @endif

                                </center></td>
                              </tr>

                            @endforeach

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <br/>

                @endforeach

              @else

                <br/>

                <center><label><i>Belum Ada Disposisi</i></label></center>

                @if(App\Models\HelperModel::allowedAccess(4, 2))

                <center><a href="{{ url('administrasi/request_barang/buat_disposisi') }}/{{ md5($data_request->id) }}" class="btn btn-xs btn-outline-primary"><i class="fa fa-folder-open"></i> Buat Disposisi</a></center>

                @endif

                <br/>

              @endif

            @endif

            @if(App\Models\HelperModel::allowedAccess(4, 6))

              @if($data_request->status == 'DITERIMA' OR $data_request->status == 'DITOLAK')

              @else
              <br/>

              <div class="card">
                <div class="card-body">
                  <center><small><i>*Apabila proses pengajuan sudah mencapai keputusan terakhir silahkan tekan salah satu tombol dibawah..</i></small></center>
                  <br/>

                    <div class="row">
                      <div class="col-lg-3"></div>

                      <div class="col-lg-3">
                        <button type="button" class="btn btn-outline-success form-control tombol_approval" data-kondisi="1"><i class="fa fa-check"></i> Setujui Permintaan Barang</button>
                      </div>

                      <div class="col-lg-3">
                        <button type="button" class="btn btn-outline-danger form-control tombol_approval" data-kondisi="0"><i class="fa fa-times-circle"></i> Tolak Permintaan Barang</button>
                      </div>

                      <div class="col-lg-3"></div>
                    </div>
                </div>
              </div>
              @endif

            @endif


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
            <button type="button" class="btn btn-outline-primary" id="approval_execute" data-id="{{ $data_request->id }}" data-md5="{{ md5($data_request->id) }}"><i class="fa fa-save"></i> Ya</button>
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
        <h4 class="modal-title">Balas Disposisi</h4>
      </div>
      
      <form method="POST" action="{{ route('simpan-balasan-disposisi-forum') }}" class="form-horizontal" data-parsley-validate="true" enctype="multipart/form-data">
        
        <div class="modal-body" id="content_holder">
        
          @csrf
          <input type="hidden" name="id_disposisi" id="id_disposisi_balas" value="">

          <div class="row">
            <div class="col-lg-12">
              <div class="form-group row mb-3">
                <label class="col-lg-12 col-form-label form-label">Isi Disposisi <sup class="text-danger">*</sup></label>
                <div class="col-lg-12">
                  <textarea class="form-control" id="isi_disposisi" name="isi_disposisi" rows="5" data-parsley-required="true" placeholder="Isi Disposisi ..." required></textarea>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
                    
              <div class="form-group row mb-3">
                <div class="col-lg-12">
                  <label class="col-form-label form-label">Lampiran <sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-2">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="lampiran_link" value="1" id="lampiran_link_disposisi" />
                      <label class="form-check-label" for="lampiran_link_disposisi"><small>Berupa Link</small></label>
                    </div>
                </div>
                <div class="col-lg-10">
                  <div id="if_berupa_link_disposisi" style="display: none">
                    <input type="text" class="form-control lampiran" name="lampiran" placeholder="Required"/>
                  </div>
                  <div id="if_file_disposisi">
                    <input type="file" class="form-control lampiran" name="lampiran" placeholder="Required"/>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="form-group row mb-3">
                <label class="col-lg-12 col-form-label form-label">Ditujukan ke <sup class="text-danger">*</sup></label>
                <div class="col-lg-12">
                  @foreach($data_role as $val)

                    <!-- <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="tujuan_disposisi2[]" value="{{ $val->id }}" />
                      <label class="form-check-label" ><small>{{ $val->nama }}</small></label>
                    </div> -->

                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="tujuan_disposisi" value="{{ $val->id }}" required />
                      <label class="form-check-label" for="radio1">{{ $val->nama }}</label>
                    </div>

                  @endforeach
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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
<script src="{{ asset('assets') }}/plugins/parsleyjs/dist/parsley.min.js"></script>
<script src="{{ asset('assets') }}/plugins/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

    var kondisi;

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    $(function(){

      $('.tombol_approval').click(function(){

        kondisi = $(this).attr('data-kondisi');

        if(kondisi == 1){
          $("#alert_content").html("Apakah anda yakin akan menyetujui permintaan barang ini?");
        }else{
          $("#alert_content").html("Apakah anda yakin akan menolak permintaan barang ini?");
        }

        $('#modal-alert').modal('show');

      });

      $('#approval_execute').click(function(){

        $('#modal-alert').modal('hide');

        let id = $(this).attr('data-id');
        let md5 = $(this).attr('data-md5');

        let link = '{{ url("administrasi/request_barang/disposisi/approval") }}/'+id+'/'+md5+'/'+kondisi;

        $.get(link, function(res){
          location.reload();
        });

      });

      $('#full_content').on('click', '.buka_modal', function(){

        let id = $(this).attr('data-id');


        $('#id_disposisi_balas').val(id);
        $('#isi_disposisi').val('');
        $('#lampiran_link_disposisi').prop('checked', false);
        $('#content_holder').find('#if_berupa_link_disposisi').css('display', 'none');
        $('#content_holder').find('#if_file_disposisi').css('display', 'block');
        $('.lampiran').val('');

        $('#modal-detail').modal('show');

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

    });
</script>


@endsection