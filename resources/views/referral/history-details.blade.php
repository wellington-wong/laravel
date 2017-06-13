@extends('layouts.app')

@section('pageTitle', 'Referrals')

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
                            <td>{{ $referral->created_at->format('m/d/y') }}</td>
                            <td>{{ $referral->id }}</em></td>
                            <td>You referred <em>{{ $referral->referred->display_name }}</em></td>
                        </tr>
                </table>
            </div>
        </div>
        @include('layouts.modal')
    </div>

@endsection