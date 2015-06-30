@extends('public.app')

@section('title')
	Peminjaman Buku Perpustakaan
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 cl-xs-12">
				<div class="page-title">
					<h3>Peminjaman Buku Perpustakaan</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="s-10"></div>
	@if(count($borrows) > 0)
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="bg-light-gray p-10">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th class="text-center">ID</th>
										<th style="width:96px" class="text-center">Waktu Pinjam</th>
										<th class="text-center">NIP/NIM/NIS</th>
										<th class="text-center">Nama</th>
										<th style="width:81px" class="text-center no-print">Kode Buku</th>
										<th style="width:352px" class="text-center no-print">Judul Buku</th>
										<th style="width:96px" class="text-center no-print">Waktu Kembali</th>
										<th style="width:111px" class="text-center no-print">Keterangan</th>
										<th class="text-center visible-print">Peminjaman</th>
									</tr>
								</thead>
								<tbody>
									@foreach($borrows as $borrow)
										<tr>
											<td class="text-center">{{ $borrow->id }}</td>
											<td class="text-center">{{ tanggal($borrow->waktu_pinjam) }}</td>
											<td class="text-center">{{ $borrow->member->id }}</td>
											<td class="text-center">{{ $borrow->member->nama }}</td>
											<td colspan="4" style="padding:0px;" class="nested">
												<table class="table table-bordered table-hover" style="margin-bottom:0px;">
													<tbody>
														@foreach($details as $detail)
															@if($detail->id == $borrow->id)
																<tr {{ empty($detail->waktu_kembali) ? 'class=c-red' : '' }}>
																	<td style="width:80px;padding:3px;" class="text-center">{{ $detail->book->id }}</td>
																	<td style="width:352px;padding:3px;" class="text-center">{{ $detail->book->judul }}</td>
																	<td style="width:96px;padding:3px;" class="text-center">{{ empty($detail->waktu_kembali) ? '' : tanggal($detail->waktu_kembali) }}</td>
																	<td style="width:110px;padding:3px;" class="text-center">{{ empty($detail->waktu_kembali) ? 'Peminjaman' : 'Pengembalian' }}</td>
																</tr>
															@endif
														@endforeach
													</body>
												</table>
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
										<small class="c-red">
											Showing {{ $perpage*$page-$perpage+1 }} to {{ $total < $perpage*$page ? $total : $perpage*$page }} of {{ $total }} entries
										</small>
									</span>
									<span class="pull-right">
										<ul class="pagination">
											<li{{ $page==1 ? ' class=disabled' : '' }}>{!! $page==1 ? '<span>&laquo;</span>' : '<a href="'.$path.($page-1).'" rel="prev">&laquo;</a>' !!}</li>
											@if($page < 7)
												@for($i=1;$i<=($totalpage>8 ? 8 : $totalpage);$i++)
													<li{{ $page==$i ? ' class=active' : '' }}>{!! $page==$i ? '<span>'.$i.'</span>' : '<a href="'.$path.$i.'">'.$i.'</a>' !!}</li>
												@endfor
												@if($totalpage > 8)
													@if($page+8 < $totalpage-1)
														<li class="disabled"><span>...</span></li>
													@endif
													<li><a href="{{ $path.($totalpage-1) }}">{{ $totalpage-1 }}</a></li>
													<li><a href="{{ $path.$totalpage }}">{{ $totalpage }}</a></li>
												@endif
											@else
												<li><a href="{{ $path }}1">1</a></li>
												<li><a href="{{ $path }}2">2</a></li>
												@if($totalpage-8 > 2)
													<li class="disabled"><span>...</span></li>
												@endif
												@for($i=($page-3 < $totalpage-8 ? $page-3 : ($totalpage-8 > 2 ? $totalpage-8 : 3));$i<$page;$i++)
													<li><a href="{{ $path.$i }}">{{ $i }}</a></li>
												@endfor
												<li class="active"><span>{{ $page }}</span></li>
												@for($i=$page+1;$i<=($page+3 > $totalpage-2 ? $totalpage-2 : $page+3);$i++)
													<li><a href="{{ $path.$i }}">{{ $i }}</a></li>
												@endfor
												@if($page+5 < $totalpage)
													<li class="disabled"><span>...</span></li>
												@endif
												@if($page < $totalpage-1)
													<li><a href="{{ $path.($totalpage-1) }}">{{ $totalpage-1 }}</a></li>
												@endif
												@if($page < $totalpage)
													<li><a href="{{ $path.$totalpage }}">{{ $totalpage }}</a></li>
												@endif
											@endif
											<li{{ $page==$totalpage ? ' class=disabled' : '' }}>{!! $page==$totalpage ? '<span>&raquo;</span>' : '<a href="'.$path.($page+1).'" rel="next">&raquo;</a>' !!}</li>
										</ul>
									</span>
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
				Data peminjaman tidak ditemukan.
			</div>
		</div>
	@endif
@endsection

@section('script')
	<script src="{{ asset('/plugins/jquery.columnizer/jquery.columnizer.min.js') }}"></script>
	<script src="{{ asset('/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
	<script>
		$(function(){
			@if(isset($_REQUEST['q']))
				var search = "{{ $_REQUEST['q'] }}";
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
			@endif
		});
	</script>
@endsection
