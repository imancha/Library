@extends('master.app')

@section('title')
	Dashboard
@endsection

@section('style')
	<link href="{{ asset('/assets/plugins/xcharts/xcharts.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div id="main-content" class="dashboard">
		<div class="row" id="_book">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-9 col-sm-9 col-xs-12">
								<h2 class="panel-title w-100">Pemasukan Buku</h2>
							</div>
							<div class="col-md-3 col-sm-9 col-xs-12">
								<div class="input-group transparent">
									<input class="form-control" id="range" type="text">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-body p-t-0">
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-12 p-5">
								<div class="withScroll" data-height="400px">
									<table class="table m-b-0">
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
						<div class="md-modal md-effect-3" id="exists" style="width:95%;max-width:95%;">
							<div class="md-content md-content-white">
								<h3><span id="judul"></span> <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
								<div class="p-10 withScroll" data-height="400px">
									<div class="table-responsive">
										<table class="table table-hover table-vatop">
											<thead>
												<tr>
													<th>Kode</th>
													<th>Judul</th>
													<th>Pengarang</th>
													<th>Penerbit</th>
													<th>Tahun</th>
													<th>Jenis</th>
													<th>Subyek</th>
													<th>Rak</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="md-overlay"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="_member">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-9 col-sm-9 col-xs-12">
								<h2 class="panel-title w-100">Pemasukan Anggota</h2>
							</div>
							<div class="col-md-3 col-sm-9 col-xs-12">
								<div class="input-group transparent">
									<input class="form-control" id="range" type="text">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-body p-t-0">
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-12 p-5">
								<div class="withScroll" data-height="400px">
									<table class="table m-b-0">
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
						<div class="md-modal md-effect-3" id="exists" style="width:95%;max-width:95%;">
							<div class="md-content md-content-white">
								<h3><span id="judul"></span> <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
								<div class="p-10 withScroll" data-height="400px">
									<div class="table-responsive">
										<table class="table table-hover table-vatop">
											<thead>
												<tr>
													<th>NIP/NIM/NIS</th>
													<th>Nama</th>
													<th>Jenis Kelamin</th>
													<th>Jenis Anggota</th>
													<th>Alamat/Divisi</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="md-overlay"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="_borrow">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-9 col-sm-9 col-xs-12">
								<h2 class="panel-title w-100">Pemasukan Peminjaman</h2>
							</div>
							<div class="col-md-3 col-sm-9 col-xs-12">
								<div class="input-group transparent">
									<input class="form-control" id="range" type="text">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-body p-t-0">
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-12 p-5">
								<div class="withScroll" data-height="400px">
									<table class="table m-b-0">
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
						<div class="md-modal md-effect-3" id="exists" style="width:95%;max-width:95%;">
							<div class="md-content md-content-white">
								<h3><span id="judul"></span> <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
								<div class="p-10 withScroll" data-height="400px">
									<div class="table-responsive">
										<table class="table table-bordered table-hover">
											<thead>
												<tr>
													<th class="text-center">ID</th>
													<th class="text-center" width="100px" >Waktu Pinjam</th>
													<th class="text-center">NIP/NIM/NIS</th>
													<th class="text-center">Nama</th>
													<th class="text-center" width="79px">Kode Buku</th>
													<th class="text-center" width="385px">Judul Buku</th>
													<th class="text-center" width="100px">Waktu Kembali</th>
													<th class="text-center" width="126px">Keterangan</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="md-overlay"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script src="{{ asset('/assets/plugins/charts-d3/d3.v3.js') }}"></script>
	<script src="{{ asset('/assets/plugins/charts-d3/nv.d3.js') }}"></script>
	<script src="{{ asset('/assets/plugins/xcharts/xcharts.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/daterangepicker/sugar.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
	<script>
	$(function(){
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var startDate	= Date.create().addDays(-29),
				endDate		= Date.create();
			var range = $('#_book #range');
			var _range = $('#_member #range');
			var __range = $('#_borrow #range');
			range.val(startDate.format('{MM}/{dd}/{yyyy}') + ' - ' + endDate.format('{MM}/{dd}/{yyyy}'));
			_range.val(startDate.format('{MM}/{dd}/{yyyy}') + ' - ' + endDate.format('{MM}/{dd}/{yyyy}'));
			__range.val(startDate.format('{MM}/{dd}/{yyyy}') + ' - ' + endDate.format('{MM}/{dd}/{yyyy}'));
			__ajaxLoadChart(startDate,endDate);
			_ajaxLoadChart(startDate,endDate);
			ajaxLoadChart(startDate,endDate);
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
			},function(start, end){
				ajaxLoadChart(start, end);
			});
			_range.daterangepicker({
				opens: 'left',
				startDate: startDate,
				endDate: endDate,
				ranges: {
					'Hari Ini': ['today', 'today'],
					'Kemarin': ['yesterday', 'yesterday'],
					'7 Hari Terakhir': [Date.create().addDays(-6), 'today'],
					'30 Hari Terakhir': [Date.create().addDays(-29), 'today']
				}
			},function(start, end){
				_ajaxLoadChart(start, end);
			});
			__range.daterangepicker({
				opens: 'left',
				startDate: startDate,
				endDate: endDate,
				ranges: {
					'Hari Ini': ['today', 'today'],
					'Kemarin': ['yesterday', 'yesterday'],
					'7 Hari Terakhir': [Date.create().addDays(-6), 'today'],
					'30 Hari Terakhir': [Date.create().addDays(-29), 'today']
				}
			},function(start, end){
				__ajaxLoadChart(start, end);
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
					tt.text(d.x.format('{Month} {ord}') + ': ' + d.y).css({
						top: topOffset + pos.top,
						left: pos.left
					}).show();
				},
				"mouseout": function (x) {
					tt.hide();
				}
			};
			var __chart = new xChart('line-dotted', data, '#_borrow #chart' , opts);
			var _chart = new xChart('line-dotted', data, '#_member #chart' , opts);
			var chart = new xChart('line-dotted', data, '#_book #chart' , opts);
			function ajaxLoadChart(startDate,endDate) {
				if(!startDate || !endDate){
					chart.setData({
						"xScale" : "time",
						"yScale" : "linear",
						"main" : [{
							className : ".stats",
							data : []
						}]
					});
					$('#_book tbody#data').empty();
					$('#_book #total').empty().text('0');
					return;
				}
				$.getJSON("{{ action('Admin\HomeController@getData') }}", {
					start:	startDate.format('{yyyy}-{MM}-{dd}'),
					end:	endDate.format('{yyyy}-{MM}-{dd}')
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
					$('#_book tbody#data').empty();
					$.each(data, function() {
						$('#_book tbody#data').append(
							'<tr>'+
								'<td class="text-center">'+(++i)+'</td>'+
								'<td class="text-center">'+this.label+'</td>'+
								'<td class="text-center"><a class="badge" href="javascript:;" onclick="_book(\''+this.label+'\');" title="Lihat">'+this.value+'</a></td>'+
							'</tr>'
						);
						total += parseInt(this.value);
					});
					$('#_book #total').empty().text(total);
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
			function _ajaxLoadChart(startDate,endDate) {
				if(!startDate || !endDate){
					_chart.setData({
						"xScale" : "time",
						"yScale" : "linear",
						"main" : [{
							className : ".stats",
							data : []
						}]
					});
					$('#_member tbody#data').empty();
					$('#_member #total').empty().text('0');
					return;
				}
				$.getJSON("{{ action('Admin\HomeController@getData') }}", {
					start:	startDate.format('{yyyy}-{MM}-{dd}'),
					end:	endDate.format('{yyyy}-{MM}-{dd}'),
					id: 1
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
					$('#_member tbody#data').empty();
					$.each(data, function() {
						$('#_member tbody#data').append(
							'<tr>'+
								'<td class="text-center">'+(++i)+'</td>'+
								'<td class="text-center">'+this.label+'</td>'+
								'<td class="text-center"><a class="badge" href="javascript:;" onclick="_member(\''+this.label+'\');" title="Lihat">'+this.value+'</a></td>'+
							'</tr>'
						);
						total += parseInt(this.value);
					});
					$('#_member #total').empty().text(total);
					_chart.setData({
						"xScale" : "time",
						"yScale" : "linear",
						"main" : [{
							className : ".stats",
							data : set
						}]
					});
				});
			}
			function __ajaxLoadChart(startDate,endDate) {
				if(!startDate || !endDate){
					__chart.setData({
						"xScale" : "time",
						"yScale" : "linear",
						"main" : [{
							className : ".stats",
							data : []
						}]
					});
					$('#_borrow tbody#data').empty();
					$('#_borrow #total').empty().text('0');
					return;
				}
				$.getJSON("{{ action('Admin\HomeController@getData') }}", {
					start:	startDate.format('{yyyy}-{MM}-{dd}'),
					end:	endDate.format('{yyyy}-{MM}-{dd}'),
					id: 2
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
					$('#_borrow tbody#data').empty();
					$.each(data, function() {
						$('#_borrow tbody#data').append(
							'<tr>'+
								'<td class="text-center">'+(++i)+'</td>'+
								'<td class="text-center">'+this.label+'</td>'+
								'<td class="text-center"><a class="badge" href="javascript:;" onclick="_borrow(\''+this.label+'\');" title="Lihat">'+this.value+'</a></td>'+
							'</tr>'
						);
						total += parseInt(this.value);
					});
					$('#_borrow #total').empty().text(total);
					__chart.setData({
						"xScale" : "time",
						"yScale" : "linear",
						"main" : [{
							className : ".stats",
							data : set
						}]
					});
				});
			}

		$('#_book #exists a.md-close').click(function(){
			$('#_book #exists').removeClass('md-show');
		});
		$('#_member #exists a.md-close').click(function(){
			$('#_member #exists').removeClass('md-show');
		});
		$('#_borrow #exists a.md-close').click(function(){
			$('#_borrow #exists').removeClass('md-show');
		});
	});
	function _book(tid){
		$('#_book #exists table > tbody').empty();
		$('#_book #exists #judul').empty().text(tid);
		$.getJSON("{{ action('Admin\HomeController@getDetail') }}", {
			id: tid,
		}, function(data){
			var i = 0;
			$.each(data, function(){
				$('#_book #exists table > tbody').append(
					'<tr>'+
						'<td class="text-left">'+this.kode+'</td>'+
						'<td class="text-left">'+this.judul+'</td>'+
						'<td class="text-left">'+this.pengarang+'</td>'+
						'<td class="text-left">'+this.penerbit+'</td>'+
						'<td class="text-left">'+this.tahun+'</td>'+
						'<td class="text-left">'+this.jenis+'</td>'+
						'<td class="text-left">'+this.subyek+'</td>'+
						'<td class="text-left">'+this.rak+'</td>'+
					'</tr>'
				);
			});
		});
		$('#_book #exists').addClass('md-show');
	}
	function _member(tid){
		$('#_member #exists table > tbody').empty();
		$('#_member #exists #judul').empty().text(tid);
		$.getJSON("{{ action('Admin\HomeController@getDetail') }}", {
			id: tid,
			it: 1,
		}, function(data){
			var i = 0;
			$.each(data, function(){
				$('#_member #exists table > tbody').append(
					'<tr>'+
						'<td class="text-left">'+this.kode+'</td>'+
						'<td class="text-left">'+this.nama+'</td>'+
						'<td class="text-left">'+this.jkel+'</td>'+
						'<td class="text-left">'+this.jang+'</td>'+
						'<td class="text-left">'+this.alam+'</td>'+
					'</tr>'
				);
			});
		});
		$('#_member #exists').addClass('md-show');
	}
	function _borrow(tid){
		$('#_borrow #exists table > tbody').empty();
		$('#_borrow #exists #judul').empty().text(tid);
		$.getJSON("{{ action('Admin\HomeController@getDetail') }}", {
			id: tid,
			it: 2,
		}, function(data){
			var i = 0;
			var j = '';
			$.each(data, function(){
				j += '<tr>'+
								'<td class="text-center">'+this.kode+'</td>'+
								'<td class="text-center">'+this.pinj+'</td>'+
								'<td class="text-center">'+this.nipn+'</td>'+
								'<td class="text-center">'+this.nama+'</td>'+
								'<td class="text-center" colspan="4" style="padding:0px" class="nested"><table class="table table-bordered table-hover" style="margin-bottom:0px;"><tbody>'+this.buku+'</tbody></table></td>'+
							'</tr>'
			});
			$('#_borrow #exists table > tbody').append(j);
		});
		$('#_borrow #exists').addClass('md-show');
	}
	</script>
@endsection
