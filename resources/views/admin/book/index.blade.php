@extends('admin.master.app')

@section('title')
	Data Buku
@endsection

@section('content')
	<div id="main-content">
		@if(count($books) > 0)
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
							<h3 class="panel-title"><strong>Data </strong> Buku</h3>
							<ul class="pull-right header-menu">
								<li class="dropdown" id="user-header">
									<a href="#" class="dropdown-toggle c-white" data-toggle="dropdown" data-close-others="true">
										<i class="fa fa-cog f-20"></i>
									</a>
										<ul class="dropdown-menu">
											<li>
												<a href="{{ route('admin.book.export','xlsx') }}">
													<i class="glyphicon glyphicon-file"></i> Export to Excel
												</a>
											</li>
										</ul>
								</li>
							</ul>
						</div>
						<div class="panel-body p-5">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 table-responsive table-red">
									<table class="table table-striped table-bordered">
										<thead>
											<tr>
												<th class="text-center">Kode</th>
												<th class="text-center">Judul Buku<span class="pull-right"><a href="#" class="c-dark"><i class="fa fa-angle-down"></i></a></span></th>
												<th class="text-center">Pengarang<span class="pull-right"><a href="#" class="c-dark"><i class="fa fa-angle-down"></i></a></span></th>
												<th class="text-center">Penerbit<span class="pull-right"><a href="#" class="c-dark"><i class="fa fa-angle-down"></i></a></span></th>
												<th width="66px">Edisi<span class="pull-right"><a href="#" class="c-dark"><i class="fa fa-angle-down"></i></a></span></th>
												<th class="text-center">Subyek<span class="pull-right"><a href="#" class="c-dark"><i class="fa fa-angle-down"></i></a></span></th>
												<th width="60px">Rak<span class="pull-right"><a href="#" class="c-dark"><i class="fa fa-angle-down"></i></a></span></th>
												<th width="85px">Status<span class="pull-right"><a href="#" class="c-dark"><i class="fa fa-angle-down"></i></a></span></th>
												<th class="text-center" colspan="3">Actions</th>
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
													<td>{{ $book->edisi }}</td>
													<td>{{ $book->subject->nama }}</td>
													<td>{{ $book->rack->nama }}</td>
													@if($borrowed)
														<td class="c-red">Dipinjam</td>
													@else
														<td>Tersedia</td>
													@endif
													<td><a class="c-blue md-trigger" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Lihat" href="#view-{{ $book->id }}" data-modal="view-{{ $book->id }}"><i class="fa fa-eye"></i></a></td>
													<td><a class="c-orange" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Ubah" href="{{ route('admin.book.edit',$book->id) }}"><i class="fa fa-edit"></i></a></td>
													<td><a class="c-red md-trigger" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Hapus" href="#remove-{{ $book->id }}" data-modal="remove-{{ $book->id }}"><i class="fa fa-trash-o"></i></a></td>
												</tr>
												<div class="md-modal md-effect-13" id="view-{{ $book->id }}">
													<div class="md-content">
														<h3 class="c-white">Lihat Buku<span class="pull-right"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
														<div class="p-b-0 text-left">
															<ul>
																<li><strong>Kode:</strong> {{ $book->id }}</li>
																<li><strong>Judul:</strong> {{ $book->judul }}</li>
																<li><strong>Edisi:</strong> {{$book->edisi }}</li>
																<li><strong>Pengarang:</strong> {{ implode(', ',$authors) }}</li>
																<li><strong>Penerbit:</strong> {{ $book->publisher->nama }}</li>
																<li><strong>Jenis:</strong> {{ $book->jenis }}</li>
																<li><strong>Subyek:</strong> {{ $book->subject->nama }}</li>
																<li><strong>Rak:</strong> {{ $book->rack->nama }}</li>
																<li><strong>Tanggal Masuk:</strong> {{ tanggal($book->tanggal_masuk) }}</li>
																<li><strong>Status:</strong> {{ $borrowed ? 'Dipinjam' : 'Tersedia' }}</li>
															</ul>
														</div>
													</div>
												</div>
												<div class="md-modal md-effect-1" id="remove-{{ $book->id }}">
													<div class="md-content md-content-red">
														<h3 class="c-white">Hapus Buku . . . ?<span class="pull-right"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
														<div class="text-left">
															<form role="form" method="POST" action="{{ action('Admin\BookController@destroy',$book->id) }}">
																<input name="_method" type="hidden" value="DELETE">
																<input type="hidden" name="_token" value="{{ csrf_token() }}">
																<input type="hidden" name="id" value="{{ $book->id }}">
																<input type="hidden" name="judul" value="{{ $book->judul }}">
																<ul>
																	<li><strong>Kode:</strong> {{ $book->id }}</li>
																	<li><strong>Judul:</strong> {{ $book->judul }}</li>
																</ul>
																<button type="submit" class="btn btn-default btn-rounded btn-transparent">Hapus</button>
															</form>
														</div>
													</div>
												</div>
											@endforeach
										</tbody>
									</table>
									<div class="md-overlay"></div><!-- the overlay element -->
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 table-red">
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
		});
	</script>
@endsection
