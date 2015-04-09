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
									<input name="_method" type="hidden" value="PATCH">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
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
											<input type="text" id="nama" name="nama" class="form-control" value="" parsley-minlength="3" parsley-required="true" autocomplete="off" readonly />
										</div>
									</div>
									<hr>
									<div id="table" class="form-group">
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
												<tbody id="tbody"></tbody>
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
			$('#id').autocomplete({
				source:[{
					data:{!! $borrows !!}
				}],
				valueKey:'member_id',
				limit:'10',
				openOnFocus:false,
			});
			$.ajaxSetup({
        headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
			});
			$('#table').hide();
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
			$('#id').change(function(){
				$.ajax({
					url:'{!! route('admin.book.return') !!}',
					dataType:'',
					type:'POST',
					data:{'id':$('#id').val()},
					cache:false,
					success:function(data){
						$('#tbody').empty();
						if((data != null) && (data != undefined) && (data.length != 0)){
							$('#table').show();
							for(row in data){
								var html = '<tr>';
								html += '	<td class="text-center">'+data[row].id+'</td>';
								html += '	<td>'+data[row].book_id+'</td>';
								html += '	<td>'+data[row].judul+'</td>';
								html += '	<td class="text-center">'+data[row].tanggal_pinjam+'</td>';
								html += '	<td class="text-center"><input type="checkbox" name="kode[]" value="'+data[row].id+'/'+data[row].book_id+'"></td>';
								html += '</tr>';
								$('#tbody').append(html);
							}
						}else{
							$('#table').hide();
						}
					},
				});
			});
			$('#cancel').click(function(){
				$('#table').hide();
				$('#tbody').empty();
			});
		});
	</script>
@endsection
