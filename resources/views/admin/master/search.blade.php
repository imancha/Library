<div class="search">
	<div class="md-modal md-effect-15" id="book">
		<div class="md-content md-content-white">
			<h3>Cari Buku <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
			<div class="p-b-10 m-t-10">
				<form class="form-horizontal" method="get" action="{{ action('Admin\BookController@index') }}">
					<div class="form-group">
						<label class="control-label sr-only">Search:</label>
						<input class="form-control" type="text" name="q" placeholder="Type something . . ." autofocus required>
					</div>
					<div class="form-group">
						<button class="btn btn-dark btn-transparent btn-rounded">Cari</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="md-modal md-effect-15" id="member">
		<div class="md-content md-content-white">
			<h3>Cari Anggota <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
			<div class="p-b-10 m-t-10">
				<form class="form-horizontal" method="get" action="{{ action('Admin\MemberController@index') }}">
					<div class="form-group">
						<label class="control-label sr-only">Search:</label>
						<input class="form-control" type="text" name="q" placeholder="Type something . . ." autofocus required>
					</div>
					<div class="form-group">
						<button class="btn btn-dark btn-transparent btn-rounded">Cari</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="md-modal md-effect-15" id="borrow">
		<div class="md-content md-content-white">
			<h3>Cari Peminjaman <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
			<div class="p-b-10 m-t-10">
				<form class="form-horizontal" method="get" action="{{ action('Admin\BorrowController@index') }}">
					<div class="form-group">
						<label class="control-label sr-only">Search:</label>
						<input class="form-control" type="text" name="q" placeholder="Type something . . ." autofocus required>
					</div>
					<div class="form-group">
						<button class="btn btn-dark btn-transparent btn-rounded">Cari</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="md-modal md-effect-4" id="account">
		<div class="md-content md-content-white">
			<h3>Account <span class="pull-right" title="Close"><a class="c-dark md-close" href=""><i class="fa fa-times"></i></a></span></h3>
			<div class="p-b-10 m-t-10">
				<form class="form-horizontal" method="post" action="{{ Action('Admin\UserController@update') }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group m-b-0">
						<label class="control-label" style="text-align:left !important">Nama:</label>
						<input class="form-control" type="text" name="nama" placeholder="Nama" value="{{ Auth::user()->name }}" autocomplete="off" required disabled>
					</div>
					<div class="form-group m-b-0">
						<label class="control-label" style="text-align:left !important">Email:</label>
						<input class="form-control" type="email" name="email" placeholder="Email" value="{{ Auth::user()->email }}" autocomplete="off" required disabled>
					</div>
					<div class="form-group m-b-0 sr-only">
						<label class="control-label" style="text-align:left !important">Password:</label>
						<input class="form-control" type="password" name="password" placeholder="Password" value="" autocomplete="off" required>
					</div>
					<div class="form-group m-b-0 sr-only">
						<label class="control-label" style="text-align:left !important">New Password: <span class="pull-right text-muted">&nbsp;<small><sup>*</sup>kosongkan jika tidak ingin diubah</small></span></label>
						<input class="form-control" type="password" name="new" placeholder="New Password" value="" autocomplete="off">
					</div>
					<div class="form-group m-t-20">
						<button class="btn btn-dark btn-transparent btn-rounded" id="ubah">Ubah</button>
						<button class="btn btn-dark btn-transparent btn-rounded sr-only" id="submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="md-overlay"></div><!-- the overlay element -->
</div>
