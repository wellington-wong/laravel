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
                  <li><a href="{{ route('edit-basic-pages', ['edit' => 'referral-rewards']) }}">Rewards</a></li>
                  <li><a href="{{ route('edit-basic-pages', ['edit' => 'how-this-works']) }}">How This Works</a></li>
                  <li><a href="{{ route('edit-basic-pages', ['edit' => 'how-to-get-more-referrals']) }}">How to Get More Referrals</a></li>
                  <li><a href="{{ route('edit-basic-pages', ['edit' => 'help']) }}">Need Help?</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <label>Guest Pages</label>
                <ul>
                  <li><a href="{{ route('how-it-works', ['edit' => 'how-it-works']) }}">How it Works</a></li>
                  <li><a href="{{ route('features', ['edit' => 'features']) }}">Features</a></li>
                  <li><a href="{{ route('about-us', ['edit' => 'about-us']) }}">About Us</a></li>
                  <li><a href="{{ route('pricing', ['edit' => 'pricing']) }}">Pricing</a></li>
                </ul>
            </div>
        </div>

    </div>
@endsection
