@extends('layouts.app')

@section('pageTitle', 'Reviews')

@section('content')

    <div class="container-fluid reviews-wrapper">


        @if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin']))

        <div class="row">
            @include('layouts.page-header', ['header' => 'Reviews', 'col' => 3])
        </div>
        @else
        <div class="row">
        @include('layouts.page-header', ['header' => 'Your Submitted Referrals', 'col' => 12, 'class' => 'customer-referrals'])
        </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                @include('reviews.partials.reviews-table', [ 'route' => '' ])
            </div>
        </div>
        <div class="clearfix"></div>

@endsection