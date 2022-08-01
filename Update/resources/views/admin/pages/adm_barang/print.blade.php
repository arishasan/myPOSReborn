<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Print Barcode</title>

<link href='https://fontlibrary.org/face/idautomationhc39m-code-39-barcode' 
rel='stylesheet'>

<style type="text/css">
	@media print {
	  @page { margin: 0; }
	  body {
	  	margin: 0;
	  	}
	}
	* {
		font-family: "Arial";
	}
	.serif {
	    font-family: 'IDAHC39M Code 39 Barcode', Times, serif;
	}

	.sansserif {
	    font-family: Arial, Helvetica, sans-serif;
	}
</style>
</head>
<body onload="window.print()" style="
	max-width: 250px;
  margin: auto;
  background: white;
  padding: 10px;
">

	<div>
		
		<table style="border-collapse: collapse;
	    border-spacing: 0;
	    width: 100%;
	    ">
			<tr>
				<td rowspan="2">
					{!! QrCode::size(90)->generate($data_barang->kode_barang); !!}
				</td>
				<td>
					<b style="font-size: 12px">MyPOS Barcode</b>
					<div style="padding-top: 2px;"></div>
					<div style="border:2px solid black">
						
						<center>
							<b style="font-size: 10px">{{ $data_barang->nama_barang }}</b>
						</center>
					</div>

					<br/>

					<?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($data_barang->kode_barang, "C128" ,1,20) . '" alt="barcode"   />'; ?>
					
				</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			
			<tr>
				<td colspan="2">
					
					<div style="border:2px solid black">
						
						<center><b style="font-size: 12px">{{ $data_barang->kode_barang }}</b></center>

					</div>

				</td>
			</tr>
		</table>

	</div>	

</body>
</html>