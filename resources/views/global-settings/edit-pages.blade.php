@extends('layouts.app')

@section('pageTitle', 'Edit Pages')

@section('content')

    <div class="container-fluid members-wrapper">        

        <div class="row">
            @include('layouts.page-header', ['header' => 'Edit Pages', 'col' => 3])
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <label>Auth Pages</label>
                <ul>
                  <li><a href="{{ route('edit-basic-page', ['edit' => 'referral-rewards']) }}">Rewards</a></li>
                  <li><a href="{{ route('edit-basic-page', ['edit' => 'how-this-works']) }}">How This Works</a></li>
                  <li><a href="{{ route('edit-basic-page', ['edit' => 'how-to-get-more-referrals']) }}">How to Get More Referrals</a></li>
                  <li><a href="{{ route('edit-basic-page', ['edit' => 'help']) }}">Need Help?</a></li>
                </ul>
            </div>
        </div>

        @role(['globalAdmin'])
        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <label>Guest Pages</label>
                <ul>
                  <li><a href="{{ route('edit-member-page', ['edit' => 'how-it-works']) }}">How it Works</a></li>
                  <li><a href="{{ route('edit-member-page', ['edit' => 'features']) }}">Features</a></li>
                  <li><a href="{{ route('edit-member-page', ['edit' => 'about-us']) }}">About Us</a></li>
                  <li><a href="{{ route('edit-member-page', ['edit' => 'pricing']) }}">Pricing</a></li>
                </ul>
            </div>
        </div>
        @endrole

    </div>
@endsection
