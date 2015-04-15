@extends('admin.master.app')

@section('title')
	Data Anggota
@endsection

@section('content')
	<div id="main-content">
		@if(count($members) > 0)
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
							<h3 class="panel-title"><strong>Data </strong> Anggota</h3>
							<ul class="pull-right header-menu">
								<li class="dropdown" id="user-header">
									<a href="#" class="dropdown-toggle c-white" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
										<i class="fa fa-cog f-20"></i>
									</a>
										<ul class="dropdown-menu">
											<li>
												<a href="{{ route('admin.member.export','xlsx') }}">
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
												<th class="text-center">NIP/NIM/NIS</th>
												<th class="text-center">Nama</th>
												<th class="text-center">Jenis Kelamin</th>
												<th class="text-center">Jenis Anggota</th>
												<th class="text-center">Alamat / Divisi</th>
												<th class="text-center" colspan="3">Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach($members as $member)
												<?php $record = 0 ?>
												@foreach($borrows as $borrow)
													@if($member->id == $borrow->member_id)
														<?php ++$record ?>
													@endif
												@endforeach
												<tr>
													<td>{{ $member->id }}</td>
													<td>{{ $member->nama }}</td>
													<td>{{ ucfirst($member->jenis_kelamin) }}</td>
													<td>{{ ucfirst($member->jenis_anggota) }}</td>
													<td>{{ $member->alamat }}</td>
													<td><a class="c-blue md-trigger" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Lihat" href="#view-{{ $member->id }}" data-modal="view-{{ $member->id }}"><i class="fa fa-eye"></i></a></td>
													<td><a class="c-orange" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Ubah" href="{{ route('admin.member.edit',$member->id) }}"><i class="fa fa-edit"></i></a></td>
													<td><a class="c-red md-trigger" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Hapus" href="#remove-{{ $member->id }}" data-modal="remove-{{ $member->id }}"><i class="fa fa-trash-o"></i></a></td>
												</tr>
												<div class="md-modal md-effect-13" id="view-{{ $member->id }}">
													<div class="md-content">
														<h3 class="c-white">Lihat Anggota<span class="pull-right"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
														<div class="text-left p-b-0">
															<ul>
																<li><strong>NIP/NIM/NIS:</strong> {{ $member->id }}</li>
																<li><strong>Nama:</strong> {{ $member->nama }}</li>
																<li><strong>Jenis Kelamin:</strong> {{ ucfirst($member->jenis_kelamin) }}</li>
																<li><strong>Tempat &amp; Tanggal Lahir:</strong> {{ $member->tanggal_lahir }}</li>
																<li><strong>Jenis Anggota:</strong> {{ ucfirst($member->jenis_anggota) }}</li>
																<li><strong>Alamat/Divisi:</strong> {{ $member->alamat }}</li>
																<li><strong>Anggota Sejak:</strong> {{ tanggal($member->created_at) }}</li>
																<li><strong>Peminjaman:</strong> {{ $record }} Kali</li>
															</ul>
														</div>
													</div>
												</div>
												<div class="md-modal md-effect-1" id="remove-{{ $member->id }}">
													<div class="md-content md-content-red">
														<h3 class="c-white">Hapus Anggota . . . ?<span class="pull-right"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
														<div class="text-left">
															<form role="form" method="POST" action="{{ route('admin.member.destroy',$member->id) }}">
																<input name="_method" type="hidden" value="DELETE">
																<input type="hidden" name="_token" value="{{ csrf_token() }}">
																<input type="hidden" name="id" value="{{ $member->id }}">
																<input type="hidden" name="nama" value="{{ $member->nama }}">
																<ul>
																	<li><strong>NIP/NIM/NIS:</strong> {{ $member->id }}</li>
																	<li><strong>Nama:</strong> {{ $member->nama }}</li>
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
