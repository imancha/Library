@extends('public.app')

@section('title')
	Laporan
@endsection

@section('style')
	<link href="{{ asset('/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/plugins/xcharts/xcharts.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 cl-xs-12">
				<div class="page-title">
					<h3>Laporan</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="s-10"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="bg-light-gray p-10">
					<div class="row">
						<div class="col-md-3 col-sm-3 col-xs-12 pull-left">
							<select class="form-control show-menu-arrow flat" name="tipe">
								<option value="1">Anggota</option>
								<option value="3" selected>Buku</option>
								<option value="2">Peminjaman</option>
							</select>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12 pull-right">
							<div class="input-group">
								<input class="form-control flat" id="range" type="text">
								<span class="input-group-addon flat">
									<i class="fa fa-calendar"></i>
								</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 col-sm-3 col-xs-12">
							<div class="r-table" style="height:400px;padding-top:10px;">
								<table class="table table-hover mb-0">
									<thead>
										<tr>
											<th class="text-center">#</th>
											<th class="text-center">Tanggal</th>
											<th class="text-center">Jumlah</th>
										</tr>
									</thead>
									<tbody id="data"></tbody>
									<thead style="border-top:2px solid #ddd;">
										<tr>
											<th colspan="2">Total</th>
											<th class="text-center" id="total"></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
						<div class="col-md-9 col-sm-9 col-xs-12 pull-right p-0">
							<figure id="chart" style="height:400px"></figure>
						</div>
					</div>
					<div class="modal fade" id="exists" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" style="width:90%;">
							<div class="modal-content flat">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel"></h4>
								</div>
								<div class="modal-body table-responsive r-table" style="height:400px;">
									<table class="table table-hover table-vatop mb-0">
										<thead></thead>
										<tbody></tbody>
									</table>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default pull-right flat" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script src="{{ asset('/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
	<script src="{{ asset('/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
	<script src="{{ asset('/plugins/charts-d3/d3.v3.js') }}"></script>
	<script src="{{ asset('/plugins/charts-d3/nv.d3.js') }}"></script>
	<script src="{{ asset('/plugins/xcharts/xcharts.min.js') }}"></script>
	<script src="{{ asset('/plugins/daterangepicker/sugar.min.js') }}"></script>
	<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}"></script>
	<script>
		$(function(){
			$('select').selectpicker();
			$('.r-table').mCustomScrollbar({
				theme:"minimal-dark",
				autoExpandScrollbar: true
			});
			var sd = $('select[name="tipe"]').val();
			var range = $('#range');
			var startDate	= Date.create().addDays(-29),
					endDate		= Date.create();
			range.val(startDate.format('{yyyy}/{MM}/{dd}') + ' - ' + endDate.format('{yyyy}/{MM}/{dd}'));
			ajaxLoadChart(startDate,endDate,sd);
			range.daterangepicker({
				opens: 'left',
				startDate: startDate,
				endDate: endDate,
				ranges: {
					'Hari Ini': ['today', 'today'],
					'Kemarin': ['yesterday', 'yesterday'],
					'7 Hari Terakhir': [Date.create().addDays(-6), 'today'],
					'30 Hari Terakhir': [Date.create().addDays(-29), 'today']
				}
			},function(start, end, sd){
				ajaxLoadChart(start, end, sd);
			});
			$('select[name="tipe"]').on('change', function(){
				sd = $('select[name="tipe"]').val();
				startDate	= Date.create().addDays(-29);
				endDate		= Date.create();
				range.val(startDate.format('{yyyy}/{MM}/{dd}') + ' - ' + endDate.format('{yyyy}/{MM}/{dd}'));
				ajaxLoadChart(startDate,endDate,sd);
			});
			var tt = $('<div class="ex-tooltip">').appendTo('body'),
				topOffset = -32;
			var data = {
				"xScale" : "time",
				"yScale" : "linear",
				"main" : [{
					className : ".stats",
					"data" : []
				}]
			};
			var opts = {
				paddingLeft : 50,
				paddingTop : 20,
				paddingRight : 10,
				axisPaddingLeft : 25,
				tickHintX: 9,
				dataFormatX : function(x) {
					return Date.create(x);
				},
				tickFormatX : function(x) {
					return x.format('{MM}/{dd}');
				},
				"mouseover": function (d, i) {
					var pos = $(this).offset();
					tt.text(d.x.format('{yyyy}/{MM}/{dd}') + ': ' + d.y).css({
						top: topOffset + pos.top,
						left: pos.left - 46
					}).show();
				},
				"mouseout": function (x) {
					tt.hide();
				},
				"click": function(d, i) {
					exists(d.x.format('{yyyy}/{MM}/{dd}'),sd);
				},
			};
			var chart = new xChart('line-dotted', data, '#chart' , opts);
			function ajaxLoadChart(startDate,endDate,sd) {
				if(!startDate || !endDate){
					chart.setData({
						"xScale" : "time",
						"yScale" : "linear",
						"main" : [{
							className : ".stats",
							data : []
						}]
					});
					$('tbody#data').empty();
					$('#total').empty().text('0');
					return;
				}
				$.getJSON("{{ action('PublicController@getData') }}", {
					start:	startDate.format('{yyyy}-{MM}-{dd}'),
					end:	endDate.format('{yyyy}-{MM}-{dd}'),
					id: sd
				}, function(data) {
					var set = [];
					var i = 0;
					var total = 0;
					$.each(data, function() {
						set.push({
							x : this.label,
							y : parseInt(this.value, 10)
						});
					});
					$('tbody#data').empty();
					$.each(data, function() {
						$('tbody#data').append(
							'<tr>'+
								'<td class="text-center">'+(++i)+'</td>'+
								'<td class="text-center">'+this.label+'</td>'+
								'<td class="text-center"><a class="badge" href="javascript:;" onclick="exists(\''+this.label+'\','+sd+');" title="Lihat">'+this.value+'</a></td>'+
							'</tr>'
						);
						total += parseInt(this.value);
					});
					$('#total').empty().append('<a class="badge" href="javascript:;" onclick="texists(\''+startDate.format('{yyyy}-{MM}-{dd}')+'\',\''+endDate.format('{yyyy}-{MM}-{dd}')+'\','+sd+');" title="Lihat">'+total+'</a>');
					chart.setData({
						"xScale" : "time",
						"yScale" : "linear",
						"main" : [{
							className : ".stats",
							data : set
						}]
					});
				});
			}
		});
		function exists(tid,sid){
			$('#exists table > tbody').empty();
			$('#exists #myModalLabel').empty().text(Date.create(tid).format('{Weekday}, {dd} {Month} {yyyy}'));
			$.getJSON("{{ action('PublicController@getDetail') }}", {
				id: tid,
				it: sid
			}, function(data){
				if(sid == 1){
					$('#exists table > thead').empty().append('<tr><th>NIP/NIM/NIS</th><th>Nama</th><th>Jenis Kelamin</th><th>Jenis Anggota</th><th>Alamat/Divisi</th><th>Waktu Daftar</th></tr>');
					$.each(data, function(){
						$('#exists table > tbody').append('<tr><td class="text-left">'+this.kode+'</td><td class="text-left">'+this.nama+'</td><td class="text-left">'+this.jkel+'</td><td class="text-left">'+this.jang+'</td><td class="text-left">'+this.alam+'</td><td class="text-left">'+this.wakt+'</td></tr>');
					});
				}else if(sid == 2){
					$('#exists table > thead').empty().append('<tr><th class="text-center">ID</th><th class="text-center" width="100px" >Waktu Pinjam</th><th class="text-center">NIP/NIM/NIS</th><th class="text-center">Nama</th><th class="text-center" width="79px">Kode Buku</th><th class="text-center" width="385px">Judul Buku</th><th class="text-center" width="100px">Waktu Kembali</th><th class="text-center" width="126px">Keterangan</th></tr>');
					var j = '';
					$.each(data, function(){
						j += '<tr><td class="text-center">'+this.kode+'</td><td class="text-center">'+this.pinj+'</td><td class="text-center">'+this.nipn+'</td><td class="text-center">'+this.nama+'</td><td class="text-center" colspan="4" style="padding:0px" class="nested"><table class="table table-bordered table-hover" style="margin-bottom:0px;"><tbody>'+this.buku+'</tbody></table></td></tr>'
					});
					$('#exists table > tbody').append(j);
				}else{
					$('#exists table > thead').empty().append('<tr><th>Kode</th><th>Judul</th><th>Pengarang</th><th>Penerbit</th><th>Tahun</th><th>Subyek</th><th>Rak</th><th>Jenis</th></tr>');
					$.each(data, function(){
						$('#exists table > tbody').append('<tr><td class="text-left">'+this.kode+'</td><td class="text-left">'+this.judul+'</td><td class="text-left">'+this.pengarang+'</td><td class="text-left">'+this.penerbit+'</td><td class="text-left">'+this.tahun+'</td><td class="text-left">'+this.subyek+'</td><td class="text-left">'+this.rak+'</td><td class="text-left">'+this.jenis+'</td></tr>');
					});
				}
				$('#exists').modal('show');
			});
		}
		function texists(istart,iend,sid){
			$('#exists table > tbody').empty();
			$('#exists #myModalLabel').empty().text(Date.create(istart).format('{dd} {Month} {yyyy}')+' - '+Date.create(iend).format('{dd} {Month} {yyyy}'));
			$.getJSON("{{ action('PublicController@getDetail') }}", {
				start: istart,
				end: iend,
				it: sid
			}, function(data){
				if(sid == 1){
					$('#exists table > thead').empty().append('<tr><th>NIP/NIM/NIS</th><th>Nama</th><th>Jenis Kelamin</th><th>Jenis Anggota</th><th>Alamat/Divisi</th><th>Waktu Daftar</th></tr>');
					$.each(data, function(){
						$('#exists table > tbody').append('<tr><td class="text-left">'+this.kode+'</td><td class="text-left">'+this.nama+'</td><td class="text-left">'+this.jkel+'</td><td class="text-left">'+this.jang+'</td><td class="text-left">'+this.alam+'</td><td class="text-left">'+this.wakt+'</td></tr>');
					});
				}else if(sid == 2){
					$('#exists table > thead').empty().append('<tr><th class="text-center">ID</th><th class="text-center" width="100px" >Waktu Pinjam</th><th class="text-center">NIP/NIM/NIS</th><th class="text-center">Nama</th><th class="text-center" width="79px">Kode Buku</th><th class="text-center" width="385px">Judul Buku</th><th class="text-center" width="100px">Waktu Kembali</th><th class="text-center" width="126px">Keterangan</th></tr>');
					var j = '';
					$.each(data, function(){
						j += '<tr><td class="text-center">'+this.kode+'</td><td class="text-center">'+this.pinj+'</td><td class="text-center">'+this.nipn+'</td><td class="text-center">'+this.nama+'</td><td class="text-center" colspan="4" style="padding:0px" class="nested"><table class="table table-bordered table-hover" style="margin-bottom:0px;"><tbody>'+this.buku+'</tbody></table></td></tr>'
					});
					$('#exists table > tbody').append(j);
				}else{
					$('#exists table > thead').empty().append('<tr><th>Kode</th><th>Judul</th><th>Pengarang</th><th>Penerbit</th><th>Tahun</th><th>Subyek</th><th>Rak</th><th>Jenis</th></tr>');
					$.each(data, function(){
						$('#exists table > tbody').append('<tr><td class="text-left">'+this.kode+'</td><td class="text-left">'+this.judul+'</td><td class="text-left">'+this.pengarang+'</td><td class="text-left">'+this.penerbit+'</td><td class="text-left">'+this.tahun+'</td><td class="text-left">'+this.subyek+'</td><td class="text-left">'+this.rak+'</td><td class="text-left">'+this.jenis+'</td></tr>');
					});
				}
				$('#exists').modal('show');
			});
		}
	</script>
@endsection
