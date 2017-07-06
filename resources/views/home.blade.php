@extends('layouts.app')

@section('pageTitle', 'Home')

@section('content')
@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            @foreach (Session::get('success') as $msg)
            <li>{!! $msg !!}</li>
            @endforeach
        </ul>
    </div>
@endif
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
                            <td><a href="{{ route('notification', $notification->id) }}" class="btn btn-primary">view details</a></td>
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

                @include( 'company.info_inner' )

                <a href="{{ route('manage-account') }}" class="btn btn-primary">Account Settings</a>
            </div>
        </div>
    </div>
</div>
@endsection
