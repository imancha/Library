@extends('admin.master.app')

@section('title')
	Edit Buku
@endsection

@section('style')
	<link href="{{ asset('/assets/plugins/jquery-autocomplete/jquery.autocomplete.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div id="main-content">
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
						<h3 class="panel-title"><strong>Edit</strong> Buku</h3>
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
								<form id="form4" class="form-horizontal icon-validation" role="form" method="POST" enctype="multipart/form-data" action="{{ action('Admin\BookController@update',$book->id) }}" parsley-validate>
									<input name="_method" type="hidden" value="PATCH">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group">
										<label class="col-sm-3 control-label">Jenis</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="jenis" name="jenis" class="form-control" value="{{ $book->jenis }}" maxlength="10" size="10" parsley-minlength="1" parsley-required="true" autocomplete="off" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Kode Buku</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="id" name="id" class="form-control" value="{{ $book->id }}" maxlength="10" size="10" parsley-minlength="1" parsley-required="true" autocomplete="off" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Judul Buku</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" name="judul" class="form-control" value="{{ $book->judul }}" parsley-minlength="3" parsley-required="true" autocomplete="off" autofocus />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Pengarang</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<?php $authors = []; ?>
											@foreach($book->author as $author)
												<?php $authors[] = $author->nama ?>
											@endforeach
											<input type="text" name="pengarang" class="form-control" value="{{ implode(' / ',$authors) }}" placeholder="Nama 1 / Nama 2 / . . . " parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Penerbit</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="penerbit" name="penerbit" class="form-control" value="{{ $book->publisher->nama }}" parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Edisi</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="year" name="edisi" class="form-control" maxlength="4" size="4" value="{{ $book->edisi }}" parsley-type="digits" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Subyek</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="subyek" name="subyek" class="form-control" value="{{ $book->subject->nama }}" parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Rak</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="rak" name="rak" class="form-control" value="{{ $book->rack->nama }}" parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Keterangan</label>
										<div class="col-sm-7">
											<textarea class="form-control" name="keterangan">{{ $book->keterangan }}</textarea>
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
										<button type="reset" class="btn btn-default" onclick="history.go(-1)">Cancel</button>
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
		});
	</script>
@endsection
