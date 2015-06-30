@extends('master.app')

@section('title')
	Dashboard
@endsection

@section('style')
	<link href="{{ asset('/assets/plugins/xcharts/xcharts.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
	<link href="{{ asset('/assets/plugins/magnific/magnific-popup.css') }}" rel="stylesheet">
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
							<div class="col-md-3 col-sm-4 col-xs-12 pull-left">
								<select class="form-control show-menu-arrow flat" name="tipe">
									<option value="1">Anggota</option>
									<option value="3" selected>Buku</option>
									<option value="2">Peminjaman</option>
								</select>
							</div>
							<div class="col-md-3 col-sm-4 col-xs-12 pull-right">
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
									<table class="table table-hover m-b-0">
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
											<img src="{{ asset('/img/slider/slide-.jpg') }}" alt="" width="50" height="40" class="pull-left">
											<div class="media-body">
												<small class="pull-right">
													<span class="m-r-5" data-placement="left" title="" rel="tooltip" data-original-title="Ubah">
														<a href="" class="md-trigger" data-modal="-slider-"><i class="fa fa-edit"></i></a>
													</span>
												</small>
												<h5 class="c-dark"><strong>Slide-Start</strong></h5>
												<h4 class="c-dark">{!! $slidej !!}</h4>
											</div>
										</div>
										{!! $slider !!}
									</div>
									<div class="md-modal md-effect-8" id="-slider-">
										<div class="md-content md-content-white">
											<h3>Slider-Start <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
											<div class="p-b-10 m-t-10">
												<form method="post" action="{{ action('Admin\HomeController@postSlider') }}">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<div class="form-group">
														<label for="field-1" class="control-label">Judul</label>
														<input type="text" name="judul" class="form-control" value="{!! $slidej !!}" placeholder="" autocomplete="off" required />
													</div>
													<div class="form-group">
														<label for="field-2" class="control-label">Keterangan</label>
														<textarea class="form-control" name="keterangan" value="" placeholder="" autocomplete="off" rows="5" maxlength="321" required>{!! $slider !!}</textarea>
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
													<img src="{{ asset('/img/slider/slide-'.(empty($slider->mime) ? '.jpg' : $slider->id.'.'.$slider->mime)) }}" alt="" width="50" height="40" class="pull-left">
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
												{{ $slider->keterangan }}
											</div>
											<div class="md-modal md-effect-8" id="ubah-{{ $slider->id }}">
												<div class="md-content md-content-white">
													<h3>Slide-{{ $i }} <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
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
									<div class="message-item media">
										<div class="media">
											<img src="{{ asset('/img/slider/'.$slider__) }}" alt="" width="50" height="40" class="pull-left">
											<div class="media-body">
												<small class="pull-right">
													<span class="m-r-5" data-placement="left" title="" rel="tooltip" data-original-title="Ubah">
														<a href="" class="md-trigger" data-modal="-slider_-"><i class="fa fa-edit"></i></a>
													</span>
												</small>
												<h5 class="c-dark"><strong>Slide-End</strong></h5>
												<h4 class="c-dark">{!! $slidej_ !!}</h4>
											</div>
										</div>
										{!! $slider_ !!}
									</div>
									<div class="md-modal md-effect-8" id="-slider_-">
										<div class="md-content md-content-white">
											<h3>Slide-End <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
											<div class="p-b-10 m-t-10">
												<form method="post" action="{{ action('Admin\HomeController@postSlider_') }}" enctype="multipart/form-data">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input type="hidden" name="_img" value="{{ $slider__ }}">
													<div class="form-group">
														<label for="field-1" class="control-label">Judul</label>
														<input type="text" name="judul" class="form-control" value="{!! $slidej_ !!}" placeholder="" autocomplete="off" required />
													</div>
													<div class="form-group">
														<label for="field-2" class="control-label">Keterangan</label>
														<textarea class="form-control" name="keterangan" value="" placeholder="" autocomplete="off" rows="5" maxlength="321" required>{!! $slider_ !!}</textarea>
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
											{{ $guest->komentar }}
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
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title w-100">
							Gallery
						</h2>
					</div>
					<div class="panel-body p-t-0">
						@if(count($gallery) > 0)
							<div class="gallery config-open p-t-0">
								<div class="row">
									@foreach($gallery as $galery)
										<div class="mix col-md-2 col-sm-3 col-xs-12" style="display: inline-block;">
											<div class="thumbnail" style="width:144px;height:70px;background: #C7D6E9 none repeat scroll 0% 0%;">
												<div class="overlay">
													<div class="thumbnail-actions">
														<a href="{{ asset('/img/slider-deal/'.$galery) }}" class="btn btn-default btn-icon btn-rounded magnific" title="Lihat"><i class="fa fa-search"></i></a>
														<a href="{{ action('Admin\HomeController@getGallery', [sha1($galery)]) }}" class="btn btn-danger btn-icon btn-rounded" title="Hapus"><i class="fa fa-trash-o"></i></a>
													</div>
												</div>
												<img class="thumbnail" src="{{ asset('/img/slider-deal/'.$galery)}}" style="max-width:100%;max-height:100%;margin:auto;display:block;">
											</div>
										</div>
									@endforeach
								</div>
							</div>
						@endif
						<div class="pull-left" id="gallery">
							<form method="post" action="{{ action('Admin\HomeController@postGallery') }}" enctype="multipart/form-data">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<a class="file-input-wrapper">
									<input type="file" name="file" data-filename-placement="inside" class="btn-transparent">
								</a>
								<button class="btn btn-dark btn-transparent sr-only">Submit</button>
								 <small> *(Best Resolution: 335x163 px)</small>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="md-modal md-effect-3" id="exists" style="width:95%;max-width:95%;">
			<div class="md-content md-content-white">
				<h3><span id="judul"></span> <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
				<div class="p-10 withScroll" data-height="400px">
					<div class="table-responsive">
						<h3 class="text-center visible-print"><u id="rjudul"></u></h3>
						<table class="table table-hover table-vatop">
							<thead></thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
				<div class="p-10">
					<button class="btn btn-dark btn-transparent btn-rounded" id="bprint">Print</button>
				</div>
			</div>
		</div>
		<div class="md-overlay"></div>
	</div>
