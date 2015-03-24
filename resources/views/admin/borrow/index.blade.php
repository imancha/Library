@extends('admin.master.app')

@section('title')
	Koleksi Peminjaman
@endsection

@section('content')
	<div id="main-content">
		@if(!empty($borrows))
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading bg-red">
							<h3 class="panel-title"><strong>Koleksi </strong> Peminjaman</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 m-b-20">
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
											</tr>
										</thead>
										<tbody>
											@foreach($borrows as $borrow)
												<tr>
													<td>{{ $borrow->id }}</td>
													<td>{{ $borrow->member->nama }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 table-red">
									<span class="pull-left">
										<small class="c-red">
											Showing {!! count($borrows) > 0 ? $borrows->perPage()*$borrows->currentPage()-$borrows->perPage()+1 : 0 !!}
											to {!! $borrows->perPage()*$borrows->currentPage() < $borrows->total() ? $borrows->perPage()*$borrows->currentPage() : $borrows->total() !!}
											of {!! $borrows->total() !!} entries</small></span>
									<span class="pull-right">{!! $borrows->render() !!}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
@endsection
