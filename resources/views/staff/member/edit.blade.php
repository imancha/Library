@extends('master.app')

@section('title')
	Edit Anggota
@endsection

@section('content')
	<div id="main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading bg-red">
						<h3 class="panel-title"><strong>Edit</strong> Anggota</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<form id="form4" class="form-horizontal icon-validation" role="form" method="POST" action="{{ action('Admin\MemberController@update', [$member->id]) }}">
									<input name="_method" type="hidden" value="PATCH">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group">
										<label class="col-sm-3 control-label">NIP/NIM/NIS<span class="c-gray">*</span></label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" name="id" class="form-control" value="{{ empty(old('id')) ? $member->id : old('id') }}" parsley-type="digits" parsley-minlength="3" parsley-required="true" autocomplete="off" autofocus />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Nama<span class="c-gray">*</span></label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" name="nama" class="form-control" value="{{ empty(old('nama')) ? $member->nama : old('nama') }}" parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Tempat &amp; Tanggal Lahir</label>
										<div class="col-sm-7">
											<input type="text" name="lahir" class="form-control" value="{{ empty(old('lahir')) ? $member->tanggal_lahir : old('lahir') }}" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Jenis Kelamin</label>
										<div class="col-sm-7 skin-section">
											<ul class="list inline m-t-5">
												<li>
													<input tabindex="11" type="radio" name="jk" value="laki-Laki" {{ (empty(old('jk')) ? $member->jenis_kelamin : old('jk')) != 'perempuan' ? 'checked' : '' }} />
													<label class="m-r-20">Laki-Laki</label>
												</li>
												<li>
													<input tabindex="11" type="radio" name="jk" value="perempuan" {{ (empty(old('jk')) ? $member->jenis_kelamin : old('jk')) == 'perempuan' ? 'checked' : '' }} />
													<label>Perempuan</label>
												</li>
											</ul>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Jenis Anggota</label>
										<div class="col-sm-7 skin-section">
											<ul class="list inline m-t-5">
												<li>
													<input id="k" tabindex="11" type="radio" name="ja" value="karyawan" {{ (empty(old('ja')) ? $member->jenis_anggota : old('ja')) == 'karyawan' ? 'checked' : '' }} />
													<label class="m-r-20">Karyawan</label>
												</li>
												<li>
													<input id="nk" tabindex="11" type="radio" name="ja" value="non-karyawan" {{ (empty(old('ja')) ? $member->jenis_anggota : old('ja')) != 'karyawan' ? 'checked' : '' }} />
													<label>Non-Karyawan</label>
												</li>
											</ul>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Nomor Telepon</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" name="phone" class="form-control" value="{{ empty(old('phone')) ? $member->phone : old('phone') }}" maxlength="12" parsley-type="digits" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Alamat / Divisi</label>
										<div class="col-sm-7">
											<textarea class="form-control" name="alamat">{{ empty(old('alamat')) ? $member->alamat : old('alamat') }}</textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Keterangan</label>
										<div class="col-sm-7">
											<textarea class="form-control" name="keterangan">{{ empty(old('keterangan')) ? $member->keterangan : old('keterangan') }}</textarea>
										</div>
									</div>
									<div class="form-group text-center">
										<button class="btn btn-danger" type="submit">Submit</button>
										<button type="reset" class="btn btn-default">Clear</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script src="{{ asset('/assets/plugins/icheck/custom.js') }}"></script>
	<script src="{{ asset('/assets/js/form.js') }}"></script>
@endsection
