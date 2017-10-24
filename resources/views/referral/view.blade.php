@extends('layouts.app')

@section('pageTitle', 'Referral View')

@section('content')

    <div class="container-fluid referrals-history with-referral-counter">
        
        <div class="row">
            @include('layouts.page-header', ['header' => 'Referral History', 'col' => 3])
        </div>

        <div class="clearfix"></div>
        @include('referral.partials.history-details')
        
        <div class="row">
            @include('layouts.page-header', ['header' => 'Referral Details', 'col' => 3])
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Label</th>
                            <th>Value</th>
                        </tr>
                    </thead> 
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                    @foreach($referralValues as $key => $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $r->name)) }}</td>
                            <td>@if ($r->name == "state") {{ strtoupper($r->value) }} @else {{ $r->value }} @endif</td>
                        </tr>
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                    @endforeach
                    @if (!count($referralValues))<tr><td colspan="5">No referral value/s found.</td></tr>@endif
                </table>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12 no-padding-lr">
                <button class="btn btn-danger delete-btn pull-right" data-url="{{ route('referral-delete', $referral->id) }}" data-rname="{{ isset($referral->referred) ? $referral->referred->getName() : null }}">Delete</button>
            </div>
        </div>

        @include('layouts.modal')
    </div>

@endsection