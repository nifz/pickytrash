<form class="form-inline mr-auto" action="#">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
</form>
<ul class="navbar-nav navbar-right">

    @if(Auth::check())
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifikasi</div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @php $notifikasi = 1; @endphp
                    @if($notifikasi != NULL)
                        @php 
                            $address = DB::Table('addresses')->where('id_users', Auth::user()->id)->where('status',1)->first();
                            $auth = Role::is().'.';
                        @endphp
                        
                        <a href="{{ route(Role::is().'.settings') }}#addresses " class="dropdown-item @if(empty($address)) dropdown-item-unread @endif">
                            <div class="dropdown-item-icon bg-primary text-white">
                            <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="dropdown-item-desc">
                            Tambahkan alamat!
                            <div class="time @if(empty($address)) text-primary @endif">{{ Auth::user()->created_at->diffForHumans() }}</div>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown"
               class="nav-link dropdown-toggle image nav-link-lg nav-link-user" style="padding: 0;">
                <img alt="image" src="{{ asset(Auth::user()->photo) }}"
                     class="rounded-circle mr-1 thumbnail-rounded user-thumbnail " style="width: 30px; height: 30px;">
                <div class="d-sm-none d-lg-inline-block">
                    Halo, {{Auth::user()->name}}!</div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                @if(Auth::user()->role != 1)
                    <div class="dropdown-title">
                        Anda login sebagai, @if(Auth::user()->role == 2) Driver! @elseif(Auth::user()->role == 3) Admin! @endif
                    </div>
                @endif
                @if(Auth::user()->role != 3)
                    <div class="dropdown-title">
                        Saldo Rp.{{number_format(Wallet::amount(Auth::user()->id),0)}}
                    </div>
                @endif
                <a class="dropdown-item has-icon" href="{{ route(Role::is().'.settings') }}" data-id="{{ Auth::id() }}">
                    <i class="fas fa-cog"></i>Peraturan</a>
                <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger"
                   onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    @else
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                {{--                <img alt="image" src="#" class="rounded-circle mr-1">--}}
                <div class="d-sm-none d-lg-inline-block">{{ __('messages.common.hello') }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{ __('messages.common.login') }}
                    / {{ __('messages.common.register') }}</div>
                <a href="{{ route('login') }}" class="dropdown-item has-icon">
                    <i class="fas fa-sign-in-alt"></i> {{ __('messages.common.login') }}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('register') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user-plus"></i> {{ __('messages.common.register') }}
                </a>
            </div>
        </li>
    @endif
</ul>
