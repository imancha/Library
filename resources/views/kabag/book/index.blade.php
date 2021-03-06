@extends('master.app')

@section('title')
	Data Buku
@endsection

@section('content')
	<div id="main-content">
		@if(count($books) > 0)
			<div class="row">
				<div class="col-md-12">
					<div class="panel-default">
						<div class="panel-heading bg-red hidden-print">
							<h3 class="panel-title"><strong>Data </strong> Buku</h3>
							<ul class="pull-right header-menu">
								<li class="dropdown" id="user-header">
									<a href="#" class="dropdown-toggle c-white" data-toggle="dropdown" data-close-others="true">
										<i class="fa fa-cog f-20"></i>
									</a>
										<ul class="dropdown-menu">
											<li>
												<a href="{{ url('admin/book/print') }}" class="event">
													<i class="fa fa-print fa-fw"></i> Print this page
												</a>
												<a href="{{ action('Admin\BookController@export', ['xls']) }}">
													<i class="fa fa-table fa-fw"></i> Export to Excel
												</a>
											</li>
										</ul>
								</li>
							</ul>
						</div>
						<h3 class="text-center visible-print p-t-0 m-t-0 p-b-10">DATA BUKU PERPUSTAKAAN INTI</h3>
						<div class="panel-body p-5">
							<div class="row m-b-10 m-t-5">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<form method="get" action="{{ action('Admin\BookController@index') }}">
										<div class="input-group">
											<input class="form-control" type="text" name="q" placeholder="Search..." value="{{ isset($_REQUEST['q']) ? $_REQUEST['q'] : '' }}">
											<div class="input-group-btn">
												<button class="btn btn-default" title="Search" style="padding:6.5px 24px;"><i class="fa fa-search"></i></button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 table-responsive table-red">
									<table class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th class="text-center">Kode</th>
												<th class="text-center">Judul Buku</th>
												<th class="text-center">Pengarang</th>
												<th class="text-center">Penerbit</th>
												<th class="text-center">Tahun</th>
												<th class="text-center">Subyek</th>
												<th class="text-center">Rak</th>
												<th class="text-center">Jenis</th>
												<th class="text-center">Tanggal Masuk</th>
												<th class="text-center no-print"><i class="fa fa-download"></i></th>
											</tr>
										</thead>
										<tbody>
											@foreach($books as $book)
												<?php $authors = []; $borrowed = false; ?>
												@foreach($book->author as $author)
													<?php $authors[] = $author->nama ?>
												@endforeach
												@foreach($borrows as $borrow)
													@if($borrow->book_id == $book->id)
														<?php $borrowed = true ?>
													@endif
												@endforeach
												<tr>
													<td>{{ $book->id }}</td>
													<td>{{ $book->judul }}</td>
													<td>{{ implode(', ',$authors) }}</td>
													<td>{{ $book->publisher->nama }}</td>
													<td>{{ $book->tahun }}</td>
													<td>{{ $book->subject->nama }}</td>
													<td>{{ $book->rack->nama }}</td>
													<td>{{ strtoupper($book->jenis) }}</td>
													<td>{{ tanggal($book->tanggal_masuk) }}</td>
													<td class="no-print">
														@if(!empty($book->file->book_id) AND file_exists(public_path('files/'.$book->id.' - '.$book->judul.'.'.$book->file->mime)))
															<a class="c-green" href="{{ action('PublicController@getDownload', $book->file->sha1sum) }}" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="{{ $book->file->size }}"><i class="fa fa-download"></i></a>
														@else
															<i class="fa fa-download c-gray ch-disabled"></i>
														@endif
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
									<small class="pull-right" style="font-size:smaller;color:gray !important;"><i id="timestamp"></i></small>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 table-red no-print">
									<span class="pull-left">
										<small class="c-red">
											Showing {!! count($books) > 0 ? $books->perPage()*$books->currentPage()-$books->perPage()+1 : 0 !!}
											to {!! $books->perPage()*$books->currentPage() < $books->total() ? $books->perPage()*$books->currentPage() : $books->total() !!}
											of {!! $books->total() !!} entries
										</small>
									</span>
									<span class="pull-right">{!! isset($_REQUEST['q']) ? strtr($books->render(),['^' => '?','?' => '&']) : $books->render() !!}</span>
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
				Oops! Data buku tidak ditemukan . . .
			</div>
		@endif
	</div>
@endsection

@section('script')
	<script>
		$(document).ready(function(){
			@if(isset($_REQUEST['q']))
				var search = "{{ $_REQUEST['q'] }}";
				$.extend($.expr[":"], {
					"containsN": function(elem, i, match, array) {
						return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
					}
				});
				$('td:containsN("'+search+'")').each(function(index, value){
					$(this).html(function (i, str) {
						return str.replace(new RegExp("("+search+")",'gi'), "<span style='background:#E5E5E5;border-radius:10%;'>$1</span>");
					});
				});
			@endif
			$('a.event').click(function(e){
				e.preventDefault();
				e.stopPropagation();
				var currentdate = new Date();
				$('#timestamp').append("Waktu cetak: "+currentdate.getDate()+"/"+(currentdate.getMonth()+1)+"/"+currentdate.getFullYear()+" "+currentdate.getHours()+":"+currentdate.getMinutes()+":"+currentdate.getSeconds());
				window.print();
				$('#timestamp').empty();
			});
		});
	</script>
@endsection
