@extends('layouts.app')

@section('pageTitle', 'Login as user')

@section('content')


    <div class="container-fluid members-wrapper">        

        <div class="row">
            @include('layouts.page-header', ['header' => 'Login as User', 'col' => 3])
        </div>

        <div class="clearfix"></div>

        @foreach ( $companies as $c )

            <div class="row">
                <h4 class="col-md-6 no-padding-lr">{{ $c->company_name }} (id: {{ $c->id }})</h4>
                <div class="col-md-6 page-filters no-padding-lr">
                    <div class="row">
                        <div class="col-md-8 filter-item search pull-right">
                            <i class="fa fa-search" aria-hidden="true"></i>      
                            {{ Form::open(['method' => 'GET', 'id' => 'reward-settings-form', 'class' => 'reward-settings-form']) }}
                                {{ Form::text('q-' . $c->id, old('q-' . $c->id), ['placeholder' => 'Search', 'class' => 'form-control text', 'data-query' => (isset($param->q) ? $param->q : '')]) }}            
                                {{ Form::submit('Search', ['placeholder' => 'Search', 'class' => 'btn btn-search login-users']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>

            <?php $users = $c->membersByRole(['member', 'admin', 'superAdmin'])->distinct('user_id')->paginate(15, ['*'], 'company_' . $c->id); ?>

                <div class="row">
                    <div class="col-md-12 table-login-as-wrapper table-wrapper">

                        <table class="table table-login-as tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th></th>
                                <th></th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tr class="tr-spacer"><td colspan=5></td></tr>
                            @foreach ($users as $user)
                                @if ($user->id != auth()->user()->id)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->display_name }}</td>
                                    <td>{{ $user->allReferrals()->count() }}</td>
                                    <td>{{ $user->allReferred()->count() }}</td>
                                    <td>{{ isset($user->roles($c)->orderBy('role_id', 'DESC')->first()->display_name) ? $user->roles($c)->orderBy('role_id', 'DESC')->first()->display_name : '' }}</td>
                                    <td><a href="https://{{ $c->subdomain }}.{{ env('DOMAIN') }}{{ URL::route('login-as-user-id', [$user->id], false)}}" class="btn btn-primary">Login</a></td>
                                </tr>
                                <tr class="tr-spacer"><td colspan=5></td></tr>
                                @endif
                            @endforeach
                            @if (!count($users))<tr><td colspan="7">No users found.</td></tr>@endif
                        </table>
                        <div class="col-md-12 pagination-wrapper">{{ $users->appends(app('request')->query())->links() }}</div>

                    </div>
                </div>


        @endforeach






    </div>
@endsection
