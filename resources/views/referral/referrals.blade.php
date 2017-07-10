@extends('layouts.app')

@section('pageTitle', 'Referrals')

@section('content')

    <div class="container-fluid referrals-wrapper with-referral-counter">
        @include('referral.counter')

        <div class="col-md-12 text-right export-link"><a href="{{ route('referrals-export') . '?' . Request::getQueryString() }}">Export</a></div>

        <div class="row">
            @include('layouts.page-header', ['header' => 'Referrals', 'col' => 3])

            <div class="col-md-9 page-filters no-padding-lr">
                <div class="row">
                    <div class="col-md-4 filter-item search">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        {{ Form::text('q', old('q'), ['placeholder' => 'Search', 'class' => 'form-control text', 'data-query' => (isset($param->q) ? $param->q : ''), 'data-url' => route('referrals')]) }}            
                        {{ Form::submit('Search', ['placeholder' => 'Search', 'class' => 'btn btn-search btn-referrals']) }}
                    </div>
                    <div class="col-md-4 filter-item date-range">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        {{ Form::text('daterange', old('daterange'), ['class' => 'form-control text', 'data-query' => (isset($param->daterange) ? $param->daterange : '')] ) }}            
                        <i class="fa fa-angle-down" aria-hidden="true"></i>          
                    </div>
                    <div class="col-md-4 filter-item filter-by">                    
                        <div class="form-control text" data-toggle="dropdown">{{ (null !== app('request')->get('status')) ? \App\Referral::$status[app('request')->get('status')] : 'Filter By' }}</div>
                        <i class="fa fa-angle-down" aria-hidden="true"></i>          
                        <ul class="dropdown-menu">
                            @foreach ($referralStatus as $key => $status)
                                <li><a href="javascript:void(0)" data-id="{{ $status }}" data-query="{{ (isset($param->status) ? $param->status : '') }}" data-status="{{ $key }}">{{ \App\Referral::$status[$status] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        @include('referral.partials.referral-table')

@endsection