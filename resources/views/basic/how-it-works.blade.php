@section('pageTitle', isset($page->title) ? $page->title : null)
@include('auth.document-top')
        <!-- Start Header -->
        <header>
            <div class="row header-right">
                <div class="col-xs-12 col-md-12 pull-right">
                    <ul class="nav navbar-nav navbar-right navbar-top-right">
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
            </div>
        @include('auth.header')
        </header>
        <!-- End Header -->
        <!-- Start Main -->
		<main>
            <div class="container">
              <div class="row">
                {!!  isset($page->content) ? $page->content : 'Content unavailable.' !!}
		      </div>   
            </div>
        </main>
        <!-- End Main -->
<!-- Start Footer -->
@include('auth.footer')
<!-- End Footer -->