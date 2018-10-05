@extends('layouts.app')

@section('pageTitle', 'Reviews')

@section('content')

    <div class="container-fluid reviews-wrapper">


        @if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin']))

        <div class="row">
            @include('layouts.page-header', ['header' => 'Reviews', 'col' => 6])
            <div class="col-md-6 text-right"><a href="{{ route('create-reviews') }}">Create a Review</a></div>
        </div>
        @else
        <div class="row">
        @include('layouts.page-header', ['header' => 'Submitted Reviews', 'col' => 12, 'class' => 'customer-reviews'])
        </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                @include('reviews.partials.reviews-table', [ 'route' => '' ])
            </div>
        </div>
        <div class="clearfix"></div>

@endsection