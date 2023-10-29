<!-- Topbar Start -->
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ asset('assets/images/users/avatar-4.jpg') }}" alt="user-image" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                        {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->name) }}) <i class="mdi mdi-chevron-down"></i> 
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h6 class="m-0">
                            Welcome !
                        </h6>
                    </div>

                    <a href="{{ route('account_settings') }}" class="dropdown-item notify-item">
                        <i class="dripicons-user"></i>
                        <span>Account Settings</span>
                    </a>
                    <!-- item-->
                    {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="dripicons-user"></i>
                        <span>My Account</span>
                    </a> --}}

                    <!-- item-->
                    <a class="dropdown-item notify-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="dripicons-power"></i>
                        <span>Logout</span>
                    </a>
                    

                    <form id="logout-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                    </form>

                </div>
            </li>

        </ul>

        <ul class="list-unstyled menu-left mb-0">
            <li class="float-left">
                <a href="#" class="logo">
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/default_logo.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="24">
                    </span>
                </a>
            </li>
            <li class="float-left">
                <a class="button-menu-mobile navbar-toggle">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
<!-- end Topbar -->