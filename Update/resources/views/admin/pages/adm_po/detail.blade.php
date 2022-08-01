<div class="row">
  <div class="col-lg-8">
    <div class="card" style="height: 100%">
      <div class="card-body">
          
          <div class="row">
            <div class="col-lg-6">

              @php

              $dSupplier = App\Models\SupplierModel::find($data_po->id_supplier);

              if($dSupplier){
                $getSupplier = $dSupplier->nama;
              }else{
                $getSupplier = '-';
              }

              @endphp

              <div class="form-group row mb-3">
                <label class="col-lg-12 col-form-label form-label" for="vendor">Supplier </label>
                <div class="col-lg-12">
                  <label>{{ $getSupplier }}</label>
                </div>
              </div>

            </div>

          </div>

          <div class="card mb-3">
            <div class="card-header">
              Catatan Admin
            </div>
            <div class="card-body">
              <p>{!! $data_po->catatan_admin !!}</p>
            </div>
          </div>

          <div class="card mb-3" {{ $data_po->catatan_supplier == null || $data_po->catatan_supplier == '' ? 'hidden' : '' }}>
            <div class="card-header">
              Catatan Supplier
            </div>
            <div class="card-body">
              <p>{!! $data_po->catatan_supplier !!}</p>
            </div>
          </div>

          <div class="card mb-3" {{ $data_po->catatan_retur == null || $data_po->catatan_retur == '' ? 'hidden' : '' }}>
            <div class="card-header">
              Catatan Retur
            </div>
            <div class="card-body">
              <p>{!! $data_po->catatan_retur !!}</p>
            </div>
          </div>

      </div>
    </div>
  </div>
  <div class="col-lg-4">

    <div class="card" style="height: 100%">
      <div class="card-body">
        <div class="form-group row mb-3">
          <label class="col-lg-12 col-form-label form-label" for="sewa">Tanggal PO </label>
          <div class="col-lg-12">
            <label>{{ date('d M Y', strtotime($data_po->tgl_po)) }}</label>
          </div>
        </div>
        <div class="form-group row mb-3">
          <label class="col-lg-12 col-form-label form-label" for="sewa">Status </label>
          <div class="col-lg-12">
            <label class="text-primary"><b>{{ $data_po->status }}</b></label>
          </div>
        </div>
        <br/>

        

      </div>
    </div>

  </div>
</div>


<br/>

<form action="{{ route('do-po-selesai') }}" method="POST" id="form_terima_po">

@csrf

<input type="hidden" name="po_id" value="{{ $data_po->id }}">

<div class="table-responsive">
  <table class="table table-sm table-striped table-bordered table-hover table_det" width="100%">
    <thead>
      <tr>
        <td><label>Nama Item</label></td>
        <td style="width: 8%">Satuan</td>
        <td width="8%" class="text-center"><label>QTY Dipesan <br/> (Admin)</label></td>
        <td width="8%" class="text-center"><label>QTY Tersedia <br/> (Supplier)</label></td>
        <td width="8%" class="text-center"><label>QTY Retur <br/> (Admin)</label></td>
        <td width="8%" class="text-center"><label>Est. QTY Masuk Stok</label></td>
        <!-- <td width="15%" class="text-center">Tgl. Expired <br/> (Supplier)</td> -->
        <td width="15%" class="text-end"><label>Harga Satuan <br/> (Supplier)</label></td>
      </tr>
    </thead>
    <tbody>
      @php
      $sum = 0;
      if($data_detail_po->count() > 0){

        foreach($data_detail_po->get() as $key => $val){
          $sum += ($val->harga_satuan * $val->qty_tersedia);

          $getBarang = \App\Models\BarangModel::find($val->id_barang);
          $satuan = '';

          if(null !== $getBarang){

            $getSatuan = \App\Models\SatuanModel::find($getBarang->id_satuan);
            $satuan = $getSatuan->nama;

          }

          @endphp

          <tr>
              <td><b>{{ @$getBarang->kode_barang }}</b> - {{ @$getBarang->nama_barang }}</td>
              <td width="8%">{{ $satuan }}</td>
              <td class="text-center" width="8%">
                <b>{{ $val->qty_dipesan }}</b>
              </td> 
              <td class="text-center" width="8%">
                <b>{{ $val->qty_tersedia }}</b>
              </td>
              <td class="text-center" width="8%">
                <b>{{ $val->qty_retur }}</b>
              </td>
              <td class="text-center" width="8%">
                <b>{{ ($val->qty_tersedia - $val->qty_retur) }}</b>
              </td>
              <!-- <td class="text-center" width="15%">
                <b>{{ ($val->is_exp_date == 1 ? date('d M Y', strtotime($val->exp_date)) : '') }}</b>
              </td> -->
              <td class="text-end" width="15%">Rp. <label>{{ number_format($val->harga_satuan) }}</label></td> 
          </tr>

          @php

        }

      }else{

      }

      @endphp
    </tbody>
  </table>
</div>


</form>