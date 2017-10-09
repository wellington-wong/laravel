
            <section class="container">
                <div class="row">
                    <nav>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <figure class="logo col-xs-3 col-md-2"><a href="{{ route('login') }}" title="Referrals"><img src="{{ isset($_company->logo) ? $_company->logo : '/images/logo-main.png' }}" alt=""></a></figure>
                        <div class="col-xs-12 col-md-9 collapse navbar-collapse pull-right" id="app-navbar-collapse">
                            <ul class="nav navbar-nav navbar-right navbar-bottom-right-access">
                                <li><a href="{{ route('login') }}" class="login-link">Login</a></li>
                                <li><a href="{{ route('register') }}" class="register-link">Register</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right navbar-bottom-right">
                                <li><a href="{{ route('how-it-works') }}">How it Works</a></li>
                                <li><a href="{{ route('features') }}">Features</a></li>
                                <li><a href="{{ route('about-us') }}">About Us</a></li>
                                <li><a href="{{ route('pricing') }}">Pricing</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </section>