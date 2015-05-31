@extends('master.app')

@section('title')
	Data Peminjaman
@endsection

@section('content')
	<div id="main-content">
		@if(count($borrows) > 0)
			<div class="row">
				<div class="col-md-12">
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
												<a href="{{ url('admin/borrow/print') }}" class="event">
													<i class="fa fa-print fa-fw"></i> Print this page
												</a>
												<a href="{{ action('Admin\BorrowController@export', ['xls']) }}">
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
												<th width="99px" class="text-center">Waktu Pinjam</th>
												<th class="text-center">NIS/NIM/NIP</th>
												<th class="text-center">Nama</th>
												<th width="79px" class="text-center">Kode Buku</th>
												<th width="384px" class="text-center">Judul Buku</th>
												<th width="99px" class="text-center">Waktu Kembali</th>
												<th width="111px" class="text-center">Keterangan</th>
											</tr>
										</thead>
										<tbody>
											@foreach($borrows as $borrow)
												<tr>
													<td>{{ $borrow->id }}</td>
													<td>{{ tanggal($borrow->waktu_pinjam) }}</td>
													<td>{{ $borrow->member->id }}</td>
													<td>{{ $borrow->member->nama }}</td>
													<td colspan="5" style="padding:0px;" class="nested">
														<table class="table table-bordered table-hover" style="margin-bottom:0px;">
															<tbody>
																@foreach($details as $detail)
																	@if($detail->id == $borrow->id)
																		<tr {{ empty($detail->waktu_kembali) ? 'class=c-red' : '' }}>
																			<td width="78px" class="text-center">{{ $detail->book->id }}</td>
																			<td width="385px" class="text-center">{{ $detail->book->judul }}</td>
																			<td width="99px" class="text-center">{{ empty($detail->waktu_kembali) ? '' : tanggal($detail->waktu_kembali) }}</td>
																			<td width="110px" class="text-center">{{ empty($detail->waktu_kembali) ? 'Peminjaman' : 'Pengembalian' }}</td>
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
								</div>
								<small class="pull-right" style="font-size:smaller;color:gray !important;"><i id="timestamp"></i></small>
								<div class="col-md-12 col-sm-12 col-xs-12 table-red no-print">
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
			$('.nested td').each(function(){
				$(this).height($(this).parent().height());
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
