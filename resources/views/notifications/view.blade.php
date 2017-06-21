@extends('layouts.app')

@section('pageTitle', 'Notification')

@section('content')
    <div class="container-fluid referral-program-settings-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Notification', 'col' => 12])
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-notification-wrapper table-wrapper">                
                <table class="table table-notification tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th>Submitted</th>
                            <th>Referral ID</th>
                            <th>Submitted By</th>
                            <th>Person Referred</th>
                            <th>Status</th>
                        </tr>
                    </thead> 
                    <tbody>
                        <tr>
                            <td>{{ $notification->created_at->format('m/d/Y') }}</td>
                            <td>{{ $referral->id }}</td>
                            <td>{{ isset($referral->referrer->name) ? $referral->referrer->name : $referral->referrer->first_name . ' ' . $referral->referrer->last_name }}</td>
                            <td>{{ isset($referral->referred->name) ? $referral->referred->name : $referral->referred->first_name . ' ' . $referral->referred->last_name }}</td>
                            <td>{{ \App\Referral::$status[$referral->status] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection