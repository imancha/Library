@extends('master.app')

@section('title')
	Edit Buku
@endsection

@section('style')
	<link href="{{ asset('/assets/plugins/jquery-autocomplete/jquery.autocomplete.css') }}" rel="stylesheet">
	<link href="{{ asset('/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div id="main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading bg-red">
						<h3 class="panel-title"><strong>Edit</strong> Buku</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<form id="form4" class="form-horizontal icon-validation" role="form" method="POST" enctype="multipart/form-data" action="{{ action('Admin\BookController@update',$book->id) }}">
									<input type="hidden" name="_method" value="PATCH">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group">
										<label class="col-sm-3 control-label">Jenis<span class="c-gray">*</span></label>
										<div class="col-sm-7 skin-section">
											<ul class="list inline m-t-5">
												<li>
													<input type="radio" name="jenis" value="{{ $book->id  }}" checked="checked" />
													<label class="m-r-20">{{ strtoupper($book->jenis) }}</label>
												</li>
											</ul>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Kode Buku<span class="c-gray">*</span></label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="id" name="id" class="form-control" value="{{ $book->id }}" maxlength="10" size="10" parsley-minlength="1" parsley-required="true" autocomplete="off" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Judul Buku<span class="c-gray">*</span></label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" name="judul" class="form-control" value="{{ empty(old('judul')) ? $book->judul : old('judul') }}" parsley-minlength="3" parsley-required="true" autocomplete="off" autofocus />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Pengarang<span class="c-gray">*</span></label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<?php $authors = []; ?>
											@foreach($book->author as $author)
												<?php $authors[] = $author->nama ?>
											@endforeach
											<input type="text" name="pengarang" data-role="tagsinput" class="form-control" value="{{ empty(old('pengarang')) ? implode(',',$authors) : old('pengarang') }}" placeholder="Nama 1, Nama 2, . . . " parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Penerbit<span class="c-gray">*</span></label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="penerbit" name="penerbit" class="form-control" value="{{ empty(old('penerbit')) ? $book->publisher->nama : old('penerbit') }}" parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Tahun<span class="c-gray">*</span></label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="year" name="tahun" class="form-control" maxlength="4" size="4" value="{{ empty(old('tahun')) ? $book->tahun : old('tahun') }}" parsley-type="digits" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Subyek<span class="c-gray">*</span></label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="subyek" name="subyek" class="form-control" value="{{ empty(old('subyek')) ? $book->subject->nama : old('subyek') }}" parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Rak<span class="c-gray">*</span></label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="rak" name="rak" class="form-control" value="{{ empty(old('rak')) ? $book->rack->nama : old('rak') }}" parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Keterangan</label>
										<div class="col-sm-7">
											<textarea class="form-control" name="keterangan">{{ empty(old('keterangan')) ? $book->keterangan : old('keterangan') }}</textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">File</label>
										<div class="col-sm-7">
											<a class="file-input-wrapper">
												<input type="file" id="file" name="file" data-filename-placement="inside" class="btn-transparent">
											</a>
											<small class="text-muted"> *(pdf,doc,docx,ppt,pptx,zip,rar)</small>
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
	<script src="{{ asset('/assets/plugins/icheck/icheck.js') }}"></script>
	<script src="{{ asset('/assets/plugins/bootstrap-fileinput/bootstrap.file-input.js') }}"></script>
	<script src="{{ asset('/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
	<script src="{{ asset('/assets/plugins/jquery-autocomplete/jquery.autocomplete.js') }}"></script>
	<script src="{{ asset('/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
	<script src="{{ asset('/assets/js/form.js') }}"></script>
	<script>
		$(document).ready(function(){
			$('input:text[name=pengarang]').tagsinput({
				trimValue: true
			});
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
