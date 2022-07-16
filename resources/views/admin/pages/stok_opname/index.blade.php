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
    <li class="breadcrumb-item"><a href="javascript:;">Transaksi</a></li>
    <li class="breadcrumb-item active">Stok Opname</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Data Stok Opname </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">
      
      <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
          <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active" id="tab_satu">Data Tabel</a>
        </li>
        <li class="nav-item" {{ Auth()->user()->role == 'Pemilik' ? 'hidden' : '' }}>
          <a href="#default-tab-3" data-bs-toggle="tab" class="nav-link" id="tab_tiga">Tambah Data Baru</a>
        </li>
      </ul>
      <div class="tab-content bg-white p-3 rounded-bottom">
        <!-- TAB 1 -->
        <div class="tab-pane fade active show" id="default-tab-1">

          <!-- Klik di <a href="javascript:void(0)" id="redirect_form_add">sini</a> untuk menambahkan data baru. -->
          
          <!-- BEGIN card -->
          <div class="card">
            <div class="card-body">

              <!-- html -->
              <div class="table-responsive">
                <table id="data_table" style="width: 100%" class="table table-bordered table-striped align-middle h4">
                  <thead>
                    <tr>
                      <th width="1%" hidden></th>
                      <th><label>Tanggal OpName</label></th>
                      <th width="10%"><center><label>Oleh</label></center></th>
                      <th width="13%" data-orderable="false"></th>
                    </tr>
                  </thead>
                  <tbody id="body_opname">
                    @foreach($data_op as $key => $val)

                    <tr>
                      <td hidden>{{ $val->id }}</td>
                      <td>{{ date('d M Y', strtotime($val->tgl_opname)) }}</td>
                      <td><center>{{ $val->name }}</center></td>
                      <td>

                        <center>
                          <button class="btn btn-outline-info detail_opname" data-id="{{ $val->id }}" data-kode="{{ date('d M Y', strtotime($val->tgl_opname)) }}"><i class="fa fa-info"></i></button>
                            @if(Auth()->user()->role != 'Pemilik')

                              <button class="btn btn-outline-danger delete_button" data-id="{{ md5($val->id) }}"><i class="fa fa-trash"></i></button>

                            @endif
                        </center>

                      </td>
                    </tr>

                    @endforeach
                  </tbody>
                </table>
              </div>

            </div>
          </div>
          <!-- END card -->

          

        </div>
        <!-- END OF TAB 1 -->

        <!-- TAB 3 -->
        <div class="tab-pane fade" id="default-tab-3">
          
          <div class="card">
            <div class="card-body">
              <form action="{{ route('simpan-stokopname') }}" method="POST" class="form-horizontal" data-parsley-validate="true">
                @csrf
                
                <div class="row vertical-align">
                  <div class="col-lg-6">
                    <label>Tanggal OpName</label><br/><br/>
                    <input type="date" class="form-control" name="tgl_opname" value="{{ date('Y-m-d') }}">
                  </div>
                  <div class="col-lg"></div>
                  <div class="col-lg-2 text-end">
                    <button type="button" class="btn btn-outline-success form-control" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </div>

                <br/>

                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                      <tr>
                        <td width="3%">
                          <center>
                            <div class="form-check">
                              <input class="form-check-input parent" type="checkbox" value="1" id="check_all">
                            </div>
                          </center>
                        </td>
                        <td style="width: 15%">Kode Barang</td>
                        <td>Nama Barang</td>
                        <td style="width: 8%"><center>Satuan</center></td>
                        <td style="width: 11%"><center>QTY System</center></td>
                        <td style="width: 11%"><center>QTY Real</center></td>
                        <td style="width: 11%"><center>Varian</center></td>
                        <td style="width: 20%"><center>Keterangan</center></td>
                      </tr>
                    </thead>
                    <tbody>
                      
                      @foreach($data_barang as $key => $val)

                      @php

                        $est = 0;
                        $getStokTerakhir = \App\Models\BarangStokModel::where('id_barang', $val->id)->get();
                        foreach ($getStokTerakhir as $kk => $value) {
                            $est += $value->stok;
                        }

                      @endphp

                      <tr>
                        <td>
                          <div class="form-check">
                            <input class="form-check-input ceklis ceklis_{{ $val->id }}" data-id="{{ $val->id }}" name="id_barang[]" type="checkbox" value="{{ $val->id }}">
                          </div>
                        </td>
                        <td>
                          {{ $val->kode_barang }}
                        </td>
                        <td>
                          {{ $val->nama_barang }}
                        </td>
                        <td><center>{{ $val->nama_satuan }}</center></td>
                        <td>
                          <center>
                            <input type="number" step="0.1" value="{{ $est }}" name="qty_system[]" class="form-control qty_system qty_system_{{ $val->id }}" style="text-align: right" readonly disabled>
                          </center>
                        </td>
                        <td>
                          <center>
                            <input type="number" step="0.1" value="0" name="qty_real[]" data-id="{{ $val->id }}" class="form-control qty_real qty_real_{{ $val->id }}" style="text-align: right" disabled>
                          </center>
                        </td>
                        <td>
                          <center>
                            <input type="number" step="0.1" value="{{ $est }}" name="qty_varian[]" class="form-control qty_varian qty_varian_{{ $val->id }}" style="text-align: right" readonly disabled>
                          </center>
                        </td>
                        <td>
                          <center>
                            <textarea rows="3" class="form-control keterangan keterangan_{{ $val->id }}" name="keterangan[]" placeholder="Keterangan..." disabled></textarea>
                          </center>
                        </td>
                      </tr>

                      @endforeach

                    </tbody>
                  </table>
                </div>

                <button type="submit" id="btn_real" hidden>Simpan</button>

              </form>
            </div>
          </div>

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
            <a href="javascript:;" class="btn btn-outline-primary" data-bs-dismiss="modal" id="btn_submit"><i class="fa fa-save"></i> Ya</a>
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
        <h5 class="modal-title" id="title_nya"></h5>
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

      $('#data_table').DataTable();

      $('#btn_simpan').click(function(){

        swal({
          title: "Perhatian",
          text: "Apakah anda yakin?",
          icon: "info",
          buttons: true,
        })
        .then((willDo) => {
          if (willDo) {
            
            $('#btn_real').trigger('click');

          }
        });

      });

      $('#body_opname').on('click','.detail_opname', function(){

        let data = $(this).attr('data-id');
        let kode = $(this).attr('data-kode');
        let link = "{{ url('transaksi/stok_opname/get_detail') }}/" + data;

        $('body').addClass('loading');

        $.get(link, function(res){
          $('body').removeClass('loading');
          $('#title_nya').text(kode);
          $('#holder_detail').html(res);
          $('#holder_detail').find('#table_detail').DataTable();
          $('#modal_detail').modal('show');
        });

      });

      $(document).on('keyup', '.qty_real', function(){

        let id = $(this).attr('data-id');
        let ini = $('.qty_real_'+id).val();
        let stok = $('.qty_system_'+id).val();
        let varian = (parseFloat(ini) - parseFloat(stok)).toFixed(1);

        $('.qty_varian_'+id).val(varian);

      });

      $(document).on('change', '.ceklis', function(){
        if(this.checked) {
            let id = $(this).attr('data-id');

            $('.qty_system_'+id).attr('disabled', false);
            $('.qty_real_'+id).attr('disabled', false);
            $('.qty_varian_'+id).attr('disabled', false);
            $('.keterangan_'+id).attr('disabled', false);

        }else{

            let id = $(this).attr('data-id');

            $('.qty_system_'+id).attr('disabled',true);
            $('.qty_real_'+id).attr('disabled',true);
            $('.qty_varian_'+id).attr('disabled',true);
            $('.keterangan_'+id).attr('disabled',true);

        }
      });

      $('#check_all').change(function(){

        if(this.checked){

          $('.ceklis').prop('checked', true);
          $('.qty_system').attr('disabled', false);
          $('.qty_real').attr('disabled', false);
          $('.qty_varian').attr('disabled', false);
          $('.keterangan').attr('disabled', false);

        }else{

          $('.ceklis').prop('checked', false);

          $('.qty_system').attr('disabled',true);
          $('.qty_real').attr('disabled',true);
          $('.qty_varian').attr('disabled',true);
          $('.keterangan').attr('disabled',true);

        }

      });

      $('#redirect_form_add').click(function(){
        $('#myTab a[href="#default-tab-3"]').tab("show");
      });

      $('#body_opname').on('click', '.delete_button', function(){

        let dd = $(this).attr('data-id');
        id = dd;

        $('#alert_content').text("Apakah Anda yakin akan menghapus data ini?");
        $('#modal-alert').modal('show');

      });

      $('#btn_submit').click(function(){

        let link = '{{ url("transaksi/stok_opname/delete") }}/'+id;
        $.get(link, function(res){
          location.reload();
        });

      });


    });
</script>


@endsection