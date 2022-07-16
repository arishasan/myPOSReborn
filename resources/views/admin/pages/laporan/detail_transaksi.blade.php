<div class="table-responsive">
	<table class="table table-bordered table-hover table-striped" id="det_table_trx" width="100%">
		<thead>
			<tr>
				<th colspan="4"><center>Main</center></th>
				<th colspan="4"><center>Item</center></th>
			</tr>
			<tr>
				<th><center><b>No.</b></center></th>
				<th>Kode Trx</th>
				<th>Nama Pembeli</th>
				<th><center>Tgl. Transaksi</center></th>

				<th>Nama Barang</th>
				<th style="text-align: right;">Harga Satuan</th>
				<th><center>QTY</center></th>
				<th style="text-align: right;">Jumlah</th>
			</tr>
		</thead>
		<tbody>
			
			@php $tot = 0; @endphp
			@foreach($ret as $key => $val)

			<tr>
				<td><center><b>{{ $key+1 }}.</b></center></td>
				<td><b>{{ $val['kode_transaksi'] }}</b></td>
				<td>{{ $val['nama_pembeli'] }}</td>
				<td><center>{{ date('d M Y, H:i:s', strtotime($val['created_at'])) }}</center></td>

				<td>
					<b>{{ $val['kode_barang'] }}</b> - {{ $val['nama_barang'] }}
				</td>
				<td style="text-align: right;">Rp. {{ number_format($val['harga_satuan_barang']) }}</td>
				<td><center><b>{{ $val['qty'] }}</b></center></td>
				<td style="text-align: right;">Rp. {{ number_format($val['jml_harga']) }}</td>
			</tr>

			@php $tot += $val['jml_harga']; @endphp

			@endforeach

		</tbody>
		<tfoot>
			<tr>
				<td colspan="7"><center><b>TOTAL</b></center></td>
				<td style="text-align: right;"><b>Rp. {{ number_format($tot) }}</b></td>
			</tr>
		</tfoot>
	</table>
</div>