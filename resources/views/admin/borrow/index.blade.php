@extends('admin.master.app')

@section('title')
	Data Peminjaman
@endsection

@section('content')
	<div id="main-content">
		@if(count($borrows) > 0)
			<div class="row">
				<div class="col-md-12">
					@if(Session::has('message')) @include('admin.master.message') @endif
					<div class="panel panel-default">
						<div class="panel-heading bg-red no-print">
							<h3 class="panel-title"><strong>Data </strong> Peminjaman</h3>
							<ul class="pull-right header-menu">
								<li class="dropdown" id="user-header">
									<a href="#" class="dropdown-toggle c-white" data-toggle="dropdown" data-close-others="true">
										<i class="fa fa-cog f-20"></i>
									</a>
										<ul class="dropdown-menu">
											<li>
												<a href="{{ route('admin.borrow.export','print') }}" class="event">
													<i class="fa fa-print fa-fw"></i> Print this page
												</a>
												<a href="{{ route('admin.borrow.export','xls') }}">
													<i class="fa fa-table fa-fw"></i> Export to Excel
												</a>
											</li>
										</ul>
								</li>
							</ul>
						</div>
						<h3 class="text-center visible-print p-t-0 m-t-0 p-b-10">DATA PEMINJAMAN PERPUSTAKAAN INTI</h3>
						<div class="panel-body p-5">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 table-responsive table-red">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th class="text-center">ID</th>
												<th class="text-center">NIS/NIM/NIP</th>
												<th class="text-center">Nama</th>
												<th class="text-center">Kode Buku</th>
												<th class="text-center">Judul Buku</th>
												<th class="text-center">Tanggal Pinjam</th>
												<th class="text-center">Tanggal Kembali</th>
												<th class="text-center">Keterangan</th>
											</tr>
										</thead>
										<tbody>
											@foreach($borrows as $borrow)
												<tr {{ empty($borrow->tanggal_kembali) ? 'class=c-red' : '' }}>
													<td>{{ $borrow->id }}</td>
													<td>{{ $borrow->member->id }}</td>
													<td>{{ $borrow->member->nama }}</td>
													<td>{{ $borrow->book->id }}</td>
													<td>{{ $borrow->book->judul }}</td>
													<td>{{ tanggal($borrow->tanggal_pinjam) }}</td>
													<td>{{ empty($borrow->tanggal_kembali) ? '' : tanggal($borrow->tanggal_kembali) }}</td>
													<td>{{ empty($borrow->tanggal_kembali) ? 'Peminjaman' : 'Pengembalian' }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								<small class="pull-right" style="font-size:smaller;color:gray !important;"><i id="timestamp"></i></small>
								<div class="col-md-12 col-sm-12 col-xs-12 table-red no-print">
									<span class="pull-left">
										<small class="c-red">
											Showing {!! count($borrows) > 0 ? $borrows->perPage()*$borrows->currentPage()-$borrows->perPage()+1 : 0 !!}
											to {!! $borrows->perPage()*$borrows->currentPage() < $borrows->total() ? $borrows->perPage()*$borrows->currentPage() : $borrows->total() !!}
											of {!! $borrows->total() !!} entries
										</small>
									</span>
									<span class="pull-right">{!! isset($_REQUEST['q']) ? strtr($borrows->render(),['^' => '?','?' => '&']) : $borrows->render() !!}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		@else
			<div class="alert alert-warning w-100 m-t-0 m-b-10" role="alert">
				<i class='fa fa-frown-o' style='padding-right:3px'></i>
				<span class="glyphicon glyphicon-exclamation-ok-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				Oops! Data peminjaman tidak ditemukan . . .
			</div>
		@endif
	</div>
@endsection

@section('script')
	<script>
		$(document).ready(function(){
			var search = "{{ isset($_REQUEST['q']) ? $_REQUEST['q'] : '`~`' }}";
			$.extend($.expr[":"], {
				"containsN": function(elem, i, match, array) {
					return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
				}
			});
			$('td:containsN("'+search+'")').each(function(index, value){
				$(this).html(function (i, str) {
					return str.replace(new RegExp("("+search+")",'gi'), "<strong>$1</strong>");
				});
			});
			$('a.event').click(function(){
				var currentdate = new Date();
				$('#timestamp').append("Waktu cetak: "+currentdate.getDate()+"/"+(currentdate.getMonth()+1)+"/"+currentdate.getFullYear()+" "+currentdate.getHours()+":"+currentdate.getMinutes()+":"+currentdate.getSeconds());
				window.print();
				$('#timestamp').empty();
			});
		});
	</script>
@endsection
