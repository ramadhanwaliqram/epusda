<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            <div class="pcoded-navigation-label">Navigation</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ request()->is('superadmin') ? 'active' : '' }}">
                    <a href="{{ route('superadmin.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->is('superadmin/slider') ? 'active' : '' }}">
                    <a href="{{ route('superadmin.slider') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-list"></i>
                        </span>
                        <span class="pcoded-mtext">Slider</span>
                    </a>
                </li>
                <li class="{{ request()->is('superadmin/pengumuman') ? 'active' : '' }}">
                    <a href="{{ route('superadmin.pengumuman.pengumuman') }}" class="waves-effect waves-dark">
                       <span class="pcoded-micon">
                           <i class="fa fa-bell"></i>
                       </span>
                       <span class="pcoded-mtext">Pengumuman</span>
                   </a>
                </li>
                <li class="{{ request()->is('superadmin/list-user/list-user') ? 'active' : '' }}">
                    <a href="{{ route('superadmin.list-user') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-user"></i>
                        </span>
                        <span class="pcoded-mtext">List user</span>
                    </a>
                </li>
                {{-- <li class="@if (request()->is('superadmin/library/tambah-baru') || request()->is('superadmin/library/setting')) pcoded-hasmenu active pcoded-trigger @else pcoded-hasmenu @endif">
                    <a href="#" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-book"></i>
                        </span>
                        <span class="pcoded-mtext">Library</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->is('superadmin/library/tambah-baru') ? 'active' : '' }}">
                            <a href="{{ route('superadmin.library.tambah-baru') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Tambah Baru</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('superadmin/library/setting') ? 'active' : '' }}">
                            <a href="{{ route('superadmin.library.setting') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Setting</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>
</nav>
