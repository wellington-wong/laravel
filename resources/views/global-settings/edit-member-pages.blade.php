@extends('layouts.app')

@section('pageTitle', 'Edit Member Page')

@section('content')

    <div class="container-fluid members-wrapper">        

        <div class="row">
            @include('layouts.page-header', ['header' => 'Edit Member Page', 'col' => 3])
        </div>

        <div class="clearfix"></div>

    </div>
@endsection
