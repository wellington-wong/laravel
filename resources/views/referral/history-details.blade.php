@extends('layouts.app')

@section('pageTitle', 'Referral History Details')

@section('content')

    <div class="container-fluid referrals-history with-referral-counter">
        
        <div class="row">
            @include('layouts.page-header', ['header' => 'Referral Details for ' . $referral->referred->display_name, 'col' => 12])
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Referral Id</th>
                            <th>Details</th>
                        </tr>
                    </thead> 
                        <tr>
                            <td>{{ isset($referral->created_at) ? $referral->created_at->format('m/d/y') : '' }}</td>
                            <td>{{ $referral->id }}</em></td>
                            <td>You referred <em>"{{ $referral->referred->display_name }}"</em></td>
                        </tr>
                        @foreach ($referral->revisionHistory as $history)
                        <tr>
                            <td>{{ $history->created_at->format('m/d/y') }}</td>
                            <td>{{ $history->revisionable_id }}</td>
                            <td>The referral status for <em>"{{ $referral->referred->display_name }}"</em> was changed to {{ \App\Referral::$status[$referral->status] }}</td>
                        </tr>
                        @endforeach
                </table>
            </div>
        </div>
        @include('layouts.modal')
    </div>

@endsection