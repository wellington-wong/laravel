<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="env" content="{{ config('app.env') }}" >
    @if ( 'local' == config('app.env') )
        <meta name="robots" content="noindex" >
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('pageTitle', '') | {{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://app.{{ env('DOMAIN') }}{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://app.{{ env('DOMAIN') }}{{ mix('css/all.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Domine" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>