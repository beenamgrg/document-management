<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>
            <div class="navbar-brand">
                <!-- Logo icon -->
                <a href="{{ route('dashboard.index') }}">
                    {{ env('APP_NAME') }}
                </a>
            </div>
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav float-left mr-auto ml-3 pl-1"></ul>
            <ul class="navbar-nav float-right">
                <li class="nav-item d-none d-md-block">
                    <a class="nav-link" href="javascript:void(0)"> </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('assets/images/users/profile-pic.jpg') }}" alt="user" class="rounded-circle" width="40">
                        <span class="ml-2 d-none d-lg-inline-block">
                            <span>Hello,</span>
                            <span class="text-dark">User</span>
                            <i data-feather="chevron-down" class="svg-icon"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <a class="dropdown-item" href="#">
                            <i data-feather="user" class="svg-icon mr-2 ml-1"></i> My Profile
                        </a>

                        <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i data-feather="power" class="svg-icon mr-2 ml-1"></i> Logout
                        </a>
                    </div>
                    <form id="logout-form" action="{{ route('logout.submit') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>