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
                        {{ Form::text('q', old('q'), ['placeholder' => 'Search', 'class' => 'form-control text', 'data-query' => (isset($param->q) ? $param->q : '')]) }}            
                        {{ Form::submit('Search', ['placeholder' => 'Search', 'class' => 'btn btn-search']) }}
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

        <div class="row">
            <div class="col-md-12 table-referral-wrapper">
                <table class="table table-referral tablesaw tablesaw-stack" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th><a href="{{ route('referrals', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['created_at'], 'column' => 'created_at']) }}">Submitted <i class="fa fa-sort{{ $sortc['created_at']?:'' }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route('referrals', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['id'], 'column' => 'id']) }}">Referral ID <i class="fa fa-sort{{ $sortc['id'] }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route('referrals', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['user_id'], 'column' => 'user_id']) }}">Submitted By <i class="fa fa-sort{{ $sortc['user_id'] }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route('referrals', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['referred'], 'column' => 'referred']) }}">Person Referred <i class="fa fa-sort{{ $sortc['referred'] }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route('referrals', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['status'], 'column' => 'status']) }}">Status <i class="fa fa-sort{{ $sortc['status'] }}" aria-hidden="true"></i></a></th>
                        </tr>
                    </thead> 
                    @foreach($referrals as $r)
                        <tr>
                            <td>{{ $r->referred->created_at->format('m/d/y') }}</td>
                            <td><a href="{{ $r->id }}">{{ $r->id }}</a></td>
                            <td><a href="{{ $r->user_id }}">{{ auth()->user()->name }}</a></td>
                            <td><a href="{{ $r->referred->id }}">{{ $r->referred->display_name }}</a></td>
                            <td class="referral-status" data-id="{{ $r->id }}">
                                <div class="form-control" data-toggle="dropdown">{{ \App\Referral::$status[$r->status] }}</div>
                                @can('change-referral-statuses')<ul class="dropdown-menu">                                
                                    @foreach ($referralStatus as $key => $status)
                                        <li><a href="javascript:void(0)" data-status="{{ $status }}">{{ \App\Referral::$status[$status] }}</a></li>
                                    @endforeach
                                </ul>
                                <i class="fa fa-angle-down" aria-hidden="true"></i>@endcan
                            </td>
                        </tr>
                    @endforeach
                    @if (!count($referrals))<tr><td colspan="5">No referrals found.</td></tr>@endif
                </table>
                {{ $referrals->links() }}
            </div>
        </div>
        @include('layouts.modal')
    </div>

@endsection