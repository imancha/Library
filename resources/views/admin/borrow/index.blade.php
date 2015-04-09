@extends('admin.master.app')

@section('title')
	Data Peminjaman
@endsection

@section('content')
	<div id="main-content">
		@if(!empty($borrows))
			<div class="row">
				<div class="col-md-12">
					@if(Session::has('message'))
						<div class="alert alert-success w-100 m-t-0 m-b-10" role="alert">
							<i class='fa fa-check-square-o' style='padding-right:6px'></i>
							<button type="button" class="close" data-dismiss="alert">×</button>
							<span class="glyphicon glyphicon-exclamation-ok-sign" aria-hidden="true"></span>
							<span class="sr-only">Success:</span>
							{{ Session::get('message') }}
						</div>
					@endif
					<div class="panel panel-default">
						<div class="panel-heading bg-red">
							<h3 class="panel-title"><strong>Data </strong> Peminjaman</h3>
							<ul class="pull-right header-menu">
								<li class="dropdown" id="user-header">
									<a href="#" class="dropdown-toggle c-white" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
										<i class="fa fa-cog f-20"></i>
									</a>
										<ul class="dropdown-menu">
											<li>
												<a href="#" class="p-t-0 p-b-0">
													<strong>Filter By:</strong>
												</a>
											</li>
											<li {{ setActiv('admin/borrow') }}>
												<a href="{{ route('admin.borrow.index') }}">
													<i class="glyphicon glyphicon-sort"></i> Semua Peminjaman
												</a>
											</li>
											<li {{ setActiv('admin/borrow/pinjam') }}>
												<a href="{{ route('admin.borrow.show','pinjam') }}">
													<i class="glyphicon glyphicon-sort-by-attributes-alt"></i> Sedang Dipinjam
												</a>
											</li>
											<li {{ setActiv('admin/borrow/kembali') }}>
												<a href="{{ route('admin.borrow.show','kembali') }}">
													<i class="glyphicon glyphicon-sort-by-attributes"></i> Telah Dikembalikan
												</a>
											</li>
											<li class="border-top">
												<a href="{{ route('admin.borrow.export','xlsx') }}">
													<i class="glyphicon glyphicon-file"></i> Export to Excel
												</a>
											</li>
										</ul>
								</li>
							</ul>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 table-responsive table-red">
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th>ID</th>
												<th>NIS/NIM/NIP</th>
												<th>Nama</th>
												<th>Kode Buku</th>
												<th>Tanggal Pinjam</th>
												<th>Tanggal Kembali</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											@foreach($borrows as $borrow)
												<tr>
													<td>{{ $borrow->id }}</td>
													<td>{{ $borrow->member->id }}</td>
													<td>{{ $borrow->member->nama }}</td>
													<td>{{ $borrow->book->id }}</td>
													<td>{{ tanggal($borrow->tanggal_pinjam) }}</td>
													<td>{{ empty($borrow->tanggal_kembali) ? '' : tanggal($borrow->tanggal_kembali) }}</td>
													<td>{{ $borrow->status }}</td>
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
