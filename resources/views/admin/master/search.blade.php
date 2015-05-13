<div class="search">
	<div class="md-modal md-effect-15" id="book">
		<div class="md-content md-content-white">
			<h3>Cari Buku <span class="pull-right" title="close"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
			<div class="p-b-10 m-t-10">
				<form class="form-horizontal" method="get" action="{{ route('admin.book.index') }}">
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
			<h3>Cari Anggota <span class="pull-right" title="close"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
			<div class="p-b-10 m-t-10">
				<form class="form-horizontal" method="get" action="{{ route('admin.member.index') }}">
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
			<h3>Cari Peminjaman <span class="pull-right" title="close"><a class="c-dark md-close" href="#"><i class="fa fa-times"></i></a></span></h3>
			<div class="p-b-10 m-t-10">
				<form class="form-horizontal" method="get" action="{{ route('admin.borrow.index') }}">
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
	<div class="md-overlay"></div><!-- the overlay element -->
</div>
