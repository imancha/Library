<!-- BEGIN MAIN SIDEBAR -->
<nav id="sidebar">
	<div id="main-menu">
		<ul class="sidebar-nav">
			<li class="{{ setCurrent('admin.dashboard') }}">
				<a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i><span class="sidebar-text">Dashboard</span></a>
			</li>
			<li class="{{ setActive('admin.book.index') }}{{ setActive('admin.book.create') }}{{ setActive('admin.book.show') }}">
				<a href="#"><i class="fa fa-book"></i><span class="sidebar-text">Buku</span><span class="fa arrow"></span></a>
				<ul class="submenu collapse">
					<li class="{{ setCurrent('admin.book.create') }}">
						<a href="{{ action('BookController@create') }}"><span class="sidebar-text">Tambah Buku</span></a>
					</li>
					<li class="{{ setCurrent('admin.book.index') }}{{ setCurrent('admin.book.show') }}">
						<a href="{{ action('BookController@index') }}"><span class="sidebar-text">Koleksi Buku</span></a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<div class="footer-widget">
		<img src="{{ asset('/assets/img/gradient.png') }}" alt="gradient effet" class="sidebar-gradient-img" />
		<div class="sidebar-footer clearfix">
			<a class="pull-left" href="" rel="tooltip" data-placement="top" data-original-title="Settings"><i class="glyph-icon flaticon-settings21"></i></a>
			<a class="pull-left toggle_fullscreen" href="#" rel="tooltip" data-placement="top" data-original-title="Fullscreen"><i class="glyph-icon flaticon-fullscreen3"></i></a>
			<a class="pull-left" href="{{ route('admin.lockscreen') }}" rel="tooltip" data-placement="top" data-original-title="Lockscreen"><i class="glyph-icon flaticon-padlock23"></i></a>
			<a class="pull-left" href="{{ url('/auth/logout') }}" rel="tooltip" data-placement="top" data-original-title="Logout"><i class="fa fa-power-off"></i></a>
		</div>
	</div>
</nav>
<!-- END MAIN SIDEBAR -->
