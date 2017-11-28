@extends('layouts.app')

@section('pageTitle', 'Notification Emails')

@section('content')

    <div class="container-fluid referrals-history with-referral-counter">
        <div class="row">
            <div class="top-content text-center">
                <span>500 Internal Server Error</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="text-center">The requested URL <em>{{ Request::url() }}</em> was not found on this server.
            </div>
        </div>
    </div>

@endsection