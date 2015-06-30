@extends('public.app')

@section('title')
	{{ $title }}
@endsection

@section('style')
	<link href="{{ asset('/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 cl-xs-12">
				<div class="page-title">
					<h3>{{ $title }}</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="s-10"></div>
	@if(count($books) > 0)
		@if(count($subjects) > 0)
			<div class="container no-print">
				<div class="row">
					<div class="col-md-12">
						<div class="bg-dark p-10">
							<h3 class="mt-0">SUBYEK <span class="pull-right text-smaller i-click" rel="tooltip" data-placement="left" data-original-title="collapse" title=""><i class="fa fa-angle-double-down"></i></span></h3>
							<ul class="subject">
								@foreach($subjects as $subject)
									<li><a class="text-white{{ strtolower($title) == strtolower($subject->nama) ? ' text-strong text-larger' : '' }}" href="{{ route('book',strtolower(str_replace(' ','+',$subject->nama))) }}">{{ $subject->nama }} <sup><span class="badge badge-rounded text-smaller">{{ count($subject->book) }}</span></sup></a></li>
								@endforeach
							</ul>
							<span class="i-click text-larger sr-only" style="position: absolute; bottom: 2px; right: 25px;" rel="tooltip" data-placement="left" data-original-title="collapse" title=""><i class="fa fa-angle-double-up"></i></span>
						</div>
					</div>
				</div>
			</div>
		@endif
		<div class="s-20"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="bg-light-gray p-10">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Kode</th>
										<th>Judul Buku</th>
										<th>Pengarang</th>
										<th>Penerbit</th>
										<th>Tahun</th>
										<th>Subyek</th>
										<th>Rak</th>
										<th><i class="fa fa-download"></i></th>
									</tr>
								</thead>
								<tbody>
								@foreach($books as $book)
									<?php $authors = []; $borrowed = false; $nama=$waktu=$alamat=''; ?>
									@foreach($book->author as $author)
										<?php $authors[] = $author->nama ?>
									@endforeach
									@foreach($borrows as $borrow)
										@if($borrow->book_id == $book->id)
											<?php
												$borrowed = true;
												$nama = $borrow->member->nama;
												$alamat = $borrow->member->alamat;
												$waktu = $borrow->waktu_pinjam;
												break;
											?>
										@endif
									@endforeach
									<tr id="{{ $book->id }}"{{ $borrowed ? ' class=text-red' : '' }}>
										<td class="nested">
											@if($borrowed)
												<a href="javascript:;" class="text-red underline" data-target="#view-{{ $book->id }}" data-toggle="modal">{{ $book->id }}</a>
												<div class="modal fade" id="view-{{ $book->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content flat">
															<div class="modal-body table-responsive">
																<table class="table table-striped text-black">
																	<thead><tr><th colspan="3" class="text-center">DATA PEMINJAMAN</th></tr>
																	</thead>
																	<tbody>
																		<tr><td><strong>Kode Buku</strong></td><td> : </td><td> {{ $book->id }}</td></tr>
																		<tr><td><strong>Judul Buku</strong></td><td> : </td><td> {{ $book->judul }}</td></tr>
																		<tr><td><strong>Nama Peminjam</strong></td><td> : </td><td> {{ $nama }}</td></tr>
																		<tr><td><strong>Alamat/Divisi</strong></td><td> : </td><td> {{ $alamat }}</td></tr>
																		<tr><td><strong>Waktu Pinjam</strong></td><td> : </td><td> {{ tanggal($waktu) }}</td></tr>
																	</tbody>
																</table>
																<button type="button" class="btn btn-danger pull-left flat" style="letter-spacing:3px">DIPINJAM</button>
																<button type="button" class="btn btn-default pull-right flat" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</div>
											@else
												{{ $book->id }}
											@endif
										</td>
										<td>{{ $book->judul }}</td>
										<td>{{ implode(', ',$authors) }}</td>
										<td>{{ $book->publisher->nama }}</td>
										<td>{{ $book->tahun }}</td>
										<td>{{ $book->subject->nama }}</td>
										<td>{{ $book->rack->nama }}</td>
										<td>
											@if(!empty($book->file->book_id) AND file_exists(public_path('files/'.$book->id.' - '.$book->judul.'.'.$book->file->mime)))
												<a href="{{ route('book.download',$book->file->sha1sum) }}" data-placement="bottom" data-toggle="tooltip" rel="tooltip" data-original-title="{{ $book->file->size }}">
													@if($book->file->mime == 'pdf') <i class="fa fa-file-pdf-o"></i>
													@elseif($book->file->mime == 'doc' || $book->file->mime == 'docx') <i class="fa fa-file-word-o"></i>
													@elseif($book->file->mime == 'ppt' || $book->file->mime == 'pptx') <i class="fa fa-file-powerpoint-o"></i>
													@elseif($book->file->mime == 'rar' || $book->file->mime == 'zip') <i class="fa fa-file-archive-o"></i>
													@else <i class="fa fa-file-o"></i>
													@endif
												</a>
											@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
							<hr>
						</div>
						<div class="row clearfix no-print">
							<div class="col-md-12">
								<span class="pull-left">
									<small class="text-muted">
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
	@else
		<div class="container">
			<div class="alert alert-warning flat" role="alert">
				<i class='fa fa-exclamation-circle' style='padding-right:6px'></i>
				<span class="sr-only">Error:</span>
				Data buku tidak ditemukan.
			</div>
		</div>
	@endif
@endsection

@section('script')
	<script src="{{ asset('/plugins/jquery.columnizer/jquery.columnizer.min.js') }}"></script>
	<script src="{{ asset('/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
	<script>
		$(function(){
			$('.subject').columnize();
			$('.subject').mCustomScrollbar({
				theme:"light-2",
				autoExpandScrollbar:true
			});
			$('[rel="tooltip"]').tooltip();
			var search = "{{ isset($_REQUEST['q']) ? $_REQUEST['q'] : '`~`' }}";
			$.extend($.expr[":"], {
				"containsN": function(elem, i, match, array) {
					return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
				}
			});
			$('td:containsN("'+search+'")').not('.nested').each(function(index, value){
				$(this).html(function (i, str) {
					return str.replace(new RegExp("("+search+")",'gi'), "<span style='background:#E5E5E5;border-radius:10%;'>$1</span>");
				});
			});
			$('.i-click').on('click',function(e){
				e.preventDefault();
				if($('ul').hasClass('subject')){
					$('ul').removeClass('subject');
					$('.i-click > i.fa').removeClass('fa-angle-double-down');
					$('.i-click > i.fa').addClass('fa-angle-double-up');
					$('ul').next('.i-click').removeClass('sr-only');
				}else{
					$('ul').addClass('subject');
					$('.i-click > i.fa').removeClass('fa-angle-double-up');
					$('.i-click > i.fa').addClass('fa-angle-double-down');
					$('ul').next('.i-click').addClass('sr-only');
				}
			});
		});
	</script>
@endsection
