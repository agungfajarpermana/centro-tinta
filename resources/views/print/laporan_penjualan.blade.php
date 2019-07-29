<?php 
	use Carbon\Carbon;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penjualan</title>
    <style>
		/* Font Definitions */
		@font-face
			{font-family:"Calisto MT";
			panose-1:2 4 6 3 5 5 5 3 3 4;
			mso-font-charset:0;
			mso-generic-font-family:roman;
			mso-font-pitch:variable;
			mso-font-signature:3 0 0 0 1 0;}
		/* Style Definitions */
		body {
			/* width: 21cm; */
			mso-style-unhide:no;
			mso-style-qformat:yes;
			mso-style-parent:"";
			margin:0in;
			margin-bottom:.0001pt;
			mso-layout-grid-align:none;
			text-autospace:none;
			font-size:15.0pt;
			font-family:"Times New Roman","serif";
			mso-fareast-font-family:"Times New Roman";
			mso-fareast-theme-font:minor-fareast;
		}

		.calisto {
			font-family:"Calisto MT","serif";
			mso-bidi-font-family:"Calisto MT";
		}
		.border-2 {
			border-width:2px !important;
		}

		.border-black{
			border-color: #000000 !important;
		}

		.table-border-black td,.table-border-black th {
			border-color: #000000 !important;
		}

		.print-border-0 {
			border:none !important;
		}

		.td-title {
			width: 0.1%;
			white-space: nowrap;
		}

		.td-border {
			padding:10px;
			border-bottom: 1px solid !important;
		}

		.td-border th{
			border-bottom: 2px solid !important;
		}

		.clearfix{
			clear:both;
		}
		table { page-break-inside:auto }
		tr    { page-break-inside:avoid; page-break-after:auto }
		thead { display:table-header-group;font-size:18px; }
		tfoot { display:table-footer-group; }
	</style>
