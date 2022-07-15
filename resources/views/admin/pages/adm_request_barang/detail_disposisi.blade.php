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

<div class="table-responsive">
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th width="10%"><center><label style="font-size: 12px">Tanggal</label></center></th>
        <th width="15%"><center><label style="font-size: 12px">Dari</label></center></th>
        <th><center><label style="font-size: 12px">Isi Disposisi</label></center></th>
        <th width="15%"><center><label style="font-size: 12px">Ditujukan ke</label></center></th>
        <th width="10%"><center><label style="font-size: 12px">Act</label></center></th>
      </tr>
    </thead>
    <tbody id="badan_disposisi">

      @if($data_disposisi)

      @foreach($data_disposisi as $key => $val)

        @php
          $tombolBalasAktif = App\Models\DetDisposisiModel::checkAuthBalas(Auth()->user()->role, $val->tujuan);

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

        <tr>
          <td><center>{{ @date('d M Y', strtotime($val->created_at)) }}</center></td>
          <td><center>{{ @$val->nama_user }}</center></td>
          <td><center>{{ @$val->isi_disposisi }}</center></td>
          <td>
            <p>
              <center>
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
              </center>
            </p>
          </td>
          <td>

            @if($tombolBalasAktif)
            <center>
              <a href="javascript:;" 
              data-id="{{ @$val->id }}"
              data-tgl="{{ @date('d M Y', strtotime($val->created_at)) }} / {{ @$val->nama_user }}"
              data-isi="<?= (str_replace('"', "`", $val->isi_disposisi)) ?>"

              data-tgl-last="{{ @date('d M Y', strtotime($last_date)) }} / {{ @$last_oleh }}"
              data-isi-last="<?= @(str_replace('"', "`", $last_isi)) ?>"

              class="btn btn-xs btn-outline-primary btn_reply_disposisi"><i class="fa fa-reply"></i> Balas</a>
            </center>
            <br/>
            @endif

            <a href="{{ url('administrasi/request_barang/detail') }}/{{ md5($val->id_barang_permintaan) }}" class="btn btn-xs btn-outline-primary" target="_blank" title="Lihat Balasan"><i class="fa fa-info-circle"></i> Lihat Balasan</a>

          </td>
        </tr>

      @endforeach


      @endif

    </tbody>
  </table>
</div>

<form method="POST" action="{{ route('simpan-balasan-disposisi') }}" class="form-horizontal" data-parsley-validate="true" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="id_disposisi" id="id_disposisi_balas" value="" required>
  
  <div id="form_balas_disposisi" style="display: none;">
    <div class="row">

      <div class="col-lg-4">
        
        <div class="row">
          
          <div class="col-lg-12">
            
            <div class="card">
              <div class="card-body">

                <h5>Disposisi Awal</h5>
                <hr>
                
                <h6 class="">Tanggal / Dari</h6>
                <label id="detdis_tgl"></label>

                <br/>
                <br/>

                <h6 class="">Isi</h6>
                <p id="detdis_isi"></p>

              </div>
            </div>

          </div>

        </div>

        <br/>

        <div class="row">
          
          <div class="col-lg-12">
            
            <div class="card">
              <div class="card-body">

                <h5>Balasan Terakhir</h5>
                <hr>
                
                <h6 class="">Tanggal / Dari</h6>
                <label id="detdis_tgl_last"></label>

                <br/>
                <br/>

                <h6 class="">Isi</h6>
                <p id="detdis_isi_last"></p>

              </div>
            </div>

          </div>

        </div>

      </div>
      
      <div class="col-lg-8">
        
        <div class="card">
          <div class="card-body">
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
                      <input type="text" class="form-control" name="lampiran" placeholder="Required"/>
                    </div>
                    <div id="if_file_disposisi">
                      <input type="file" class="form-control" name="lampiran" placeholder="Required"/>
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

            <div class="text-end">
              <button class="btn btn-outline-primary"><i class="fa fa-save"></i> Simpan</button>
            </div>

          </div>
        </div>

      </div>

    </div>
  </div>

</form>