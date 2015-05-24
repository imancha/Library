@extends('admin.master.app')

@section('title')
	Dashboard
@endsection

@section('style')
	<link href="{{ asset('/assets/plugins/xcharts/xcharts.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div id="main-content" class="dashboard">
		<div class="row">
			<div class="col-md-6 m-b-10">
				<div class="input-group transparent">
					<span class="input-group-addon">Lokasi</span>
					<input class="form-control" name="address-1" type="text" value="{{ address(1) }}" />
				</div>
			</div>
			<div class="col-md-6 m-b-10">
				<div class="input-group transparent">
					<input class="form-control" name="address-2" type="text" value="{{ address(2) }}" />
					<span class="input-group-addon">Alamat</span>
				</div>
			</div>
		</div>
		<div class="row">
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
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-7 col-sm-7 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title w-100">
							Slider
							<span class="pull-right" data-placement="left" title="" rel="tooltip" data-original-title="Tambah">
								<a href="" class="c-green md-trigger" data-modal="slider">
									<i class="glyph-icon flaticon-plus16 f-32"></i>
								</a>
							</span>
						</h2>
					</div>
					<div class="panel-body messages p-b-20">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="withScroll" data-height="388">
									<div class="message-item media">
										<div class="media">
											<img src="{{ asset('/img/slide-.jpg') }}" alt="" width="50" height="40" class="pull-left">
											<div class="media-body">
												<small class="pull-right">
													<span class="m-r-5" data-placement="left" title="" rel="tooltip" data-original-title="Ubah">
														<a href="" class="md-trigger" data-modal="ubah-slider-"><i class="fa fa-edit"></i></a>
													</span>
												</small>
												<h5 class="c-dark"><strong>Slide-0</strong></h5>
												<h4 class="c-dark">PERPUSTAKAAN INTI</h4>
											</div>
										</div>
										<p class="f-14 c-gray">Memiliki sekitar koleksi buku yang terdiri dari buku referensi, pengetahuan umum, ensiklopedia dan laporan hasil penelitian yang dilakukan di PT. INTI (Persero)</p>
									</div>
									<div class="md-modal md-effect-8" id="ubah-slider-">
										<div class="md-content md-content-white">
											<h3>Ubah Slider <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
											<div class="p-10">
												<form method="post" action="">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<div class="form-group">
														<label for="field-2" class="control-label sr-only">Keterangan</label>
														<textarea class="form-control cke-editor" name="keterangan" value="" placeholder="" autocomplete="off"></textarea>
													</div>
													<div class="form-group">
														<button class="btn btn-dark btn-transparent btn-rounded">Submit</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div class="md-overlay"></div>
									@if(count($sliders) > 0)
										<?php $i=0 ?>
										@foreach($sliders as $slider)
											<div class="message-item media">
												<div class="media">
													<img src="{{ asset('/img/slide-'.(empty($slider->mime) ? '.jpg' : $slider->id.'.'.$slider->mime)) }}" alt="" width="50" height="40" class="pull-left">
													<div class="media-body">
														<small class="pull-right">
															<span class="m-r-5" data-placement="left" title="" rel="tooltip" data-original-title="Ubah">
																<a href="" class="md-trigger" data-modal="ubah-{{ $slider->id }}"><i class="fa fa-edit"></i></a>
															</span>
															<span data-placement="left" title="" rel="tooltip" data-original-title="hapus">
																<a href="" class="c-red md-trigger" data-modal="hapus-{{ $slider->id }}"><i class="fa fa-times"></i></a>
															</span>
														</small>
														<h5 class="c-dark"><strong>Slide-{{ ++$i }}</strong></h5>
														<h4 class="c-dark">{{ $slider->judul }}</h4>
													</div>
												</div>
												<p class="f-14 c-gray">{{ $slider->keterangan }}</p>
											</div>
											<div class="md-modal md-effect-8" id="ubah-{{ $slider->id }}">
												<div class="md-content md-content-white">
													<h3>Ubah Slider <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
													<div class="p-b-10 m-t-10">
														<form method="post" action="{{ action('Admin\SliderController@update',$slider->id) }}" enctype="multipart/form-data">
														<input name="_method" type="hidden" value="PATCH">
															<input type="hidden" name="_token" value="{{ csrf_token() }}">
															<div class="form-group">
																<label for="field-1" class="control-label">Judul</label>
																<input type="text" name="judul" class="form-control" value="{{ $slider->judul }}" placeholder="" autocomplete="off" required />
															</div>
															<div class="form-group">
																<label for="field-2" class="control-label">Keterangan</label>
																<textarea class="form-control" name="keterangan" value="" placeholder="" autocomplete="off">{{ $slider->keterangan }}</textarea>
															</div>
															<div class="form-group">
																<label for="field-3" class="control-label">Gambar</label>
																<a class="file-input-wrapper">
																	<input type="file" name="file" data-filename-placement="inside" class="btn-transparent">
																</a>
															</div>
															<div class="form-group">
																<button class="btn btn-dark btn-transparent btn-rounded">Submit</button>
															</div>
														</form>
													</div>
												</div>
											</div>
											<div class="md-modal md-effect-1" id="hapus-{{ $slider->id }}">
												<div class="md-content md-content-red">
													<h3 class="c-white">Hapus<span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
													<div class="text-left">
														<form role="form" method="POST" action="{{ action('Admin\SliderController@destroy',$slider->id) }}">
														<input name="_method" type="hidden" value="DELETE">
															<input type="hidden" name="_token" value="{{ csrf_token() }}">
															<input type="hidden" name="id" value="{{ $slider->id }}">
															<div class="text-center m-b-20">
																Hapus Slide-{{ $i }} . . . ?
															</div>
															<button type="submit" class="btn btn-default btn-rounded btn-transparent">Hapus</button>
														</form>
													</div>
												</div>
											</div>
										@endforeach
										<div class="md-overlay"></div>
									@endif
								</div>
							</div>
						</div>
					</div>
					<div class="md-modal md-effect-10" id="slider">
						<div class="md-content md-content-white">
							<h3>Tambah Slider <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
							<div class="p-b-10 m-t-10">
								<form method="post" action="{{ action('Admin\SliderController@store') }}" enctype="multipart/form-data">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group">
										<label for="field-1" class="control-label">Judul</label>
										<input type="text" name="judul" class="form-control" value="" placeholder="" autocomplete="off" required />
									</div>
									<div class="form-group">
										<label for="field-2" class="control-label">Keterangan</label>
										<textarea class="form-control" name="keterangan" value="" placeholder="" autocomplete="off"></textarea>
									</div>
									<div class="form-group">
										<label for="field-3" class="control-label">Gambar</label>
										<a class="file-input-wrapper">
											<input type="file" name="file" data-filename-placement="inside" class="btn-transparent">
										</a>
									</div>
									<div class="form-group">
										<button class="btn btn-dark btn-transparent btn-rounded">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="md-overlay"></div>
				</div>
			</div>
			<div class="col-md-5 col-sm-5 col-xs-12">
				<div class="panel panel-default chat m-b-20">
					<div class="panel-heading">
						<h2 class="panel-title w-100">Buku Tamu</h2>
					</div>
					<div class="panel-body withScroll" data-height="410">
						@if(count($guests) > 0)
							<ul>
								@foreach($guests as $guest)
									<li class="left clearfix">
										<div class="chat-img pull-left text-center">
											<span>{{ substr($guest->waktu,8,2) }}</span>
											<br>
											<span>{{ bulan(substr($guest->waktu,5,2)) }}</span>
											<br>
											<span>{{ substr($guest->waktu,0,4) }}</span>
										</div>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font">{{ $guest->nama }} </strong>
												<small class="pull-right" data-placement="left" title="" rel="tooltip" data-original-title="Hapus">
													<a href="" class="c-red md-trigger" data-modal="remove-{{ $guest->id }}">
														<i class="fa fa-times"></i>
													</a>
												</small>
												<small class="text-muted">{{ $guest->email }}</small>
											</div>
											<p>{{ $guest->komentar }}</p>
										</div>
									</li>
									<div class="md-modal md-effect-1" id="remove-{{ $guest->id }}">
										<div class="md-content md-content-red">
											<h3 class="c-white">Hapus<span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
											<div class="text-left">
												<form role="form" method="POST" action="{{ action('Admin\HomeController@guestBook') }}">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input type="hidden" name="id" value="{{ $guest->id }}">
													<input type="hidden" name="nama" value="{{ $guest->nama }}">
													<div class="text-center m-b-20">
														Hapus komentar dari <strong>{{ $guest->nama }}</strong> . . . ?
													</div>
													<button type="submit" class="btn btn-default btn-rounded btn-transparent">Hapus</button>
												</form>
											</div>
										</div>
									</div>
								@endforeach
								<div class="md-overlay"></div><!-- the overlay element -->
							</ul>
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title w-100">
							Beranda
							<span class="pull-right" data-placement="left" title="" rel="tooltip" data-original-title="Ubah">
								<a href="" class="c-green md-trigger" data-modal="beranda">
									<i class="fa fa-edit"></i>
								</a>
							</span>
						</h2>
					</div>
					<div class="panel-body text-justify p-t-0 withScroll" data-height="400">
						{!! $beranda !!}
					</div>
					<div class="md-modal md-effect-7" id="beranda">
						<div class="md-content md-content-white">
							<h3>Beranda <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
							<div class="p-b-10 m-t-10">
								<form method="post" action="{{ action('Admin\HomeController@postDashboard') }}" enctype="multipart/form-data">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="_file" value="">
									<div class="form-group">
										<label for="field-1" class="control-label">Judul</label>
										<input type="text" name="title" class="form-control" value="" placeholder="" autocomplete="off" required />
									</div>
									<div class="form-group">
										<label for="field-2" class="control-label">Keterangan</label>
										<textarea class="form-control" name="post" rows="10" value="" placeholder="" autocomplete="off" required></textarea>
									</div>
									<div class="form-group">
										<label for="field-3" class="control-label">Gambar</label>
										<a class="file-input-wrapper">
											<input type="file" name="img" data-filename-placement="inside" class="btn-transparent">
										</a>
									</div>
									<div class="form-group">
										<button class="btn btn-dark btn-transparent btn-rounded">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="md-overlay"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title w-100">
							Layanan Keanggotaan
							<span class="pull-right" data-placement="left" title="" rel="tooltip" data-original-title="Ubah">
								<a href="" class="c-green md-trigger" data-modal="anggota">
									<i class="fa fa-edit"></i>
								</a>
							</span>
						</h2>
					</div>
					<div class="panel-body text-justify p-t-0 withScroll" data-height="400">
						{!! $member !!}
					</div>
					<div class="md-modal md-effect-14" id="anggota">
						<div class="md-content md-content-white">
							<h3>Layanan Keanggotaan<span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
							<div class="p-10">
								<form method="post" action="{{ action('Admin\HomeController@postService','member') }}">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="_id" value="Layanan Keanggotaan">
									<div class="form-group">
										<label for="field-2" class="control-label sr-only">Keterangan</label>
										<textarea class="form-control cke-editor" name="member" rows="10" value="" placeholder="" autocomplete="off" required>{{ $member }}</textarea>
									</div>
									<div class="form-group">
										<button class="btn btn-dark btn-transparent btn-rounded">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="md-overlay"></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title w-100">
							Layanan Peminjaman
							<span class="pull-right" data-placement="left" title="" rel="tooltip" data-original-title="Ubah">
								<a href="" class="c-green md-trigger" data-modal="pinjam">
									<i class="fa fa-edit"></i>
								</a>
							</span>
						</h2>
					</div>
					<div class="panel-body text-justify p-t-0 withScroll" data-height="400">
						{!! $borrow !!}
					</div>
					<div class="md-modal md-effect-14" id="pinjam">
						<div class="md-content md-content-white">
							<h3>Layanan Peminjaman <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
							<div class="p-10">
								<form method="post" action="{{ action('Admin\HomeController@postService','borrow') }}">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="_id" value="Layanan Peminjaman">
									<div class="form-group">
										<label for="field-2" class="control-label sr-only">Keterangan</label>
										<textarea class="form-control cke-editor" name="borrow" rows="10" value="" placeholder="" autocomplete="off" required>{{ $borrow }}</textarea>
									</div>
									<div class="form-group">
										<button class="btn btn-dark btn-transparent btn-rounded">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="md-overlay"></div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script src="{{ asset('/assets/plugins/bootstrap-fileinput/bootstrap.file-input.js') }}"></script>
	<script src="{{ asset('/assets/plugins/charts-d3/d3.v3.js') }}"></script>
	<script src="{{ asset('/assets/plugins/charts-d3/nv.d3.js') }}"></script>
	<script src="{{ asset('/assets/plugins/xcharts/xcharts.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/daterangepicker/sugar.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('/assets/plugins/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('/assets/plugins/ckeditor/adapters/jquery.js') }}"></script>
	<script>
	$(function(){
		$('input[type="file"]').bootstrapFileInput();
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$('input:text[name="address-1"]').on('change', function(){
			$.ajax({
				url:'{!! route('admin.dashboard.address') !!}',
				type:'POST',
				data:{
					'id' : 1,
					'txt': $('input:text[name="address-1"]').val(),
				},
				cache:false,
				success:function(data){
					console.log('address updated');
				},
			});
		});
		$('input:text[name="address-2"]').on('change', function(){
			$.ajax({
				url:'{!! route('admin.dashboard.address') !!}',
				type:'POST',
				data:{
					'id' : 2,
					'txt': $('input:text[name="address-2"]').val(),
				},
				cache:false,
				success:function(data){
					console.log('address updated');
				},
			});
		});
		$('input:text[name="title"]').val($.trim($('#title').text()));
		$('textarea[name="post"]').val($.trim($('#post').text()));
		$('input[name="_file"]').val($('img#img').attr('alt'));
		// Set the default dates
		var startDate	= Date.create().addDays(-29),	// 30 days ago
				endDate		= Date.create(); 				// today
		var range = $('#range');
		// Show the dates in the range input
		range.val(startDate.format('{MM}/{dd}/{yyyy}') + ' - ' + endDate.format('{MM}/{dd}/{yyyy}'));
		// Load chart
		ajaxLoadChart(startDate,endDate);
		range.daterangepicker({
			opens: 'left',
			startDate: startDate,
			endDate: endDate,
			ranges: {
							'Today': ['today', 'today'],
							'Yesterday': ['yesterday', 'yesterday'],
							'Last 7 Days': [Date.create().addDays(-6), 'today'],
							'Last 30 Days': [Date.create().addDays(-29), 'today']
			}
		},function(start, end){
			ajaxLoadChart(start, end);
		});
		// The tooltip shown over the chart
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
			tickHintX: 9, // How many ticks to show horizontally
			dataFormatX : function(x) {
				// This turns converts the timestamps coming from
				// ajax.php into a proper JavaScript Date object
				return Date.create(x);
			},
			tickFormatX : function(x) {
				// Provide formatting for the x-axis tick labels.
				// This uses sugar's format method of the date object.
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
		// Create a new xChart instance, passing the type
		// of chart a data set and the options object
		var chart = new xChart('line-dotted', data, '#chart' , opts);
		// Function for loading data via AJAX and showing it on the chart
		function ajaxLoadChart(startDate,endDate) {
			// If no data is passed (the chart was cleared)
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
				$('#total').empty();
				return;
			}
			// Otherwise, issue an AJAX request
			$.getJSON("{{ route('admin.dashboard.data') }}", {
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
				$('tbody#data').empty();
				$.each(data, function() {
					$('tbody#data').append(
						'<tr>'+
							'<td class="text-center">'+(++i)+'</td>'+
							'<td class="text-center">'+this.label+'</td>'+
							'<td class="text-center">'+this.value+'</td>'+
						'</tr>'
					);
					total += parseInt(this.value);
				});
				$('#total').empty().append(total);
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
	</script>
@endsection
