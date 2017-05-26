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
                <p class="social-links">
                    <a href="http://www.facebook.com/sharer.php?u={{ url('/') }}" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                    <a href="https://twitter.com/share?url={{ url('/') }}&amp;text={{ auth()->user()->name }}%20Dashboard&amp;hashtags=referralbiz" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
                    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ url('/') }}" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                    <a href="mailto:?Subject=Referral Biz&amp;Body=Referrals Incentive Program%20 {{ url('/') }}"><i class="fa fa-envelope" aria-hidden="true"></i></a>
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
