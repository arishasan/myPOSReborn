@extends('admin.mainlayout')

<link href="{{ asset('assets') }}/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets') }}/jstree/dist/themes/default/style.min.css" />
<link href="{{ asset('assets') }}/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />


@section('content')

<div id="content" class="app-content">
  <!-- BEGIN breadcrumb -->
  <ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Master</a></li>
    <li class="breadcrumb-item active">Kategori</li>
  </ol>
  <!-- END breadcrumb -->
  <!-- BEGIN page-header -->
  <h1 class="page-header">Master Kategori </h1>
  <!-- END page-header -->

  @include('admin.parts.feedback')

  <div class="row">
    <div class="col-xl-9">
      <!-- BEGIN panel -->
        <div class="panel ">
          <div class="panel-heading">
            <h4 class="panel-title">Data Kategori</h4>
            <div class="panel-heading-btn">
              
            </div>
          </div>
          <div class="panel-body pe-1">
            
            <div id="dataTree" class="dataTree"></div>

          </div>
        </div>
      <!-- END panel -->
    </div>
    <div class="col-xl-3">
      <!-- BEGIN panel -->
        <div class="panel ">
          <div class="panel-heading">
            <h4 class="panel-title" id="method_type">New Data</h4>
            <div class="panel-heading-btn">
              
            </div>
          </div>
          <form action="javascript:;" method="POST" id="form_kategori">
            <div class="panel-body">
              <input type="hidden" name="id_kategori" id="id_kategori">
              <input type="hidden" name="method" id="method" value="new">
              <div class="form-group">
                <label>Parent</label>

                <div class="row">
                  
                  <div class="col-lg-9">
                    <input type="hidden" name="parent_kategori" value="0" id="parent_kategori">
                    <label id="label_parent_kategori"><b>Tidak Memilih</b></label>
                  </div>
                  <div class="col-lg-3">
                    <button type="button" id="btn_pilih_parent" class="btn btn-outline-primary form-control" title="Pilih Parent"><i class="fa fa-search"></i></button>
                  </div>

                </div>

              </div>
              <br/>
              <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" placeholder="Masukkan Nama Kategori.." data-parsley-required="true" />
              </div>
              <br/>
              <div class="form-group" hidden>
                <label>Kode</label>
                <input type="text" class="form-control" name="kode_kategori" id="kode_kategori" placeholder="Masukkan Kode Kategori.." data-parsley-required="true" />
              </div>
              <br/>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <button type="button" class="form-control btn btn-outline-danger" id="btn_reset"><i class="fa fa-sync"></i> Reset</button>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <button type="button" class="form-control btn btn-outline-primary" id="button_simpan"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </div>
              </div>
              <br/>
              <div class="form-group" id="form_button_delete">
                <button type="button" class="form-control btn btn-outline-danger" id="button_delete"><i class="fa fa-trash"></i> Hapus</button>
              </div>
            </div>
          </form>
        </div>
      <!-- END panel -->
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

<div class="modal fade" id="modal_pilih_parent">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pilih Parent</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        
        <div class="row">
          
          <div class="col-lg-8">
            <div id="dataTree_parent" class="dataTree_parent"></div>
          </div>

          <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <label>Selected Node</label><br/>
                <label id="selected_node" style="font-weight: bold"></label> <br/><br/>
                <label>Node Parent</label><br/>
                <label id="selected_parent" style="font-weight: bold"></label>
              </div>
            </div>
          </div>

        </div>

      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white" id="tidak_parent">Tidak Memilih Parent / Utama</a>
        <a href="javascript:;" class="btn btn-primary" id="ya_parent">Pilih</a>
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
<script src="{{ asset('assets') }}/jstree/dist/jstree.min.js"></script>
<script src="{{ asset('assets') }}/plugins/select2/dist/js/select2.min.js"></script>
<script src="{{ asset('assets') }}/plugins/parsleyjs/dist/parsley.min.js"></script>

