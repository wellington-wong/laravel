@extends('layouts.app')

@section('pageTitle', 'Login as user')

@section('content')


    <div class="container-fluid members-wrapper">        

        <div class="row">
            @include('layouts.page-header', ['header' => 'Edit Basic Pages', 'col' => 3])
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <ul>
                  <li><a href="{{ route('company-referrals') }}">How</a></li>
                   <li><a href="{{ route('get-company', $_company->id ) }}">Company Profile</a></li>
                  <li><a href="{{ route('members') }}">Users</a></li>
                  <li><a href="{{ route('program-options-referral-program-settings') }}">Referral Program Settings</a></li>
                  <li><a href="{{ route('program-options-reward-settings') }}">Reward Settings</a></li>
                  <li><a href="{{ route('program-options-notification-emails') }}">Notifications Emails</a></li>
                 <li><a href="{{ route('program-options-email-logs') }}">Email Logs</a></li>
                  <li><a href="{{ route('program-options-lob') }}">Bank Account</a></li>
                </ul>
            </div>
        </div>


    </div>
@endsection
