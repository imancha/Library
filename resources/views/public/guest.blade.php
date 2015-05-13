@extends('public.app')

@section('title')
	Buku Tamu
@endsection

@section('style')
	<link href="{{ asset('/plugins/metrojs/MetroJs.min.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="container">
		@if(Session::has('message'))
			<div class="alert alert-info flat" role="alert">
				<i class='fa fa-smile-o' style='padding-right:3px'></i>
				<span class="sr-only">Success:</span>
				{{ Session::get('message') }}
			</div>
		@endif
		<div class="row">
			<div class="col-md-12 col-sm-12 cl-xs-12">
				<div class="page-title">
					<h3>Buku Tamu</h3>
				</div>
			</div>
		</div>
		<div class="s-10"></div>
		<div class="row">
			<div class="col-md-8 col-sm-8 col-xs-12">
				<div class="guest">
					<form method="post" action="{{ action('PublicController@guestBook') }}" role="form">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="control-label">Nama</label>
							<input type="text" name="nama" class="flat form-control" value="{{ old('nama') }}" title="" autocomplete="off" required autofocus />
						</div>
						<div class="form-group">
							<label class="control-label">Email</label>
							<input type="email" name="email" class="flat form-control" value="{{ old('email') }}" title="" autocomplete="off" />
						</div>
						<div class="form-group">
							<label class="control-label">Komentar</label>
							<textarea class="flat form-control" name="komentar" rows="5" title="" autocomplete="off" required></textarea>
						</div>
						<div class="form-group text-right">
							<button class="btn btn-default flat" type="reset">Clear</button>
							<button class="btn btn-primary flat" type="submit">Submit</button>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="live-tile tile-guest" data-mode="carousel" data-bounce="true">
					@if(count($guests) > 0)
						@foreach($guests as $guest)
							<div class="guest-tile {{ $guest->id % 2 == 0 ? 'bg-blue' : 'bg-green' }}">
								<div class="tile-item">
									<sup><i class="fa fa-quote-right fa-flip-horizontal"></i></sup> {{ $guest->komentar }} <sup><i class="fa fa-quote-right"></i></sup>
									<span class="tile-title">{{ $guest->nama }}</span>
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script src="{{ asset('/plugins/metrojs/MetroJs.min.js') }}"></script>
	<script>
		$(document).ready(function(){
			function getRandomOptions(){
				var doIt = Math.floor(Math.random() * 1001) % 2 == 0;
				return{
					index: "next",
					delay: 4321,
					animationDirection: doIt ? 'forward' : 'backward',
					direction: doIt ? 'vertical' : 'horizontal'
				};
			}
			$(".live-tile").liveTile({
				animationComplete: function(tileData){
					$(this).liveTile("goto", getRandomOptions());
				}
			}).liveTile("goto", getRandomOptions());
		});
	</script>
@endsection
