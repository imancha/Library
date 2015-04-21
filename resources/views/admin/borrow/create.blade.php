@extends('admin.master.app')

@section('title')
	Tambah Peminjaman
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
						<h3 class="panel-title"><strong>Tambah</strong> Peminjaman</h3>
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
								<form id="form4" class="form-horizontal icon-validation" role="form" method="POST" action="{{ route('admin.borrow.store') }}" parsley-validate>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group">
										<label class="col-sm-3 control-label">ID Peminjaman</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="idp" name="idp" class="form-control" value="P{{ $borrow }}" maxlength="10" size="10" parsley-minlength="1" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">NIP/NIM/NIS</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="id" name="id" class="form-control" value="{{ old('id') }}" parsley-type="digits" parsley-minlength="3" parsley-required="true" autocomplete="off" autofocus />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Nama</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="nama" name="nama" class="form-control" value="" parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div id="added"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Kode Buku</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="kode" name="kode[]" class="form-control" value="" maxlength="10" size="10" parsley-minlength="1" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Judul</label>
										<div class="col-sm-7">
											<div class="input-group">
												<input type="text" id="judul" name="judul" class="form-control" value="" autocomplete="off" readonly />
												<span id="plus" class="input-group-addon btn btn-sm" data-placement="right" data-toggle="tooltip" rel="tooltip" data-original-title="Tambah Buku">
													<i class="fa fa-plus"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group text-center">
										<button class="btn btn-danger" onclick="javascript:$('#form4').parsley('validate');">Submit</button>
										<button id="cancel" type="reset" class="btn btn-default">Cancel</button>
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
			var i = 0;
			$('#id').autocomplete({
				source:[{
					data:{!! $members !!}
				}],
				valueKey:'id',
				limit:'10',
				openOnFocus:false,
			});
			$('#kode').autocomplete({
				source:[{
					data:{!! $books !!}
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
			$('#id').keypress(function(){
				$.ajax({
					url:'{!! route('admin.member.borrow') !!}',
					dataType:'json',
					type:'POST',
					data:{'id':$('#id').val()},
					cache:false,
					success:function(data){
						$('#nama').val('');
						for(row in data)
							$('#nama').val(data[row].nama);
					},
				});
			});
			$('#kode').keypress(function(){
				$.ajax({
					url:'{!! route('admin.book.borrow') !!}',
					dataType:'json',
					type:'POST',
					data:{'kode':$('#kode').val()},
					cache:false,
					success:function(data){
						$('#judul').val('');
						for(row in data)
							$('#judul').val(data[row].judul);
					},
				});
			});
			$('#plus').click(function(){
				var html = '';
				html += '<div id="'+(++i)+'">';
				html += '<div class="form-group">';
				html += '	<label class="col-sm-3 control-label">Kode Buku</label>';
				html += '	<div class="col-sm-7 input-icon right">';
				html += '		<i class="fa"></i>';
				html += '		<input type="text" name="kode[]" class="form-control" value="'+$('#kode').val()+'" maxlength="10" size="10" parsley-minlength="1" parsley-required="true" autocomplete="off" />';
				html += '	</div>';
				html += '</div>';
				html += '<div class="form-group">';
				html += '	<label class="col-sm-3 control-label">Judul</label>';
				html += '	<div class="col-sm-7">';
				html += '		<div class="input-group">';
				html += '			<input type="text" name="judul" class="form-control" value="'+$('#judul').val()+'" parsley-minlength="3" parsley-required="true" autocomplete="off" readonly />';
				html += '			<span class="input-group-addon btn btn-sm" data-placement="right" data-toggle="tooltip" rel="tooltip" data-original-title="Hapus Buku" onclick="remover('+i+');">';
				html += '				<i class="fa fa-minus"></i>';
				html += '			</span>';
				html += '		</div>';
				html += '	</div>';
				html += '</div>';
				html += '</div>';
				$('#kode,#judul').val('');
				$('#added').append(html);
			});
			$('#cancel').click(function(){
				$('#added').empty();
				i = 0;
			});
		});
		function remover(x){
			$("#"+x).remove();
		}
	</script>
@endsection
