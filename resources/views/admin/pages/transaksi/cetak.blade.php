<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cetak Struk</title>
	<style type="text/css">
		@media print {
		  @page { margin: 0; }
		  body {
		  	margin: 0;
		  	}
		}
		#invoice-POS{
		box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
		padding:2mm;
		margin: 0 auto;
		width: 44mm;
		background: #FFF;
		}

		::selection {background: #f31544; color: #FFF;}
		::moz-selection {background: #f31544; color: #FFF;}
		h1{
		font-size: 1.5em;
		color: #222;
		}
		h2{font-size: .9em;}
		h3{
		font-size: 1.2em;
		font-weight: 300;
		line-height: 2em;
		}
		p{
		font-size: .7em;
		color: #666;
		line-height: 1.2em;
		}

		#top, #mid,#bot{ /* Targets all id with 'col-' */
		border-bottom: 1px solid #EEE;
		}

		#top{min-height: 30px;}
		#mid{min-height: 80px;}
		#bot{ min-height: 50px;}

		#top .logo{
		//float: left;
		height: 60px;
		width: 60px;
		background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
		background-size: 60px 60px;
		}
		.clientlogo{
		float: left;
		height: 60px;
		width: 60px;
		background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
		background-size: 60px 60px;
		border-radius: 50px;
		}
		.info{
		display: block;
		//float:left;
		margin-left: 0;
		}
		.title{
		float: right;
		}
		.title p{text-align: right;}
		table{
		width: 100%;
		border-collapse: collapse;
		}
		td{
		//padding: 5px 0 5px 15px;
		//border: 1px solid #EEE
		}
		.tabletitle{
		//padding: 5px;
		font-size: .5em;
		background: #EEE;
		}
		.service{border-bottom: 1px solid #EEE;}
		.item{width: 24mm;}
		.itemtext{font-size: .5em;}

		#legalcopy{
		margin-top: 5mm;
		}
	</style>
</head>
<body onload="window.print()">
	

  <div id="invoice-POS">
    
    <center id="top">
      <div class="info"> 
        <h2>MyPOS Basic</h2>
      </div><!--End Info-->
    </center><!--End InvoiceTop-->
    
    <div id="mid">
      <div class="info">
        <h2>Receipt</h2>
        <p style="font-size: 9px"> 
            Tgl.Trx   : {{ date('d M Y, H:i:s', strtotime($data_trx->updated_at)) }}</br>
            Pembeli   : {{ $data_trx->nama_pembeli; }}</br>
            Keterangan   : {{ $data_trx->keterangan }}</br>
        </p>
      </div>
    </div><!--End Invoice Mid-->
    
    <div id="bot">

		<div id="table">
			<table>
				<tr class="tabletitle">
					<td class="item"><h2>Item</h2></td>
					<td class="Hours"><h2>Qty</h2></td>
					<td class="Rate"><h2>Jumlah</h2></td>
				</tr>


				@php

				$getDetail = \App\Models\DetTransaksiModel::where('id_transaksi', $data_trx->id)->get();
				foreach($getDetail as $key => $val){

					$getBarang = \App\Models\BarangModel::find($val->id_barang);
					$getStok = \App\Models\BarangStokModel::find($val->id_stok_barang);

					@endphp

					<tr class="service">
						<td class="tableitem"><p class="itemtext">{{ @$getBarang->nama_barang }} <br/><b><small>({{ number_format($val->harga_satuan_barang) }})</small></b></p></td>
						<td class="tableitem"><p class="itemtext">{{ $val->qty }}</p></td>
						<td class="tableitem"><p class="itemtext">{{ number_format(($val->harga_satuan_barang * $val->qty)) }}</p></td>
					</tr>

					@php

				}

				@endphp

				<tr class="tabletitle">
					<td></td>
					<td class="Rate"><h2>Total</h2></td>
					<td class="payment">{{ number_format($data_trx->jumlah_harga) }}</td>
				</tr>

				<tr class="tabletitle">
					<td></td>
					<td class="Rate"><h2>Diskon</h2></td>
					<td class="payment">{{ number_format($data_trx->diskon_nominal) }}</td>
				</tr>

				<tr class="tabletitle">
					<td></td>
					<td class="Rate"><h2>Sub Total</h2></td>
					<td class="payment">{{ number_format(($data_trx->jumlah_harga - $data_trx->diskon_nominal)) }}</td>
				</tr>

				<tr class="tabletitle">
					<td></td>
					<td class="Rate"><h2>Nominal Bayar</h2></td>
					<td class="payment">{{ number_format($data_trx->nominal_bayar) }}</td>
				</tr>

				<tr class="tabletitle">
					<td></td>
					<td class="Rate"><h2>Kembalian</h2></td>
					<td class="payment">{{ number_format($data_trx->nominal_bayar - ($data_trx->jumlah_harga - $data_trx->diskon_nominal)) }}</td>
				</tr>

			</table>
		</div><!--End Table-->

		<div id="legalcopy">
			<p class="legal"><strong>Terima kasih!</strong>  Semoga berkesinambungan.
			</p>
		</div>

	</div><!--End InvoiceBot-->
  </div><!--End Invoice-->	

</body>
</html>