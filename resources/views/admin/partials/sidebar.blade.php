<nav class="pcoded-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="{{ asset('index.html') }}" class="b-brand">
                <!-- <img src="{{ asset('assets/images/logo.svg') }}" alt="" class="logo images">
                <img src="{{ asset('assets/images/logo-icon.svg') }}" alt="" class="logo-thumb images"> -->
                <!-- <img class="logo-1" src="{{ asset('images/inter-logo.png') }}" alt="" style="width: 121px; height: 65px;"> -->
                <img class="logo-2" src="{{ asset('images/inter-logo.png') }}" alt="" style="width: 121px; height: 65px;">
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="#"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                <li data-username="dashboard" class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                @if(Auth::user()->can('view_cars'))
                <li data-username="invoice summury list" class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-minus"></i></span><span
								class="pcoded-mtext">Fleet</span></a>
						<ul class="pcoded-submenu">
							<li class=""><a href="{{ route('admin.car-categories.index') }}" class="">car category</a></li>
							<li class=""><a href="{{ route('admin.cars.index') }}" class="">Cars list</a></li>
						</ul>
					</li>
                @endif
                @if(Auth::user()->can('view_bookings'))
                <li data-username="bookings list" class="nav-item">
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-calendar"></i></span>
                        <span class="pcoded-mtext">Bookings</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->can('view_drivers'))
                <li data-username="drivers list" class="nav-item">
                    <a href="{{ route('admin.drivers.index') }}" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                        <span class="pcoded-mtext">Drivers</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->can('view_users'))
                <li data-username="users list" class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                        <span class="pcoded-mtext">Users</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->can('view_roles'))
                <li data-username="users list" class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-list"></i></span>
                        <span class="pcoded-mtext">Roles</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav> 