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
  font-size: 10px;
 }
</style>

@section('content')

<div id="content" class="app-content">
  <!-- BEGIN breadcrumb -->
  <ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Sistem Data</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users') }}">Users</a></li>
    <li class="breadcrumb-item">Akses</li>
    <li class="breadcrumb-item active">{{ $data_user->name }}</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Akses User </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <form action="{{ route('simpan-akses') }}" method="POST" class="form-horizontal" data-parsley-validate="true">
    @csrf
    <input type="hidden" name="user_id" value="{{ $data_user->user_id }}">

    <div class="row">
      <div class="col-xl-3">
        
        <div class="card">
          <div class="card-body">
            
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group row mb-3">
                  <div class="col-lg-12">
                    <center style="margin-bottom:10px;border:dashed 1px #ccc;padding:15px;"><img class="preview_gambar" src="{{ $data_user->photo_url }}" style="width:200px;max-height:200px;" alt="NONE" /></center>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group row mb-3">
                      <label class="col-lg-12 col-form-label form-label">Role </label>
                      <div class="col-lg-12">
                        <?php 
                          $role_selected = "";
                          foreach ($data_role as $item){
                            $role_selected = ($item->id == $data_user->role ? $item->nama : '');
                            echo $role_selected;
                          }
                        ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group row mb-3">
                      <label class="col-lg-12 col-form-label form-label">Nama </label>
                      <div class="col-lg-12">
                        {{ $data_user->name }}
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group row mb-3">
                      <label class="col-lg-12 col-form-label form-label">No HP </label>
                      <div class="col-lg-12">
                        {{ $data_user->mobile_phone }}
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group row mb-3">
                      <label class="col-lg-12 col-form-label form-label">Email </label>
                      <div class="col-lg-12">
                        {{ $data_user->email }}
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="text-center">
              <div class="row">
                <div class="col-lg-12">
                  <button type="submit" class="form-control btn btn-outline-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
              </div>
              <br/>
              <div class="row">
                <div class="col-lg-6">
                  <a href="{{ route('users') }}" class="form-control btn btn-outline-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
                <div class="col-lg-6">
                  <button type="button" class="form-control btn btn-outline-primary" id="cek_semua"><i class="fa fa-check"></i> Ceklis Semua</button>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
      <div class="col-xl-9 mb-3">

        
        <div class="row" id="barisan_akses">
          
          @foreach($array_akses as $key => $val)

            <div class="col-lg-4 mb-3">
              
              <div class="card" style="height: 100%">
                <div class="card-header bg-white">
                  <br/>
                  <div class="row">
                    <div class="col-lg-10">
                      <h5>{{ ucwords($val['name']) }}</h5>
                    </div>
                    <div class="col-lg-2 text-end">
                      <div class="form-check">
                        <input class="form-check-input parent" name="parent_{{ $key }}" type="checkbox" value="1" id="parent_{{ $key }}"
                        <?= @(null !== $akses_selected[$key]->enable && $akses_selected[$key]->enable == 1 ? 'checked' : '') ?>
                        >
                      </div>
                    </div>
                  </div>
                  
                </div>
                <div class="card-body">

                  <div class="row">
                    <div class="col-md-12">

                      @foreach($val['menu'] as $key2 => $val2)

                      <div class="form-check mt-2 mb-2">
                        <input class="form-check-input child_parent_{{ $key }}" name="child_{{ $key }}_{{$key2}}" type="checkbox" value="1" id="child{{$key2}}"
                          <?= @(null !== $akses_selected[$key]->menu[$key2]->enable && $akses_selected[$key]->menu[$key2]->enable == 1 ? 'checked' : '') ?>
                          >
                          <label class="form-check-label" for="child{{$key2}}">
                            {{ ucwords(str_replace("_"," ", $val2['name'])) }}
                          </label>
                      </div>

                      @endforeach
                      
                    </div>
                  </div>

                </div>
              </div>  


            </div>

          @endforeach

        </div>

        
      </div>
    </div>

    <br/>
    <div class="row">
      <div class="col-lg-12">
        
        <div class="card">
          <div class="card-header bg-white">
            <br/>
            <div class="row">
              <div class="col-lg-12">
                <h5>Akses Lokasi / Wilayah</h5>
              </div>
            </div>
            
          </div>
          <div class="card-body">

            <div class="row">
              <div class="col-md-12">

                @foreach($array_lokasi as $key2 => $val2)

                <div class="form-check mt-2 mb-2">
                  <input class="form-check-input" name="wilayah_{{ $val2['id'] }}" type="checkbox" value="1" id="wilayah{{$key2}}"
                  <?= @(null !== $akses_wilayah[$key2]->enable && $val2['id'] == $akses_wilayah[$key2]->id && $akses_wilayah[$key2]->enable == 1 ? 'checked' : '') ?>
                  >
                  <label class="form-check-label" for="wilayah{{$key2}}">
                    {{ ucwords(str_replace("_"," ", $val2['name'])) }}
                  </label>
                </div>

                @endforeach
                
              </div>
            </div>

          </div>
        </div>

      </div>

      <div class="col-lg-6" hidden>
        
        <div class="card">
          <div class="card-header bg-white">
            <br/>
            <div class="row">
              <div class="col-lg-12">
                <h5>Akses Requester</h5>
              </div>
            </div>
            
          </div>
          <div class="card-body">

            <div class="row">
              <div class="col-md-12">

                @foreach($array_requester as $key2 => $val2)

                <div class="form-check mt-2 mb-2">
                  <input class="form-check-input" name="requester_{{ $val2['id'] }}" type="checkbox" value="1" id="requester{{$key2}}"
                  <?= @(null !== $akses_requester[$key2]->enable && $val2['id'] == $akses_requester[$key2]->id && $akses_requester[$key2]->enable == 1 ? 'checked' : '') ?>
                  >
                  <label class="form-check-label" for="requester{{$key2}}">
                    {{ ucwords(str_replace("_"," ", $val2['name'])) }}
                  </label>
                </div>

                @endforeach
                
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>

  </form>

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

<script type="text/javascript">

    $(function(){

      $('#cek_semua').click(function(){
        $('input:checkbox').prop('checked', true);
      });

      $('#barisan_akses').on('change' , '.parent', function(){

        let id = $(this).attr('id');

        if(this.checked) {
          $('.child_'+id).prop('checked', true);
        }else{
          $('.child_'+id).prop('checked', false);
        }

      });

      $(".default-select2").select2();

    });
</script>


@endsection