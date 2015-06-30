@extends('public.app')

@section('title')
	Anggota Perpustakaan
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 cl-xs-12">
				<div class="page-title">
					<h3>Anggota Perpustakaan</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="s-10"></div>
	@if(count($members) > 0)
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="bg-light-gray p-10">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>NIP/NIM/NIS</th>
										<th>Nama</th>
										<th>Jenis Kelamin</th>
										<th>Jenis Anggota</th>
										<th>Alamat / Divisi</th>
										<th>Waktu Daftar</th>
									</tr>
								</thead>
								<tbody>
								@foreach($members as $member)
									<tr>
										<td>{{ $member->id }}</td>
										<td>{{ $member->nama }}</td>
										<td>{{ $member->jenis_kelamin == 'perempuan' ? 'Perempuan' : 'Laki-Laki' }}</td>
										<td>{{ $member->jenis_anggota == 'karyawan' ? 'Karyawan' : 'Non-Karyawan' }}</td>
										<td>{{ $member->alamat }}</td>
										<td>{{ tanggal($member->waktu) }}</td>
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
										Showing {!! count($members) > 0 ? $members->perPage()*$members->currentPage()-$members->perPage()+1 : 0 !!}
										to {!! $members->perPage()*$members->currentPage() < $members->total() ? $members->perPage()*$members->currentPage() : $members->total() !!}
										of {!! $members->total() !!} entries
									</small>
								</span>
								<span class="pull-right">{!! isset($_REQUEST['q']) ? strtr($members->render(),['^' => '?','?' => '&']) : $members->render() !!}</span>
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
				Data anggota tidak ditemukan.
			</div>
		</div>
	@endif
@endsection

@section('script')
	<script src="{{ asset('/plugins/jquery.columnizer/jquery.columnizer.min.js') }}"></script>
	<script src="{{ asset('/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
	<script>
		$(function(){
			var search = "{{ isset($_REQUEST['q']) ? $_REQUEST['q'] : '`~`' }}";
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
		});
	</script>
@endsection
