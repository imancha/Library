@extends('admin.master.app')

@section('title')
	Tambah Pengembalian
@endsection

@section('style')
	<link href="{{ asset('/assets/plugins/jquery-autocomplete/jquery.autocomplete.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div id="main-content" class="dashboard">
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
						<h3 class="panel-title"><strong>Tambah</strong> Pengembalian</h3>
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
								<form id="form4" class="form-horizontal icon-validation" role="form" method="POST" action="{{ action('Admin\BorrowController@update','return') }}" parsley-validate>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input name="_method" type="hidden" value="PATCH">
									<div class="form-group">
										<label class="col-sm-3 control-label">ID Peminjaman</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="idp" name="idp" class="form-control" value="{{ old('idp') }}" maxlength="10" size="10" parsley-minlength="1" parsley-required="true" autocomplete="off" autofocus />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">NIP/NIM/NIS</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="id" name="id" class="form-control" value="{{ old('id') }}" parsley-type="digits" parsley-minlength="3" parsley-required="true" autocomplete="off" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Nama</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="nama" name="nama" class="form-control" value="" parsley-minlength="3" parsley-required="true" autocomplete="off" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Kode Buku</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="kode" name="kode" class="form-control" value="{{ old('kode') }}" maxlength="10" size="10" parsley-minlength="1" parsley-required="true" autocomplete="off" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Judul</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="judul" name="judul" class="form-control" value="" parsley-minlength="3" parsley-required="true" autocomplete="off" readonly />
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
	<script src="{{ asset('/assets/plugins/jquery-autocomplete/jquery.autocomplete.js') }}"></script>
	<script src="{{ asset('/assets/js/form.js') }}"></script>
	<script>
		$(document).ready(function(){
			$('#idp').autocomplete({
				source:[{
					data:{!! $borrows !!}
				}],
				valueKey:'id',
				limit:'10',
				openOnFocus:false,
			});
			$.ajaxSetup({
        headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
			});
			$('#idp').keypress(function(){
				$.ajax({
					url:'{!! route('admin.book.return') !!}',
					dataType:'',
					type:'POST',
					data:{'id':$('#idp').val()},
					cache:false,
					success:function(data){
						$('#id').val('');
						$('#nama').val('');
						$('#kode').val('');
						$('#judul').val('');
						if((data != null) && (data != undefined) && (data.length != 0)){
							$('#id').val(data['member'][0]['id']);
							$('#nama').val(data['member'][0]['nama']);
							$('#kode').val(data['book'][0]['id']);
							$('#judul').val(data['book'][0]['judul']);
						}
					},
				});
			});
		});
	</script>
@endsection
