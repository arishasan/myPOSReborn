<div class="row">
	
	<div class="col-lg-9">
		
		Tgl. Transaksi
		<h5>{{ date('d M Y, H:i:s', strtotime($data_trx->updated_at)) }}</h5>

		Nama Pembeli
		<h5>{{ $data_trx->nama_pembeli }}</h5>

	</div>
	<div class="col-lg-3">
		
		@php

		$color = 'text-success';

        if(strtolower($data_trx->status) == 'paid'){

        }else if(strtolower($data_trx->status) == 'void/cancel'){
           $color = 'text-danger'; 
        }else{
            $color = 'text-primary';
        }

		@endphp

		<div class="card">
			<div class="card-body">
				<center>
					Status
					<h4 class="{{ $color }}">{{ $data_trx->status }}</h4>
				</center>
			</div>
		</div>

	</div>

</div>

<br/>

<div class="table-responsive">
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th width="5%">No.</th>
				<th width="12%">Kode Barang</th>
				<th>Nama Barang</th>
				<!-- <th width="15%"><center>Expired Date</center></th> -->
				<th width="15%" style="text-align: right;">Harga Satuan</th>
				<th width="5%"><center>QTY</center></th>
				<th width="15%" style="text-align: right;">Jumlah</th>
			</tr>
		</thead>
		<tbody>
			
			@php

			$getDetail = \App\Models\DetTransaksiModel::where('id_transaksi', $data_trx->id)->get();
			foreach($getDetail as $key => $val){

				$getBarang = \App\Models\BarangModel::find($val->id_barang);
				$getStok = \App\Models\BarangStokModel::find($val->id_stok_barang);

				@endphp

				<tr>
					<td>{{ $key+1 }}.</td>
					<td><b>{{ @$getBarang->kode_barang }}</b></td>
					<td>{{ @$getBarang->nama_barang }}</td>
					<!-- <td><center>{{ (null !== $getStok ? date('d M Y', strtotime($getStok->tgl_kadaluarsa)) : '-') }}</center></td> -->
					<td style="text-align: right">
						Rp. {{ number_format($val->harga_satuan_barang) }}
					</td>
					<td>
						<center>{{ $val->qty }}</center>
					</td>
					<td style="text-align: right">
						<b>Rp. {{ number_format(($val->harga_satuan_barang * $val->qty)) }}</b>
					</td>
				</tr>

				@php

			}

			@endphp

		</tbody>
		<tfoot>
			<tr>
				<td colspan="5" style="text-align: right"><b>Total</b></td>
				<td style="text-align: right"><b>Rp. {{ number_format($data_trx->jumlah_harga) }}</b></td>
			</tr>
			<tr>
				<td colspan="5" style="text-align: right"><b>Diskon</b></td>
				<td style="text-align: right"><b>Rp. {{ number_format($data_trx->diskon_nominal) }}</b></td>
			</tr>
			<tr>
				<td colspan="5" style="text-align: right"><b>Sub Total</b></td>
				<td style="text-align: right"><b>Rp. {{ number_format(($data_trx->jumlah_harga - $data_trx->diskon_nominal)) }}</b></td>
			</tr>
			<tr>
				<td colspan="5" style="text-align: right"><b>Nominal Bayar</b></td>
				<td style="text-align: right"><b>Rp. {{ number_format($data_trx->nominal_bayar) }}</b></td>
			</tr>
			<tr>
				<td colspan="5" style="text-align: right"><b>Kembalian</b></td>
				<td style="text-align: right"><b>Rp. {{ number_format($data_trx->nominal_bayar - ($data_trx->jumlah_harga - $data_trx->diskon_nominal)) }}</b></td>
			</tr>
		</tfoot>
	</table>
</div>

<div class="card">
	<div class="card-body">
		<h5>Keterangan</h5>
		<p>
			<small>{{ $data_trx->keterangan }}</small>
		</p>
	</div>
</div>

<br/>

<center><small>Diinput oleh <b>{{ @$getUser->name }}</b> pada {{ date('d M Y, H:i:s', strtotime($data_trx->created_at)) }}</small></center>

<br/>