@extends('layouts.app')

@section('pageTitle', 'Users')

@section('content')
    <div class="container-fluid users-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Users', 'col' => 12])
        </div>
    </div>

@endsection