</head>
<body>
	<div class="w-100 px-0 mx-0">
		<div class="row border-bottom border-black border-2">
			<div id="header" class="col-12">
				<div class="row">
					<div class="col-12">
						<table class="w-100" width="100%">
							<tbody>
								<tr>
									<td class="w-50" style="margin-bottom:0px;">
										PT. Centro Link (Indonesia) <br/>
										Jl. Raden Patah Blok 3 No. 7, BSD - Tangerang Selatan <br/>
										Telp : +62 778 453 800 <br/>
										Fax : +62 778 431 696 <br/>
									</td>
									<td class="tag-text">
										<h4 style="text-align:right;margin-top:60px;margin-bottom:0px;">
											LAPORAN PENJUALAN <br/>
											Tanggal : {{ Carbon::parse($from)->format('d, M Y') }} - {{ Carbon::parse($to)->format('d, M Y') }}	
										</h4>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<hr>
		
		<div class="row">
			<div id="body" class="col-12 mt-3">
				<div class="row justify-content-end" style="float:right;">
					<div id="upper-body" class="col-auto d-flex justify-content-end">
						<table class="ml-auto">
							<tbody>
								<tr>
									<td style="text-align:right">
										Tanggal Cetak : <br/>
									</td>
									<td style="text-align:left">
										{{ Carbon::now()->format('d, M Y') }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="clearfix"></div>

				<div class="row">
					<div id="table-container" class="col-12 d-flex justify-content-between">
						@forelse($data as $keys => $print)
                        <table id="tableGL" class="table table-border-black print-border-0" cellspacing="0.5" width="100%">
							<h5>{{ Carbon::parse($keys)->format('d, M Y') }}</h5>
                            <thead style="font-size:20px;">
                                <tr>
                                    <th class="td-border" nowrap="nowrap">No</th>
                                    <th class="td-border" nowrap="nowrap">Tanggal</th>
                                    <th class="td-border" nowrap="nowrap">No. Invoice</th>
                                    <th class="td-border" nowrap="nowrap" style="text-align:left">Nama Pelanggan</th>
                                    <th class="td-border" nowrap="nowrap" style="text-align:left">Product</th>
                                    <th class="td-border" nowrap="nowrap">Jumlah Barang</th>
									<th class="td-border" nowrap="nowrap" style="text-align:right">Harga Satuan</th>
                                    <th class="td-border" nowrap="nowrap" style="text-align:right;">Total Harga</th>
								</tr>
                            </thead>
                            <tbody>
							   @foreach($print as $index => $value)
									@foreach($value->order_detail as $key => $deep)
										<tr class="tr">
											<td class="td-border py-2" style="text-align:center;">{{ ($key+1) }}</td>
											<td class="td-border py-2" style="text-align:center;">{{ Carbon::parse($value->tanggal)->format('d, M Y') }}</td>
											<td class="td-border py-2" style="text-align:center;">INV-{{ $value->no_order }}</td>
											<td class="td-border py-2" style="text-align:left;">{{ $value->customer->nama_customer }}</td>
											<td class="td-border py-2" nowarp="nowrap" style="text-align:left;">{{ ($deep->product ? $deep->product->nama_product : '') }}</td> 
											<td class="td-border py-2" nowrap="nowrap" style="text-align:center;">{{ $deep->qty }}</td>
											<td class="td-border py-2" nowrap="nowrap" style="text-align:right;">{{ number_format($deep->product->productDetail->harga,0,'','.') }}</td>
											<td class="td-border py-2" nowrap="nowrap" style="text-align:right;">{{ number_format($deep->total_pembelian,0,'','.') }}</td>
										</tr>
									@endforeach
								{{-- {{ ($value->order_detail->product ? $value->order_detail->product->nama_product : $value->id) }} --}}
								{{-- {{ number_format($value->product_detail->harga,0,'','.') }} --}}
                               @endforeach
							</tbody>
                            <footer>
                                <tr class="tr">
                                    <td class="border-0 print-border-0" colspan="4">&nbsp;</td>
                                    <td class="border-0 print-border-0">&nbsp;</td>
                                    <td class="td-border" nowrap="nowrap"><b>S U B T O T A L</b></td>
                                    <td class="td-border" style="text-align:right;"><b></b></td>
                                    <td class="td-border" style="text-align:right;"><b>{{ number_format($subtotal[$no++],0,'','.') }}</b></td>
                                </tr>
                            </footer>
						</table>
						@empty
						<table id="tableGL" class="table table-border-black print-border-0" cellspacing="0.5" width="100%">
							<thead style="font-size:20px;">
								<tr>
                                    <th class="td-border" nowrap="nowrap">No</th>
                                    <th class="td-border" nowrap="nowrap">Tanggal</th>
                                    <th class="td-border" nowrap="nowrap">No. Invoice</th>
                                    <th class="td-border" nowrap="nowrap" style="text-align:left">Nama Pelanggan</th>
                                    <th class="td-border" nowrap="nowrap" style="text-align:left">Product</th>
                                    <th class="td-border" nowrap="nowrap">Jumlah Barang</th>
									<th class="td-border" nowrap="nowrap" style="text-align:right">Harga Satuan</th>
                                    <th class="td-border" nowrap="nowrap" style="text-align:right;">Total Harga</th>
								</tr>
                            </thead>
                            <tbody>
                                <tr class="tr">
                                    <td class="td-border py-2" colspan="8" style="text-align:center;">Data Belum Tersedia</td>
                                </tr>
							</tbody>
						</table>
						@endforelse
						<table id="tableGL" class="table table-border-black print-border-0" cellspacing="0.5" width="100%">
							<thead style="font-size:20px;">
                                <tr>
                                    <th class="td-border" nowrap="nowrap" style="opacity:0">No</th>
                                    <th class="td-border" nowrap="nowrap" style="opacity:0">No. Voucher</th>
                                    <th class="td-border" nowrap="nowrap" style="opacity:0">No. Bill</th>
                                    <th class="td-border" nowrap="nowrap" style="opacity:0">No. Room</th>
                                    <th class="td-border" style="text-align:left;opacity:0">Keterangan</th>
                                    <th class="td-border" nowrap="nowrap" style="text-align:right;opacity:0">Jumlah</th>
                                    <th class="td-border" nowrap="nowrap" style="opacity:0">User Entry</th>
								</tr>
                            </thead>
                            <tbody>
                                
							</tbody>
							<footer>
                                <tr class="tr">
                                    <td class="border-0 print-border-0" colspan="4">&nbsp;</td>
                                    <td class="border-0 print-border-0">&nbsp;</td>
                                    <td class="td-border" nowrap="nowrap"><b>T O T A L</b></td>
                                    <td class="td-border" style="text-align:right;"><b></b></td>
                                    <td class="td-border" style="text-align:right;"><b>{{ number_format($total,0,'','.') }}</b></td>
                                </tr>
                            </footer>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>