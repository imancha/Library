@extends('admin.master.app')

@section('title')
	Trash Data Anggota
@endsection

@section('content')
	<div id="main-content">
		@if(count($result) > 0)
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading bg-red">
							<h3 class="panel-title"><strong>Trash </strong> Data Anggota</h3>
							<ul class="pull-right header-menu sr-only">
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
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th class="text-center">NIP/NIM/NIS</th>
												<th class="text-center">Nama</th>
												<th class="text-center">Waktu Hapus</th>
												<th class="text-center" colspan="3">Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach($result as $member)
												<tr>
													<td>{{ $member->id }}</td>
													<td>{{ $member->nama }}</td>
													<td>{{ $member->deleted_at }}</td>
													<td><a class="c-blue md-trigger" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="View" href="#view-{{ $member->id }}" data-modal="view-{{ $member->id }}"><i class="fa fa-eye"></i></a></td>
													<td><a class="c-orange md-trigger" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Restore" href="#restore-{{ $member->id }}" data-modal="restore-{{ $member->id }}"><i class="fa fa-undo"></i></a></td>
													<td><a class="c-red md-trigger" data-placement="top" data-toggle="tooltip" rel="tooltip" data-original-title="Delete" href="#delete-{{ $member->id }}" data-modal="delete-{{ $member->id }}"><i class="fa fa-times"></i></a></td>
												</tr>
												<div class="md-modal md-effect-13" id="view-{{ $member->id }}">
													<div class="md-content">
														<h3 class="c-white">View Anggota<span class="pull-right"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
														<div class="text-left p-b-0">
															<ul>
																<li><strong>NIP/NIM/NIS:</strong> {{ $member->id }}</li>
																<li><strong>Nama:</strong> {{ $member->nama }}</li>
																<li><strong>Jenis Kelamin:</strong> {{ $member->jenis_kelamin == 'perempuan' ? 'Perempuan' : 'Laki-Laki' }}</li>
																<li><strong>Tempat &amp; Tanggal Lahir:</strong> {{ $member->tanggal_lahir }}</li>
																<li><strong>Jenis Anggota:</strong> {{ $member->jenis_anggota == 'karyawan' ? 'Karyawan' : 'Non-Karyawan' }}</li>
																<li><strong>Alamat/Divisi:</strong> {{ $member->alamat }}</li>
																<li><strong>Keterangan:</strong> {{ $member->keterangan }}</li>
															</ul>
														</div>
													</div>
												</div>
												<div class="md-modal md-effect-9" id="restore-{{ $member->id }}">
													<div class="md-content md-content-orange">
														<h3 class="c-white">Restore Anggota . . . ?<span class="pull-right"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
														<div class="text-left">
															<form role="form" method="POST" action="{{ route('admin.trash.update','member-'.$member->id) }}">
																<input name="_method" type="hidden" value="PATCH">
																<input type="hidden" name="_token" value="{{ csrf_token() }}">
																<input type="hidden" name="id" value="{{ $member->id }}">
																<input type="hidden" name="nama" value="{{ $member->nama }}">
																<ul>
																	<li><strong>NIP/NIM/NIS:</strong> {{ $member->id }}</li>
																	<li><strong>Nama:</strong> {{ $member->nama }}</li>
																</ul>
																<button type="submit" class="btn btn-default btn-rounded btn-transparent">Restore</button>
															</form>
														</div>
													</div>
												</div>
												<div class="md-modal md-effect-1" id="delete-{{ $member->id }}">
													<div class="md-content md-content-red">
														<h3 class="c-white">Delete Anggota . . . ?<span class="pull-right"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
														<div class="text-left">
															<form role="form" method="POST" action="{{ route('admin.trash.destroy','member-'.$member->id) }}">
																<input name="_method" type="hidden" value="DELETE">
																<input type="hidden" name="_token" value="{{ csrf_token() }}">
																<input type="hidden" name="id" value="{{ $member->id }}">
																<input type="hidden" name="nama" value="{{ $member->nama }}">
																<ul>
																	<li><strong>NIP/NIM/NIS:</strong> {{ $member->id }}</li>
																	<li><strong>Nama:</strong> {{ $member->nama }}</li>
																</ul>
																<button type="submit" class="btn btn-default btn-transparent">Delete</button>
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
				Oops! Trash data anggota tidak ditemukan . . .
			</div>
		@endif
	</div>
@endsection
