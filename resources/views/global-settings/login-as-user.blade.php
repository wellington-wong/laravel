@extends('layouts.app')

@section('pageTitle', 'Login as user')

@section('content')


    <div class="container-fluid members-wrapper">        

        <div class="row">
            @include('layouts.page-header', ['header' => 'Login as User', 'col' => 3])

            <div class="col-md-9 page-filters no-padding-lr">
                <div class="row">
                    <div class="col-md-4 filter-item search pull-right">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        {{ Form::text('q', old('q'), ['placeholder' => 'Search', 'class' => 'form-control text', 'data-query' => (isset($param->q) ? $param->q : '')]) }}            
                        {{ Form::submit('Search', ['placeholder' => 'Search', 'class' => 'btn btn-search login-users']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        @foreach ( $companies as $c )

            <h4>{{ $c->company_name }} (id: {{ $c->id }})</h4>

            <?php $users = $c->membersByRole(['member', 'admin', 'superAdmin'])->distinct('user_id')->get(); ?>

                <div class="row">
                    <div class="col-md-12 table-login-as-wrapper table-wrapper">

                        <table class="table table-login-as tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            @foreach ($users as $user)
                                @if ($user->id != auth()->user()->id)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ isset($user->roles($c)->orderBy('role_id', 'DESC')->first()->display_name) ? $user->roles($c)->orderBy('role_id', 'DESC')->first()->display_name : '' }}</td>
                                    <td><a href="{{ route('login-as-user-id', [$user->id])}}" class="btn btn-primary">Login</a></td>
                                </tr>
                                @endif
                            @endforeach
                            @if (!count($users))<tr><td colspan="5">No users found.</td></tr>@endif
                        </table>

                    </div>
                </div>


        @endforeach






    </div>
@endsection
