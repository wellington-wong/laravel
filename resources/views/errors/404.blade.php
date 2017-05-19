@include('auth.document-top')

    <div id="stage1" class="build-wrap"></div>
    <form class="render-wrap"></form>
        <!-- Start Header -->
        <header>
            <div class="row header-right">
                <div class="col-xs-12 col-md-12 pull-right">
                    <ul class="nav navbar-nav navbar-right navbar-top-right">
                        <li><a href="{{ route('register') }}">Login</a></li>
                    </ul>
                </div>
            </div>
        @include('auth.header')
        </header>
        <!-- End Header -->

        <!-- Start Main -->
        <main>
            <div class="row top-content-wrapper">
                <div class="top-content text-center">
                    <span>404 Not Found</span>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 main-content">
                        <p>The requested URL <em>{{ Request::url() }}</em> was not found on this server.
                    </div>
                </div>
            </div>
        </main>
        <!-- End Main -->

<!-- Start Footer -->
@include('auth.footer')
<!-- End Footer -->
