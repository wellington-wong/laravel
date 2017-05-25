@extends('layouts.app')

@section('pageTitle', 'Referrals')

@section('content')

    <div class="container-fluid referrals-wrapper">
        @include('referral.counter')

        <div class="col-md-12 text-right export-link"><a href="{{ route('referrals-export') }}">Export</a></div>

        @include('layouts.page-header', ['header' => 'Referrals', 'col' => 4])

        <div class="col-md-8 page-filters no-padding-lr">
            <div class="row">
                <div class="col-md-4 filter-item search">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    {{ Form::text('search', old('search'), ['placeholder' => 'Search', 'class' => 'form-control text']) }}            
                    {{ Form::submit('Search', ['placeholder' => 'Search', 'class' => 'btn btn-search']) }}            
                </div>
                <div class="col-md-4 filter-item date-range">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    {{ Form::text('date_filter', old('date_filter', date("m/d/y")), ['class' => 'form-control text']) }}            
                    <i class="fa fa-angle-down" aria-hidden="true"></i>          
                </div>
                <div class="col-md-4 filter-item filter-by">                    
                    <div class="form-control text" data-toggle="dropdown">Filter By</div>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>          
                    <ul class="dropdown-menu">
                      <li><a href="#">Pending Verification</a></li>
                      <li><a href="#">Pending Reward</a></li>
                      <li><a href="#">Completed</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-referral-wrapper">
                <table class="table table-referral">
                    <thead>
                        <tr>
                            <th><a href="#">Submitted <i class="fa fa-sort" aria-hidden="true"></i></a></th>
                            <th><a href="#">Referral ID <i class="fa fa-sort" aria-hidden="true"></i></a></th>
                            <th><a href="#">Submitted By <i class="fa fa-sort" aria-hidden="true"></i></a></th>
                            <th><a href="#">Person Referred <i class="fa fa-sort" aria-hidden="true"></i></a></th>
                            <th><a href="#">Status <i class="fa fa-sort" aria-hidden="true"></i></a></th>
                        </tr>
                    </thead>
                    @foreach($referrals as $r) 
                        <tr>
                            <td>{{ $r->referred->created_at->format('m/d/y') }}</td>
                            <td><a href="{{ $r->referred->id }}">{{ $r->referrer_id }}</a></td>
                            <td><a href="{{ $r->user_id }}">{{ auth()->user()->name }}</a></td>
                            <td><a href="{{ $r->referred->id }}">{{ $r->referred->display_name }}</a></td>
                            <td class="referral-status">
                                <div class="form-control" data-toggle="dropdown">Pending Verification</div>
                                <ul class="dropdown-menu">
                                  <li><a href="#">Pending Verification</a></li>
                                  <li><a href="#">Pending Reward</a></li>
                                  <li><a href="#">Completed</a></li>
                                </ul>
                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $referrals->links() }}
            </div>
        </div>
    </div>


@endsection