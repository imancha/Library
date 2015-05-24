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
				<div class="panel panel-default">
					<div class="panel-heading bg-red">
						<h3 class="panel-title"><strong>Tambah</strong> Peminjaman</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<form id="form4" class="form-horizontal icon-validation" role="form" method="POST" action="{{ action('Admin\BorrowController@store') }}" parsley-validate>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group">
										<label class="col-sm-3 control-label">ID Peminjaman</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" id="idp" name="idp" class="form-control" value="P{{ $borrow }}" maxlength="10" size="10" parsley-minlength="1" parsley-required="true" autocomplete="off" autofocus />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">NIP/NIM/NIS</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" name="id" class="form-control" value="{{ old('id') }}" parsley-type="digits" parsley-minlength="3" parsley-required="true" autocomplete="off" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Nama</label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" name="nama" class="form-control" value="{{ old('nama') }}" parsley-minlength="3" parsley-required="true" autocomplete="off" />
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
												<span id="plus" class="input-group-addon btn btn-sm" data-placement="left" data-toggle="tooltip" rel="tooltip" data-original-title="Tambah Buku">
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
			$('input:text[name="id"]').autocomplete({
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
			$('input:text[name="id"]').on('keypress, change',function(){
				$.ajax({
					url:"{!! action('Admin\HomeController@postMember') !!}",
					dataType:'json',
					type:'POST',
					data:{
						'id':1,
						'id1':$('input:text[name="id"]').val(),
					},
					cache:false,
					success:function(data){
						if(!jQuery.isEmptyObject(data))
							$('input:text[name="nama"]').val('').val(data[0].nama);
					},
				});
			});
			$('#kode').on('keypress, change', function(){
				$.ajax({
					url:"{!! action('Admin\HomeController@postBook') !!}",
					dataType:'json',
					type:'POST',
					data:{'kode':$('#kode').val()},
					cache:false,
					success:function(data){
						if(!jQuery.isEmptyObject(data))
							$('#judul').val('').val(data[0].judul);
					},
				});
			});
			$('#plus').click(function(){
				$('#kode,#judul').val('');
				$('#added').append(
					'<div id="'+(++i)+'">'+
						'<div class="form-group">'+
							'<label class="col-sm-3 control-label">Kode Buku</label>'+
							'<div class="col-sm-7 input-icon right">'+
								'<i class="fa"></i>'+
								'<input type="text" name="kode[]" class="form-control" value="'+$('#kode').val()+'" maxlength="10" size="10" parsley-minlength="1" parsley-required="true" autocomplete="off" />'+
							'</div>'+
						'</div>'+
						'<div class="form-group">'+
							'<label class="col-sm-3 control-label">Judul</label>'+
							'<div class="col-sm-7">'+
								'<div class="input-group">'+
									'<input type="text" name="judul" class="form-control" value="'+$('#judul').val()+'" autocomplete="off" readonly />'+
									'<span class="input-group-addon btn btn-sm" data-placement="left" data-toggle="tooltip" rel="tooltip" title="Hapus Buku" data-original-title="Hapus Buku" onclick="remover('+i+');">'+
										'<i class="fa fa-minus"></i>'+
									'</span>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>'
				);
			});
			$('#cancel').click(function(){
				$('#added').empty();
				i = 0;
			});
		});
		function remover(x){$("#"+x).remove();}
	</script>
@endsection
