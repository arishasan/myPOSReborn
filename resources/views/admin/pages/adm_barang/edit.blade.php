@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<link href="{{ asset('assets') }}/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset('assets') }}/jstree/dist/themes/default/style.min.css" />

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
    <li class="breadcrumb-item">Administrasi</li>
    <li class="breadcrumb-item">Data</li>
    <li class="breadcrumb-item"><a href="{{ route('adm-barang') }}">Barang</a></li>
    <li class="breadcrumb-item">Edit</li>
    <li class="breadcrumb-item active">{{ $data_barang->nama_barang }}</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Edit Data Barang </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">
      
      <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
          <a href="#detail-1" data-bs-toggle="tab" class="nav-link active">Keterangan Barang</a>
        </li>
        <li class="nav-item">
          <a href="#detail-2" data-bs-toggle="tab" class="nav-link">Harga Barang</a>
        </li>
        <li class="nav-item">
          <a href="#detail-3" data-bs-toggle="tab" class="nav-link">Stok Barang</a>
        </li>
        <li class="nav-item">
          <a href="#detail-4" data-bs-toggle="tab" class="nav-link">Aktivitas Stok Barang</a>
        </li>
      </ul>
      <div class="tab-content bg-white p-3 rounded-bottom">

        <!-- TAB 3 -->
        <div class="tab-pane fade active show" id="detail-1">
          
          <form method="POST" action="{{ route('update-adm-barang') }}" class="form-horizontal" data-parsley-validate="true" name="demo-form" enctype="multipart/form-data">  
            @csrf

            <div class="row">
              
              <div class="col-lg-3">
              
                @php

                $img = asset('assets').'/logo/noimage.png';
                if($data_barang->photo_url == null || $data_barang->photo_url == ""){}else{
                  $img = asset('/').$data_barang->photo_url;
                }

                @endphp

                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group row mb-3">
                      <label class="col-lg-12 col-form-label form-label" for="foto">Foto</label>
                      <div class="col-lg-12">
                        <center style="margin-bottom:10px;border:dashed 1px #ccc;padding:15px;background:#FFF"><img class="preview_gambar" style="width:200px;max-height:200px;" src="{{ $img }}" alt="NONE" /></center>
                      </div>
                      <div class="col-lg-12">
                        <input type="file" class="form-control" id="upload_gambar" name="foto" accept="image/x-png,image/jpeg">
                        <center><small class="text-danger">*Maksimal size 2 MB</small></center>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row text-center">
                  <div class="col-lg-12">

                    <div class="card">
                      
                      <div class="card-body">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="kode_barang">Kode Barang</label>
                          <div class="col-lg-12">
                            <h5 class="text-primary" style="font-size: 20px">{{ $data_barang->kode_barang }}</h5>
                          </div>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>

              </div>
              <div class="col-lg-9">
                
                <div class="card">
                  <div class="card-body">
                    
                    <input type="hidden" name="id" value="{{ $data_barang->id }}">

                    <div class="row">
                      <div class="col-lg-6">

                        @php
                        $globSatuan = '';
                        @endphp

                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="satuan">Satuan <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <select class="default-select2 form-control" name="id_satuan" id="satuan" data-parsley-required="true">
                              <option value="">[ Silahkan Pilih ]</option>
                              @foreach($data_satuan as $val)
                                @if($data_barang->id_satuan == $val->id)
                                @php $globSatuan = $val->nama; @endphp
                                @endif
                                <option value="{{ $val->id }}" <?= $data_barang->id_satuan == $val->id ? 'selected' : '' ?>>{{ $val->nama }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                      </div>
                      <div class="col-lg-6">

                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="kategori">Kategori <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">

                            @php

                              $txt_kategori = '';
                              $get_kategori = App\Models\KategoriModel::find($data_barang->id_kategori);
                              if($get_kategori){

                                $txt_kategori = App\Models\KategoriModel::getParentName($get_kategori->parent).' - '.$get_kategori->nama;

                              }

                            @endphp

                            <div class="row">
                              <div class="col-lg-10">
                                <input type="hidden" name="id_kategori" value="{{ $data_barang->id_kategori }}" id="parent_kategori">
                                <input class="form-control" type="text" value="{{ $txt_kategori }}" placeholder="[ Silahkan Pilih ]" id="label_parent_kategori" data-parsley-required="true" readonly />
                              </div>
                              <div class="col-lg-2">
                                <button type="button" id="btn_pilih_kategori" class="btn btn-lg btn-outline-primary form-control" title="Pilih kategori"><i class="fa fa-search"></i></button>
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
                            <input class="form-control" type="text" id="nama_barang" name="nama_barang" placeholder="Required" value="<?= $data_barang->nama_barang ?>" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-lg-12">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="deskripsi">Deskripsi <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= $data_barang->keterangan ?></textarea>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-lg-4" hidden>
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Barang Memiliki Tanggal Kadaluarsa? <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <select class="default-select2 form-control" id="is_expiracy" name="is_expiracy" data-parsley-required="true">
                              <option value="0">Tidak</option>
                              <option value="1" <?= $data_barang->expired_date_status == 1 ? 'selected' : '' ?>>Ya</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-4" hidden>
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="status">Status</label>
                          <div class="col-lg-12">
                            <select class="default-select2 form-control" id="status" name="status" data-parsley-required="true">
                              <option value="1">AKTIF</option>
                              <option value="0" <?= $data_barang->status == 0 ? 'selected' : '' ?>>NON-AKTIF</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Harga Grosir Saat QTY Lebih Dari<sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control currency" type="text" value="<?= number_format($data_barang->qty_min_grosir) ?>" id="qty_grosir" name="qty_grosir" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>

                    </div>


                    <div style="text-align: right;">
                      <div class="row">
                        <div class="col-lg-12">
                          <a href="{{ route('adm-barang') }}" class="btn btn-outline-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
                          <button type="submit" class="btn btn-outline-primary"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                      </div>
                    </div>

                    
                  </div>
                </div>

              </div>

            </div>
            
          </form>

        </div>
        <!-- END OF TAB 3 -->

        <!-- TAB 3 -->
        <div class="tab-pane fade" id="detail-2">

          @php

          $terakhirUpdate = "";
          $temp_beli = 0;
          $temp_grosir = 0;
          $temp_eceran = 0;
          $getHargaTerakhir = \App\Models\BarangHargaModel::where('id_barang', $data_barang->id)->orderBy('id_harga_barang', 'DESC')->first();
          if(null !== $getHargaTerakhir){
              $temp_grosir = $getHargaTerakhir->harga_jual_grosir;
              $temp_eceran = $getHargaTerakhir->harga_jual_eceran;
              $temp_beli = $getHargaTerakhir->harga_beli;
              $terakhirUpdate = date('d M Y, H:i:s', strtotime($getHargaTerakhir->created_at));
          }

          @endphp

          <div class="card">
            <div class="card-header">
              Ringkasan Harga Barang <br/>
              <small>Terakhir Update Pada : <b>{{ $terakhirUpdate }}</b></small>
            </div>
            <div class="card-body">
                
              <div class="row">

                  <div class="col-lg-8">
                    
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Harga Beli </label>
                          <div class="col-lg-12">
                            <b><label>Rp. {{ number_format($temp_beli) }}</label></b>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Harga Jual Grosir </label>
                          <div class="col-lg-12">
                            <b><label>Rp. {{ number_format($temp_grosir) }}</label></b>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Harga Jual Eceran </label>
                          <div class="col-lg-12">
                            <b><label>Rp. {{ number_format($temp_grosir) }}</label></b>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-lg-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">QTY pembelian minimal untuk auto pengambilan harga grosir.</label>
                          <div class="col-lg-12">
                            <b><label>{{ number_format($data_barang->qty_min_grosir) }}</label></b>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

            </div>
          </div>

          <br/>
          
          <div class="row">
            <div class="col-lg-8">
              
              <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle h4 detail_table" style="width: 100%">
                  <thead>
                    <tr>
                      <td width="3%">No.</td>
                      <td width="20%">Tanggal Input</td>
                      <td>Harga Beli</td>
                      <td>Harga Jual Grosir</td>
                      <td>Harga Jual Eceran</td>
                      <td width="15%">Oleh</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    
                    <?php

                      $getHargaBarang = \App\Models\BarangHargaModel::select(DB::raw('tb_harga_barang.*, users.name'))
                      ->join('users','tb_harga_barang.created_by','=','users.id')
                      ->where('tb_harga_barang.id_barang', $data_barang->id)->orderBy('tb_harga_barang.id_harga_barang', 'DESC')->get();

                      foreach ($getHargaBarang as $key => $value) {
                        ?>

                          <tr>
                            <td><b><?= $key+1 ?>.</b></td>
                            <td><b><?= date('d M Y, H:i:s', strtotime($value->created_at)) ?></b></td>
                            <td>Rp. <?= number_format($value->harga_beli) ?></td>
                            <td>Rp. <?= number_format($value->harga_jual_grosir) ?></td>
                            <td>Rp. <?= number_format($value->harga_jual_eceran) ?></td>
                            <td>
                              <?= $value->name ?>
                            </td>
                            <td>
                              <center><a href="<?= url("master/barang/harga/delete/".$value->id_harga_barang.'/'.md5($data_barang->id)) ?>" class="btn btn-outline-danger"><i class="fa fa-trash"></i></a></center>
                            </td>
                          </tr>

                        <?php
                      }

                    ?>

                  </tbody>
                </table>
              </div>

            </div>
            <div class="col-lg-4">
              
              <form action="{{ route('simpan-harga-baru') }}" method="POST" data-parsley-validate="true">
                @csrf

                <input type="hidden" name="id_barang" value="<?= $data_barang->id ?>">

                <div class="card">
                  <div class="card-header">
                    Update Harga Baru
                  </div>
                  <div class="card-body">
                    
                    <div class="row">

                      <div class="col-lg-12">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Harga Beli <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control currency" type="text" value="<?= number_format($temp_beli) ?>" id="harga_beli" name="harga_beli" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Harga Jual Grosir <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control currency" type="text" value="<?= number_format($temp_grosir) ?>" id="harga_grosir" name="harga_grosir" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Harga Jual Eceran<sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control currency" type="text" value="<?= number_format($temp_eceran) ?>" id="harga_eceran" name="harga_eceran" placeholder="Required" data-parsley-required="true" />
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <button class="btn btn-outline-primary form-control"><i class="fa fa-save"></i> Simpan</button>
                      </div>

                    </div>

                  </div>
                </div>

              </form>

            </div>
          </div>

        </div>
        <!-- END OF TAB 3 -->

        <!-- TAB 3 -->
        <div class="tab-pane fade" id="detail-3">

          @php

          $terakhirUpdate = "";
          $temp_stok = 0;
          $getStokTerakhir = \App\Models\BarangStokModel::where('id_barang', $data_barang->id)->orderBy('updated_at', 'asc')->get();

          foreach($getStokTerakhir as $key => $val){
              $temp_stok += $val->stok;
              $terakhirUpdate = date('d M Y, H:i:s', strtotime($val->updated_at));
          }

          @endphp

          <div class="card">
            <div class="card-header">
              Ringkasan Stok Barang<br/>
              <small>Terakhir Update Pada : <b>{{ $terakhirUpdate }}</b></small>
            </div>
            <div class="card-body">
                
              <div class="row">

                <div class="col-lg-8">
                  
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Akumulasi Stok Saat Ini </label>
                        <div class="col-lg-12">
                          <h4><label>{{ $temp_stok }} {{ $globSatuan }}</label></h4>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-lg-4" hidden>
                  <div class="card">
                    <div class="card-body">
                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Barang Memiliki Tanggal Kadaluarsa?</label>
                        <div class="col-lg-12">
                          <b><label>{{ $data_barang->expired_date_status == 1 ? 'Ya' : 'Tidak' }}</label></b>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>

          <br/>
          
          <div class="row">
            <div class="col-lg-8">
              
              <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle h4 detail_table" style="width: 100%">
                  <thead>
                    <tr>
                      <td width="3%">No.</td>
                      <td width="20%">Tanggal Input/Update</td>
                      <td>Stok</td>
                      <?= ($data_barang->expired_date_status == 1 ? '<td>Tanggal Kadaluarsa</td>' : '') ?>
                      <td width="15%">Oleh</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    
                    <?php

                      $getStokBarang = \App\Models\BarangStokModel::select(DB::raw('tb_stok_barang.*, users.name'))
                      ->join('users','tb_stok_barang.created_by','=','users.id')
                      ->where('tb_stok_barang.id_barang', $data_barang->id)->orderBy('tb_stok_barang.id_stok_barang', 'DESC')->get();

                      foreach ($getStokBarang as $key => $value) {
                        ?>

                          <tr>
                            <td><b><?= $key+1 ?>.</b></td>
                            <td><b><?= date('d M Y, H:i:s', strtotime($value->updated_at)) ?></b></td>
                            <td><?= $value->stok ?></td>
                            <?= ($data_barang->expired_date_status == 1 ? '<td>'.date('d M Y', strtotime($value->tgl_kadaluarsa)).'</td>' : '') ?>
                            <td>
                              <?= $value->name ?>
                            </td>
                            <td>
                              <center>
                                <button type="button" class="btn btn-outline-warning btn-sm keluarkanStok" 
                                data-id="<?= $value->id_stok_barang ?>" 
                                data-idbarang="<?= $value->id_barang ?>" 
                                data-stok="<?= $value->stok ?>"
                                data-tgl="<?= ($data_barang->expired_date_status == 1 ? date('d M Y', strtotime($value->tgl_kadaluarsa)) : '-') ?>"
                                ><i class="fa fa-arrow-left"></i> Keluarkan Stok</button>
                                <a href="<?= url("master/barang/stok/delete/".$value->id_stok_barang.'/'.md5($data_barang->id)) ?>" class="btn btn-outline-danger"><i class="fa fa-trash"></i></a>
                              </center>
                              </td>
                          </tr>

                        <?php
                      }

                    ?>

                  </tbody>
                </table>
              </div>

            </div>
            <div class="col-lg-4">
              
              <form action="{{ route('simpan-stok-baru') }}" method="POST" data-parsley-validate="true">
                @csrf

                <input type="hidden" name="id_barang" value="<?= $data_barang->id ?>">
                <input type="hidden" name="is_kadaluarsa_active" value="<?= $data_barang->expired_date_status ?>">

                <div class="card">
                  <div class="card-header">
                    Tambah Stok Baru
                  </div>
                  <div class="card-body">
                    
                    <div class="row">

                      <div class="col-lg-12" <?= $data_barang->expired_date_status == 1 ? '' : 'hidden' ?>>
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Tanggal Kadaluarsa <sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input type="date" class="form-control" id="tgl_kadaluarsa" name="tgl_kadaluarsa" value="{{ date('Y-m-d') }}" />
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-12">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="stok">Stok<sup class="text-danger">*</sup></label>
                          <div class="col-lg-12">
                            <input class="form-control" type="number" value="0" min="0" step="0.1" id="stok" name="stok" placeholder="Required" required data-parsley-required="true"/>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-12">
                        <button class="btn btn-outline-primary form-control"><i class="fa fa-save"></i> Simpan</button>
                      </div>

                    </div>

                  </div>
                </div>

              </form>

            </div>
          </div>

        </div>
        <!-- END OF TAB 3 -->

        <!-- TAB 4 -->
        <div class="tab-pane fade" id="detail-4">

          <div class="table-responsive">
              <table class="table table-bordered table-striped align-middle h4 detail_table" style="width: 100%">
                <thead>
                  <tr>
                    <td width="3%">No.</td>
                    <td width="20%">Tanggal Input</td>
                    <td>QTY</td>
                    <td>Status</td>
                    <td width="15%">Oleh</td>
                  </tr>
                </thead>
                <tbody>
                  
                  <?php

                    $getAktivitasBarang = \App\Models\BarangAktivitasModel::select(DB::raw('tb_aktivitas_barang.*, users.name'))
                    ->join('users','tb_aktivitas_barang.created_by','=','users.id')
                    ->where('tb_aktivitas_barang.id_barang', $data_barang->id)->orderBy('tb_aktivitas_barang.id_aktivitas_barang', 'DESC')->get();

                    foreach ($getAktivitasBarang as $key => $value) {
                      ?>

                        <tr>
                          <td><b><?= $key+1 ?>.</b></td>
                          <td><b><?= date('d M Y, H:i:s', strtotime($value->created_at)) ?></b></td>
                          <td><?= $value->qty ?></td>
                          <td><b class="<?= ($value->status == 'Masuk' ? 'text-success' : 'text-danger') ?>"><?= $value->status ?></b></td>
                          <td>
                            <?= $value->name ?>
                          </td>
                        </tr>

                      <?php
                    }

                  ?>

                </tbody>
              </table>
            </div>

        </div>
        <!-- END OF TAB 4 -->

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
          <h5><i class="fa fa-info-white"></i> Perhatian</h5>
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
        <a href="javascript:;" class="btn btn-primary" id="ya_kategori">Pilih</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_keluarkan_stok">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Keluarkan Stok</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      
      <form action="{{ route('simpan-keluar-barang') }}" method="POST">
        @csrf
        <input type="hidden" name="id" id="keluar_id">
        <input type="hidden" name="id_barang" id="keluar_idbarang">
        <div class="modal-body">
        
          <div class="row">
            
            <div class="col-lg-8">
              
              <div class="col-lg-12">
                <div class="form-group row mb-3">
                  <label class="col-lg-12 col-form-label form-label" for="stok">QTY yang akan dikeluarkan<sup class="text-danger">*</sup></label>
                  <div class="col-lg-12">
                    <input class="form-control" type="number" value="0" min="0" step="0.1" name="stok" placeholder="Required" required/>
                  </div>
                </div>
              </div>

            </div>

            <div class="col-lg-4">
              <div class="card">
                <div class="card-body">
                  <label>Stok Tersedia</label><br/>
                  <label id="keluar_stok" style="font-weight: bold"></label> <br/><br/>
                  <label>Tanggal Kadaluarsa</label><br/>
                  <label id="keluar_tgl" style="font-weight: bold"></label>
                </div>
              </div>
            </div>

          </div>

        </div>
        <div class="modal-footer">
          <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
          <button class="btn btn-primary">Simpan</a>
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

<script type="text/javascript">

    var kategori, lokasi;

    var lokasiID, lokasiName;
    var kategoriID, kategoriName;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(function(){

      $(document).on('click','.keluarkanStok',function(){

        let id = $(this).attr('data-id');
        let idbarang = $(this).attr('data-idbarang');
        let stok = $(this).attr('data-stok');
        let tgl = $(this).attr('data-tgl');

        $('#keluar_stok').text(stok);
        $('#keluar_tgl').text(tgl);
        $('#keluar_id').val(id);
        $('#keluar_idbarang').val(idbarang);

        $('#modal_keluarkan_stok').modal('show');

      });

      $('.detail_table').DataTable();

      $('#sewa').on('change', function(){

        if($(this).val() == 0){

          $('#holder_po_barang').attr('hidden', false);
          $('#holder_lokasi').attr('class', 'col-lg-6');

        }else{

          $('#holder_po_barang').attr('hidden', true);
          $('#holder_lokasi').attr('class', 'col-lg-12');

        }

      });

      lokasiID = $('#parent_lokasi').val();
      kategoriID = $('#parent_kategori').val();

      $('#btn_pilih_lokasi').click(function(){
        $("#dataTree_lokasi").jstree("deselect_all");
        $("#dataTree_lokasi").jstree("close_all");

        let lokasi = $('#parent_lokasi').val();


        $('#dataTree_lokasi').jstree(true).select_node("#"+lokasi+"");
        // $('#selected_node').text('');
        // $('#selected_parent').text('');

        $('#modal_pilih_lokasi').modal('show');
      });

      $('#ya_lokasi').click(function(){

        if(lokasiID == null){
          swal({
            title: 'Perhatian',
            text: 'Anda belum memilih lokasi!',
            icon: 'error',
          });
        }else{
          $('#parent_lokasi').val(lokasiID);
          $('#label_parent_lokasi').val(lokasiName);
        }

        $('#modal_pilih_lokasi').modal('hide');
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
        $("#dataTree_kategori").jstree("deselect_all");
        $("#dataTree_kategori").jstree("close_all");

        let kategori = $('#parent_kategori').val();

        $('#dataTree_kategori').jstree(true).select_node("#"+kategori+"");

        // $('#selected_node').text('');
        // $('#selected_parent').text('');

        $('#modal_pilih_kategori').modal('show');
      });

      $('#ya_kategori').click(function(){

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

        $('#modal_pilih_kategori').modal('hide');
      });

      $(".default-select2").select2();

      $("#date_picker").datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
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



    });
</script>


@endsection