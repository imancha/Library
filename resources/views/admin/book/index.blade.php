@extends('admin.master.app')

@section('title')
	Data Buku
@endsection

@section('style')
	<link href="{{ asset('/assets/plugins/modal-effects/css/ccomponent.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div id="main-content">
		@if(!empty($books))
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
									<a href="#" class="dropdown-toggle c-white" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
										<i class="fa fa-cog f-20"></i>
									</a>
										<ul class="dropdown-menu">
											<li>
												<a href="#" class="p-t-0 p-b-0">
													<strong>Filter By:</strong>
												</a>
											</li>
											<li {{ setActiv('admin/book') }}>
												<a href="{{ route('admin.book.index') }}">
													<i class="glyphicon glyphicon-sort"></i> Semua Buku
												</a>
											</li>
											<li {{ setActiv('admin/book/pkl') }}>
												<a href="{{ route('admin.book.show','pkl') }}">
													<i class="glyphicon glyphicon-sort-by-attributes-alt"></i> Buku Pkl
												</a>
											</li>
											<li {{ setActiv('admin/book/asli') }}>
												<a href="{{ route('admin.book.show','asli') }}">
													<i class="glyphicon glyphicon-sort-by-attributes"></i> Buku Asli
												</a>
											</li>
											<li class="border-top">
												<a href="{{ route('admin.book.export','xlsx') }}">
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
									<table class="table table-striped table-bordered">
										<thead>
											<tr>
												<th class="text-center">Kode</th>
												<th class="text-center">Judul Buku</th>
												<th class="text-center">Subyek</th>
												<th class="text-center">Rak</th>
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
													<td class="text-center">{{ $book->subject->nama }}</td>
													<td class="text-center">{{ $book->rack->nama }}</td>
													<td class="text-center"><a class="c-blue md-trigger" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Lihat" href="#view-{{ $book->id }}" data-modal="view-{{ $book->id }}"><i class="fa fa-eye"></i></a></td>
													<td class="text-center"><a class="c-orange" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Ubah" href="{{ route('admin.book.edit',$book->id) }}"><i class="fa fa-edit"></i></a></td>
													<td class="text-center"><a class="c-red md-trigger" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Hapus" href="#remove-{{ $book->id }}" data-modal="remove-{{ $book->id }}"><i class="fa fa-trash-o"></i></a></td>
													<td class="text-center sr-only">
														@if(!empty($book->file->book_id))
															<a class="c-green" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Download" href="{{ route('download',$book->file->sha1sum) }}"><i class="fa fa-save"></i></a>
														@else
															<i class="fa fa-save transparent-color"></i>
														@endif
													</td>
												</tr>
												<div class="md-modal md-effect-13" id="view-{{ $book->id }}">
													<div class="md-content">
														<h3 class="c-white">Lihat Buku</h3>
														<div>
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
															<button class="btn btn-default btn-transparent md-close">Close</button>
														</div>
													</div>
												</div>
												<div class="md-modal md-effect-1" id="remove-{{ $book->id }}">
													<div class="md-content md-content-red">
														<h3 class="c-white">Hapus Buku . . . ?</h3>
														<div>
															<form role="form" method="POST" action="{{ action('Admin\BookController@destroy',$book->id) }}">
																<input name="_method" type="hidden" value="DELETE">
																<input type="hidden" name="_token" value="{{ csrf_token() }}">
																<input type="hidden" name="id" value="{{ $book->id }}">
																<input type="hidden" name="judul" value="{{ $book->judul }}">
																<ul>
																	<li><strong>Kode:</strong> {{ $book->id }}</li>
																	<li><strong>Judul:</strong> {{ $book->judul }}</li>
																</ul>
																<p class="m-20 m-t-0">
																	<span class="pull-left">
																		<button type="submit" class="btn btn-default btn-transparent">Hapus</button>
																	</span>
																	<span class="pull-right">
																		<button type="reset" class="btn btn-default btn-transparent md-close">Close</button>
																	</span>
																</p>
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

@section('script')
	<script src="{{ asset('/assets/plugins/modal-effects/js/modernizr.custom.js') }}"></script>
	<script src="{{ asset('/assets/plugins/modal-effects/js/classie.js') }}"></script>
	<script src="{{ asset('/assets/plugins/modal-effects/js/modalEffects.js') }}"></script>
	<!-- for the blur effect -->
	<!-- by @derSchepp https://github.com/Schepp/CSS-Filters-Polyfill -->
	<script>
		// this is important for IEs
		var polyfilter_scriptpath = '{{ asset('/assets/plugins/modal-effects/js/') }}';
	</script>
	<script src="{{ asset('/assets/plugins/modal-effects/js/cssParser.js') }}"></script>
	<script src="{{ asset('/assets/plugins/modal-effects/js/css-filters-polyfill.js') }}"></script>
@endsection
