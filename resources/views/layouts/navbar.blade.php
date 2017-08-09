        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <div class="col-sm-3 navbar-messages no-padding-lr">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    <a href="{{ route('messages') }}"><strong>{{ Session::get('messageCount') > 1 || Session::get('messageCount') == 0 ? Session::get('messageCount') . ' Messages' : Session::get('messageCount') . ' Message' }} </strong></a>
                </div>
                <div class="col-sm-9 no-padding-lr">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown pull-left navbar-settings-wrapper">
                                Hi {{ Auth::user()->displayName }} 
                                <span class="nav-separator">|</span> <a href="#" class="navbar-settings no-padding" data-toggle="dropdown" data-hover="dropdown">Settings <i class="fa fa-angle-down" aria-hidden="true"></i></a> 
                                <ul class="dropdown-menu">
                                  @if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin']))<li><a href="{{ route('program-options') }}">Program Options</a></li>@endif
                                  <li><a href="{{ route('manage-account') }}">Manage Account</a></li>
                                  <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
                                </ul>
                            </li>
                            <li class="logout pull-left">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">                                    
                                </a> 

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
