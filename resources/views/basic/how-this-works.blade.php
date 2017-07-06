@extends('layouts.app')

@section('pageTitle', 'How this works')

@section('content')
    <div class="container-fluid more-referrals-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'How this works', 'col' => 12])
        </div>
        <div class="row">
            <div class="col-md-12 no-padding-lr">
                  <strong>Create your program</strong>
                    <p>All you need is a name and a credit card. We handle the rest! </p>

                  <strong>Send your customers to a unique subdomain so they can start submitting referrals.</strong>
                  <p>Once your custom referral program is created, you’ll receive the custom URL for your program. You can share your link with your customers and start receiving new referrals instantly!</p>
    
                  <strong>Once logged in to your custom referral program. Your customers can easily submit referrals</strong>
                  <p>Your customers will be able to create a free account within your referral program so that they can easily login, submit, and keep track of their rewards and referrals. </p>
    
                  <strong>Custom notification emails for your customers.</strong>
                  <p>Your customers will be able to create a free account within your referral program so that they can easily login, submit, and keep track of their rewards and referrals. Keep your customers engaged with our custom email templates. Notify your customer with updates on their pending referrals. You can even export your member’s emails to use within your own Email management System.</p>
    
                  <strong>Start a Contest and increase your referral count.</strong>
                  <p>Perxi even offers a leaderboard option for your referral program. Award customers with the most referrals.</p>
                </div>
        </div>
    </div>
@endsection