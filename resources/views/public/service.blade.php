@extends('public.app')

@section('title')
	Layanan {{ $id }}
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="page-title">
					<h3>Layanan {{ $id }}</h3>
				</div>
			</div>
		</div>
		<div class="s-10"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="panel panel-gray">
					<div class="panel-body">
						{!! $service !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
