@extends('layouts.app')

@section('pageTitle', 'Home')

@section('content')
<div class="container-fluid with-referral-counter admin-dashboard">
    @include('referral.counter')
    <div class="row">
        <div class="col-md-9 dashboard-left cta">
            <div class="page-header"><h3>Share Your Referral Program</h3></div>
            <div class="referral-url text-center">
                <p>This is your referral program's link: <a href="#">refermybiz.businessname.com</a></p>
                <p>
                    <i class="fa fa-facebook-official" aria-hidden="true"></i>
                    <i class="fa fa-twitter-square" aria-hidden="true"></i>
                    <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                </p>
            </div>
        </div>
        <div class="col-md-3 dashboard-left">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
