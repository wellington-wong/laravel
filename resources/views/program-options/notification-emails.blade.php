@extends('layouts.app')

@section('pageTitle', 'Notification Emails')

@section('content')
    <div class="container-fluid notification-wrapper">    
        <div class="row">
        @include('layouts.page-header', ['header' => 'Notification Emails', 'col' => 12])
        </div>
    </div>

@endsection