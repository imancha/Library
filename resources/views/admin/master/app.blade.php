<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js sidebar-large lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js sidebar-large lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js sidebar-large lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js sidebar-large"> <!--<![endif]-->

<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
	<!-- BEGIN META SECTION -->
	<meta charset="utf-8">
	<title>@yield('title') - Admin Perpustakaan INTI</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- END META SECTION -->
	<!-- BEGIN MANDATORY STYLE -->
	<link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">
	<!-- END  MANDATORY STYLE -->
	<!-- BEGIN PAGE LEVEL STYLE -->
	@yield('style')
	<!-- END PAGE LEVEL STYLE -->
	<script src="{{ asset('/assets/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
</head>

<body>
	<!-- BEGIN TOP MENU -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#sidebar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a id="menu-medium" class="sidebar-toggle tooltips">
					<i class="fa fa-outdent"></i>
				</a>
				<a class="navbar-brand" href="{{ route('admin.dashboard') }}">
					<img src="{{ asset('/assets/img/logo.png') }}" alt="INTI" width="70" height="26">
				</a>
			</div>
			<div class="navbar-center"><strong>PERPUSTAKAAN INTI</strong></div>
			<div class="navbar-collapse collapse">
				<!-- BEGIN TOP NAVIGATION MENU -->
				<ul class="nav navbar-nav pull-right header-menu">
					<!-- BEGIN USER DROPDOWN -->
					<li class="dropdown" id="user-header">
						<a href="#" class="dropdown-toggle c-white" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
							<span class="username">{{ Auth::user()->name }}</span>
							<i class="fa fa-angle-down p-r-10"></i>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="{{ url('admin/account') }}" class="md-trigger" data-modal="account" title="Account">
									<i class="glyph-icon flaticon-account"></i>Account
								</a>
							</li>
							<li>
								<a href="{{ url('admin/fullscreen') }}" class="toggle_fullscreen" title="Fullscreen">
									<i class="glyph-icon flaticon-fullscreen3 fa-fw"></i> Fullscreen
								</a>
							</li>
							<li>
								<a href="{{ action('Admin\UserController@getLogout') }}" title="Logout">
									<i class="fa fa-power-off fa-fw"></i> Logout
								</a>
							</li>
						</ul>
					</li>
					<!-- END USER DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU -->
			</div>
		</div>
	</nav>
	<!-- END TOP MENU -->
	<!-- BEGIN WRAPPER -->
	<div id="wrapper">
		@include('admin.master.sidebar')
		@include('admin.master.message')
		<!-- BEGIN MAIN CONTENT -->
		@yield('content')
		<!-- END MAIN CONTENT -->
		@include('admin.master.search')
	</div>
	<!-- END WRAPPER -->
	<!-- BEGIN MANDATORY SCRIPTS -->
	<script src="{{ asset('/assets/plugins/jquery-1.11.js') }}"></script>
	<script src="{{ asset('/assets/plugins/jquery-migrate-1.2.1.js') }}"></script>
	<script src="{{ asset('/assets/plugins/jquery-ui/jquery-ui-1.10.4.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/bootstrap/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/bootstrap-dropdown/bootstrap-hover-dropdown.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
	<script src="{{ asset('/assets/plugins/icheck/icheck.js') }}"></script>
	<script src="{{ asset('/assets/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/mmenu/js/jquery.mmenu.min.all.js') }}"></script>
	<script src="{{ asset('/assets/plugins/nprogress/nprogress.js') }}"></script>
	<script src="{{ asset('/assets/plugins/charts-sparkline/sparkline.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/breakpoints/breakpoints.js') }}"></script>
	<script src="{{ asset('/assets/plugins/numerator/jquery-numerator.js') }}"></script>
	<script src="{{ asset('/assets/plugins/modal-effects/js/modernizr.custom.js') }}"></script>
	<script src="{{ asset('/assets/plugins/modal-effects/js/classie.js') }}"></script>
	<script src="{{ asset('/assets/plugins/modal-effects/js/modalEffects.js') }}"></script>
	<!-- for the blur effect -->
	<!-- by @derSchepp https://github.com/Schepp/CSS-Filters-Polyfill -->
	<script>
		// this is important for IEs
		var polyfilter_scriptpath = '{{ asset('/assets/plugins/modal-effects/js/') }}';
	</script>
	<script src="{{ asset('/assets/plugins/modal-effects/js/cssParser.js') }}"></script>
	<script src="{{ asset('/assets/plugins/modal-effects/js/css-filters-polyfill.js') }}"></script>
	<!-- END MANDATORY SCRIPTS -->
	@yield('script')
	<script src="{{ asset('/assets/js/application.js') }}"></script>
	<script>
		$(document).ready(function(){
			$('a.md-trigger, a.md-close, a.toggle_fullscreen').on('click', function(e){
				e.preventDefault();
				e.stopPropagation();
			});
			$('#account #ubah').on('click', function(e){
				e.preventDefault();
				$('#account input[name="name"]').prop('disabled', false).focus();
				$('#account input[name="email"]').prop('disabled', false);
				$('#account input[name="password"]').parent().removeClass('sr-only');
				$('#account input[name="new"]').parent().removeClass('sr-only');
				$('#account #ubah').addClass('sr-only');
				$('#account #submit').removeClass('sr-only');
			});
			$('#account .md-close').on('click', function(e){
				$('#account input[name="name"]').prop('disabled', true);
				$('#account input[name="email"]').prop('disabled', true);
				$('#account input[name="password"]').parent().addClass('sr-only');
				$('#account input[name="new"]').parent().addClass('sr-only');
				$('#account #ubah').removeClass('sr-only');
				$('#account #submit').addClass('sr-only');
			});
		});
	</script>
</body>
</html>
