@extends('layouts.app')

@section('pageTitle', 'Referral History')

@section('content')

    <div class="container-fluid referrals-history with-referral-counter">
        
        <div class="row">
            @include('layouts.page-header', ['header' => 'Referral History', 'col' => 3])

            <div class="col-md-9 page-filters no-padding-lr">
                <div class="row">
                    <div class="col-md-4 filter-item search pull-right">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        {{ Form::text('q', old('q'), ['placeholder' => 'Search', 'class' => 'form-control text', 'data-query' => (isset($param->q) ? $param->q : ''), 'data-url' => route('referral-history')]) }}            
                        {{ Form::submit('Search', ['placeholder' => 'Search', 'class' => 'btn btn-search history']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th><a href="{{ route('referral-history', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['created_at'], 'column' => 'created_at']) }}">Updated <i class="fa fa-sort{{ $sortc['created_at']?:'' }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route('referral-history', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['id'], 'column' => 'id']) }}">Referral ID <i class="fa fa-sort{{ $sortc['id'] }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route('referral-history', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['user_id'], 'column' => 'user_id']) }}">Submitted By <i class="fa fa-sort{{ $sortc['user_id'] }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route('referral-history', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['referred'], 'column' => 'referred']) }}">Person Referred <i class="fa fa-sort{{ $sortc['referred'] }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route('referral-history', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['status'], 'column' => 'status']) }}">Status <i class="fa fa-sort{{ $sortc['status'] }}" aria-hidden="true"></i></a></th>
                        </tr>
                    </thead> 
                    @foreach($referrals as $r)
                        <tr>
                            <td>{{ $r->referred->created_at->format('m/d/y') }}</td>
                            <td><a href="{{ route('referral-history-details', [$r->id]) }}">{{ $r->id }}</a></td>
                            <td><a href="{{ route('referral-history-details', [$r->id]) }}">{{ auth()->user()->name }}</a></td>
                            <td><a href="{{ route('referral-history-details', [$r->id]) }}">{{ $r->referred->display_name }}</a></td>
                            <td class="referral-status" data-id="{{ $r->id }}">{{ \App\Referral::$status[$r->status] }}</td>
                        </tr>
                    @endforeach
                    @if (!count($referrals))<tr><td colspan="5">No referrals found.</td></tr>@endif
                </table>

            </div>
        </div>
        @include('layouts.modal')
    </div>

@endsection