<!DOCTYPE html>
<html lang="en">
<!-- ================== BEGIN core-css ================== -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 <!-- ================== END core-css ================== -->
 <style type="text/css">
 	.text-end {
 		text-align: right;
 	}
 </style>
<body>

	<table style="width: 100%">
		<tr>
			<td style="width: 100%">
				<center>
					<label class="font-weight-bold">My POS Basic</label><br/>
					<p style="font-size: 11px">
						Alamat <br/>
					</p>
					
					
				</center>
			</td>
		</tr>
	</table>

	<hr>
	<!-- <hr style="height:1px;border:none;color:#333;background-color:#333;" /> -->
	
	<table style="width: 100%; font-size: 11px;" >
		<tr>
			<td style="width: 7%;">
				Nomor
			</td>
			<td style="width: 1%">:</td>
			<td style="width: 42%">{{ $data_po->kode_po }}</td>
			<td style="width: 25%;"></td>
			<td style="width: 25%; text-align: left;">
				Cianjur, {{ date('d M Y', strtotime($data_po->tgl_po)) }}
			</td>
		</tr>
		<tr>
			<td style="width: 7%;">
				Perihal
			</td>
			<td style="width: 1%">:</td>
			<td style="width: 42%">Purchase Order (PO)</td>
			<td style="width: 25%;"></td>
			<td style="width: 25%; text-align: right;">
				
			</td>
		</tr>
		<tr>
			<td style="width: 7%;">
				
			</td>
			<td style="width: 1%"></td>
			<td style="width: 42%"></td>
			<td style="width: 25%;"></td>
			<td style="width: 25%; text-align: left;">
				Kepada Yth, <br/>
				{{ @$data_supplier->nama }}<br/>
				{{ @$data_supplier->alamat }}
			</td>
		</tr>
	</table>


	<i style="font-size: 11px"><b>Assalamualaikum Wr. Wb.</b></i><br/>
	<label style="font-size: 11px">Dengan hormat, kami sampaikan pesanan pembelian (PO) sebagai berikut :</label>

	<table class="table table-sm table-striped table-bordered table-hover" style="font-size: 10px">
    <thead>
      <tr>
        <td width="5%" class="text-center"><label><b>No.</b></label></td>
        <td><label>Nama Item</label></td>
        <td width="10%"><center>Satuan</center></td>
        <td width="5%" class="text-center"><label>QTY</label></td>
      </tr>
    </thead>
    <tbody>
      @php
      if($data_detail_po->count() > 0){

        foreach($data_detail_po->get() as $key => $val){

          $getBarang = \App\Models\BarangModel::find($val->id_barang);
          $satuan = '';

          if(null !== $getBarang){

            $getSatuan = \App\Models\SatuanModel::find($getBarang->id_satuan);
            $satuan = $getSatuan->nama;

          }

          @endphp

          <tr>
              <td><center><b>{{ $key+1 }}.</b></center></td>
              <td>{{ @$getBarang->kode_barang }} - {{ @$getBarang->nama_barang }}</td>
              <td><center>{{ $satuan }}</center></td>
              <td class="text-center">
                {{ $val->qty_dipesan }}
              </td> 
          </tr>

          @php

        }

      }else{

      }

      @endphp
    </tbody>
  </table>

 <div style="font-size: 11px">
 	<?= $data_po->catatan ?>
 </div>
 <p style="font-size: 11px">
 	Demikian permohonan ini kami sampaikan, atas perhatiannya kami ucapkan terima kasih. <br/><br/>
 	<b>Wabillahit Taufiq Walhidayah <br/> Wassalamualaikum Wr.Wb.</b><br/><br/>
 	Mengetahui,
 </p>


 <table style="width: 100%; font-size: 11px">
 	<tr>
 		<td style="width: 33.33%"><center>Admin Toko</center></td>
 		<td style="width: 33.33%;" rowspan="3">
 			
 		</td>
 		<td style="width: 33.33%"><center>Supplier</center></td>
 	</tr>
 	<tr>
 		<td style="width: 33.33%">
 			<br/><br/><br/>
 		</td>
 		<td style="width: 33.33%">
 			<br/><br/><br/>
 		</td>
 	</tr>
 	<tr>
 		<td style="width: 33.33%"><center>{{ Auth()->user()->name }}</center></td>
 		<td style="width: 33.33%"><center>{{ $data_supplier->nama ?? '-' }}</center></td>
 	</tr>
 </table>

</body>
<!--================== BEGIN core-js ================== -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- ================== END core-js ================== -->
</html>