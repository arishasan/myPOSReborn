@php

$img = '';

if($data_user->photo_url == null || $data_user->photo_url == ""){
    $img = asset('assets').'/logo/noimage.png';
}else{
    $img = asset('/').$data_user->photo_url;
}

@endphp
<div class="row">
    
  <div class="col-lg-4">

    <div class="row">
      <div class="col-lg-12">
        <div class="form-group row mb-3">
          <!-- <label class="col-lg-12 col-form-label form-label" for="foto">Foto</label> -->
          <div class="col-lg-12">
            <center style="margin-bottom:10px;border:dashed 1px #ccc;padding:15px;background:#FFF"><img class="preview_gambar" src="{{ $img }}" style="width:200px;max-height:200px;" alt="NONE" /></center>
          </div>
        </div>
      </div>
    </div>
    
  </div>

  <div class="col-lg-8">
    
    
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-6">

            <div class="form-group row mb-3">
              <label class="col-lg-12 col-form-label form-label" for="role">Role <sup class="text-danger">*</sup></label>
              <div class="col-lg-12">
                <b>{{ $data_user->role }}</b>
              </div>
            </div>

          </div>
          <div class="col-lg-6">

            <!-- <div class="form-group row mb-3">
              <label class="col-lg-12 col-form-label form-label" for="permission">Permission <sup class="text-danger">*</sup></label>
              <div class="col-lg-12">
                {{ $data_user->permission }}
              </div>
            </div> -->

            <div class="form-group row mb-3">
              <label class="col-lg-12 col-form-label form-label" for="kampus">Supplier <sup class="text-danger">*</sup></label>
              <div class="col-lg-12">
                <?php 
                  $supplierSelected = "";
                  foreach ($data_supplier as $item){
                    $supplierSelected = ($item->id == $data_user->id_supplier ? $item->nama : '');
                    echo $supplierSelected;
                  }
                ?>
              </div>
            </div>

          </div>
     

        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="form-group row mb-3">
              <label class="col-lg-12 col-form-label form-label" for="name">Nama <sup class="text-danger">*</sup></label>
              <div class="col-lg-12">
                {{ $data_user->name }}
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group row mb-3">
              <label class="col-lg-12 col-form-label form-label" for="nohp">No HP <sup class="text-danger">*</sup></label>
              <div class="col-lg-12">
                {{ $data_user->mobile_number }}
              </div>
            </div>
          </div>

        </div>

        <div class="row">
          <div class="col-lg-6">
            <div class="form-group row mb-3">
              <label class="col-lg-12 col-form-label form-label" for="email">Username <sup class="text-danger">*</sup></label>
              <div class="col-lg-12">
                {{ $data_user->username }}
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group row mb-3">
              <label class="col-lg-12 col-form-label form-label" for="email">Email <sup class="text-danger">*</sup></label>
              <div class="col-lg-12">
                {{ $data_user->email }}
              </div>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="form-group row mb-3">
              <label class="col-lg-12 col-form-label form-label" for="status">Status </label>
              <div class="col-lg-12">
                {{ $data_user->status }}
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>


  </div>

</div>
