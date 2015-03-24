@extends('admin.master.app')

@section('title')
	Dashboard
@endsection

@section('content')
	<div id="main-content" class="dashboard">
		<div class="row">
			<div class="col-lg-4 col-md-6">
				<div class="panel no-bd bd-9 panel-stat">
					<div class="panel-body bg-orange">
						<div class="icon"><i class="fa fa-tasks"></i></div>
						<div class="row">
							<div class="col-md-12">
								<div class="stat-num">{{ $books }}</div>
								<h3>Total Koleksi Buku</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="panel no-bd bd-9 panel-stat">
					<div class="panel-body bg-blue">
						<div class="icon"><i class="fa fa-align-right"></i></div>
						<div class="row">
							<div class="col-md-12">
								<div class="stat-num">{{ $asli }}</div>
								<h3>Total Buku Asli</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="panel no-bd bd-9 panel-stat">
					<div class="panel-body bg-purple">
						<div class="icon"><i class="fa fa-print"></i></div>
						<div class="row">
							<div class="col-md-12">
								<div class="stat-num">{{ $pkl }}</div>
								<h3>Total Buku PKL</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
@endsection
