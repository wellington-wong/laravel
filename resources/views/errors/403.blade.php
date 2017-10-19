@section('pageTitle', '403 Forbidden')
@include('auth.document-top')

    <form class="render-wrap"></form>
        <!-- Start Header -->
        <header>
        @include('auth.header')
        </header>
        <!-- End Header -->

        <!-- Start Main -->
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 main-content">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row top-content-wrapper">
                                    <div class="top-content text-center">
                                        <span>403 Forbidden</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center">You don't have permission to access <em>{{ Request::url() }}</em> on this server.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- End Main -->

<!-- Start Footer -->
@include('auth.footer')
<!-- End Footer -->
