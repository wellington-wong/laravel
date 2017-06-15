@extends('layouts.app')

@section('pageTitle', 'Home')

@section('content')
<div class="container-fluid with-referral-counter admin-dashboard">
    @include('referral.counter')
    <div class="row dashboard-top">
        <div class="col-md-8 dashboard-left-wrapper">
            <div class="dashboard-left cta">
                <div class="page-header"><h3>Share Your Referral Program</h3></div>
                <div class="referral-url text-center">
                    <p>This is your referral program's link: <a href="https://{{ $shareUrl }}">{{ $shareUrl }}</a></p>
                    <p class="social-links">
                        <a href="http://www.facebook.com/sharer.php?u={{ url('/') }}" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                        <a href="https://twitter.com/share?url={{ url('/') }}&amp;text={{ $user->name }}%20Dashboard&amp;hashtags=referralbiz" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
                        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ url('/') }}" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                        <a href="mailto:?Subject=Referral Biz&amp;Body=Referrals Incentive Program%20 {{ url('/') }}"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                    </p>
                </div>
            </div>
            <div class="row-inner">
                @include('layouts.page-header', ['header' => 'Notifications', 'col' => 12])
                <table class="table">
                    <tbody>
                        @foreach ( $user->unreadNotifications()->paginate(4) as $notification)
                        <tr>
                            <td>{{ $notification->created_at->format('m/d/y') }}</td>
                            <td>Referral Submitted for Approval</td> 
                            <td><button class="btn btn-primary">view details</button></td>
                        </tr>
                        @endforeach
                        @if (!count($user->unreadNotifications()->get()))<tr><td colspan="3">No notifications found.</td></tr> @endif
                    </tbody>
                </table>
                <div class="col-md-12 pagination-wrapper">
                    {{ $user->unreadNotifications()->paginate(4)->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-4 dashboard-right">
            <div class="company-info text-center">            
                <div class="company-logo">
                    <img alt="{{ isset($user->companies()->first()->company_name) ? $user->companies()->first()->company_name : '' }}" src="/{{ isset($user->companies()->first()->logo) ? $user->companies()->first()->logo : 'images/company-placeholder.png' }}" class="img-responsive col-xs-10 col-xs-offset-1"> 
                    <div class="logo-pencil ajax-logo"><i class="fa fa-pencil"></i></div>
                    {{ Form::open(['route' => ['post-company-update-logo', (isset($user->companies()->first()->id) ? $user->companies()->first()->id : '')], 'id' => 'company-update-logo', 'enctype' => 'multipart/form-data']) }}
                    {{ Form::file('update-logo', ['class' => 'hidden logo-input']) }}
                    {{ Form::close() }}
                    <div class="hidden processing">Processing...</div>
                </div>
                <div class="clearfix"></div>
                <div class="company-info-name">{{ isset($user->companies()->first()->company_name) ? $user->companies()->first()->company_name : '' }}</div>
                <div class="membership-role">
                    <h4><strong>Membership Role</strong></h4>
                    <span>{{ isset($user->roles->first()->display_name) ? $user->roles->first()->display_name : '' }}</span>
                </div>
                <div class="program-url">
                    <h5>Program URL</h5>
                    <span><a href="https://{{ $shareUrl }}">{{ $shareUrl }}</a></span>
                </div>
                <a href="{{ route('manage-account') }}" class="btn btn-primary">Account Settings</a>
            </div>
        </div>
    </div>
</div>
@endsection
