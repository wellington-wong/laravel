<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('layouts.head')
<body class="logged-in">
    <div id="app" class="fill">

        <div class="container-fluid fill">
            <div class="row fill">

                @if (!Auth::guest())
                <div class="col-sm-3 col-sidebar affix">
                @include('layouts.sidebar')
                </div>
                @endif
                <div class="col-sm-9 page-right main-content">
                    <div class="panel panel-default fill">
                        <div class="panel-heading top-navbar">
                            @include('layouts.navbar')
                        </div>

                        <div class="panel-body">
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                    <ul>
                                        @foreach (Session::get('success') as $msg)
                                        <li>{!! $msg !!}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if( !$errors->isEmpty() )
                                <div class="alert alert-warning">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    @include('layouts.scripts')

</body>
</html>
