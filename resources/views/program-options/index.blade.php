@extends('layouts.app')

@section('pageTitle', 'Program Options')

@section('content')
    <div class="container-fluid program-options-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Program Options', 'col' => 12])
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
            	<ul>
            	   <li><a href="{{ route('get-company', $_company->id ) }}">Company Profile</a></li>
            	   <li><a href="{{ route('company-create') }}">Create Company</a></li>
            	   <li><a href="{{ route('program-options-email-logs') }}">Email Logs</a></li>
                  <li><a href="{{ route('program-options-users') }}">Users</a></li>
                  <li><a href="{{ route('program-options-referral-program-settings') }}">Program Settings</a></li>
                  <li><a href="{{ route('program-options-reward-settings') }}">Reward Settings</a></li>
                  <li><a href="{{ route('program-options-notification-emails') }}">Notifications Emails</a></li>
            	</ul>
            </div>
        </div>
    </div>

@endsection