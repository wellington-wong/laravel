@extends('layouts.app')

@section('pageTitle', 'Rewards')

@section('content')
    <div class="container-fluid rewards-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Rewards', 'col' => 12])
        </div>
        <div class="row">
            <div class="col-md-12 no-padding-lr">            
                <p>As a Cool Cash Rewards Club member, you are offered an assortment of membership perks. Following your account creation, you will need to verify that your referral’s AC installation has successfully been completed with All Year Cooling and then you will receive a <strong><em>$100 Cash Gift Card</em></strong>. You can refer your friends, family and coworkers to All Year Cooling and receive the $100 Gift Card every time. There is no limit to the number of referrals you complete.</p>
                <p>In addition to the referral gift card, each Cool Cash Rewards member is eligible to win monthly raffles, giveaways and other exclusive offers. All Year Cooling offers prizes for everyone. Our raffles and giveaways can range from tickets like Marlins games to Disney on Ice.</p>

                @include('layouts.page-header', ['header' => 'Membership of the Year Award', 'col' => 12])
                <p>All Year Cooling is appreciative of every customer and referral that is brought our way! To make the Cool Cash Rewards Club even cooler, we are honoring our top selling member every year. No referrals go unnoticed at All Year Cooling. As we receive your referrals, we’ll post our top members on the Leader Board where you can see where you stand in the race for the final award. For the Cool Cash Rewards member that refers the most AC installations, All Year Cooling will grant you the <strong><em>Member of the Year Award</em></strong>! </p>
                <p><strong>Clear your calendars because the recipient of the Member of the Year Award is hopping aboard one of the fun vessels of Carnival Cruise Lines on a 7-night Cruise for two!</strong></p>
            </div>
        </div>
    </div>
@endsection