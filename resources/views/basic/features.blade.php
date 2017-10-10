@section('pageTitle', isset($page->title) ? $page->title : null)
@include('auth.document-top')
        <!-- Start Header -->
        <header>
        @include('auth.header')
        </header>
        <!-- End Header -->
        <!-- Start Main -->
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 main-content">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                {!!  isset($page->content) ? $page->content : null !!}        
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