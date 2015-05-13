@extends('admin.master.app')

@section('title')
	Trash Data Buku
@endsection

@section('content')
	<div id="main-content">
		@if(count($result) > 0)
			<div class="row">
				<div class="col-md-12">
				@if(Session::has('message')) @include('admin.master.message') @endif
					<div class="panel panel-default">
						<div class="panel-heading bg-red">
							<h3 class="panel-title"><strong>Trash </strong> Data Buku</h3>
							<ul class="pull-right header-menu sr-only">
								<li class="dropdown" id="user-header">
									<a href="#" class="dropdown-toggle c-white" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
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
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th class="text-center">Kode</th>
												<th class="text-center">Judul Buku</th>
												<th class="text-center">Tanggal Masuk</th>
												<th class="text-center">Waktu Hapus</th>
												<th class="text-center" colspan="3">Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach($result as $book)
												<?php $authors = []; ?>
												@foreach($book->author as $author)
													<?php $authors[] = $author->nama ?>
												@endforeach
												<tr>
													<td>{{ $book->id }}</td>
													<td>{{ $book->judul }}</td>
													<td>{{ tanggal($book->created_at) }}</td>
													<td>{{ $book->deleted_at }}</td>
													<td><a class="c-blue md-trigger" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="View" href="#view-{{ $book->id }}" data-modal="view-{{ $book->id }}"><i class="fa fa-eye"></i></a></td>
													<td><a class="c-orange md-trigger" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Restore" href="#restore-{{ $book->id }}" data-modal="restore-{{ $book->id }}"><i class="fa fa-undo"></i></a></td>
													<td><a class="c-red md-trigger" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Delete" href="#delete-{{ $book->id }}" data-modal="delete-{{ $book->id }}"><i class="fa fa-times"></i></a></td>
												</tr>
												<div class="md-modal md-effect-13" id="view-{{ $book->id }}">
													<div class="md-content">
														<h3 class="c-white">View Buku<span class="pull-right" title="close"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
														<div class="p-b-0 text-left">
															<ul>
																<li><strong>Kode:</strong> {{ $book->id }}</li>
																<li><strong>Judul:</strong> {{ $book->judul }}</li>
																<li><strong>Edisi:</strong> {{$book->edisi }}</li>
																<li><strong>Pengarang:</strong> {{ implode(', ',$authors) }}</li>
																<li><strong>Penerbit:</strong> {{ $book->publisher->nama }}</li>
																<li><strong>Jenis:</strong> {{ strtoupper($book->jenis) }}</li>
																<li><strong>Subyek:</strong> {{ $book->subject->nama }}</li>
																<li><strong>Rak:</strong> {{ $book->rack->nama }}</li>
																<li><strong>Keterangan:</strong> {{ $book->keterangan }}</li>
															</ul>
														</div>
													</div>
												</div>
												<div class="md-modal md-effect-9" id="restore-{{ $book->id }}">
													<div class="md-content md-content-orange">
														<h3 class="c-white">Restore Buku . . . ?<span class="pull-right" title="close"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
														<div class="text-left">
															<form role="form" method="POST" action="{{ route('admin.trash.update','book-'.$book->id) }}">
																<input name="_method" type="hidden" value="PATCH">
																<input type="hidden" name="_token" value="{{ csrf_token() }}">
																<input type="hidden" name="id" value="{{ $book->id }}">
																<input type="hidden" name="judul" value="{{ $book->judul }}">
																<ul>
																	<li><strong>Kode:</strong> {{ $book->id }}</li>
																	<li><strong>Judul:</strong> {{ $book->judul }}</li>
																</ul>
																<button type="submit" class="btn btn-default btn-rounded btn-transparent">Restore</button>
															</form>
														</div>
													</div>
												</div>
												<div class="md-modal md-effect-1" id="delete-{{ $book->id }}">
													<div class="md-content md-content-red">
														<h3 class="c-white">Delete Buku . . . ?<span class="pull-right" title="close"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
														<div class="text-left">
															<form role="form" method="POST" action="{{ route('admin.trash.destroy','book-'.$book->id) }}">
																<input name="_method" type="hidden" value="DELETE">
																<input type="hidden" name="_token" value="{{ csrf_token() }}">
																<input type="hidden" name="id" value="{{ $book->id }}">
																<input type="hidden" name="judul" value="{{ $book->judul }}">
																<ul>
																	<li><strong>Kode:</strong> {{ $book->id }}</li>
																	<li><strong>Judul:</strong> {{ $book->judul }}</li>
																</ul>
																<button type="submit" class="btn btn-default btn-rounded btn-transparent">Delete</button>
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
											Showing {!! count($result) > 0 ? $result->perPage()*$result->currentPage()-$result->perPage()+1 : 0 !!}
											to {!! $result->perPage()*$result->currentPage() < $result->total() ? $result->perPage()*$result->currentPage() : $result->total() !!}
											of {!! $result->total() !!} entries
										</small>
									</span>
									<span class="pull-right">{!! $result->render() !!}</span>
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
				Oops! Trash data buku tidak ditemukan . . .
			</div>
		@endif
	</div>
@endsection
