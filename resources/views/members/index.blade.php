@extends('layouts.app')

@section('pageTitle', 'Members')

@section('content')
    <div class="container-fluid members-wrapper">
        <!--<div class="col-md-12 text-right export-link"><a href="{{ route('referrals-export') . '?' . Request::getQueryString() }}">Export</a></div>-->


        <div class="row">
            <div class="text-right pull-right col-md-6 create-user-link no-padding-lr">
                <a href="{{ route('create-user') }}"><i class="fa fa-user-plus"></i> Create New User</a>&nbsp;&nbsp;
                <a href="javascript:void(0)" class="export-members"><i class="fa fa-users"></i> Export Users</a>
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
                        @role(['superAdmin', 'globalAdmin'])<th>Actions</th>@endrole
                    </tr>
                    </thead>
                    <tr class="tr-spacer"><td colspan=5></td></tr>
                    @foreach ($admins as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td><a href="{{ route('view-user', $member->id) }}">{{ isset($member->name) ? $member->name : $member->first_name . ' ' . $member->last_name }}</a></td>
                            <td>{{ $member->email }}</td>
                            <td>{{ implode(', ', $member->roles()->pluck('display_name')->toArray()) }}</td>
                            @role(['superAdmin', 'globalAdmin'])
                            <td>                     
                              <div class="dropdown users-action">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                    Actions
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                  <li><a href="javascript:void(0)" class="change-role" data-role-id="{{ isset($member->roles()->first()->id) ? $member->roles()->first()->id : 0 }}" data-role-name="{{ isset($member->roles()->first()->name) ? $member->roles()->first()->name : null }}" data-name="{{ $member->getName() }}" data-url="{{ route('members-change-role', $member->id) }}">Change Role</a></li>
                                  <li><a href="javascript:void(0)" class="delete-user" data-id="{{ $member->id }}" data-name="{{ $member->getName() }}" data-url="{{ route('members-delete', $member->id) }}">Delete</a></li>
                                </ul>
                              </div>
                                <!--<div class="btn-users">
                                    <button class="btn btn-primary change-role" data-role-id="{{ isset($member->roles()->first()->id) ? $member->roles()->first()->id : 0 }}" data-role-name="{{ isset($member->roles()->first()->name) ? $member->roles()->first()->name : null }}" data-name="{{ $member->getName() }}" data-url="{{ route('members-change-role', $member->id) }}">Change Role</button>
                                    <button class="btn btn-danger delete-user" data-id="{{ $member->id }}" data-name="{{ $member->getName() }}" data-url="{{ route('members-delete', $member->id) }}">Delete</button>
                                </div>-->
                            </td>
                            @endrole
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
                            @role(['superAdmin', 'globalAdmin'])<th></th>@endrole
                        </tr>
                    </thead> 
                    <tr class="tr-spacer"><td colspan=5></td></tr>
                    @foreach ($members as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td><a href="{{ route('view-user', $member->id) }}">{{ isset($member->name) ? $member->name : $member->first_name . ' ' . $member->last_name }}</a></td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->referrals()->where('company_id', $_company->id)->count() }}</td>                                   
                            @role(['superAdmin', 'globalAdmin']) 
                            <td>                                
                              <div class="dropdown users-action">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                    Actions
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                  <li><a href="javascript:void(0)" class="change-role" data-role-id="{{ isset($member->roles()->first()->id) ? $member->roles()->first()->id : 0 }}" data-role-name="{{ isset($member->roles()->first()->name) ? $member->roles()->first()->name : null }}" data-name="{{ $member->getName() }}" data-url="{{ route('members-change-role', $member->id) }}">Change Role</a></li>
                                  <li><a href="javascript:void(0)" class="change-password" data-id="{{ $member->id }}" data-name="{{ $member->getName() }}" data-url="{{ route('members-change-password', $member->id) }}">Change Password</a></li>
                                  <li><a href="javascript:void(0)" class="delete-user" data-id="{{ $member->id }}" data-name="{{ $member->getName() }}" data-url="{{ route('members-delete', $member->id) }}">Delete</a></li>
                                </ul>
                              </div>

                                <!--<div class="btn-group btn-users">
                                    <button class="btn btn-primary change-role" data-role-id="{{ isset($member->roles()->first()->id) ? $member->roles()->first()->id : 0 }}" data-role-name="{{ isset($member->roles()->first()->name) ? $member->roles()->first()->name : null }}" data-name="{{ $member->getName() }}" data-url="{{ route('members-change-role', $member->id) }}">Change Role</button>
                                    <button class="btn btn-danger delete-user" data-id="{{ $member->id }}" data-name="{{ $member->getName() }}" data-url="{{ route('members-delete', $member->id) }}">Delete</button>
                                    <button class="btn btn-primary change-password" data-id="{{ $member->id }}" data-name="{{ $member->getName() }}" data-url="{{ route('members-change-password', $member->id) }}">Change Password</button>
                                </div>-->
                            </td>
                            @endrole
                        </tr>
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                    @endforeach
                    @if (!count($members))<tr><td colspan="5">No members found.</td></tr>@endif
                </table>
                <div class="text-right">
                    <a href="{{ route('create-user') }}"><i class="fa fa-user"></i> Create New User</a>&nbsp;&nbsp;
                    <a href="{{ route('export-members') }}" class="export-members"><i class="fa fa-users"></i> Export Users</a>
                </div>
                <div class="col-md-12 pagination-wrapper">{{ count($members) ? $members->links() : '' }}</div>
            </div>
        </div>

        @include('layouts.modal')
        <div class="member-roles hidden">
            <div class="clearfix">&nbsp;</div>
            <div class="row">
                <div class="col-md-12">
                    <label>Roles:</label>
                    {{ Form::select('member-roles', $allRoles, null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

    </div>

@endsection