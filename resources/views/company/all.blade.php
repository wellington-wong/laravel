@extends('layouts.app')

@section('pageTitle', 'All Companies')

@section('content')

    <!--@foreach( $companies as $c )
        {{-- @todo SUBDOMAIN ROUTING :( --}}
        <div class="row">
	        <div class="col-md-6">
	        	<a href="//{{ $c->subdomain }}.{{ config('app.domain') }}/referral/create">{{ $c->company_name }}</a> 
	        </div>
	        @role(['globalAdmin'])
	        	<button href="javascript:void(0)" class="delete-company" data-id="{{ isset($c->id) ? $c->id : null }}">Delete</button>
			@endrole
        </div>
    @endforeach-->

    <div class="row col-md-12">
        <div class="table-members-wrapper table-wrapper">
            <table class="table table-members tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <!-- @role(['superAdmin', 'globalAdmin'])<th>Actions</th>@endrole -->
                </tr>
                </thead>
                <tr class="tr-spacer"><td colspan=5></td></tr>
    				 @foreach( $companies as $c )
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td><a href="//{{ $c->subdomain }}.{{ config('app.domain') }}/referral/create">{{ $c->company_name }}</a> </td>
                        <td>{{ $c->email }}</td>
                        <!--@role(['superAdmin', 'globalAdmin'])
                        <td>                     
                          <div class="dropdown users-action">
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                Actions
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                              <li><a>Edit</a></li>
                              <li><a>Delete</a></li>
                            </ul>
                          </div>
                        </td>
                        @endrole-->
                    </tr>
                    <tr class="tr-spacer"><td colspan=5></td></tr>
                @endforeach
                @if (!count($companies))<tr><td colspan="5">No companies found.</td></tr>@endif
            </table>
            <div class="col-md-12 pagination-wrapper">{{ count($companies) ? $companies->links() : '' }}</div>
        </div>
    </div>

    <div class="all-companies-modal">@include('layouts.modal')</div>

@endsection