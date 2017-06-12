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
                        {{ Form::submit('Search', ['placeholder' => 'Search', 'class' => 'btn btn-search']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-login-as-wrapper">
                <table class="table table-login-as tablesaw tablesaw-stack" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Subdomain</th>
                        </tr>
                    </thead> 
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</a></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ isset($user->companies->first()->subdomain) ? $user->companies->first()->subdomain : 'no subdomain' }}</td>
                        </tr>
                    @endforeach
                    @if (!count($users))<tr><td colspan="5">No users found.</td></tr>@endif
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Login as User</div>

                <div class="panel-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
