@extends('app')

@section('title')
	Beranda
@endsection

@section('style')
	<link href="{{ asset('/css/iview.css') }}" rel="stylesheet">
	<link href="{{ asset('/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-sm-8 col-xs-12">
				<div class="slider">
          <div id="iview">
            <!-- Slide 1 -->
            <div data-iview:image="{{ asset('/img/slide0.jpg') }}">
              <div class="iview-caption metro-box1 orange" data-transition="wipeUp" data-x="94" data-y="209"> <a href="{{ route('book','asli') }}">
                <div class="box-hover"></div>
                <i class="fa fa-tasks fa-fw"></i> <span>Buku Asli</span></a> </div>
              <div class="iview-caption metro-box1 blue" data-transition="wipeUp" data-x="266" data-y="209"> <a href="{{ route('book','pkl') }}">
                <div class="box-hover"></div>
                <i class="fa fa-university fa-fw"></i> <span>Buku PKL</span></a> </div>
              <div class="iview-caption metro-box2" data-transition="expandLeft" data-x="438" data-y="209">
                <div class="monthlydeals">
                  <div class="monthly-deals slide" id="monthly-deals">
                    <div class="carousel-inner">
                      <div class="item active"> <img alt="" src="{{ asset('/img/slider-deal1.jpg') }}"> </div>
                      <div class="item"> <img alt="" src="{{ asset('/img/slider-deal2.jpg') }}"> </div>
                    </div>
                  </div>
                  <a class="left carousel-control" data-slide="prev" href="#monthly-deals"> <i class="fa fa-angle-left fa-fw"></i> </a> <a class="right carousel-control" data-slide="next" href="#monthly-deals"> <i class="fa fa-angle-right fa-fw"></i> </a> </div>
                <!--  <span>Deals of the month</span> -->
              </div>
              <div class="iview-caption metro-box1 purple" data-transition="wipeDown" data-x="438" data-y="37"> <a href="{{ route('book') }}">
                <div class="box-hover"></div>
                <i class="fa fa-book fa-fw"></i> <span>Koleksi Buku</span></a> </div>
              <div class="iview-caption metro-box1 dark-blue" data-transition="wipeDown" data-x="610" data-y="37"> <a href="{{ route('book') }}">
                <div class="box-hover"></div>
                <i class="fa fa-book fa-fw"></i> <span>Koleksi Buku</span></a> </div>
              <div class="iview-caption metro-heading" data-transition="expandLeft" data-x="95" data-y="40">
                <h1>PERPUSTAKAAN INTI</h1>
              </div>
              <div class="iview-caption metro-heading" data-transition="wipeLeft" data-x="95" data-y="100">
								<span class="text-larger">Memiliki sekitar {{ $book }} koleksi buku yang terdiri dari buku referensi, pengetahuan umum, ensiklopedia dan laporan hasil penelitian yang dilakukan di<br>PT. INTI (Persero)</span>
							</div>
            </div>
            <!-- Slide 1 -->
            <div data-iview:image="{{ asset('/img/slide0.jpg') }}">
              <div class="iview-caption caption2" data-easing="easeInOutElastic" data-transition="wipeLeft" data-x="100" data-y="140">Buka Setiap Hari</div>
              <div class="iview-caption caption3" data-easing="easeInOutElastic" data-transition="wipeLeft" data-x="100" data-y="200">Mulai jam 07.00 sampai jam 17.00 WIB</div>
            </div>
            <!-- Slide 2 -->
            <div data-iview:image="{{ asset('/img/slide0.jpg') }}">
              <div class="iview-caption caption3 btm-bar" data-height="107px" data-transition="expandRight" data-width="867px" data-x="0" data-y="300">
                <h1><b>Perpustakaan INTI</b></h1>
                Gedung GKP Lantai 2<br>
                Jl. Moh. Toha No. 77 Bandung
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-4 col-xs-12 box">
				<div class="visible-xs s-20"></div>
				<div class="box-heading">
					<span>Buku Terbaru</span>
				</div>
				<div class="box-content">
					<div class="panel-group">
						<div class="panel panel-default">
							<div class="panel-body recent">
								<ul>
									@foreach($books as $book)
										<li class="item"><a href="#">{{ $book->judul }}</a></li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</div>
      </div>
    </div>
	</div>
@endsection

@section('script')
	<script src="{{ asset('/plugins/iview/raphael-min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('/plugins/iview/jquery.easing.js') }}" type="text/javascript"></script>
	<script src="{{ asset('/plugins/iview/iview.js') }}" type="text/javascript"></script>
	<script src="{{ asset('/plugins/iview/retina-1.1.0.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
	<script>
		(function($) {
			"use strict";
			$('#iview').iView({
				pauseTime: 12345,
				pauseOnHover: true,
				directionNavHoverOpacity: 0.6,
				timer: "360Bar",
				timerBg: '#2da5da',
				timerColor: '#fff',
				timerOpacity: 0.9,
				timerDiameter: 20,
				timerPadding: 1,
				touchNav: true,
				timerStroke: 2,
				timerBarStrokeColor: '#fff'
			});
			$('#monthly-deals').carousel({
				interval: 3000
			});
			$('.recent').mCustomScrollbar({
				theme:"minimal-dark",
				autoExpandScrollbar: true
			});
		})(jQuery);
	</script>
@endsection
