        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <div class="col-md-3">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    324 Messages
                </div>
                <div class="col-md-9">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown pull-left">
                                Hi <a href="{{ route('manage-account') }}" class="" role="button" aria-expanded="false">{{ Auth::user()->name }}</a> 
                                <span class="nav-separator">|</span> <a href="{{ route('manage-account') }}">Settings <i class="fa fa-angle-down" aria-hidden="true"></i></a>
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