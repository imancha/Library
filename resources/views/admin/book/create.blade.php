@extends('admin.master.app')

@section('title')
	Tambah Buku
@endsection

@section('style')
	<link href="{{ asset('/assets/plugins/jquery-autocomplete/jquery.autocomplete.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div id="main-content">
		<div class="row">
			<div class="col-md-12">
				@if(Session::has('message'))
					<div class="alert alert-success w-100" role="alert">
						<i class='fa fa-check-square-o' style='padding-right:6px'></i>
						<button type="button" class="close" data-dismiss="alert">×</button>
						<span class="glyphicon glyphicon-exclamation-ok-sign" aria-hidden="true"></span>
						<span class="sr-only">Success:</span>
						{{ Session::get('message') }}
					</div>
				@endif
				<div class="panel panel-default">
					<div class="panel-heading bg-red">
						<h3 class="panel-title"><strong>Tambah</strong> Buku</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								@if(count($errors) > 0)
									<!-- BEGIN ERROR BOX -->
									<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<h4><i class='fa fa-ban' style='padding-right:6px'></i> Error!</h4>
										<ul>
										@foreach($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
										</ul>
									</div>
									<!-- END ERROR BOX -->
								@endif
								<form id="form4" class="form-horizontal icon-validation" role="form" method="POST" enctype="multipart/form-data" action="{{ action('Admin\BookController@store') }}" parsley-validate>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group">
										<label class="col-sm-3 control-label">Jenis</label>
										<div class="col-sm-7 skin-section">
											<ul class="list inline m-t-5">
												<li>
													<input type="radio" name="jenis" value="{{ $asli }}" {{ is_numeric(Input::old('jenis')) ? 'checked' : '' }} />
													<label class="m-r-20">ASLI</label>
												</li>
												<li>
													<input type="radio" name="jenis" value="{{ $pkl }}P" {{ is_numeric(Input::old('jenis')) ? '' : 'checked' }} />
													<label>PKL</label>
												</li>
											</ul>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Kode Buku</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="id" name="id" class="form-control" value="{{ old('id') }}" maxlength="10" size="10" parsley-minlength="1" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Tanggal Masuk</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="date" name="tanggal" class="form-control datepicker" value="{{ old('tanggal') }}" size="10" maxlength="10" parsley-minlength="8" parsley-required="true" autocomplete="off" >
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Judul Buku</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" name="judul" class="form-control" value="{{ old('judul') }}" parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Pengarang</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" name="pengarang" class="form-control" value="{{ old('pengarang') }}" placeholder="Nama 1 / Nama 2 / . . . " parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Penerbit</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="penerbit" name="penerbit" class="form-control" value="{{ old('penerbit') }}" parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Edisi</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="year" name="edisi" class="form-control" maxlength="4" size="4" value="{{ old('edisi') }}" parsley-type="digits" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Subyek</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="subyek" name="subyek" class="form-control" value="{{ old('subyek') }}" parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Rak</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="rak" name="rak" class="form-control" value="{{ old('rak') }}" parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Keterangan</label>
										<div class="col-sm-7">
											<textarea class="form-control" name="keterangan">{{ old('keterangan') }}</textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">File</label>
										<div class="col-sm-7">
											<a class="file-input-wrapper">
												<input type="file" id="file" name="file" data-filename-placement="inside" class="btn-transparent">
											</a>
										</div>
									</div>
									<div class="form-group text-center">
										<button class="btn btn-danger" onclick="javascript:$('#form4').parsley('validate');">Submit</button>
										<button type="reset" class="btn btn-default">Cancel</button>
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
	<script src="{{ asset('/assets/plugins/parsley/parsley.js') }}"></script>
	<script src="{{ asset('/assets/plugins/parsley/parsley.extend.js') }}"></script>
	<script src="{{ asset('/assets/plugins/icheck/custom.js') }}"></script>
	<script src="{{ asset('/assets/plugins/icheck/icheck.js') }}"></script>
	<script src="{{ asset('/assets/plugins/bootstrap-fileinput/bootstrap.file-input.js') }}"></script>
	<script src="{{ asset('/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
	<script src="{{ asset('/assets/plugins/jquery-autocomplete/jquery.autocomplete.js') }}"></script>
	<script src="{{ asset('/assets/js/form.js') }}"></script>
	<script>
		var jenis = document.getElementsByName('jenis');
		if(jenis[0].checked)
			document.getElementById('id').value = jenis[0].value;
		else if(jenis[1].checked)
			document.getElementById('id').value = jenis[1].value;
	</script>
	<script>
		$(document).ready(function(){
			$('#penerbit').autocomplete({
				source:[{
					data:{!! $publishers !!}
				}],
				valueKey:'nama',
				limit:'10',
				openOnFocus:false,
			});
			$('#subyek').autocomplete({
				source:[{
					data:{!! $subjects !!}
				}],
				valueKey:'nama',
				limit:'10',
				openOnFocus:false,
			});
			$('#rak').autocomplete({
				source:[{
					data:{!! $racks !!}
				}],
				valueKey:'nama',
				limit:'10',
				openOnFocus:false,
			});
			$('#file').bootstrapFileInput();
			$('.list input:radio').on('ifClicked', function(event){
				$('#id').val(this.value);
			});
		});
	</script>
@endsection
