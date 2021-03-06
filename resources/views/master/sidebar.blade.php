	<!-- BEGIN MAIN SIDEBAR -->
	<nav id="sidebar">
		<div id="main-menu">
			<ul class="sidebar-nav">
				<li class="{{ setCurrent('admin.dashboard') }}" title="Dashboard">
					<a href="{{ action('Admin\HomeController@index') }}"> <i class="fa fa-dashboard"></i> <span class="sidebar-text">Dashboard</span></a>
				</li>
				@if(Auth::user()->status == 'kabag')
					<li class="{{ setCurrent('admin.book.index') }}{{ setCurrenq('admin.book.index') }}" title="Buku">
						<a href="{{ action('Admin\BookController@index') }}"> <i class="fa fa-book"></i> <span class="sidebar-text">Buku</span></a>
					</li>
					<li class="{{ setCurrent('admin.member.index') }}{{ setCurrent('admin.member.show') }}{{ setCurrenq('admin.member.index') }}" title="Anggota">
						<a href="{{ action('Admin\MemberController@index') }}"> <i class="fa fa-group"></i> <span class="sidebar-text">Anggota</span></a>
					</li>
					<li class="{{ setCurrent('admin.borrow.index') }}{{ setCurrenq('admin.borrow.index') }}" title="Peminjaman">
						<a href="{{ action('Admin\BorrowController@index') }}"> <i class="fa fa-retweet"></i> <span class="sidebar-text">Peminjaman</span></a>
					</li>
				@else
					<li class="{{ setActive('admin.book.index') }}{{ setActive('admin.book.create') }}{{ setActive('admin.book.show') }}{{ setActive('admin.book.edit') }}">
						<a href="#" title="Buku"> <i class="fa fa-book"></i> <span class="sidebar-text">Buku</span><span class="fa arrow"></span></a>
						<ul class="submenu collapse">
							<li class="{{ setCurrent('admin.book.create') }}" title="Tambah Buku">
								<a href="{{ action('Admin\BookController@create') }}"><span class="sidebar-text">Tambah Buku</span></a>
							</li>
							<li class="{{ setCurrent('admin.book.index') }}{{ setCurrent('admin.book.edit') }}" title="Data Buku">
								<a href="{{ action('Admin\BookController@index') }}"><span class="sidebar-text">Data Buku</span></a>
							</li>
							<li class="{{ setCurrenq('admin.book.index') }}" title="Cari Buku">
								<a class="md-trigger" href="{{ url('admin/book/search') }}" data-modal="book"><span class="sidebar-text">Cari Buku</span></a>
							</li>
						</ul>
					</li>
					<li class="{{ setActive('admin.member.index') }}{{ setActive('admin.member.create') }}{{ setActive('admin.member.show') }}{{ setActive('admin.member.edit') }}">
						<a href="#" title="Anggota"> <i class="fa fa-group"></i> <span class="sidebar-text">Anggota</span><span class="fa arrow"></span></a>
						<ul class="submenu collapse">
							<li class="{{ setCurrent('admin.member.create') }}" title="Tambah Anggota">
								<a href="{{ action('Admin\MemberController@create') }}"><span class="sidebar-text">Tambah Anggota</span></a>
							</li>
							<li class="{{ setCurrent('admin.member.index') }}{{ setCurrent('admin.member.show') }}{{ setCurrent('admin.member.edit') }}" title="Data Anggota">
								<a href="{{ action('Admin\MemberController@index') }}"><span class="sidebar-text">Data Anggota</span></a>
							</li>
							<li class="{{ setCurrenq('admin.member.index') }}" title="Cari Anggota">
								<a class="md-trigger" href="{{ url('admin/member/search') }}" data-modal="member"><span class="sidebar-text">Cari Anggota</span></a>
							</li>
						</ul>
					</li>
					<li class="{{ setActive('admin.borrow.index') }}{{ setActive('admin.borrow.create') }}{{ setActive('admin.borrow.show') }}{{ setActive('admin.borrow.return') }}">
						<a href="#" title="Peminjaman"> <i class="fa fa-retweet"></i> <span class="sidebar-text">Peminjaman</span><span class="fa arrow"></span></a>
						<ul class="submenu collapse">
							<li class="{{ setCurrent('admin.borrow.create') }}" title="Tambah Peminjaman">
								<a href="{{ action('Admin\BorrowController@create') }}"><span class="sidebar-text">Tambah Peminjaman</span></a>
							</li>
							<li class="{{ setCurrent('admin.borrow.return') }}" title="Tambah Pengembalian">
								<a href="{{ route('admin.borrow.return') }}"><span class="sidebar-text">Tambah Pengembalian</span></a>
							</li>
							<li class="{{ setCurrent('admin.borrow.index') }}" title="Data Peminjaman">
								<a href="{{ action('Admin\BorrowController@index') }}"><span class="sidebar-text">Data Peminjaman</span></a>
							</li>
							<li class="{{ setCurrenq('admin.borrow.index') }}" title="Cari Peminjaman">
								<a class="md-trigger" href="{{ url('admin/borrow/search') }}" data-modal="borrow"><span class="sidebar-text">Cari Peminjaman</span></a>
							</li>
						</ul>
					</li>
				@endif
			</ul>
		</div>
		<div class="footer-widget">
			<img src="{{ asset('/assets/img/gradient.png') }}" alt="gradient effet" class="sidebar-gradient-img" />
			<div class="sidebar-footer clearfix">
				<a class="pull-left md-trigger" href="{{ url('admin/account') }}" data-modal="account" rel="tooltip" data-placement="top" data-original-title="Account"><i class="glyph-icon flaticon-account"></i></a>
				<a class="pull-left toggle_fullscreen" href="{{ url('admin/fullscreen') }}" rel="tooltip" data-placement="top" data-original-title="Fullscreen"><i class="glyph-icon flaticon-fullscreen3"></i></a>
				<a class="pull-left" href="{{ action('Admin\UserController@getLogout') }}" rel="tooltip" data-placement="top" data-original-title="Logout"><i class="fa fa-power-off"></i></a>
			</div>
		</div>
	</nav>
	<!-- END MAIN SIDEBAR -->
