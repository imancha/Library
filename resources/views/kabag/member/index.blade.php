@extends('master.app')

@section('title')
	Data Anggota
@endsection

@section('content')
	<div id="main-content">
		@if(count($members) > 0)
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading bg-red no-print">
							<h3 class="panel-title"><strong>Data </strong> Anggota</h3>
							<ul class="pull-right header-menu">
								<li class="dropdown" id="user-header">
									<a href="#" class="dropdown-toggle c-white" data-toggle="dropdown" data-close-others="true">
										<i class="fa fa-cog f-20"></i>
									</a>
										<ul class="dropdown-menu">
											<li>
												<a href="{{ url('admin/member/print') }}" class="event">
													<i class="fa fa-print fa-fw"></i> Print this page
												</a>
												<a href="{{ action('Admin\MemberController@export', ['xls']) }}">
													<i class="fa fa-table fa-fw"></i> Export to Excel
												</a>
											</li>
											</li>
										</ul>
								</li>
							</ul>
						</div>
						<h3 class="text-center visible-print p-t-0 m-t-0 p-b-10">DATA ANGGOTA PERPUSTAKAAN INTI</h3>
						<div class="panel-body p-5">
							<div class="row m-b-10 m-t-5">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<form method="get" action="{{ action('Admin\MemberController@index') }}">
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
												<th class="text-center">NIP/NIM/NIS</th>
												<th class="text-center">Nama</th>
												<th class="text-center">Jenis Kelamin</th>
												<th class="text-center">Tempat &amp; Tanggal Lahir</th>
												<th class="text-center">Jenis Anggota</th>
												<th class="text-center">Alamat / Divisi</th>
												<th class="text-center no-print"><i class="fa fa-eye"></i></th>
											</tr>
										</thead>
										<tbody>
											@foreach($members as $member)
												<tr>
													<td>{{ $member->id }}</td>
													<td>{{ $member->nama }}</td>
													<td>{{ $member->jenis_kelamin == 'perempuan' ? 'Perempuan' : 'Laki-Laki' }}</td>
													<td>{{ $member->tanggal_lahir }}</td>
													<td>{{ $member->jenis_anggota == 'karyawan' ? 'Karyawan' : 'Non-Karyawan' }}</td>
													<td>{{ $member->alamat }}</td>
													<td class="no-print"><a class="c-blue" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Lihat" href="{{ action('Admin\MemberController@show', [$member->id]) }}"><i class="fa fa-eye"></i></a></td>
												</tr>
											@endforeach
										</tbody>
									</table>
									<small class="pull-right" style="font-size:smaller;color:gray !important;"><i id="timestamp"></i></small>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 table-red no-print">
									<span class="pull-left">
										<small class="c-red">
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
			</div>
		@else
			<div class="alert alert-warning w-100 m-t-0 m-b-10" role="alert">
				<i class='fa fa-frown-o' style='padding-right:3px'></i>
				<span class="glyphicon glyphicon-exclamation-ok-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				Oops! Data anggota tidak ditemukan . . .
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
			$('a.event').click(function(){
				var currentdate = new Date();
				$('#timestamp').append("Waktu cetak: "+currentdate.getDate()+"/"+(currentdate.getMonth()+1)+"/"+currentdate.getFullYear()+" "+currentdate.getHours()+":"+currentdate.getMinutes()+":"+currentdate.getSeconds());
				window.print();
				$('#timestamp').empty();
			})
		});
	</script>
@endsection
