        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper {{ auth()->user()->hasRole('member') ? 'member-referrals' : '' }}">
                <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th><a href="{{ route($route, [isset($args) ? $args : '', (isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['created_at'], 'column' => 'created_at']) }}">Submitted <i class="fa fa-sort{{ $sortc['created_at']?:'' }}" aria-hidden="true"></i></a></th>
                            @if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin']))<th><a href="{{ route($route, [isset($args) ? $args : '', (isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['id'], 'column' => 'id']) }}">Referral ID <i class="fa fa-sort{{ $sortc['id'] }}" aria-hidden="true"></i></a></th>@endif
                            @if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin']))<th><a href="{{ route($route, [isset($args) ? $args : '', (isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['user_id'], 'column' => 'referrer_id']) }}">Submitted By <i class="fa fa-sort{{ $sortc['user_id'] }}" aria-hidden="true"></i></a></th>@endif
                            <th><a href="{{ route($route, [isset($args) ? $args : '', (isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['referred'], 'column' => 'referred']) }}">Person Referred <i class="fa fa-sort{{ $sortc['referred'] }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route($route, [isset($args) ? $args : '', (isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['status'], 'column' => 'status']) }}">Status <i class="fa fa-sort{{ $sortc['status'] }}" aria-hidden="true"></i></a></th>
                            @if (auth()->user()->hasRole('member'))<th></th>@endif
                        </tr>
                    </thead> 
                    <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>
                    @foreach($referrals as $r)

                        @if ( Gate::allows('send-check')
                            && count($r->check) == 0
                            && $r->status == \App\Referral::STATUS_APPROVED
                            && ( null != $_company->lob && $_company->lob->numberBankAccounts() > 0 && $_company->lob->banksVerified() == true ) )
                            <?php $canSendCheck = 1; ?>
                        @else
                            <?php $canSendCheck = 0; ?>
                        @endif

                        <tr @if(1==$canSendCheck || count($r->check) == 1) class="canSendCheck" @endif>
                            <td>{{ isset($r->created_at) ? $r->created_at->format('m/d/y') : '' }}</td>
                            @if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin']))<td><a href="{{ route('referral-view', $r->id) }}">{{ $r->id }}</a></td>@endif
                            @if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin']))<td><a href="{{ route('view-user', $r->referrer->id) }}">{{ $r->referrer->display_name }}</a></td>@endif
                            @if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin']))<td><a href="{{ route('view-user', $r->referred->id) }}">{{ $r->referred->display_name }}</a></td>
                            @else <td>{{ $r->referred->display_name }}</td>
                            @endif
                            <td class="referral-status" data-id="{{ $r->id }}">
                                <div class="form-control current-referral-status" data-toggle="dropdown" data-status="{{ $r->status }}">{{ \App\Referral::$status[$r->status] }}</div>
                                @if (auth()->user()->can(['change_referral_statuses']) && !isset($viewOnly))
                                <ul class="dropdown-menu">                                
                                    @foreach ($referralStatus as $key => $status)
                                        <li><a href="javascript:void(0)" data-status="{{ $status }}">{{ \App\Referral::$status[$status] }}</a></li>
                                    @endforeach
                                </ul>
                                <i class="fa {{ isset($r->status) ? ($r->status == 3 ? 'fa-lock' : 'fa-angle-down' ) : '' }}" aria-hidden="true"></i>
                                @endif

                            </td>
                            @if (auth()->user()->hasRole('member'))<td class="view-details"><a href="{{ route('referral-view', $r->id) }}" class="btn btn-primary">view details</a></td>@endif
                        </tr>

                        @if ( 1 == $canSendCheck )
                            <tr class="check" >
                                <td></td><td></td>
                                <td colspan="4" >
                                <form method="POST" action="{{ route('post-send-check', ['referral_id'=>$r->id]) }}" >
                                    {{ csrf_field() }}

                                    <input name="amount" placeholder="$" length="5" style="width:100px" >

                                    <input name="memo" placeholder="MEMO" >

                                    <input type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled=true; this.value='Sending…';" value="Send Check" >
                                </form>
                                </td>
                            </tr>
                        @endif

                        @if( count($r->check) == 1 )
                            <?php $check = $r->check->first(); ?>
                            <tr class="check">
                                <td>CHECK SENT</td>
                                <td><a href="{{ $check->pdf }}" target="_blank">{{ $check->check_number }}</a></td>
                                <td>${{ round($check->amount,2) }}</td>
                                <td>Send Date: {{ $check->send_date }}</td>
                                <td>Expected: {{ $check->expected_delivery_date }}</td>
                            </tr>
                        @endif
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                    @endforeach
                    @if (!count($referrals))<tr><td colspan="5">No referrals found.</td></tr>@endif
                </table>
                <div class="col-md-12 pagination-wrapper">{{ $referrals->links() }}</div>
            </div>
        </div>
        @include('layouts.modal')
    </div>