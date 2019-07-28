<?php 
	use Carbon\Carbon;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Jalan</title>
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
                                        <p>
                                            <span style="border-bottom:1px solid black">Nama Perusahaan</span> <br>
                                            <span>{{ $order->customer->perusahaan }}</span>
                                        </p>
                                        <p style="float:left; margin-top:-5px;">
                                            <span style="border-bottom:1px solid black">Contact Person</span> <br>
                                            <span>{{ $order->customer->nama_customer }}</span>
                                        </p>
                                        <p style="float:left; margin-top: -5px; margin-left: 20px;">
                                            <span style="border-bottom:1px solid black">Telephone</span> <br>
                                            <span>{{ $order->customer->telpon }}</span>
                                        </p>
										<p style="clear:both; margin-top: -15px;">
                                            <span style="border-bottom: 1px solid black">Alamat Customer</span> <br>
                                            <span>{{ $order->customer->alamat }}</span>
                                        </p>
									</td>
									<td class="tag-text">
										<p style="text-align:right;margin-top:60px;margin-bottom:0px;">
                                            <br>SURAT JALAN<br>
											No. {{ $order->no_order }} <br><br>
                                            Tanggal<br>
                                            {{ Carbon::now()->format('d, M Y') }}
										</p>
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
						<!-- no body -->
					</div>
				</div>

				<div class="clearfix"></div>

				<div class="row">
					<div id="table-container" class="col-12 d-flex justify-content-between">
						
                        <table id="tableGL" class="table table-border-black print-border-0" cellspacing="0.5" width="100%">
							<thead style="font-size:20px;">
                                <tr>
                                    <th class="td-border" style="text-align:center;width:20px" nowrap="nowrap">NO</th>
                                    <th class="td-border" style="text-align:center;width:20px" nowrap="nowrap">BANYAKNYA</th>
                                    <th class="td-border" style="text-align:center;width:500px;" nowrap="nowrap">NAMA BARANG</th>
								</tr>
                            </thead>
                            <tbody>
                            @foreach($data as $key => $order)
                                <tr class="tr">
                                    <td class="td-border py-2" style="text-align:center;width:20px">{{ $key + 1}}</td>
                                    <td class="td-border py-2" style="text-align:center;width:20px">{{ $qty[$key] }}</td>
                                    <td class="td-border py-2" style="text-align:center;width:500px;">{{ $order->nama_product }}</td>
                                </tr>
                            @endforeach
							</tbody>
						</table>
						
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
                                    <td class="" nowrap="nowrap">Tanda Terima</td>
                                    <td style="text-align:right;"><b></b></td>
                                    <td colspan="7" style="text-align:right;">Hormat Kami</td>
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