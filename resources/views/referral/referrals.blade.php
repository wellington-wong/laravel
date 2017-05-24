@extends('layouts.app')

@section('pageTitle', 'Referrals')

@section('content')

    <div class="container-fluid referrals-wrapper">
        <div class="row">
            <div class="col-md-4 referral-hub">
                <div class="pending-approval">
                    <div class="rh-count"><span>1</span></div><hr />                
                    <div class="rh-desc">
                        <span>Referrals Pending Approval</span>
                        <i class="fa fa-question-circle-o tooltip-q" aria-hidden="true" data-toggle="tooltip" title="Lorem ipsum dolor sit amet, mea audiam philosophia ne, ex tamquam inimicus eos. Labore contentiones quo ne, quo epicuri voluptua ei"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 referral-hub">
                <div class="pending-reward">
                    <div class="rh-count"><span>5232323</span></div><hr />                
                    <div class="rh-desc">
                        <span>Referrals Pending Reward</span>
                        <i class="fa fa-question-circle-o tooltip-q" aria-hidden="true" data-toggle="tooltip" title="Lorem ipsum dolor sit amet, mea audiam philosophia ne, ex tamquam inimicus eos. Labore contentiones quo ne, quo epicuri voluptua ei"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 referral-hub">
                <div class="member-message">
                    <div class="rh-count"><span>532</span></div><hr />                
                    <div class="rh-desc">
                        <span>Member Message</span>
                        <i class="fa fa-question-circle-o tooltip-q" aria-hidden="true" data-toggle="tooltip" title="Lorem ipsum dolor sit amet, mea audiam philosophia ne, ex tamquam inimicus eos. Labore contentiones quo ne, quo epicuri voluptua ei"></i>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 text-right export-link"><a href="#">Export</a></div>

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
                    {{ Form::text('filter_by', old('filter_by'), ['placeholder' => 'Filter By', 'class' => 'form-control text']) }}            
                    <i class="fa fa-angle-down" aria-hidden="true"></i>          
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-referral">
                    <thead>
                        <tr>
                            <th>Submitted <i class="fa fa-sort" aria-hidden="true"></i></th>
                            <th>Referral ID <i class="fa fa-sort" aria-hidden="true"></i></th>
                            <th>Submitted By <i class="fa fa-sort" aria-hidden="true"></i></th>
                            <th>Person Referred <i class="fa fa-sort" aria-hidden="true"></i></th>
                            <th>Status <i class="fa fa-sort" aria-hidden="true"></i></th>
                        </tr>
                    </thead>
                    @foreach($referrals as $r)
                        <tr>
                            <td>{{ $r->referred->created_at->format('m/d/y') }}</td>
                            <td><a href="{{ $r->referred->id }}">{{ $r->referrer_id }}</a></td>
                            <td><a href="{{ $r->user_id }}">{{ auth()->user()->name }}</a></td>
                            <td><a href="{{ $r->referred->id }}">{{ $r->referred->display_name }}</a></td>
                            <td class="referral-status"><div class="form-control">Pending Verification</div><i class="fa fa-angle-down" aria-hidden="true"></i>   </td>
                        </tr>
                    @endforeach
                </table>
                {{ $referrals->links() }}
            </div>
        </div>
    </div>


@endsection