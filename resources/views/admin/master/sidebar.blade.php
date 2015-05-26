<!-- BEGIN MAIN SIDEBAR -->
<nav id="sidebar">
	<div id="main-menu">
		<ul class="sidebar-nav">
			<li class="{{ setCurrent('admin.dashboard') }}">
				<a href="{{ action('Admin\HomeController@index') }}"> <i class="fa fa-dashboard"></i> <span class="sidebar-text">Dashboard</span></a>
			</li>
			<li class="{{ setActive('admin.book.index') }}{{ setActive('admin.book.create') }}{{ setActive('admin.book.show') }}{{ setActive('admin.book.edit') }}">
				<a href="#"> <i class="fa fa-book"></i> <span class="sidebar-text">Buku</span><span class="fa arrow"></span></a>
				<ul class="submenu collapse">
					<li class="{{ setCurrent('admin.book.create') }}">
						<a href="{{ action('Admin\BookController@create') }}"><span class="sidebar-text">Tambah Buku</span></a>
					</li>
					<li class="{{ setCurrent('admin.book.index') }}{{ setCurrent('admin.book.edit') }}">
						<a href="{{ action('Admin\BookController@index') }}"><span class="sidebar-text">Data Buku</span></a>
					</li>
					<li class="{{ setCurrenq('admin.book.index') }}">
						<a class="md-trigger" href="{{ url('admin/book/search') }}" data-modal="book"><span class="sidebar-text">Cari Buku</span></a>
					</li>
				</ul>
			</li>
			<li class="{{ setActive('admin.member.index') }}{{ setActive('admin.member.create') }}{{ setActive('admin.member.show') }}{{ setActive('admin.member.edit') }}">
				<a href="#"> <i class="fa fa-group"></i> <span class="sidebar-text">Anggota</span><span class="fa arrow"></span></a>
				<ul class="submenu collapse">
					<li class="{{ setCurrent('admin.member.create') }}">
						<a href="{{ action('Admin\MemberController@create') }}"><span class="sidebar-text">Tambah Anggota</span></a>
					</li>
					<li class="{{ setCurrent('admin.member.index') }}{{ setCurrent('admin.member.show') }}{{ setCurrent('admin.member.edit') }}">
						<a href="{{ action('Admin\MemberController@index') }}"><span class="sidebar-text">Data Anggota</span></a>
					</li>
					<li class="{{ setCurrenq('admin.member.index') }}">
						<a class="md-trigger" href="{{ url('admin/member/search') }}" data-modal="member"><span class="sidebar-text">Cari Anggota</span></a>
					</li>
				</ul>
			</li>
			<li class="{{ setActive('admin.borrow.index') }}{{ setActive('admin.borrow.create') }}{{ setActive('admin.borrow.show') }}{{ setActive('admin.borrow.return') }}">
				<a href="#"> <i class="fa fa-retweet"></i> <span class="sidebar-text">Peminjaman</span><span class="fa arrow"></span></a>
				<ul class="submenu collapse">
					<li class="{{ setCurrent('admin.borrow.create') }}">
						<a href="{{ action('Admin\BorrowController@create') }}"><span class="sidebar-text">Tambah Peminjaman</span></a>
					</li>
					<li class="{{ setCurrent('admin.borrow.return') }}">
						<a href="{{ route('admin.borrow.return') }}"><span class="sidebar-text">Tambah Pengembalian</span></a>
					</li>
					<li class="{{ setCurrent('admin.borrow.index') }}">
						<a href="{{ action('Admin\BorrowController@index') }}"><span class="sidebar-text">Data Peminjaman</span></a>
					</li>
					<li class="{{ setCurrenq('admin.borrow.index') }}">
						<a class="md-trigger" href="{{ url('admin/borrow/search') }}" data-modal="borrow"><span class="sidebar-text">Cari Peminjaman</span></a>
					</li>
				</ul>
			</li>
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
