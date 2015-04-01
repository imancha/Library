@extends('admin.master.app')

@section('title')
	Koleksi Buku
@endsection

@section('content')
	<div id="main-content">
		@if(!empty($books))
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading bg-red">
							<h3 class="panel-title"><strong>Koleksi </strong> Buku</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 m-b-20">
									<div class="btn-group m-b-20">
										<span class="btn btn-default {{ setActiv('admin/book') }}"  onclick="window.location='{{ route('admin.book.index') }}'">ALL</span>
										<span class="btn btn-default {{ setActiv('admin/book/asli') }}" onclick="window.location='{{ route('admin.book.show','asli') }}'">ASLI</span>
										<span class="btn btn-default {{ setActiv('admin/book/pkl') }}" onclick="window.location='{{ route('admin.book.show','pkl') }}'">PKL</span>
									</div>
									<div class="btn-group pull-right">
										<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i></button>
										<ul class="dropdown-menu pull-right">
											<li><a href="#">Print</a></li>
											<li><a href="#">Save as PDF</a></li>
											<li><a href="{{ route('admin.book.export','xlsx') }}">Export to Excel</a></li>
										</ul>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 table-responsive table-red">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>Kode</th>
												<th>Judul Buku</th>
												<th>Pengarang</th>
												<th>Penerbit</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											@foreach($books as $book)
												<?php $authors = [] ?>
												@foreach($book->author as $author)
													<?php $authors[] = $author->nama ?>
												@endforeach
												<tr>
													<td>{{ $book->id }}</td>
													<td>{{ $book->judul }}</td>
													<td>{{ implode(', ',$authors) }}</td>
													<td>{{ $book->publisher->nama }}</td>
													<td class="text-center">
														@if(!empty($book->file->book_id))
															<a class="c-blue" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Download" href="{{ route('download',$book->file->sha1sum) }}"><i class="fa fa-download"></i></a>
														@else
															<i class="fa fa-download"></i>
														@endif
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 table-red">
									<span class="pull-left">
										<small class="c-red">
											Showing {!! count($books) > 0 ? $books->perPage()*$books->currentPage()-$books->perPage()+1 : 0 !!}
											to {!! $books->perPage()*$books->currentPage() < $books->total() ? $books->perPage()*$books->currentPage() : $books->total() !!}
											of {!! $books->total() !!} entries</small></span>
									<span class="pull-right">{!! $books->render() !!}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
@endsection
