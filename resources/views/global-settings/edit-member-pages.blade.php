@extends('layouts.app')

@section('pageTitle', 'Login as user')

@section('content')

    <div class="container-fluid members-wrapper">        

        <div class="row">
            @include('layouts.page-header', ['header' => 'Edit Member Pages', 'col' => 3])
        </div>

        <div class="clearfix"></div>

    </div>
@endsection
