@extends('layouts.app')

@section('pageTitle', 'How to get more referrals')

@section('content')
    <div class="container-fluid more-referrals-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'How to get more referrals', 'col' => 12])
        </div>
        <div class="row">
            <div class="col-md-12 no-padding-lr">
                               
                <p>Ways to get more referrals:</p>
                <ul>
                    <li><p><strong>Word of Mouth.</strong> By spreading the word to your family, friends and coworkers, you won’t believe how many people are looking to install a new AC unit.</p></li>
                    <li><p><strong>Social Media.</strong> Using our provided images for social media posting, your reach can increase exponentially to people that aren’t in your usual circle of friends.</p></li>
                    <li><p><strong>Printable Flyer or Postcard.</strong> For those of you who utilize poster boards in the office or flyer around the neighborhood, this referral resource is perfect for you!</p></li>
                    <li><p><strong>Printable Referral Cards.</strong> In the real estate or construction business? You can keep a referral card with you while working and give your cards to potential clients that need AC installation.</p></li>
                </ul>


            </div>
        </div>
    </div>
@endsection