@endsection

@section('script')
	<script src="{{ asset('/assets/plugins/bootstrap-fileinput/bootstrap.file-input.js') }}"></script>
	<script src="{{ asset('/assets/plugins/jquery-printElement/jquery.printElement.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/charts-d3/d3.v3.js') }}"></script>
	<script src="{{ asset('/assets/plugins/charts-d3/nv.d3.js') }}"></script>
	<script src="{{ asset('/assets/plugins/xcharts/xcharts.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/daterangepicker/sugar.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('/assets/plugins/magnific/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/gallery-mixitup/jquery.mixitup.js') }}"></script>
	<script src="{{ asset('/assets/js/gallery.js') }}"></script>
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
			$.getJSON("{{ action('Admin\HomeController@getData') }}", {
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
		$('#exists a.md-close').click(function(){
			$('#exists').removeClass('md-show');
		});
		$('#gallery input[type="file"]').change(function(){
			if($('#gallery button').hasClass('sr-only'))
				$('#gallery button').removeClass('sr-only');
		});
		$('#bprint').on('click', function(){
			$('#exists table').addClass('table-bordered');
			$('#exists .table-responsive').printElement({
				overrideElementCSS: ['{{ asset('/assets/css/bootstrap.min.css') }}']
			});
			$('#exists table').removeClass('table-bordered');
		});
	});
	function exists(tid,sid){
			$('#exists table > tbody').empty();
			$('#exists #judul').empty().text(Date.create(tid).format('{Weekday}, {dd} {Month} {yyyy}'));
			$.getJSON("{{ action('Admin\HomeController@getDetail') }}", {
				id: tid,
				it: sid
			}, function(data){
				if(sid == 1){
					$('#exists #rjudul').empty().text('Data Anggota Perpustakaan INTI');
					$('#exists table > thead').empty().append('<tr><th>NIP/NIM/NIS</th><th>Nama</th><th>Jenis Kelamin</th><th>Jenis Anggota</th><th>Alamat/Divisi</th><th>Waktu Daftar</th></tr>');
					$.each(data, function(){
						$('#exists table > tbody').append('<tr><td class="text-left">'+this.kode+'</td><td class="text-left">'+this.nama+'</td><td class="text-left">'+this.jkel+'</td><td class="text-left">'+this.jang+'</td><td class="text-left">'+this.alam+'</td><td class="text-left">'+this.wakt+'</td></tr>');
					});
				}else if(sid == 2){
					$('#exists #rjudul').empty().text('Data Peminjaman Perpustakaan INTI');
					$('#exists table > thead').empty().append('<tr><th class="text-center">ID</th><th class="text-center" width="100px" >Waktu Pinjam</th><th class="text-center">NIP/NIM/NIS</th><th class="text-center">Nama</th><th class="text-center" width="79px">Kode Buku</th><th class="text-center" width="385px">Judul Buku</th><th class="text-center" width="100px">Waktu Kembali</th><th class="text-center" width="126px">Keterangan</th></tr>');
					var j = '';
					$.each(data, function(){
						j += '<tr><td class="text-center">'+this.kode+'</td><td class="text-center">'+this.pinj+'</td><td class="text-center">'+this.nipn+'</td><td class="text-center">'+this.nama+'</td><td class="text-center" colspan="4" style="padding:0px" class="nested"><table class="table table-bordered table-hover" style="margin-bottom:0px;"><tbody>'+this.buku+'</tbody></table></td></tr>'
					});
					$('#exists table > tbody').append(j);
				}else{
					$('#exists #rjudul').empty().text('Data Buku Perpustakaan INTI');
					$('#exists table > thead').empty().append('<tr><th>Kode</th><th>Judul</th><th>Pengarang</th><th>Penerbit</th><th>Tahun</th><th>Subyek</th><th>Rak</th><th>Jenis</th></tr>');
					$.each(data, function(){
						$('#exists table > tbody').append('<tr><td class="text-left">'+this.kode+'</td><td class="text-left">'+this.judul+'</td><td class="text-left">'+this.pengarang+'</td><td class="text-left">'+this.penerbit+'</td><td class="text-left">'+this.tahun+'</td><td class="text-left">'+this.subyek+'</td><td class="text-left">'+this.rak+'</td><td class="text-left">'+this.jenis+'</td></tr>');
					});
				}
				$('#exists').addClass('md-show');
			});
		}
		function texists(istart,iend,sid){
			$('#exists table > tbody').empty();
			$('#exists #judul').empty().text(Date.create(istart).format('{dd} {Month} {yyyy}')+' - '+Date.create(iend).format('{dd} {Month} {yyyy}'));
			$.getJSON("{{ action('PublicController@getDetail') }}", {
				start: istart,
				end: iend,
				it: sid
			}, function(data){
				if(sid == 1){
					$('#exists #rjudul').empty().text('Data Anggota Perpustakaan INTI');
					$('#exists table > thead').empty().append('<tr><th>NIP/NIM/NIS</th><th>Nama</th><th>Jenis Kelamin</th><th>Jenis Anggota</th><th>Alamat/Divisi</th></tr>');
					$.each(data, function(){
						$('#exists table > tbody').append('<tr><td class="text-left">'+this.kode+'</td><td class="text-left">'+this.nama+'</td><td class="text-left">'+this.jkel+'</td><td class="text-left">'+this.jang+'</td><td class="text-left">'+this.alam+'</td></tr>');
					});
				}else if(sid == 2){
					$('#exists #rjudul').empty().text('Data Peminjaman Perpustakaan INTI');
					$('#exists table > thead').empty().append('<tr><th class="text-center">ID</th><th class="text-center" width="100px" >Waktu Pinjam</th><th class="text-center">NIP/NIM/NIS</th><th class="text-center">Nama</th><th class="text-center" width="79px">Kode Buku</th><th class="text-center" width="385px">Judul Buku</th><th class="text-center" width="100px">Waktu Kembali</th><th class="text-center" width="126px">Keterangan</th></tr>');
					var j = '';
					$.each(data, function(){
						j += '<tr><td class="text-center">'+this.kode+'</td><td class="text-center">'+this.pinj+'</td><td class="text-center">'+this.nipn+'</td><td class="text-center">'+this.nama+'</td><td class="text-center" colspan="4" style="padding:0px" class="nested"><table class="table table-bordered table-hover" style="margin-bottom:0px;"><tbody>'+this.buku+'</tbody></table></td></tr>'
					});
					$('#exists table > tbody').append(j);
				}else{
					$('#exists #rjudul').empty().text('Data Buku Perpustakaan INTI');
					$('#exists table > thead').empty().append('<tr><th>Kode</th><th>Judul</th><th>Pengarang</th><th>Penerbit</th><th>Tahun</th><th>Subyek</th><th>Rak</th><th>Jenis</th></tr>');
					$.each(data, function(){
						$('#exists table > tbody').append('<tr><td class="text-left">'+this.kode+'</td><td class="text-left">'+this.judul+'</td><td class="text-left">'+this.pengarang+'</td><td class="text-left">'+this.penerbit+'</td><td class="text-left">'+this.tahun+'</td><td class="text-left">'+this.subyek+'</td><td class="text-left">'+this.rak+'</td><td class="text-left">'+this.jenis+'</td></tr>');
					});
				}
				$('#exists').addClass('md-show');
			});
		}
	</script>
@endsection
