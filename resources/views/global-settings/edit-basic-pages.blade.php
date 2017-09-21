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
                  <li><a href="">Rewards</a></li>
                  <li><a href="">How This Works</a></li>
                  <li><a href="">How to Get More Referrals</a></li>
                  <li><a href="">Need help?</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <label>Guest Pages</label>
                <ul>
                  <li><a href="">How it Works</a></li>
                  <li><a href="">Features</a></li>
                  <li><a href="">About Us</a></li>
                  <li><a href="">Pricing</a></li>
                </ul>
            </div>
        </div>


    </div>
@endsection
