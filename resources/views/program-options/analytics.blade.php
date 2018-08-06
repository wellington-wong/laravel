@extends('layouts.app')

@section('pageTitle', 'Analytics')

@section('content')
    <div class="container-fluid referrals-analytics">
        <div class="row">
            @include('layouts.page-header', ['header' => 'Analytics for ' . $_company->company_name, 'col' => 12])
            </div>

            <div class="row">
                <div class="col-md-12 table-referral-wrapper table-wrapper {{ auth()->user()->hasRole('member') ? 'member-referrals' : '' }}">
                    <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                        <thead>
                            <tr>
                                <th><a href="">New referral source accounts</a></th>
                                <th><a href="">Referred by referral sources</a></th>
                                <th><a href="">Converted referrals</a></th>
                            </tr>
                        </thead> 
                        <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>                    
                        <tr>
                           <td><a href="#referral-source">{{ $referralsSource->count() }}</a></td>                          
                           <td><a href="#referral-referred">{{ $referrals->where('status', 1)->count() }}</a></td>                          
                           <td><a href="#referral-converted">{{ $referrals->where('status', 3)->count() }}</a></td>                          
                        </tr>
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                    </table>
                 </div>
            </div>
            <div class="row" id="referral-source">
                <div class="col-md-12 table-referral-wrapper table-wrapper {{ auth()->user()->hasRole('member') ? 'member-referrals' : '' }}">
                    <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                        <thead>
                            <tr>
                                <th>New referral source accounts</th>
                            </tr>
                        </thead>
                        <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>            
                        @foreach ($referralsSource as $referralSource)
                        <tr>
                           <td>{{ $referralSource->referrer->name }}</td>          
                        </tr>        
                        <tr class="tr-spacer"><td colspan=5></td></tr>          
                        @endforeach
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                    </table>  
                    <div class="col-md-12 pagination-wrapper">{{ $referralsSource->appends(app('request')->query())->links() }}</div>
                    @if (count($referralsSource))<div class="small text-center">Showing {{ $referralsSource->firstItem() }} - {{ $referralsSource->lastItem() }} of <strong>{{ $referralsSource->total() }}</strong></div>@endif
                 </div>
              </div>
            <div class="row" id="referral-referred">
                <div class="col-md-12 table-referral-wrapper table-wrapper {{ auth()->user()->hasRole('member') ? 'member-referrals' : '' }}">
                    <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                        <thead>
                            <tr>
                                <th><a href="">Referred by referral sources</th>
                            </tr>
                        </thead> 
                        <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>                    
                        <tr>
                           <td></td>                            
                        </tr>
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                    </table>
                 </div>
            </div>
            <div class="row" id="referral-converted">
                <div class="col-md-12 table-referral-wrapper table-wrapper {{ auth()->user()->hasRole('member') ? 'member-referrals' : '' }}">
                    <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                        <thead>
                            <tr>
                                <th><a href="">Converted referrals</th>
                            </tr>
                        </thead> 
                        <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>                    
                        <tr>
                           <td></td>                            
                        </tr>
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                    </table>
                 </div>
            </div>
            @include('layouts.modal')
        </div>
    </div>

@endsection