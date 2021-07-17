<li class="side-menus {{ Request::is('admin','driver','user') ? 'active' : '' }}">
    <a class="nav-link" href="{{route(Role::is().'.dashboard')}}">
        <i class="fas fa-landmark"></i><span>Dashboard</span>
    </a>
</li>
@if(Auth::user()->role != 3)
<li class="side-menus {{ Request::is('user/withdrawal','driver/withdrawal') ? 'active' : ''}}">
    <a class="nav-link" href="{{route(Role::is().'.withdrawal')}}">
        <i class="fas fa-exchange-alt"></i><span>Penarikan Saldo</span>
    </a>
</li>
@endif
@if(Auth::user()->role == 3)
<li class="dropdown {{ Request::is('admin/accounts','admin/accounts/*') ? 'active' : ''}}">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>Akun</span></a>
        <ul class="dropdown-menu">
            <li class="{{ Route::is('admin.list_account') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.list_account')}}">Daftar Akun</a></li>
            <li class="{{ Route::is('admin.create_account') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.create_account')}}">Buat Akun</a></li>
        </ul>
    </li>
    <li class="side-menus {{ Route::is('admin.garbage') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.garbage')}}">
            <i class="fas fa-recycle"></i><span>Jenis Sampah</span>
        </a>
    </li>
    <li class="side-menus {{ Route::is('admin.banks') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.banks')}}">
            <i class="fas fa-money-check-alt"></i><span>Jenis Bank</span>
        </a>
    </li>
    <li class="side-menus {{ Route::is('admin.status_sells') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.status_sells')}}">
            <i class="fas fa-question"></i><span>Status Penjualan</span>
        </a>
    </li>
    <li class="dropdown {{ Request::is('admin/mail','admin/mail/*') ? 'active' : ''}}">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-envelope"></i><span>Pesan</span></a>
        <ul class="dropdown-menu">
            <li class="{{ Route::is('admin.contact_us_list') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.contact_us_list')}}">Pesan Masuk</a></li>
            <li class="{{ Route::is('admin.list_reply') ? 'active' : '' }}"><a class="nav-link" href="{{route('admin.list_reply')}}">Pesan Keluar</a></li>
        </ul>
    </li>
@endif