
            <section class="container">
                <div class="row">
                    <nav>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <figure class="logo col-xs-3 col-md-2"><a href="https://www.perxi.com/ title="Referrals"><img src="{{ isset($_company->logo) ? $_company->logo : '/images/logo-main.png' }}" alt=""></a></figure>
                        <div class="col-xs-12 col-md-9 collapse navbar-collapse pull-right" id="app-navbar-collapse">
                            <ul class="nav navbar-nav navbar-right navbar-bottom-right pull-left">
                                <li><a href="https://www.perxi.com/how-it-works/">How it Works</a></li>
                                <li><a href="https://www.perxi.com/features/">Features</a></li>
                                <li><a href="https://www.perxi.com/about-us/">About Us</a></li>
                                <li><a href="https://www.perxi.com/pricing/">Pricing</a></li>
                                <li><a href="https://www.perxi.com/contact/">Contact</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right navbar-bottom-right-access pull-right">
                                <li><a href="{{ route('login') }}" class="login-link">Login</a></li>
                                <li><a href="{{ route('register') }}" class="register-link">Register</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </section>