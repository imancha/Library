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
						<div class="icon"><i class="fa fa-book"></i></div>
						<div class="row">
							<div class="col-md-12">
								<div class="stat-num">{{ $books }}</div>
								<h3>Total Data Buku</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="panel no-bd bd-9 panel-stat">
					<div class="panel-body bg-blue">
						<div class="icon"><i class="fa fa-align-justify"></i></div>
						<div class="row">
							<div class="col-md-12">
								<div class="stat-num">{{ $asli }}</div>
								<h3>Buku Asli</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="panel no-bd bd-9 panel-stat">
					<div class="panel-body bg-purple">
						<div class="icon"><i class="fa fa-tasks"></i></div>
						<div class="row">
							<div class="col-md-12">
								<div class="stat-num">{{ $pkl }}</div>
								<h3>Buku PKL</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 col-md-6">
				<div class="panel no-bd bd-9 panel-stat">
					<div class="panel-body bg-green">
						<div class="icon"><i class="fa fa-group"></i></div>
						<div class="row">
							<div class="col-md-12">
								<div class="stat-num">{{ $members }}</div>
								<h3>Total Data Anggota</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="panel no-bd bd-9 panel-stat">
					<div class="panel-body bg-red">
						<div class="icon"><i class="fa fa-user-md"></i></div>
						<div class="row">
							<div class="col-md-12">
								<div class="stat-num">{{ $karyawan }}</div>
								<h3>Anggota Karyawan</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="panel no-bd bd-9 panel-stat">
					<div class="panel-body bg-orange">
						<div class="icon"><i class="fa fa-user"></i></div>
						<div class="row">
							<div class="col-md-12">
								<div class="stat-num">{{ $nonkaryawan }}</div>
								<h3>Anggota Non-Karyawan</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 col-md-6">
				<div class="panel no-bd bd-9 panel-stat">
					<div class="panel-body bg-blue">
						<div class="icon"><i class="fa fa-retweet"></i></div>
						<div class="row">
							<div class="col-md-12">
								<div class="stat-num">{{ $borrows }}</div>
								<h3>Total Data Peminjaman</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="panel no-bd bd-9 panel-stat">
					<div class="panel-body bg-purple">
						<div class="icon"><i class="fa fa-sign-out"></i></div>
						<div class="row">
							<div class="col-md-12">
								<div class="stat-num">{{ $pinjam }}</div>
								<h3>Peminjaman</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="panel no-bd bd-9 panel-stat">
					<div class="panel-body bg-green">
						<div class="icon"><i class="fa fa-sign-in"></i></div>
						<div class="row">
							<div class="col-md-12">
								<div class="stat-num">{{ $kembali }}</div>
								<h3>Pengembalian</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
