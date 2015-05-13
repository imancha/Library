@extends('admin.master.app')

@section('title')
	Data Anggota
@endsection

@section('content')
	<div id="main-content">
		@if(count($member) > 0)
			<div class="row">
				<div class="col-md-12">
					@if(Session::has('message'))
						<div class="alert alert-success w-100 m-t-0 m-b-10 no-print" role="alert">
							<i class='fa fa-check-square-o' style='padding-right:6px'></i>
							<button type="button" class="close" data-dismiss="alert">×</button>
							<span class="glyphicon glyphicon-exclamation-ok-sign" aria-hidden="true"></span>
							<span class="sr-only">Success:</span>
							{{ Session::get('message') }}
						</div>
					@endif
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<h3 class="text-center">DATA PEMINJAMAN ANGGOTA PERPUSTAKAAN INTI</h3>
									<h4 class="p-t-20">DATA PRIBADI</h4>
									<div class="table-responsive border-top">
										<table class="table table-borderless table-condensed text-left m-b-0">
											<tbody>
												<tr><td>NIP/NIM/NIS</td><td>:</td><td>{{ $member->id }}</td></tr>
												<tr><td>NAMA</td><td>:</td><td>{{ $member->nama }}</td></tr>
												<tr><td width="180px">TEMPAT &amp; TANGGAL LAHIR</td><td width="1px">:</td><td>{{ $member->tanggal_lahir }}</td></tr>
												<tr><td>JENIS KELAMIN</td><td>:</td><td>{{ $member->jenis_kelamin == 'perempuan' ? 'Perempuan' : 'Laki-Laki' }}</td></tr>
												<tr><td>JENIS ANGGOTA</td><td>:</td><td>{{ $member->jenis_anggota == 'karyawan' ? 'Karyawan' : 'Non-Karyawan' }}</td></tr>
												<tr><td>ALAMAT / DIVISI</td><td>:</td><td>{{ $member->alamat }}</td></tr>
												<tr><td>KETERANGAN</td><td>:</td><td>{{ $member->keterangan }}</td></tr>
											</tbody>
										</table>
									</div>
									<div>
										<h4 class="p-t-20">
											DATA PEMINJAMAN
											<span class="pull-right">
												<small style="font-size:15;color:gray !important;">
													<i>{{ (!empty($_REQUEST['from']) && !empty($_REQUEST['to'])) ? str_replace('-','/',$_REQUEST['from']).' - '.str_replace('-','/',$_REQUEST['to']) : '' }}</i>
												</small>
												<a class="md-trigger no-print p-l-10" href="#date" data-modal="date"><i class="fa fa-calendar"></i></a>
											</span>
										</h4>
									</div>
									@if(count($borrows) > 0)
										<?php $i=0 ?>
										<div class="table-responsive border-top">
											<table class="table table-striped text-left m-b-0">
												<thead>
													<th>#</th>
													<th>KODE BUKU</th>
													<th>JUDUL BUKU</th>
													<th>TANGGAL PINJAM</th>
													<th>TANGGAL KEMBALI</th>
													<th>KETERANGAN</th>
												</thead>
												<tbody>
												@foreach($borrows as $borrow)
													<tr {{ empty($borrow->tanggal_kembali) ? 'class=c-red' : '' }}>
														<td>{{ ++$i }}</td>
														<td>{{ $borrow->book_id }}</td>
														<td>{{ $borrow->book->judul }}</td>
														<td>{{ date_reverse($borrow->tanggal_pinjam,'-','/') }}</td>
														<td>{{ empty($borrow->tanggal_kembali) ? '' : date_reverse($borrow->tanggal_pinjam,'-','/') }}</td>
														<td>{{ empty($borrow->tanggal_kembali) ? 'Peminjaman' : 'Pengembalian' }}</td>
													</tr>
												@endforeach
												</tbody>
											</table>
										</div>
									@endif
									<hr>
									<small class="pull-right" style="font-size:smaller;color:gray !important;"><i id="timestamp"></i></small>
									<div class="no-print">
										<button class="btn btn-default btn-print pull-right"><i class="fa fa-print"></i> Print</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="md-modal md-effect-2 text-left" id="date">
				<div class="md-content md-content-aqua">
					<h3>Calendar <span class="pull-right" title="close"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
					<div class="p-b-10 m-t-10">
						<form class="form-horizontal" method="get" action="{{ route('admin.member.show',$member->id) }}">
							<div class="form-group">
								<label class="col-sm-4 control-label">Tanggal Awal</label>
								<div class="col-sm-6">
									<input type="text" name="from" class="form-control datepicker input-lg" value="{{ empty($_REQUEST['from']) ? '' : $_REQUEST['from'] }}" autocomplete="off" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Tanggal Akhir</label>
								<div class="col-sm-6">
									<input type="text" name="to" class="form-control datepicker input-lg" value="{{ empty($_REQUEST['to']) ? '' : $_REQUEST['to'] }}" autocomplete="off" />
								</div>
							</div>
							<div class="form-group">
								<button class="btn btn-default btn-rounded" type="submit">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="md-overlay"></div><!-- the overlay element -->
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
	<script src="{{ asset('/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
	<script>
		$(document).ready(function(){
			$('.btn-print').click(function(){
				$('.md-trigger,.btn-print').hide();
				var currentdate = new Date();
				$('#timestamp').append("Waktu cetak: "+currentdate.getDate()+"/"+(currentdate.getMonth()+1)+"/"+currentdate.getFullYear()+" "+currentdate.getHours()+":"+currentdate.getMinutes()+":"+currentdate.getSeconds());
				window.print();
				$('#timestamp').empty();
				$('.md-trigger,.btn-print').show();
			});
		});
	</script>
@endsection
