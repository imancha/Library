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
				<div class="panel panel-default">
					<div class="panel-heading bg-red">
						<h3 class="panel-title"><strong>Tambah</strong> Pengembalian</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<form id="form4" class="form-horizontal icon-validation" role="form" method="POST" action="{{ action('Admin\BorrowController@update','return') }}" parsley-validate>
									<input name="_method" type="hidden" value="PATCH">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group">
										<div class="col-sm-2 col-md-offset-1">
											<select class="form-control show-menu-arrow" name="tipe">
												<option value="1" selected>NIP/NIM/NIS</option>
												<option value="2">Kode Buku</option>
											</select>
										</div>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<span id="id1">
												<input type="text" name="id1" class="form-control" value="" autocomplete="off" autofocus />
											</span>
											<span id="id2">
												<input type="text" name="id2" class="form-control" value="" autocomplete="off" autofocus />
											</span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" id="select"></label>
										<div class="col-sm-7 input-icon right">
											<i class="fa"></i>
											<input type="text" name="nama" class="form-control" value="" parsley-minlength="3" parsley-required="true" autocomplete="off" readonly />
										</div>
									</div>
									<hr>
									<div id="table1" class="form-group sr-only">
										<div class="col-md-12 col-sm-12 col-xs-12 table-responsive table-red">
											<table class="table table-bordered">
												<thead>
													<tr>
														<th class="text-center">ID</th>
														<th class="text-center">Kode Buku</th>
														<th class="text-center">Judul Buku</th>
														<th class="text-center">Tanggal Pinjam</th>
														<th class="text-center">Dikembalikan</th>
													</tr>
												</thead>
												<tbody id="tbody1"></tbody>
											</table>
										</div>
									</div>
									<div id="table2" class="form-group sr-only">
										<div class="col-md-12 col-sm-12 col-xs-12 table-responsive table-red">
											<table class="table table-bordered">
												<thead>
													<tr>
														<th class="text-center">ID</th>
														<th class="text-center">NIP/NIM/NIS</th>
														<th class="text-center">Nama</th>
														<th class="text-center">Tanggal Pinjam</th>
														<th class="text-center">Dikembalikan</th>
													</tr>
												</thead>
												<tbody id="tbody2"></tbody>
											</table>
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
			var option = ['Nama','Judul Buku'];
			var select = $('select[name="tipe"]').val();
			$('input:text[name="id1"]').autocomplete({
				source:[{
					data:{!! $members !!}
				}],
				valueKey:'member_id',
				limit:'10',
				openOnFocus:false,
			});
			$('input:text[name="id2"]').autocomplete({
				source:[{
					data:{!! $books !!}
				}],
				valueKey:'book_id',
				limit:'10',
				openOnFocus:false,
			});
			$('label#select').empty().append(option[select-1]);
			if(select==1) $('#id2').toggle();
			else $('#id1').toggle();
			$('select[name="tipe"]').change(function(){
				select = $('select[name="tipe"]').val();
				$('label#select').empty().append(option[select-1]);
				$('#id1,#id2').toggle();
				$('.xdsoft_autocomplete_dropdown').css('top','37px');
			});
			$.ajaxSetup({
        headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
			});
			$('input:text[name="id1"],input:text[name="id2"]').on('keypress, change', function(){
				$.ajax({
					url:'{!! route('admin.member.borrow') !!}',
					dataType:'json',
					type:'POST',
					data:{
						'id' :$('select[name="tipe"]').val(),
						'id1':$('input:text[name="id1"]').val(),
						'id2':$('input:text[name="id2"]').val(),
					},
					cache:false,
					success:function(data){
						if((data != null) && (data != undefined) && (data.length != 0)){
							if(select==1)
								$('input:text[name="nama"]').val(data[0].nama);
							else
								$('input:text[name="nama"]').val(data[0].judul);
						}
					},
				});
			});
			$('input:text[name="id1"],input:text[name="id2"]').change(function(){
				$.ajax({
					url:'{!! route('admin.book.return') !!}',
					dataType:'',
					type:'POST',
					data:{
						'id' :$('select[name="tipe"]').val(),
						'id1':$('input:text[name="id1"]').val(),
						'id2':$('input:text[name="id2"]').val(),
					},
					cache:false,
					success:function(data){
						if(!$('#table1').hasClass('sr-only')) $('#table1').addClass('sr-only');
						if(!$('#table2').hasClass('sr-only')) $('#table2').addClass('sr-only');
						$('#tbody1,#tbody2').empty();
						if((data != null) && (data != undefined) && (data.length != 0)){
							if(select==1){
								$('#table1').removeClass('sr-only');
								for(row in data){
									$('#tbody1').append(
										'<tr>'+
											'<td class="text-center">'+data[row].id+'</td>'+
											'<td>'+data[row].book_id+'</td>'+
											'<td>'+data[row].judul+'</td>'+
											'<td class="text-center">'+data[row].tanggal_pinjam+'</td>'+
											'<td class="text-center"><input type="checkbox" name="kode[]" value="'+data[row].id+'/'+data[row].book_id+'"></td>'+
										'</tr>'
									);
								}
							}else{
								$('#table2').removeClass('sr-only');
								for(row in data){
									$('#tbody2').append(
										'<tr>'+
											'<td class="text-center">'+data[row].id+'</td>'+
											'<td>'+data[row].member_id+'</td>'+
											'<td>'+data[row].nama+'</td>'+
											'<td class="text-center">'+data[row].tanggal_pinjam+'</td>'+
											'<td class="text-center"><input type="checkbox" name="kode[]" value="'+data[row].id+'/'+data[row].book_id+'"></td>'+
										'</tr>'
									);
								}
							}
						}
					},
				});
			});
			$('#cancel').click(function(){
				if(!$('#table1').hasClass('sr-only')) $('#table1').addClass('sr-only');
				if(!$('#table2').hasClass('sr-only')) $('#table2').addClass('sr-only');
				$('#tbody1,#tbody2').empty();
			});
		});
	</script>
@endsection
