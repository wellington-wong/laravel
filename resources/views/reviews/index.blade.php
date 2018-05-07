@extends('layouts.app')

@section('pageTitle', 'Reviews')

@section('content')

    <div class="container-fluid reviews-wrapper">
    
        @include('reviews.partials.reviews-table', [ 'route' => '' ])

        @if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin']))

        <div class="row">
            @include('layouts.page-header', ['header' => 'Reviews', 'col' => 3])
        </div>
        @else
        <div class="row">
        @include('layouts.page-header', ['header' => 'Your Submitted Referrals', 'col' => 12, 'class' => 'customer-referrals'])
        </div>
        @endif

        <div class="clearfix"></div>

@endsection