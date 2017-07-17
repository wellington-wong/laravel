@extends('layouts.app')

@section('pageTitle', 'Referral Confirmation')

@section('content')

    <div class="container-fluid referrals-history with-referral-counter">
        
        <div class="row">
            @include('layouts.page-header', ['header' => 'Referral Confirmation', 'col' => 3])
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
    </div>

@endsection