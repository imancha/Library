<!DOCTYPE html>
<html class="no-js">
  <head>
		<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('/favicon.ico.png') }}">

    <title>@yield('title') - Perpustakaan INTI</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    @yield('style')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="{{ asset('/plugins/modernizr/modernizr-latest.js') }}"></script>
  </head>

  <body>
		<header>
			<div class="container hidden-xs">
				<div class="row clearfix">
					<div class="col-md-12">
						<div class="top">
							<ul class="nav nav-pills">
								<li class="date"></li>
								<li class="and">بِسْمِ اللهِ الرَّحْمنِ الرَّحِيْمِ</li>
								<li class="time"></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="container hidden-xs">
				<div class="row">
					<div class="col-md-12">
						<div class="logo">
							<div class="row clearfix">
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="logoimage">
										<img class="img img-responsive" src="{{ asset('/img/logo.png') }}">
									</div>
								</div>
								<div class="col-md-4 col-sm-4">
									<div class="logotext">
										PERPUSTAKAAN
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12 pull-right">
									<div id="sb-search" class="sb-search">
										<form action="{{ route('book') }}" method="get" role="form">
											<input class="sb-search-input" placeholder="Search..." type="search" value="" name="q" id="search">
											<input class="sb-search-submit" type="submit" value="">
											<span class="sb-icon-search" title="Search"></span>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<nav class="navbar navbar-primary">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand visible-xs" href="{{ route('home') }}">PERPUSTAKAAN INTI</a>
						</div>
						<div id="navbar" class="navbar-collapse collapse">
							<ul class="nav navbar-nav">
								<li class="{{ setActiv('/') }}"><a href="{{ route('home') }}"><i class="fa fa-home fa-fw"></i> Beranda</a></li>
								<li class="{{ setActiv('book') }}"><a href="{{ route('book') }}"><i class="fa fa-book fa-fw"></i> Koleksi Buku</a></li>
								<li class="{{ setActiv('book/original') }}"><a href="{{ route('book','original') }}"><i class="fa fa-tasks fa-fw"></i> Buku Asli</a></li>
								<li class="{{ setActiv('book/research') }}"><a href="{{ route('book','research') }}"><i class="fa fa-graduation-cap fa-fw"></i> Buku PKL</a></li>
								<li class="{{ setActiv('guest') }}"><a href="{{ route('guest') }}"><i class="fa fa-comments fa-fw"></i> Buku Tamu</a></li>
							</ul>
						</div><!--/.nav-collapse -->
					</div><!--/.container-fluid -->
				</nav>
			</div>
		</header>
		<div class="visible-xs">
			<div class="container">
				<form action="{{ route('book') }}" method="get" role="form">
					<div class="input-group searchbox">
						<input class="form-control" type="text" name="q" placeholder="Search...">
						<span class="input-group-addon">
							<button type="submit"><i class="fa fa-search fa-flip-horizontal"></i></button>
						</span>
					</div>
				</form>
			</div>
		</div>
		<div class="hidden-xs s-10"></div>
		<section class="content">
			@yield('content')
		</section>
		<div class="s-20"></div>
		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-6 col-md-push-6 text-right">
						<h5><strong>PERPUSTAKAAN INTI</strong></h5>
						{{ address(1) }}<br>{{ address(2) }}
					</div>
					<div class="col-xs-12 col-md-6 col-md-pull-6 pt-10">
						<div class="text-right-xs pb-5">Copyright &copy; 2015 by Imancha - All rights reserved</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('/plugins/jquery-2.1.3/jquery-2.1.3.min.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap-3.3.4/bootstrap.min.js') }}"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{{ asset('/plugins/bootstrap-3.3.4/ie10-viewport-bug-workaround.js') }}"></script>
    <script src="{{ asset('/plugins/nprogress/nprogress.js') }}"></script>
    <script src="{{ asset('/plugins/expanding-search/js/classie.js') }}"></script>
		<script src="{{ asset('/plugins/expanding-search/js/uisearch.js') }}"></script>
    @yield('script')
    <script>
			$(function(){
				(function search(){
					new UISearch(document.getElementById( 'sb-search' ));
				})();
				NProgress.configure({
					showSpinner: true
				}).start();
				setTimeout(function () {
					NProgress.done();
					$('.fade').removeClass('out');
				}, 1000);
				$(".dropdown").hover(
					function() {
						$('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
						$(this).toggleClass('open');
					},
					function() {
						$('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
						$(this).toggleClass('open');
					}
				);
				$('button[type="submit"]').on('click', function(e){
					if($('input[name="q"]').val() != '')
						$('input[name="q"]').val($('input[name="q"]').val().replace(/(<([^>]+)>)/ig,""));
				});
				(function dates(){
					date = new Date;
					year = date.getFullYear();
					month = date.getMonth();
					d = date.getDate();
					day = date.getDay();
					months = new Array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
					days = new Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
					$('.date').text(days[day]+', '+d+' '+months[month]+' '+year);
				})();
				(function times(){
					date = new Date;
					h = date.getHours();
					m = date.getMinutes();
					s = date.getSeconds();
					t = h >= 12 ? 'PM' : 'AM';
					h = h > 12 ? Math.abs(h-12) : h;
					if(h<10){h = "0"+h;}
					if(m<10){m = "0"+m;}
					if(s<10){s = "0"+s;}
					$('.time').text(h+':'+m+':'+s+' '+t);
					setTimeout(times,1000);
				})();
			});
    </script>
  </body>
</html>
