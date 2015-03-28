@extends('admin.master.app')

@section('title')
	Koleksi Anggota
@endsection

@section('content')
	<div id="main-content">
		@if(!empty($members))
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading bg-red">
							<h3 class="panel-title"><strong>Koleksi </strong> Anggota</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 m-b-20">
									<div class="btn-group m-b-20">
										<span class="btn btn-default {{ setActiv('admin/member') }}"  onclick="window.location='{{ url('/admin/member') }}'">ALL</span>
										<span class="btn btn-default {{ setActiv('admin/member/Karyawan') }}" onclick="window.location='{{ url('/admin/member/Karyawan') }}'">Karyawan</span>
										<span class="btn btn-default {{ setActiv('admin/member/Non-Karyawan') }}" onclick="window.location='{{ url('/admin/member/Non-Karyawan') }}'">Non-Karyawan</span>
									</div>
									<div class="btn-group pull-right">
										<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i></button>
										<ul class="dropdown-menu pull-right">
											<li><a href="#">Print</a></li>
											<li><a href="#">Save as PDF</a></li>
											<li><a href="#">Export to Excel</a></li>
										</ul>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 table-responsive table-red">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>ID</th>
												<th>Nama</th>
												<th>Jenis Anggota</th>
											</tr>
										</thead>
										<tbody>
											@foreach($members as $member)
												<tr>
													<td>{{ $member->id }}</td>
													<td>{{ $member->nama }}</td>
													<td>{{ $member->jenis_anggota }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 table-red">
									<span class="pull-left">
										<small class="c-red">
											Showing {!! count($members) > 0 ? $members->perPage()*$members->currentPage()-$members->perPage()+1 : 0 !!}
											to {!! $members->perPage()*$members->currentPage() < $members->total() ? $members->perPage()*$members->currentPage() : $members->total() !!}
											of {!! $members->total() !!} entries</small></span>
									<span class="pull-right">{!! $members->render() !!}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
@endsection
