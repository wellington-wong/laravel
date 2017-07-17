        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper {{ auth()->user()->hasRole('member') ? 'member-referrals' : '' }}">
                <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th><a href="{{ route($route, [isset($args) ? $args : '', (isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['created_at'], 'column' => 'created_at']) }}">Submitted <i class="fa fa-sort{{ $sortc['created_at']?:'' }}" aria-hidden="true"></i></a></th>
                            @if (!auth()->user()->hasRole('member'))<th><a href="{{ route($route, [isset($args) ? $args : '', (isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['id'], 'column' => 'id']) }}">Referral ID <i class="fa fa-sort{{ $sortc['id'] }}" aria-hidden="true"></i></a></th>@endif
                            @if (!auth()->user()->hasRole('member'))<th><a href="{{ route($route, [isset($args) ? $args : '', (isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['user_id'], 'column' => 'user_id']) }}">Submitted By <i class="fa fa-sort{{ $sortc['user_id'] }}" aria-hidden="true"></i></a></th>@endif
                            <th><a href="{{ route($route, [isset($args) ? $args : '', (isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['referred'], 'column' => 'referred']) }}">Person Referred <i class="fa fa-sort{{ $sortc['referred'] }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route($route, [isset($args) ? $args : '', (isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['status'], 'column' => 'status']) }}">Status <i class="fa fa-sort{{ $sortc['status'] }}" aria-hidden="true"></i></a></th>
                            @if (auth()->user()->hasRole('member'))<th></th>@endif
                        </tr>
                    </thead> 
                    @foreach($referrals as $r)
                        <tr>
                            <td>{{ isset($r->created_at) ? $r->created_at->format('m/d/y') : '' }}</td>
                            @if (!auth()->user()->hasRole('member'))<td><a href="{{ route('referral-view', $r->id) }}">{{ $r->id }}</a></td>@endif
                            @if (!auth()->user()->hasRole('member'))<td><a href="{{ route('view-user', auth()->user()->id) }}">{{ auth()->user()->name }}</a></td>@endif
                            @if (!auth()->user()->hasRole('member'))<td><a href="{{ route('view-user', $r->referred->id) }}">{{ $r->referred->display_name }}</a></td>
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
                        @if( count($r->check) == 1 )
                            <?php $check = $r->check->first(); ?>
                            <tr>
                                <td>CHECK SENT</td>
                                <td>{{ $check->check_number }}</td>
                                <td>${{ round($check->amount, 2) }}</td>
                                <td>Send Date: {{ $check->send_date }}</td>
                                <td>Expected: {{ $check->expected_delivery_date }}</td>
                            </tr>
                        @endif
                    @endforeach
                    @if (!count($referrals))<tr><td colspan="5">No referrals found.</td></tr>@endif
                </table>
                <div class="col-md-12 pagination-wrapper">{{ $referrals->links() }}</div>
            </div>
        </div>
        @include('layouts.modal')
    </div>