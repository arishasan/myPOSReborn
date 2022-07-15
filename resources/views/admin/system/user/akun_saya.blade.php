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

  <!-- BEGIN page-header -->
  <h1 class="page-header">Akun Saya </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">
      
      <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
          <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active" id="tab_satu">Edit Akun</a>
        </li>
        
      </ul>
      <div class="tab-content bg-white p-3 rounded-bottom">
        <!-- TAB 1 -->
        <div class="tab-pane fade active show" id="default-tab-1">

          <div class="card">
            <div class="card-body">
              <form action="{{ route('update-myacc') }}" method="POST" class="form-horizontal" enctype="multipart/form-data" data-parsley-validate="true">
                  @csrf
                  <input type="hidden" name="user_id" value="{{ $data_user->id }}">
                  <div class="row">
                      
                    <div class="col-lg-3">

                      @php

                      $img = '';

                      if($data_user->photo_url == null || $data_user->photo_url == ""){
                          $img = asset('assets').'/logo/noimage.png';
                      }else{
                          $img = asset('/').$data_user->photo_url;
                      }

                      @endphp

                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group row mb-3">
                            <!-- <label class="col-lg-12 col-form-label form-label" for="foto">Foto</label> -->
                            <div class="col-lg-12">
                              <center style="margin-bottom:10px;border:dashed 1px #ccc;padding:15px;background:#FFF"><img class="preview_gambar" src="{{ $img }}" style="width:200px;max-height:200px;" alt="NONE" /></center>
                            </div>
                            <div class="col-lg-12">
                              <input type="file" class="form-control" id="upload_gambar" name="foto" accept="image/x-png,image/jpeg">
                              <center><small><label class="text-danger"><b>Max file hanya 2MB</b></label></small></center>
                              <center><small><i>Jika tidak terjadi perubahan, tekan CTRL + F5</i></small></center>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    </div>

                    <div class="col-lg-9">
                      
                      <div class="row">

                        <div class="col-lg-3">
                          <div class="card" style="height: 100%">
                            <div class="card-body">
                              
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="form-group row mb-3">
                                    <label class="col-lg-12 col-form-label form-label" for="role">Role</label>
                                    <div class="col-lg-12">
                                      {{ $data_user->role }}
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="form-group row mb-3">
                                    <label class="col-lg-12 col-form-label form-label" for="username">Username <sup class="text-danger">*</sup></label>
                                    <div class="col-lg-12">
                                      {{ $data_user->username }}
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="form-group row mb-3">
                                    <label class="col-lg-12 col-form-label form-label" for="email">Email <sup class="text-danger">*</sup></label>
                                    <div class="col-lg-12">
                                      {{ $data_user->email }}
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                        

                        <div class="col-lg-9">

                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group row mb-3">
                                <label class="col-lg-12 col-form-label form-label" for="name">Nama <sup class="text-danger">*</sup></label>
                                <div class="col-lg-12">
                                  <input class="form-control" type="text" id="name" value="{{ $data_user->name }}" name="name" placeholder="Required" data-parsley-required="true" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group row mb-3">
                                <label class="col-lg-12 col-form-label form-label" for="nohp">No HP <sup class="text-danger">*</sup></label>
                                <div class="col-lg-12">
                                  <input type="text" class="form-control" value="{{ $data_user->mobile_number }}" id="hp" name="mobile_number" placeholder="Required" data-parsley-required="true" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group row mb-3">
                                <label class="col-lg-12 col-form-label form-label" for="password">Password </label>
                                <div class="col-lg-12">
                                  <input class="form-control" type="password" id="password" name="password" placeholder="Lewati jika tidak ingin diubah" />
                                </div>
                              </div>
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
                        <button type="submit" class="btn btn-outline-primary"><i class="fa fa-save"></i> Simpan</button>
                      </div>
                    </div>
                  </div>

                </form>
              </div>
            </div>

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

      $(".default-select2").select2();

    });
</script>


@endsection