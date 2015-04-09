<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js sidebar-large lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js sidebar-large lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js sidebar-large lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js sidebar-large"> <!--<![endif]-->

<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
	<!-- BEGIN META SECTION -->
	<meta charset="utf-8">
	<title>Login | Admin Library</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- END META SECTION -->
	<!-- BEGIN MANDATORY STYLE -->
	<link href="{{ asset('/assets/css/icons/icons.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/assets/css/plugins.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/assets/css/style.min.css') }}" rel="stylesheet">
	<!-- END  MANDATORY STYLE -->
	<!-- BEGIN PAGE LEVEL STYLE -->
	<link href="{{ asset('/assets/css/animate-custom.css') }}" rel="stylesheet">
	<!-- END PAGE LEVEL STYLE -->
	<script src="{{ asset('/assets/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
</head>

<body class="login fade-in" data-page="login">
	<!-- BEGIN LOGIN BOX -->
	<div class="container" id="login-block">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
				<div class="login-box clearfix animated flipInY">
					<div class="page-icon animated bounceInDown">
						<img src="{{ asset('/assets/img/account/user-icon.png') }}" alt="Key icon">
					</div>
					<div class="login-logo">
						<img src="" alt="PERPUSTAKAAN PT. INTI">
					</div>
					<hr>
					<div class="login-form">
						@if(count($errors) > 0)
							<!-- BEGIN ERROR BOX -->
							<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<h4>Error!</h4>
								<ul>
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
								</ul>
							</div>
						<!-- END ERROR BOX -->
						@endif
						<form role="form" method="POST" action="{{ url('/auth/login') }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="email" name="email" placeholder="Email" class="input-field form-control user" value="{{ old('email') }}" />
							<input type="password" name="password" placeholder="Password" class="input-field form-control password" />
							<button type="submit" class="btn btn-login">Login</button>
						</form>
						<div class="login-links sr-only">
							<a href="{{ url('/password/email') }}">Forgot password?</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END LOCKSCREEN BOX -->
	<!-- BEGIN MANDATORY SCRIPTS -->
	<script src="{{ asset('/assets/plugins/jquery-1.11.js') }}"></script>
	<script src="{{ asset('/assets/plugins/jquery-migrate-1.2.1.js') }}"></script>
	<script src="{{ asset('/assets/plugins/jquery-ui/jquery-ui-1.10.4.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/bootstrap/bootstrap.min.js') }}"></script>
	<!-- END MANDATORY SCRIPTS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="{{ asset('/assets/plugins/backstretch/backstretch.min.js') }}"></script>
	<script src="{{ asset('/assets/js/account.js') }}"></script>
	<!-- END PAGE LEVEL SCRIPTS -->
</body>
</html>