<script src="{{ asset('assets') }}/plugins/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    var tipe = 'cr';
    var actEd, editParentID, editParentName;

    var parentID, parentName;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function callSelect2(){
      $('#parent_kategori').html('');
      $('#parent_kategori').append('<option value="0">[ Tidak Memilih ]</option>');
      let link = "{{ route('get-data-kategori') }}";

      $.get(link, function(res){
        let data = JSON.parse(res);
        $.each(data, function(index, data){
          $('#parent_kategori').append('<option value="'+data.id+'">'+data.text+'</option>');
        });
        $('#parent_kategori').select2({});
      });
    }

    function refreshTree(){
      $("#dataTree").jstree(true).settings.core.data.url = '{{ route("get-tree-kategori") }}';
      $('#dataTree').jstree(true).refresh();

      $("#dataTree_parent").jstree(true).settings.core.data.url = '{{ route("get-tree-kategori") }}';
      $('#dataTree_parent').jstree(true).refresh();
    }

    function refreshTreeParent(){

      if(actEd == 'edit'){

        $("#dataTree_parent").jstree("deselect_all");
        $("#dataTree_parent").jstree("close_all");

        $('#selected_node').text('');
        $('#selected_parent').text('');

        var parentValue = $('#parent_kategori').val();

        $('#dataTree_parent').jstree(true).select_node("#"+parentValue+"");

      }else{

        $("#dataTree_parent").jstree("deselect_all");
        $("#dataTree_parent").jstree("close_all");

        $('#selected_node').text('');
        $('#selected_parent').text('');

        var parentValue = $('#parent_kategori').val();

      }

    }

    function resetForm(){

      $("#dataTree").jstree("deselect_all");
      $("#dataTree").jstree("close_all");

      $('#id_kategori').val('');
      $('#parent_kategori').val(0);
      $('#label_parent_kategori').html("<b>Tidak Memilih</b>");
      $('#nama_kategori').val('');
      $('#kode_kategori').val('');

      $('#method').val('new');

      $('#method_type').text("New Data");
      $('#form_button_delete').fadeOut();
      actEd = 'new';
    }

    $(function(){

      actEd = 'new';

      $('#form_button_delete').fadeOut();

      $('#btn_pilih_parent').click(function(){
        refreshTreeParent();
        $('#modal_pilih_parent').modal('show');
      });

      $('#tidak_parent').click(function(){

        parentID = 0;
        parentName = "-";

        $('#parent_kategori').val(0);
        $('#label_parent_kategori').html("<b>Tidak Memilih</b>");
        $('#modal_pilih_parent').modal('hide');
      });

      $('#ya_parent').click(function(){

        if(parentID == null){
          parentID = 0;
          parentName = "-";

          $('#parent_kategori').val(0);
          $('#label_parent_kategori').html("<b>Tidak Memilih</b>");
        }else{
          $('#parent_kategori').val(parentID);
          $('#label_parent_kategori').html(parentName);
        }

        $('#modal_pilih_parent').modal('hide');
      });


      $('#button_simpan').click(function(){

        let nama = $('#nama_kategori').val();
        let kode = $('#kode_kategori').val();

        if(nama == ""){
          swal({
            title: 'Perhatian',
            text: 'Nama kategori, tidak boleh kosong!',
            icon: 'error',
          });
        }else{
          $('#alert_content').text("Apakah Anda sudah yakin dengan data yang anda inputkan?");
          tipe = 'cr';
          $('#modal-alert').modal('show');
        }

      });

      $('#button_delete').click(function(){
        $('#alert_content').text("Apakah Anda yakin akan menghapus data ini?");
        tipe = 'd';
        $('#modal-alert').modal('show');
      });

      $('#btn_submit').click(function(){

        if(tipe == 'd'){
          $('#method').val('delete');
        }

        let form = $('#form_kategori').serializeArray();
        let link = "{{ route('post-data-kategori') }}"

        $.post(link, form, function(res){
          let retData = JSON.parse(res);
          if(retData.status == 1){
            swal({
              title: 'Perhatian',
              text: retData.message,
              icon: 'success',
            });
            resetForm();
            refreshTree();
          }else{
            swal({
              title: 'Perhatian',
              text: retData.message,
              icon: 'error',
            });
          }
          $(this).attr('disabled', false);
        });

      });

      $('#btn_reset').click(function(){
        resetForm();
      });

      $('#dataTree')
        .on("changed.jstree", function (e, data) {
          if(data.selected.length) {

            let id = data.instance.get_node(data.selected[0]).data.id;
            let nama = data.instance.get_node(data.selected[0]).data.text;
            let kode = data.instance.get_node(data.selected[0]).data.kode;
            let parent = data.instance.get_node(data.selected[0]).data.parent_id;
            let parent_name = data.instance.get_node(data.selected[0]).data.parent_name;

            $('#id_kategori').val(id);
            $('#parent_kategori').val(parent);

            $('#label_parent_kategori').html("<b>"+parent_name+"</b>");

            editParentID = parent;
            editParentName = parent_name;

            $('#nama_kategori').val(nama);
            $('#kode_kategori').val(kode);

            $('#method').val('edit');

            $('#method_type').text("Edit Data");
            $('#form_button_delete').fadeIn();

            actEd = 'edit';

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

      $('#dataTree_parent')
        .on("changed.jstree", function (e, data) {
          if(data.selected.length) {

            let id = data.instance.get_node(data.selected[0]).data.id;
            let nama = data.instance.get_node(data.selected[0]).data.text;
            let kode = data.instance.get_node(data.selected[0]).data.kode;
            let parent = data.instance.get_node(data.selected[0]).data.parent_id;
            let parent_name = data.instance.get_node(data.selected[0]).data.parent_name;
            
            parentID = id;
            parentName = parent_name + ' - <b>' + nama + '</b>';

            $('#selected_node').text(nama);
            $('#selected_parent').text(parent_name);

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

    });
</script>

@endsection