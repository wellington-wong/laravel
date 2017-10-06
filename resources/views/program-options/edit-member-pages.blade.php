@extends('layouts.app')

@section('pageTitle', 'Edit Member Pages')

@section('content')

    <div class="container-fluid members-wrapper">        

        <div class="row">
            @include('layouts.page-header', ['header' => 'Edit Member Pages', 'col' => 3])
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <ul>
                  <li><a href="{{ route('edit-member-page', 'referral-rewards') }}">Rewards</a></li>
                  <li><a href="{{ route('edit-member-page', 'how-this-works') }}">How This Works</a></li>
                  <li><a href="{{ route('edit-member-page', 'how-to-get-more-referrals') }}">How to Get More Referrals</a></li>
                  <li><a href="{{ route('edit-member-page', 'help') }}">Need Help?</a></li>
                </ul>
            </div>
        </div>

    </div>
@endsection
