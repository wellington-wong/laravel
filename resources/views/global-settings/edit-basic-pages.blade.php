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
                <label>Auth Pages</label>
                <ul>
                  <li><a href="{{ route('referral-rewards', ['edit' => 1]) }}">Rewards</a></li>
                  <li><a href="{{ route('how-this-works', ['edit' => 1]) }}">How This Works</a></li>
                  <li><a href="{{ route('how-to-get-more-referrals', ['edit' => 1]) }}">How to Get More Referrals</a></li>
                  <li><a href="{{ route('help', ['edit' => 1]) }}">Need Help?</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <label>Guest Pages</label>
                <ul>
                  <li><a href="{{ route('how-it-works', ['edit' => 1]) }}">How it Works</a></li>
                  <li><a href="{{ route('features', ['edit' => 1]) }}">Features</a></li>
                  <li><a href="{{ route('about-us', ['edit' => 1]) }}">About Us</a></li>
                  <li><a href="{{ route('pricing', ['edit' => 1]) }}">Pricing</a></li>
                </ul>
            </div>
        </div>


    </div>
@endsection
