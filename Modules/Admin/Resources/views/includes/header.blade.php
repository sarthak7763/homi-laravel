
    <nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="feather icon-menu"></i>
            </a>
            <a href="">
                <img src="{{asset('storage'.getLogo())}}" alt="Theme-Logo" class="img-fluid bg-light img-100">
                
            </a>
            <a class="mobile-options">
                <i class="feather icon-more-horizontal"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
             <ul class="nav-right">
                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            @if(Auth()->user()->profile_pic!="")
                            <img src="{{url('/')}}/images/user/{{ Auth()->user()->profile_pic}}" class="img-radius" alt="User">
                            @else
                            <img src="{{url('/')}}/no_image/user.jpg" class="img-radius" alt="User">
                            @endif
                            <span>{{Auth()->user()->name}}</span>
                            <i class="feather icon-chevron-down"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            @if(Auth::user()->hasRole('Admin'))
                                @elseif(Auth::user()->hasRole('sub-admin'))
                                @if(auth()->user()->can('admin-system-settings'))
                                <li>
                                    <a href="{{route('admin-system-settings')}}">
                                        <i class="feather icon-settings"></i> Settings
                                    </a>
                                </li>
                                @endif
                            @endif
                          
                            <li>
                                <a href="{{route('admin-profile')}}">
                                    <i class="feather icon-user"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin_logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="feather icon-log-out"></i>  {{ __('Logout') }}
                                    <form id="logout-form" action="{{ route('admin_logout') }}" method="POST" class="d-none"> @csrf </form>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>