<nav class="navbar navbar-header navbar-expand-lg" style="background-color: #6C81C6">

    <div class="container-fluid">

        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item toggle-nav-search hidden-caret">
                <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false"
                    aria-controls="search-nav">
                    <i class="fa fa-search"></i>
                </a>
            </li>



            <li class="nav-item dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        <img src="{{ asset('template-dashboard') }}/assets/img/profile.jpg"
                            alt="{{ asset('template-dashboard') }}." class="avatar-img rounded-circle">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg"><img
                                        src="{{ asset('template-dashboard') }}/assets/img/profile.jpg"
                                        alt="image profile" class="avatar-img rounded"></div>
                                <div class="u-text">
                                    <h4>Admin</h4>
                                    <p class="text-muted">Hello Admin</p>

                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ route('auth.logout') }}">Logout</a>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
