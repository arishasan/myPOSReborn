@php
  $img = '';

  if($data_barang->photo_url == null || $data_barang->photo_url == ""){
      $img = asset('assets').'/logo/noimage.png';
  }else{
      $img = asset('/').$data_barang->photo_url;
  }

  $visib_kode = 'hidden';

  if(Auth()->user()->id_requester != 0){

    if($data_barang->id_lokasi == 0 || $data_barang->status == "TERSEDIA"){}else{
      if($data_barang->status_acc == 1){
          $visib_kode = '';
      }
    }

  }else{

      $visib_kode = '';

  }

@endphp
<div class="row">


  <div class="col-lg-12">

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
      <!-- TAB 1 -->
      <div class="tab-pane fade active show" id="detail-1">

        <div class="row">
          
          <div class="col-lg-4">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group row mb-3">
                  <div class="col-lg-12">
                    <center style="margin-bottom:10px;border:dashed 1px #ccc;padding:15px;background:#FFF">
                      <a href="{{ $img }}" target="_blank"><img style="width:200px;max-height:200px;" alt="NONE" src="{{ $img }}" /></a>
                    </center>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" {{ $visib_kode }}>
              <div class="col-lg-12">

                <div class="card text-center" style="height: 100%">
                  <div class="card-body">
                    
                    <div class="form-group row mb-3">
                      <label class="col-lg-12 col-form-label form-label">
                        <center>
                          <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($data_barang->kode_barang, "C128" ,1,20) . '" alt="barcode"   />'; ?>
                        </center>
                      </label>
                      <div class="col-lg-12">
                        Kode Barang <br/>
                        <label><b style="font-size: 10px" >{{ $data_barang->kode_barang }}</b></label>
                      </div>
                    </div>

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

                      @php

                        try {

                          $getKategori = App\Models\KategoriModel::find($data_barang->id_kategori);

                          if($getKategori){
                              $data = $getKategori;
                              $retKategori = App\Models\KategoriModel::getParentName($data->parent).' - <b>'.$data->nama.'</b>';
                              $kat = $retKategori;
                          }else{
                              $kat = '<label>-</label>';
                          }
                          
                        } catch (Exception $e) {
                          $kat = '<label>-</label>';
                        }

                      @endphp

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Kategori </label>
                        <div class="col-lg-12">
                          <?= $kat ?>
                        </div>
                      </div>

                    </div>

                    <div class="col-lg-6">
                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Status </label>
                        <div class="col-lg-12">
                          <b><?= ($data_barang->status == 1 ? 'Aktif' : 'Non-Aktif') ?></b>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="row">
                    <div class="col-lg-6">

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Nama </label>
                        <div class="col-lg-12">
                          <?= $data_barang->nama_barang ?>
                        </div>
                      </div>

                    </div>
                    <div class="col-lg-6">

                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Satuan </label>
                        <div class="col-lg-12">
                          <?php

                            $getSatuan = \App\Models\SatuanModel::find($data_barang->id_satuan);
                            if(null !== $getSatuan){
                              echo $getSatuan->nama;
                            }

                          ?>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="row">

                    <div class="col-lg-12">
                      <div class="form-group row mb-3">
                        <label class="col-lg-12 col-form-label form-label">Deskripsi </label>
                        <div class="col-lg-12">
                          <p>{{ $data_barang->keterangan }}</p>
                        </div>
                      </div>
                    </div>

                  </div>

              </div>
            </div>

            <br/>

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

            @php

            $terakhirUpdate = "";
            $temp_stok = 0;
            $getStokTerakhir = \App\Models\BarangStokModel::where('id_barang', $data_barang->id)->orderBy('id_stok_barang', 'asc')->get();

            foreach($getStokTerakhir as $key => $val){
                $temp_stok += $val->stok;
                $terakhirUpdate = date('d M Y, H:i:s', strtotime($val->created_at));
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
                            <h4><label>{{ $temp_stok }}</label></h4>
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



          </div>

        </div>
        

      </div>
      <!-- END OF TAB 1 -->

      <!-- TAB 2 -->
      <div class="tab-pane fade" id="detail-2">

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
                      </tr>

                    <?php
                  }

                ?>

              </tbody>
            </table>
          </div>

      </div>
      <!-- END OF TAB 2 -->

      <!-- TAB 3 -->
      <div class="tab-pane fade" id="detail-3">

        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle h4 detail_table" style="width: 100%">
            <thead>
              <tr>
                <td width="3%">No.</td>
                <td width="20%">Tanggal Input</td>
                <td>Stok</td>
                <?= ($data_barang->expired_date_status == 1 ? '<td>Tanggal Kadaluarsa</td>' : '') ?>
                <td width="15%">Oleh</td>
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
                      <td><b><?= date('d M Y, H:i:s', strtotime($value->created_at)) ?></b></td>
                      <td><?= $value->stok ?></td>
                      <?= ($data_barang->expired_date_status == 1 ? '<td>'.date('d M Y', strtotime($value->tgl_kadaluarsa)).'</td>' : '') ?>
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