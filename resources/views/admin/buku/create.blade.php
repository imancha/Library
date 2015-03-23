@extends('admin.master.app')

@section('title')
	Tambah Buku
@endsection

@section('style')
	<link href="{{ asset('/assets/plugins/jquery-autocomplete/jquery.autocomplete.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div id="main-content" class="dashboard">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading bg-red">
						<h3 class="panel-title"><strong>Tambah</strong> Buku</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<form id="form4" class="form-horizontal icon-validation" role="form" method="POST" enctype="multipart/form-data" action="{{ action('BookController@store') }}" parsley-validate>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group">
										<label class="col-sm-3 control-label">Judul Buku</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" name="judul" parsley-minlength="3" class="form-control" value="{{ old('judul') }}" parsley-required="true" autofocus />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Pengarang</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" name="pengarang" parsley-minlength="3" class="form-control" value="{{ old('pengarang') }}" parsley-required="true" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Penerbit</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="penerbit" name="penerbit" parsley-minlength="3" class="form-control" value="{{ old('penerbit') }}" parsley-required="true" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Edisi</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="year" name="edisi" class="form-control" maxlength="4" size="4" value="{{ old('edisi') }}" parsley-type="digits" parsley-required="true" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Jenis</label>
										<div class="col-sm-7 skin-section">
											<ul class="list inline m-t-5">
												<li>
													<input tabindex="11" type="radio" data-style="square-blue" name="jenis" value="ASLI" checked />
													<label class="m-r-20">ASLI</label>
												</li>
												<li>
													<input tabindex="11" type="radio" data-style="square-blue" name="jenis" value="PKL" />
													<label>PKL</label>
												</li>
											</ul>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Subyek</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="subyek" name="subyek" class="form-control" value="{{ old('subyek') }}" parsley-required="true" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Rak</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="rak" name="rak" class="form-control" value="{{ old('rak') }}" parsley-required="true" />
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
											<a class="file-input-wrapper btn-default">
												<input type="file" id="file" name="file" data-filename-placement="inside">
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
	<script src="{{ asset('/assets/plugins/bootstrap-fileinput/bootstrap.file-input.js') }}"></script>
	<script src="{{ asset('/assets/plugins/jquery-autocomplete/jquery.autocomplete.js') }}"></script>
	<script src="{{ asset('/assets/js/form.js') }}"></script>
	<script>
		$(document).ready(function(){
			$('#penerbit').autocomplete({
				valueKey:'nama',
				limit:'10',
				source:[{
					data:{!! $publishers !!},
					getTitle:function(item){
						return item['nama']
					},
					getValue:function(item){
						return item['nama']
					},
				}]
			});
			$('#subyek').autocomplete({
				valueKey:'nama',
				limit:'10',
				source:[{
					data:{!! $subjects !!},
					getTitle:function(item){
						return item['nama']
					},
					getValue:function(item){
						return item['nama']
					},
				}]
			});
			$('#rak').autocomplete({
				valueKey:'nama',
				limit:'10',
				source:[{
					data:{!! $racks !!},
					getTitle:function(item){
						return item['nama']
					},
					getValue:function(item){
						return item['nama']
					},
				}]
			});
			$('#file').bootstrapFileInput();
		});
	</script>
@endsection
