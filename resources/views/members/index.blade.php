@extends('layouts.app')

@section('pageTitle', 'Members')

@section('content')
    <div class="container-fluid members-wrapper">
        <!--<div class="col-md-12 text-right export-link"><a href="{{ route('referrals-export') . '?' . Request::getQueryString() }}">Export</a></div>-->


        <div class="row">
            <div class="text-right pull-right col-md-6 create-user-link no-padding-lr">
                <a href="{{ route('create-user') }}"><i class="fa fa-user"></i> Create New User</a>
            </div>
        </div>
        <div class="row page-filters">
        @include('layouts.page-header', ['header' => 'Admins', 'col' => 6])

            <div class="col-md-4 filter-item search pull-right">
                <i class="fa fa-search" aria-hidden="true"></i>      
                {{ Form::open(['method' => 'GET', 'id' => 'reward-settings-form', 'class' => 'reward-settings-form']) }}
                    {{ Form::text('q-admins', old('q-admins'), ['placeholder' => 'Search', 'class' => 'form-control text']) }}            
                    {{ Form::submit('Search', ['placeholder' => 'Search', 'class' => 'btn btn-search login-users']) }}
                {{ Form::close() }}
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-members-wrapper table-wrapper">
                <table class="table table-members tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                    </thead>
                    <tr class="tr-spacer"><td colspan=5></td></tr>
                    @foreach ($admins as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td><a href="{{ route('view-user', $member->id) }}">{{ isset($member->name) ? $member->name : $member->first_name . ' ' . $member->last_name }}</a></td>
                            <td>{{ $member->email }}</td>
                            <td>{{ implode(', ', $member->roles()->pluck('display_name')->toArray()) }}</td>
                        </tr>
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                    @endforeach
                    @if (!count($admins))<tr><td colspan="5">No admins found.</td></tr>@endif
                </table>
                <div class="col-md-12 pagination-wrapper">{{ count($admins) ? $admins->links() : '' }}</div>
            </div>
        </div>



        <div class="row page-filters">
            @include('layouts.page-header', ['header' => 'Members', 'col' => 6])
        
            <div class="col-md-4 filter-item search pull-right">
                <i class="fa fa-search" aria-hidden="true"></i>      
                {{ Form::open(['method' => 'GET', 'id' => 'reward-settings-form', 'class' => 'reward-settings-form']) }}
                    {{ Form::text('q-members', old('q-members'), ['placeholder' => 'Search', 'class' => 'form-control text']) }}            
                    {{ Form::submit('Search', ['placeholder' => 'Search', 'class' => 'btn btn-search login-users']) }}
                {{ Form::close() }}
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-members-wrapper table-wrapper">
                <table class="table table-members tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Referrals</th>
                        </tr>
                    </thead> 
                    <tr class="tr-spacer"><td colspan=5></td></tr>
                    @foreach ($members as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td><a href="{{ route('view-user', $member->id) }}">{{ isset($member->name) ? $member->name : $member->first_name . ' ' . $member->last_name }}</a></td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->referrals()->where('company_id', $_company->id)->count() }}</td>
                        </tr>
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                    @endforeach
                    @if (!count($members))<tr><td colspan="5">No members found.</td></tr>@endif
                </table>
                <div class="text-right">
                    <a href="{{ route('create-user') }}"><i class="fa fa-user"></i> Create New User</a>
                </div>
                <div class="col-md-12 pagination-wrapper">{{ count($members) ? $members->links() : '' }}</div>
            </div>
        </div>


    </div>

@endsection