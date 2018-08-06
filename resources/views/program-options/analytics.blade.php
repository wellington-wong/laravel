@extends('layouts.app')

@section('pageTitle', 'Analytics')

@section('content')
    <div class="container-fluid referrals-analytics">
        <div class="row">
            @include('layouts.page-header', ['header' => 'Analytics for ' . $_company->company_name, 'col' => 12])
            </div>

            <div class="row">
                <div class="col-md-12 table-referral-wrapper table-wrapper {{ auth()->user()->hasRole('member') ? 'member-referrals' : '' }}">
                    <label>Summary</label>
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
                           <td><a href="#referral-source">{{ $referralsSource->total() }}</a></td>                          
                           <td><a href="#referral-referred"></a></td>                          
                           <td><a href="#referral-converted">{{ count($referrals) }}</a></td>                          
                        </tr>
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                    </table>
                 </div>
            </div>
            <div class="row" id="referral-source">
                <div class="col-md-12 table-referral-wrapper table-wrapper {{ auth()->user()->hasRole('member') ? 'member-referrals' : '' }}">
                    <label>New Referral Source Accounts</label>
                    <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Referred</th>
                            </tr>
                        </thead>
                        <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>
                        @foreach ($referralsSource as $referralSource)
                        <tr>
                           <td><a href="{{ route('view-user', $referralSource->referrer->id) }}">{{ $referralSource->referrer->name }}</a></td>          
                           <td>
                            @foreach ($referralSource->referrer->referrals as $key => $referral) 
                                <a href="{{ route('view-user', $referral->referred->id) }}">{{ $referral->referred->name }}</a>  {{ $loop->last ? '' : ','}}
                            @endforeach
                           </td>
                         </tr>        
                        <tr class="tr-spacer"><td colspan=5></td></tr>          
                        @endforeach
                    </table>  
                    <div class="col-md-12 pagination-wrapper">{{ $referralsSource->appends(app('request')->query(), 'referralsSource')->links() }}</div>
                    @if (count($referralsSource))<div class="small text-center">Showing {{ $referralsSource->firstItem() }} - {{ $referralsSource->lastItem() }} of <strong>{{ $referralsSource->total() }}</strong></div>@endif
                 </div>
              </div>
            <div class="row" id="referral-referred">
                <div class="col-md-12 table-referral-wrapper table-wrapper {{ auth()->user()->hasRole('member') ? 'member-referrals' : '' }}">
                    <label>Referred By Referral Sources</label>
                    <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                        <thead>
                            <tr>
                                <th>Name</th>
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
                    <label>Converted Referrals This Month</label>
                    <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Referral Date</th>
                            </tr>
                        </thead> 
                        <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>          
                        @foreach ($referrals as $referral)
                        <tr>
                           <td><a href="{{ route('view-user', $referral->referred->id) }}">{{ $referral->referred->name }}</a></td>          
                           <td>{{ $referral->referred->created_at->format('m/d/y') }}</td>          
                        </tr>        
                        <tr class="tr-spacer"><td colspan=5></td></tr>          
                        @endforeach
                    </table>
                    <div class="col-md-12 pagination-wrapper">{{ $referrals->appends(app('request')->query(), 'referrals')->links() }}</div>
                    @if (count($referrals))<div class="small text-center">Showing {{ $referrals->firstItem() }} - {{ $referrals->lastItem() }} of <strong>{{ $referrals->total() }}</strong></div>@endif
                 </div>
            </div>
            @include('layouts.modal')
        </div>
    </div>

@endsection