@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<link href="{{ asset('assets') }}/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset('assets') }}/jstree/dist/themes/default/style.min.css" />
<link href="{{ asset('assets') }}/plugins/superbox/superbox.min.css" rel="stylesheet" />

<style>
 .map_ganselect {
  height: 300px;  /* The height is 400 pixels */
  width: 100%;  /* The width is the width of the web page */
 }
 td {
  font-size: 13px;
 }
 th {
  font-size: 13px;
 }
</style>

@section('content')

<div id="content" class="app-content">
  <!-- BEGIN breadcrumb -->
  <ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item">Transaksi</li>
    <li class="breadcrumb-item">Pembelian</li>
    <li class="breadcrumb-item">Edit</li>
    <li class="breadcrumb-item active">{{ $data_trx->kode_transaksi }}</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Edit/Proses Transaksi Pembelian</h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-12">
      
      <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
          <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active" id="tab_satu">Data Transaksi</a>
        </li>
      </ul>
      <div class="tab-content bg-white p-3 rounded-bottom">
        <!-- TAB 1 -->
        <div class="tab-pane fade active show" id="default-tab-1">

          <div class="row">
              
              <div class="col-lg-8">

                <div class="card">
                  <div class="card-header">
                    Cari barang dengan barcode scanner
                  </div>
                  <div class="card-body">
                      
                    <div class="row">
                      <div class="col-lg-9">

                        <div class="form-group row ">
                          <div class="col-lg-12">
                            
                            <div class="row">
                              <div class="col-lg-12">
                                <input class="form-control" type="text" placeholder="Masukkan Kode Barang" id="scan_kode_barang" />
                                  <small class="text-success">Arahkan mouse pada input field di sebelah kiri kemudian scan barcode pada barang untuk menginputkan kode barang secara otomatis</small>
                              </div>
                            </div>

                          </div>
                        </div>
                        
                      </div>
                      <div class="col-lg-3">
                        <button type="button" class="btn btn-outline-primary form-control" id="cari_scan"><i class="fa fa-search"></i> Cari Barang</button>
                      </div>
                    </div>

                  </div>
                </div>

                <br/>
                
                <div class="card">
                  <div class="card-body">

                    <div class="row">
                      <div class="col-lg-6">

                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="kategoriCari">Kategori</label>
                          <div class="col-lg-12">
                            
                            <div class="row">
                              <div class="col-lg-9">
                                <input type="hidden" name="id_kategori" value="all" id="kategoriCari">
                                <input class="form-control" type="text" value="" placeholder="[ Semua ]" id="label_kategori_cari" readonly />
                              </div>
                              <div class="col-lg-3">
                                <button type="button" id="btn_search_kategori" class="btn btn-lg btn-outline-primary form-control" title="Pilih Kategori"><i class="fa fa-search"></i></button>
                              </div>
                            </div>

                          </div>
                        </div>

                      </div>
                      <div class="col-lg-4">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label" for="satuanCari">Satuan Barang</label>
                          <div class="col-lg-12">
                            <select class="default-select2 form-control" id="satuanCari">
                              <option value="all">[ Semua ]</option>
                              @foreach($data_satuan as $val)
                                <option value="{{ $val->id }}">{{ $val->nama }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-2">
                        <div class="form-group row mb-3">
                          <label class="col-lg-12 col-form-label form-label">Aksi</label>
                          <div class="col-lg-12">
                            <button type="button" class="btn btn-outline-primary form-control" id="cariData"><i class="fa fa-search"></i> Cari</button>
                          </div>
                        </div>
                      </div>

                    </div>

                    

                  </div>
                </div>

                <br/>

                <!-- BEGIN card -->
                <div class="card">
                  <div class="card-body">

                    <!-- html -->
                    <div class="table-responsive">
                      <table id="data_table" style="width: 100%" class="table table-bordered table-striped align-middle h4">
                        <thead>
                          <tr>
                            <th width="1%"></th>
                            <th width="10%"><center><label>Thumbnail</label></center></th>
                            <th width="5%"><center><label>Stok</label></center></th>
                            <th width="5%"><label>Satuan</label></th>
                            <th width="10%"><label><b>Kode Barang</b></label></th>
                            <th><label>Nama Barang</label></th>
                            <th width="10%"><label>Kategori</label></th>
                            <th class="text-end" width="10%"><label>Harga Jual Grosir</label></th>
                            <th class="text-end" width="10%"><label>Harga Jual Eceran</label></th>
                            <th width="8%" data-orderable="false"></th>
                          </tr>
                        </thead>
                        <tbody id="body_barang">
                        </tbody>
                      </table>
                    </div>

                  </div>
                </div>
                <!-- END card -->

              </div>

              <div class="col-lg-4">

                <form method="POST" id="form_tambah" action="{{ route('proses-update-transaksi') }}" data-parsley-validate="true" name="demo-form" enctype="multipart/form-data">  
                @csrf

                  <input type="hidden" name="id_transaksi" value="{{ $data_trx->id }}">
                  
                  <div class="card">
                    <div class="card-header">
                      <div class="row vertical-align">
                        <div class="col-lg-7">
                          <i class="fa fa-cart-plus"></i> Detail Item
                        </div>
                        <div class="col-lg-5">
                          <button type="button" class="btn btn-outline-danger form-control btn-sm" id="kosongkan_cart"><small>Kosongkan Detail</small></button>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">

                      <div data-scrollbar="true" data-height="400px">
                        <div id="body_detail_cart"></div>
                        <br/>

                      </div>

                      <br/>

                      <div class="card">
                        <div class="card-body">
                          <div class="row vertical-align mb-2">
                            <div class="col-lg-4 vcenter"><label>Tgl. Transaksi</label></div>
                            <div class="col-lg-8 align-self-end" style="text-align: right;">
                              <!-- <b>{{ date('d M Y, H:i:s', strtotime($data_trx->created_at)) }}</b> -->
                              <input type="datetime-local" class="form-control" name="tgl_trx" value="{{ date('Y-m-d H:i:s', strtotime($data_trx->created_at)) }}">
                            </div>  
                          </div>
                          <div class="row vertical-align mb-2">
                            <div class="col-lg-4 vcenter"><label>Nama Pembeli</label></div>
                            <div class="col-lg-8 align-self-end" style="text-align: right;">
                              <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" placeholder="Required" value="{{ $data_trx->nama_pembeli }}" required <?= (Auth()->user()->role == 'Pembeli' ? 'readonly' : '') ?>>
                            </div>  
                          </div>
                          <div class="row vertical-align mb-2">
                            <div class="col-lg-4 vcenter"><label>Keterangan</label></div>
                            <div class="col-lg-8 align-self-end" style="text-align: right;">
                              <textarea name="keterangan" rows="3" class="form-control" placeholder="Keterangan..">{{ $data_trx->keterangan }}</textarea>
                            </div>  
                          </div>
                        </div>
                      </div>

                      <br/>

                      <div class="card">
                        <div class="card-body">

                          <div class="row vertical-align mb-2">
                            <div class="col-lg-4 vcenter"><label>Total</label></div>
                            <div class="col-lg-8 align-self-end" style="text-align: right;">
                              <input type="text" class="form-control" name="cart_total" id="cart_total" value="0" style="text-align: right;" readonly>
                            </div>  
                          </div>

                          <div class="row vertical-align mb-2" <?= (Auth()->user()->role == 'Pembeli' ? 'hidden' : '') ?>>
                            <div class="col-lg-4 vcenter"><label>Diskon</label></div>
                            <div class="col-lg-8 align-self-end" style="text-align: right;">
                              <input type="text" class="form-control currency" name="cart_diskon" id="cart_diskon" value="{{ number_format($data_trx->diskon_nominal) }}" style="text-align: right;">
                            </div>  
                          </div>

                          <div class="row vertical-align mb-2" <?= (Auth()->user()->role == 'Pembeli' ? 'hidden' : '') ?>>
                            <div class="col-lg-4 vcenter"><label>Sub Total</label></div>
                            <div class="col-lg-8 align-self-end" style="text-align: right;">
                              <input type="text" class="form-control" name="cart_sub" id="cart_sub" value="0" style="text-align: right;" readonly>
                            </div>  
                          </div>

                          <div class="row vertical-align mb-2" <?= (Auth()->user()->role == 'Pembeli' ? 'hidden' : '') ?>>
                            <div class="col-lg-4 vcenter"><label>Nominal Bayar</label></div>
                            <div class="col-lg-8 align-self-end" style="text-align: right;">
                              <input type="text" class="form-control currency" name="cart_dibayarkan" id="cart_dibayarkan" value="{{ number_format($data_trx->nominal_bayar) }}" style="text-align: right;">
                            </div>  
                          </div>

                          <div class="row vertical-align mb-2" <?= (Auth()->user()->role == 'Pembeli' ? 'hidden' : '') ?>>
                            <div class="col-lg-4 vcenter"><label>Kembalian</label></div>
                            <div class="col-lg-8 align-self-end" style="text-align: right;">
                              <input type="text" class="form-control" name="cart_kembalian" id="cart_kembalian" value="0" style="text-align: right;" readonly>
                            </div>  
                          </div>


                        </div>
                      </div>

                      <br/>

                      <div class="row">
                        <div class="col-lg-6">
                          <a href="{{ route('transaksi') }}" class="btn btn-outline-warning form-control"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>
                         <div class="col-lg-6">
                           <button type="submit" class="btn btn-outline-primary" id="btn_tambah_data_real" hidden><i class="fa fa-save"></i> Simpan</button>
                            <button type="button" class="btn btn-outline-primary form-control" id="btn_tambah_data"><i class="fa fa-save"></i> <?= (Auth()->user()->role == 'Pembeli' ? 'Simpan' : 'Selesaikan Transaksi') ?></button>
                         </div> 
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
        <div class="alert alert-white">
          <h5><i class="fa fa-info-circle"></i> Perhatian</h5>
          <p id="alert_content"></p>
          <center>
            <a href="javascript:;" class="btn btn-outline-primary" id="btn_submit" data-bs-dismiss="modal"><i class="fa fa-save"></i> Ya</a>
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
        <h5 class="modal-title" id="title_trx"></h5>
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


<div class="modal fade" id="modal_add_cart">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambahkan ke Keranjang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">

        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-4">
                <label>Kode Barang</label>
                <h5 id="cart_kode_barang"></h5>
              </div>
              <div class="col-lg-4">
                <label>Nama Barang</label>
                <h5 id="cart_nama_barang"></h5>
              </div>
              <div class="col-lg-4">
                <label>Satuan</label>
                <h5 id="cart_satuan_barang"></h5>
              </div>
              <div class="col-lg-4">
                <label>Harga Grosir</label>
                <h5 id="cart_harga_grosir_txt"></h5>
              </div>
              <div class="col-lg-4">
                <label>Harga Eceran</label>
                <h5 id="cart_harga_eceran_txt"></h5>
              </div>
              <div class="col-lg-4">
                <label>QTY Minimal Tuk Pengambilan Harga Grosir Otomatis</label>
                <h5 id="cart_auto_grosir"></h5>
              </div>
            </div>
          </div>
        </div>

        <br/>

        <input type="hidden" name="id_barang" id="cart_id_barang">
        <input type="hidden" name="is_expire" id="cart_is_expire">

        <input type="hidden" name="cart_grosir" id="cart_harga_grosir">
        <input type="hidden" name="cart_eceran" id="cart_harga_eceran">

        <div id="holder_add_cart" hidden></div>

        <br/>

        <div class="row" id="holder_cart_qty" hidden>
          <div class="col-lg-8">
            <div class="form-group">
              <label>QTY</label>
              <input type="number" min="1" value="1" step="0.1" name="cart_qty" id="cart_qty" class="form-control">
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <label>Stok Tersedia</label>
                <h4 id="cart_stok_tersedia">0</h4>
              </div>
            </div>
          </div>
        </div>
      

      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-primary" id="masukkan_keranjang">Masukkan Keranjang</a>
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
        <a href="javascript:;" class="btn btn-white" id="semua_kategori" hidden>Semua Kategori</a>
        <a href="javascript:;" class="btn btn-primary" id="ya_kategori">Pilih</a>
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
<script src="{{ asset('assets') }}/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
<script src="{{ asset('assets') }}/plugins/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('assets') }}/jstree/dist/jstree.min.js"></script>
<script src="{{ asset('assets') }}/plugins/superbox/jquery.superbox.min.js"></script>

<script type="text/javascript">

    var kategori, lokasi, sumber, sewa, status;
    var lokasiID, lokasiName;
    var kategoriID, kategoriName;
    var methodBtn, methodBtnKategori;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function callKeranjang(){


      let link = '{{ url("transaksi/detail_data/") }}/{{ md5($data_trx->id) }}';

      $.get(link, function(res){

        let parse = JSON.parse(res);
        let txt = '';

        let subTotal = 0;

        $.each(parse, function(idx, val){

          let harga = val.det_harga;
          let total = parseFloat(harga) * parseFloat(val.qty_input);

          subTotal = parseFloat(subTotal) + total;

          txt += '<div class="itemKeranjang card mb-2 '+ (val.is_avail == 0 ? 'not_avail bg-warning' : '') +'"><div class="card-body">'+
          '<input type="hidden" name="id_barang[]" value="'+ val.id_barang +'">'+
          '<input type="hidden" name="id_stok_barang[]" value="'+ val.id_stok_barang +'">'+
          '<div class="row vertical-align">' +
          '<div class="col-lg-2"><a href="'+val.image+'" target="_blank"><img style="width:40px;max-height:auto;" class="img-responsive" alt="NONE" src="'+val.image+'" /></a></div>'+
          '<div class="col-lg-7">'+
          '<label>'+val.kode_barang+' - '+val.nama_barang+
          '<br/>' + (val.is_barang_has_expired_date == 1 ? "<small>Exp: " + val.expired_date + '</small><br/>' : '') + '<b> Rp. ' + harga.toLocaleString() + ' <small>x'+ val.qty_input +'</small></b>'+
          (val.is_avail == 0 ? '<br/><small>Stok item ini kurang dari jumlah QTY yang diinputkan.</small>' : '') +
          '</label></div>'+
          '<div class="col-lg-3 align-self-end" style="text-align: end">'+
          '<button type="button" class="btn btn-outline-danger btn-sm delete_item_cart" data-id="'+val.id_det+'"><i class="fa fa-trash"></i></button>' + 
          '<label> <b> Rp. ' + total.toLocaleString() + '</b>'+
          '</label></div>'+
          '</div>' +
          '</div></div>';

        });

        $('#cart_total').val(subTotal.toLocaleString());

        let linkUpdt = "{{ url('transaksi/update_subtotal/') }}/{{ $data_trx->id }}/"+subTotal;

        $.get(linkUpdt, function(){
          console.log('updated');
        });


        $('#body_detail_cart').html(txt);

        hitungDiskon();

      });

    }

    function callTable(){
      kategori = $('#kategoriCari').val();
      satuan = $('#satuanCari').val();
      
      $('#data_table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        bDestroy: true,
        ajax: {
            'type': 'POST',
            'url': "{{ route('get-data-barang-trx') }}",
            'data': {
               kategori: kategori,
               satuan: satuan,
               status: 'all',
            },
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'foto', name: 'foto', orderable: false, searchable: false},
            {data: 'stok', name: 'stok', orderable: false, searchable: false},
            {data: 'nama_satuan', name: 'nama_satuan', orderable: false, searchable: false},
            {data: 'kode_barang', name: 'kode_barang'},
            {data: 'nama_barang', name: 'nama_barang'},
            {data: 'id_kategori', name: 'id_kategori', orderable: false, searchable: false},
            {data: 'harga_grosir', name: 'harga_grosir', orderable: false, searchable: false},
            {data: 'harga_eceran', name: 'harga_eceran', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: ['0', 'desc'],
        columnDefs: [
          { targets: [0], visible: false},        
        ],
        dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',
        buttons: [
          { extend: 'copy', className: 'btn-sm' },
          { extend: 'csv', className: 'btn-sm' },
          { extend: 'excel', className: 'btn-sm' },
          { extend: 'pdf', className: 'btn-sm' },
          { extend: 'print', className: 'btn-sm' }
        ],
      });
    }

    function hitungDiskon(){

      let total = $('#cart_total').val().replace(",","");
      let cart_diskon = $('#cart_diskon').val().replace(",","");

      if(cart_diskon == '' || cart_diskon == null){
        $('#cart_diskon').val(0);
        cart_diskon = 0;
      }

      let subTotal = parseFloat(total) - parseFloat(cart_diskon);

      $('#cart_sub').val(subTotal.toLocaleString());

      hitungKembalian();

    }

    function hitungKembalian(){

      let subtotal = $('#cart_sub').val().replace(",","");
      let cart_dibayarkan = $('#cart_dibayarkan').val().replace(",","");

      if(cart_dibayarkan == '' || cart_dibayarkan == null){
        $('#cart_dibayarkan').val(0);
        cart_dibayarkan = 0;
      }

      let kembalian = parseFloat(cart_dibayarkan) - parseFloat(subtotal);

      $('#cart_kembalian').val(kembalian.toLocaleString());

    }

    $(function(){

      $("#scan_kode_barang").on('keyup', function (e) {
          if (e.key === 'Enter' || e.keyCode === 13) {
              $('#cari_scan').trigger('click');
          }
      });

      $('#cari_scan').click(function(){

        let kode = $('#scan_kode_barang').val();
        let link = '{{ url("transaksi/get_barang_by_kode") }}/'+kode;

        $('body').addClass('loading');

        $.get(link, function(res){

          $('body').removeClass('loading');

          if(res == 'no'){
            swal("Oops!", "Tidak ada barang yang ditemukan dengan kode barang : " + kode, "error");
            $('#scan_kode_barang').val('');
          }else{

            let parse = JSON.parse(res);

            console.log(parse);

            minimalSwitchGrosir = 0;
            globalStok = 0;
            globalDetStok = [];
            isExpiracy = 0;
            globalIDDetStok = 0;

            $('#cart_qty').val(1);

            let data = parse.id;
            let nama = parse.nama_barang;
            let kode = parse.kode_barang;
            let satuan = parse.nama_satuan;
            let link = "{{ url('transaksi/barang/get_detail_barang_lengkap') }}/" + data;

            $.get(link, function(res){

              let decode = JSON.parse(res);

              $('#cart_id_barang').val(decode.id_barang);
              $('#cart_is_expire').val(decode.is_expire_date);
              $('#cart_harga_grosir').val(decode.harga_grosir);
              $('#cart_harga_eceran').val(decode.harga_eceran);

              minimalSwitchGrosir = decode.qty_min_grosir;

              let pilihKadaluarsa = '<label>Silahkan Pilih Tanggal Kadaluarsa</label><hr><div class="row">';

              if(decode.is_expire_date == 0){

                isExpiracy = 0;
                globalStok = decode.stok_akumulasi;
                $('#cart_stok_tersedia').text(globalStok);
                $('#holder_add_cart').attr('hidden', true);
                $('#holder_cart_qty').attr('hidden', false);

              }else{

                globalDetStok = decode.det_stok;
                isExpiracy = 1;

                $.each(decode.det_stok, function(idx, val){

                  console.log(val.stok);
                  pilihKadaluarsa += '<div class="col-lg"><button class="btn btn-outline-primary form-control cart_pilih_stok" data-id="' + val.id + '">'+formatDate(val.tgl_kadaluarsa)+' <br/> Stok : '+ val.stok +'</button></div>';

                });

                $('#holder_add_cart').attr('hidden', false);
                $('#holder_cart_qty').attr('hidden', true);

              }

              pilihKadaluarsa += '</div>';


              $('#cart_kode_barang').text(kode);
              $('#cart_nama_barang').text(nama);
              $('#cart_satuan_barang').text(satuan);
              $('#cart_auto_grosir').text(decode.qty_min_grosir);

              $('#cart_harga_grosir_txt').text("Rp. " + decode.harga_grosir.toLocaleString());
              $('#cart_harga_eceran_txt').text("Rp. " + decode.harga_eceran.toLocaleString());

              $('#holder_add_cart').html(pilihKadaluarsa);
              $('#modal_add_cart').modal('show');
            });

            $('#scan_kode_barang').val('');

          }

        });

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
        
        if(methodBtnKategori == 'search'){
          $("#dataTree_kategori").jstree("deselect_all");
          $("#dataTree_kategori").jstree("close_all");

          $('#selected_node_kategori').text('');
          $('#selected_parent_kategori').text('');
        }

        methodBtnKategori = 'create';
        $('#semua_kategori').attr('hidden', true);

        $('#modal_pilih_kategori').modal('show');
      });

      $('#btn_search_kategori').click(function(){
        if(methodBtnKategori == 'create'){
          $("#dataTree_kategori").jstree("deselect_all");
          $("#dataTree_kategori").jstree("close_all");

          $('#selected_node_kategori').text('');
          $('#selected_parent_kategori').text('');
        }

        methodBtnKategori = 'search';
        $('#semua_kategori').attr('hidden', false);

        $('#modal_pilih_kategori').modal('show');
      });

      $('#semua_kategori').click(function(){
        $("#dataTree_kategori").jstree("deselect_all");
        $("#dataTree_kategori").jstree("close_all");
        kategoriID = '';
        kategoriName = '';
        $('#selected_node_kategori').text('');
        $('#selected_parent_kategori').text('');
        $('#kategoriCari').val('all');
        $('#label_kategori_cari').val('[ Semua ]');
        $('#modal_pilih_kategori').modal('hide');
      });

      $('#ya_kategori').click(function(){

        if(methodBtnKategori == 'search'){

          if(kategoriID == null){
            swal({
              title: 'Perhatian',
              text: 'Anda belum memilih kategori!',
              icon: 'error',
            });
          }else{
            $('#kategoriCari').val(kategoriID);
            $('#label_kategori_cari').val(kategoriName);
          }

        }else{

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

        }


        $('#modal_pilih_kategori').modal('hide');
      });

      $(".default-select2").select2();

      $(".date_picker").datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
      });

      $('#cariData').click(function(){
        callTable();
      });


      $('#btn_tambah_data').click(function(){

        let count = 0;
        let notAvail = 0;

        $(document).find('.itemKeranjang').each(function(){
          count = count + 1;
        });

        $(document).find('.not_avail').each(function(){
          notAvail = notAvail + 1;
        });

        if(notAvail > 0){
          swal("Oops!", "Ada item dalam keranjang belanja yang tidak bisa diproses. Silahkan cek kembali.", "error");
          return false;
        }

        if(count > 0){

          swal({
            title: "Perhatian",
            text: "Apakah anda yakin?",
            icon: "info",
            buttons: true,
          })
          .then((willDo) => {
            if (willDo) {
              
              $('#btn_tambah_data_real').trigger('click');

            }
          });

        }else{

          swal("Oops!", "Tidak ada item dalam keranjang belanja.", "error");

        }
        

      });

      $("#form_tambah").bind("keypress", function(e) {
          if (e.keyCode == 13) {
              return false;
          }
      });

      $('#cart_diskon').keyup(function() {
       
       hitungDiskon();

      });

      $('#cart_dibayarkan').keyup(function() {
       
       hitungKembalian();

      });

      $('#kosongkan_cart').click(function(){

        swal({
          title: "Perhatian",
          text: "Kosongkan Detail item?",
          icon: "info",
          buttons: true,
        })
        .then((willEmpty) => {
          if (willEmpty) {
            
            let link = '{{ route("kosongkan-detail", ["id" => md5($data_trx->id)]) }}';

            $('body').addClass('loading');

            $.get(link, function(res){

              $('body').removeClass('loading');

              if(res == 'yes'){
                swal("Yay!", "Berhasil mengosongkan Detail item.", "success");
                callKeranjang();
              }else{
                swal("Oops!", "Detail item anda kosong.", "error");
              }

            });

          }
        });

      });

      var minimalSwitchGrosir = 0;
      var globalStok = 0;
      var globalDetStok = [];
      var isExpiracy = 0;
      var globalIDDetStok = 0;

      $('#body_barang').on('click','.add_cart', function(){

        minimalSwitchGrosir = 0;
        globalStok = 0;
        globalDetStok = [];
        isExpiracy = 0;
        globalIDDetStok = 0;

        $('#cart_qty').val(1);

        let data = $(this).attr('data-id');
        let nama = $(this).attr('data-nama');
        let kode = $(this).attr('data-kode');
        let satuan = $(this).attr('data-satuan');
        let link = "{{ url('transaksi/barang/get_detail_barang_lengkap') }}/" + data;

        $.get(link, function(res){

          let decode = JSON.parse(res);

          $('#cart_id_barang').val(decode.id_barang);
          $('#cart_is_expire').val(decode.is_expire_date);
          $('#cart_harga_grosir').val(decode.harga_grosir);
          $('#cart_harga_eceran').val(decode.harga_eceran);

          minimalSwitchGrosir = decode.qty_min_grosir;

          let pilihKadaluarsa = '<label>Silahkan Pilih Tanggal Kadaluarsa</label><hr><div class="row">';

          if(decode.is_expire_date == 0){

            isExpiracy = 0;
            globalStok = decode.stok_akumulasi;
            $('#cart_stok_tersedia').text(globalStok);
            $('#holder_add_cart').attr('hidden', true);
            $('#holder_cart_qty').attr('hidden', false);

          }else{

            globalDetStok = decode.det_stok;
            isExpiracy = 1;

            $.each(decode.det_stok, function(idx, val){

              console.log(val.stok);
              pilihKadaluarsa += '<div class="col-lg"><button class="btn btn-outline-primary form-control cart_pilih_stok" data-id="' + val.id + '">'+formatDate(val.tgl_kadaluarsa)+' <br/> Stok : '+ val.stok +'</button></div>';

            });

            $('#holder_add_cart').attr('hidden', false);
            $('#holder_cart_qty').attr('hidden', true);

          }

          pilihKadaluarsa += '</div>';


          $('#cart_kode_barang').text(kode);
          $('#cart_nama_barang').text(nama);
          $('#cart_satuan_barang').text(satuan);
          $('#cart_auto_grosir').text(decode.qty_min_grosir);

          $('#cart_harga_grosir_txt').text("Rp. " + decode.harga_grosir.toLocaleString());
          $('#cart_harga_eceran_txt').text("Rp. " + decode.harga_eceran.toLocaleString());

          $('#holder_add_cart').html(pilihKadaluarsa);
          $('#modal_add_cart').modal('show');
        });

        
      });

      $(document).on('click', '.delete_item_cart', function(){

        let id = $(this).attr('data-id');
        let link = '{{ url("transaksi/delete_det_item/") }}/'+id;
        $('body').addClass("loading");

        $.get(link, function(res){

          $('body').removeClass("loading");
          if(res == 'yes'){
            swal("Yay!", "Berhasil menghapus item dari list detail transaksi.", "success");
            callKeranjang();
          }else{
            swal("Oops!", "Gagal menghapus item dari list detail transaksi. Silahkan ulangi lagi.", "error");
          }

        });


      });

      $(document).on('click', '.cart_pilih_stok', function(){

        let ini = $(this);

        $(document).find('.cart_pilih_stok').each(function(idx){
          $(this).removeClass('btn-success').addClass('btn-outline-primary');
        });

        ini.removeClass( "btn-outline-primary" ).addClass( "btn-success" );

        let id = ini.attr('data-id');
        
        globalIDDetStok = id;

        $.each(globalDetStok, function(idx, val){

          if(val.id == globalIDDetStok){

            globalStok = val.stok;

          }

        });

        $('#cart_stok_tersedia').text(globalStok);
        $('#holder_cart_qty').attr('hidden', false);

      });

      $('#masukkan_keranjang').click(function(){

        let stok_input = $('#cart_qty').val();

        if(stok_input == 0 || globalStok == 0){
          swal("Oops!", "Tidak ada stok yang tersedia atau anda belum mengisi jumlah QTY!", "error");
        }else{

          if(stok_input > globalStok){

            swal("Oops!", "QTY yang anda inputkan melebihi stok yang tersedia!", "error");

          }else{

            $('body').addClass("loading");

             $.ajax({
                  url: "{{ route('simpan-detail-trx', ['id' => $data_trx->id ?? 0]) }}",
                  type: "post",
                  data: {
                     id_barang: $('#cart_id_barang').val(),
                     is_barang_has_expired_date: $('#cart_is_expire').val(),
                     id_stok_barang: globalIDDetStok,
                     qty: stok_input
                  },
                  success: function (response) {

                     $('body').removeClass("loading");
                     swal("Informasi", response, "info");
                     $('#modal_add_cart').modal('hide');

                     callKeranjang();

                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                     $('body').removeClass("loading");
                     swal("Oops!", "Gagal menambahkan barang ke detail belanja. Silahkan ulangi.", "error");
                  }
              });


          }

        }

      });

      callTable();
      callKeranjang();

    });
</script>


@endsection