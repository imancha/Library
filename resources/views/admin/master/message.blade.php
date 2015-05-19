@if(Session::has('message'))
<div class="messages">
	<div class="alert alert-success" role="alert">
		<i class='fa fa-check-square-o' style='padding-right:6px'></i>
		<button type="button" class="close" data-dismiss="alert">×</button>
		<span class="glyphicon glyphicon-exclamation-ok-sign" aria-hidden="true"></span>
		<span class="sr-only">Success:</span>
		{{ Session::get('message') }}
	</div>
</div>
@endif
@if(count($errors) > 0)
<div class="messages">
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<h4><i class='fa fa-ban' style='padding-right:6px'></i> Error!</h4>
		<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
	</div>
</div>
@endif
