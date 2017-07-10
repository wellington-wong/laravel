        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th><a href="{{ route('referrals', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['created_at'], 'column' => 'created_at']) }}">Submitted <i class="fa fa-sort{{ $sortc['created_at']?:'' }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route('referrals', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['id'], 'column' => 'id']) }}">Referral ID <i class="fa fa-sort{{ $sortc['id'] }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route('referrals', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['user_id'], 'column' => 'user_id']) }}">Submitted By <i class="fa fa-sort{{ $sortc['user_id'] }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route('referrals', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['referred'], 'column' => 'referred']) }}">Person Referred <i class="fa fa-sort{{ $sortc['referred'] }}" aria-hidden="true"></i></a></th>
                            <th><a href="{{ route('referrals', [(isset($param->column_sort) ? $param->column_sort : ''), 'sort' => $sort['status'], 'column' => 'status']) }}">Status <i class="fa fa-sort{{ $sortc['status'] }}" aria-hidden="true"></i></a></th>
                        </tr>
                    </thead> 
                    @foreach($referrals as $r)
                        <tr>
                            <td>{{ isset($r->created_at) ? $r->created_at->format('m/d/y') : '' }}</td>
                            <td><a href="{{ route('referral-view', $r->id) }}">{{ $r->id }}</a></td>
                            <td><a href="{{ route('view-user', auth()->user()->id) }}">{{ auth()->user()->name }}</a></td>
                            <td><a href="{{ route('view-user', $r->referred->id) }}">{{ $r->referred->display_name }}</a></td>
                            <td class="referral-status" data-id="{{ $r->id }}">
                                <div class="form-control" data-toggle="dropdown">{{ \App\Referral::$status[$r->status] }}</div>
                                @can('change-referral-statuses')<ul class="dropdown-menu">                                
                                    @foreach ($referralStatus as $key => $status)
                                        <li><a href="javascript:void(0)" data-status="{{ $status }}">{{ \App\Referral::$status[$status] }}</a></li>
                                    @endforeach
                                </ul>
                                <i class="fa fa-angle-down" aria-hidden="true"></i>@endcan
                            </td>
                        </tr>
                    @endforeach
                    @if (!count($referrals))<tr><td colspan="5">No referrals found.</td></tr>@endif
                </table>
                <div class="col-md-12 pagination-wrapper">{{ $referrals->links() }}</div>
            </div>
        </div>
        @include('layouts.modal')
    </div>