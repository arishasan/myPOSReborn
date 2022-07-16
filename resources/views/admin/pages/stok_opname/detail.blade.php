<div class="table-responsive">
  <table class="table table-bordered table-hover table-striped" width="100%" id="table_detail">
    <thead>
      <tr>
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
      
      @foreach($data_opname as $key => $val)

      @php

        $dBarang = \App\Models\BarangModel::select(DB::raw('tb_barang.*, satuan.nama as `nama_satuan`'))->join('satuan', 'tb_barang.id_satuan', '=', 'satuan.id')->where('tb_barang.id', $val->id_barang)->first();

      @endphp

      <tr>
        <td>
          {{ @$dBarang->kode_barang }}
        </td>
        <td>
          {{ @$dBarang->nama_barang }}
        </td>
        <td><center>{{ @$dBarang->nama_satuan }}</center></td>
        <td>
          <center>
            <h5>{{ $val->stok_system }}</h5>
          </center>
        </td>
        <td>
          <center>
            <h5>{{ $val->jml_stok_nyata }}</h5>
          </center>
        </td>
        <td>
          <center>
            <h5>{{ $val->akumulasi }}</h5>
          </center>
        </td>
        <td>
          <p>{{ $val->catatan }}</p>
        </td>
      </tr>

      @endforeach

    </tbody>
  </table>
</div>