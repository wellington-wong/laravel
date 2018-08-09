@extends('layouts.app')

@section('pageTitle', 'Analytics')

@section('content')
    <div class="container-fluid referrals-analytics">
        <div class="row">
            @include('layouts.page-header', ['header' => 'Analytics for ' . $_company->company_name, 'col' => 12])
            </div>
            <div class="row">
                <div class="col-md-12 table-referral-wrapper table-wrapper {{ auth()->user()->hasRole('member') ? 'member-referrals' : '' }}">
                    <div class="col-md-8 no-padding-lr">
                        <label>Summary</label>
                    </div>
                    <div class="col-md-4 filter-item date-range analytics-calendar no-padding-lr">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        {{ Form::text('daterange_analytics', date("F Y", mktime(0, 0, 0, $selectionMonth + 1, 0, $selectionYear)), ['class' => 'form-control text', 'data-query' => (isset($param->daterange) ? $param->daterange : ''), 'data-url' => route('get-program-options-analytics')] ) }}            
                        <i class="fa fa-angle-down" aria-hidden="true"></i>          
                    </div> 
                    <!--<label for="startDate">Date :</label>
                    <input name="startDate" id="datepicker" class="date-picker" />-->
                    <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                        <thead>
                            <tr>
                                <th><a href="#referral-source">New referral source accounts</a></th>
                                <th><a href="#referral-referred">Referred by referral sources</a></th>
                                <th><a href="#referral-converted">Converted referrals</a></th>
                            </tr>
                        </thead> 
                        <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>                    
                        <tr>
                           <td><a href="#referral-source">{{ $referralsSource->total() }}</a></td>                          
                           <td><a href="#referral-referred">{{ $referred->total() }}</a></td>                          
                           <td><a href="#referral-converted">{{ $referrals->total() }}</a></td>                          
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
                                <th>Referral date</th>
                            </tr>
                        </thead>
                        <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>
                        @foreach ($referralsSource as $referralSource)
                        <tr>
                           <td><a href="{{ route('view-user', $referralSource->referrer->id) }}">{{ $referralSource->referrer->name }}</a></td>          
                           <td>
                            @foreach ($referralSource->referrer->referrals()->whereMonth('created_at', $selectionMonth)->whereYear('created_at', $selectionYear)->get() as $key => $referral) 
                                <a href="{{ route('view-user', $referral->referred->id) }}">{{ $referral->referred->name }}</a>  {{ $loop->last ? '' : ','}}
                            @endforeach
                           </td>
                           <td>

                            @foreach ($referralSource->referrer->referrals()->whereMonth('created_at', $selectionMonth)->whereYear('created_at', $selectionYear)->get() as $key => $referral) 
                                {{ $referral->created_at->format('m/d/y') }} {{ $loop->last ? '' : ','}}
                            @endforeach                           
                           </td>
                         </tr>        
                        <tr class="tr-spacer"><td colspan=5></td></tr>          
                        @endforeach
                    </table>  
                    @if (count($referralsSource))
                    <div class="col-md-12 pagination-wrapper">{{ $referralsSource->appends(app('request')->query(), 'referralsSource')->links() }}</div>
                    <div class="small text-center">Showing {{ $referralsSource->firstItem() }} - {{ $referralsSource->lastItem() }} of <strong>{{ $referralsSource->total() }}</strong></div>
                    @else
                    <div class="col-md-12 pagination-wrapper">No results found.</div>
                    @endif
                 </div>
              </div>
            <div class="row" id="referral-referred">
                <div class="col-md-12 table-referral-wrapper table-wrapper {{ auth()->user()->hasRole('member') ? 'member-referrals' : '' }}">
                    <label>Referred By Referral Sources</label>
                    <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Referred by</th>
                                <th>Referral date</th>
                            </tr>
                        </thead> 
                        <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>       
                        @foreach ($referred as $referredAccount)
                        <tr>
                           <td><a href="{{ route('view-user', $referredAccount->referrer->id) }}">{{ $referredAccount->referred->name }}</a></td>          
                           <td><a href="{{ route('view-user', $referredAccount->referrer->id) }}">{{ $referredAccount->referrer->name }}</a></td>
                           <td>{{ $referredAccount->created_at->format('m/d/y') }}</td>
                         </tr>        
                        <tr class="tr-spacer"><td colspan=5></td></tr>          
                        @endforeach
                    </table>
                    @if (count($referred))
                    <div class="col-md-12 pagination-wrapper">{{ $referred->appends(app('request')->query(), 'referred')->links() }}</div>
                    <div class="small text-center">Showing {{ $referred->firstItem() }} - {{ $referred->lastItem() }} of <strong>{{ $referred->total() }}</strong></div>
                    @else
                    <div class="col-md-12 pagination-wrapper">No results found.</div>
                    @endif
                 </div>
            </div>
            <div class="row" id="referral-converted">
                <div class="col-md-12 table-referral-wrapper table-wrapper {{ auth()->user()->hasRole('member') ? 'member-referrals' : '' }}">
                    <label>Converted Referrals This Month</label>
                    <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Referred by</th>
                                <th>Referral date</th>
                            </tr>
                        </thead> 
                        <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>          
                        @foreach ($referrals as $referral)
                        <tr>
                           <td><a href="{{ route('view-user', $referral->referred->id) }}">{{ $referral->referred->name }}</a></td>          
                           <td><a href="{{ route('view-user', $referral->referrer->id) }}">{{ $referral->referrer->name }}</a></td>         
                           <td>{{ $referral->created_at->format('m/d/y') }}</td>          
                        </tr>        
                        <tr class="tr-spacer"><td colspan=5></td></tr>          
                        @endforeach
                    </table>
                    @if (count($referrals))
                    <div class="col-md-12 pagination-wrapper">{{ $referrals->appends(app('request')->query(), 'referrals')->links() }}</div>
                    <div class="small text-center">Showing {{ $referrals->firstItem() }} - {{ $referrals->lastItem() }} of <strong>{{ $referrals->total() }}</strong></div>
                    @else
                    <div class="col-md-12 pagination-wrapper">No results found.</div>
                    @endif
                 </div>
            </div>
            @include('layouts.modal')
        </div>
    </div>
@endsection