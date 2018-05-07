        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper {{ auth()->user()->hasRole('member') ? 'member-referrals' : '' }}">
                <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th><a href="">Submitted By <i class="fa fa-sort" aria-hidden="true"></i></a></th>
                            <th><a href="">Rating <i class="fa fa-sort" aria-hidden="true"></i></a></th>
                            <th><a href="">URL <i class="fa fa-sort" aria-hidden="true"></i></a></th>
                            <th><a href="">Screenshot <i class="fa fa-sort" aria-hidden="true"></i></a></th>
                        </tr>
                    </thead> 
                    <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>
                    @foreach($reviews as $r)

                        <tr>
                            @if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin']))<td><a href="{{ route('view-user', isset($r->referred->id) ? $r->referred->id : 0) }}">{{ isset($r->referred->display_name) ? $r->referred->display_name : '' }}</a></td>
                            @else <td>{{ $r->referred->display_name }}</td>@endif
                            @if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin']))<td><a href="{{ route('view-user', isset($r->referrer->id) ? $r->referrer->id : 0) }}">{{ isset($r->referrer->display_name) ? $r->referrer->display_name : '' }}</a></td>@endif     
                            <td class="referral-status" data-id="{{ $r->id }}"></td>
                            <td>{{ isset($r->created_at) ? $r->created_at->format('m/d/y') : '' }}</td>
                            @if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin']))<td><a href="{{ route('referral-view', $r->id) }}">History</a></td>@endif
                            @if (auth()->user()->hasRole('member'))<td class="view-details"><a href="{{ route('referral-view', $r->id) }}" class="btn btn-primary">History</a></td>@endif
                            @role(['globalAdmin'])<td class="referral-actions">
                                <a href="javascript:void(0)" class="transfer" title="Delete" data-url="{{ route('referral-transfer', $r->id) }}" data-rname="{{ isset($r->referred) ? $r->referred->getName() : null }}"><i class="fa fa-exchange fa-1x" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="javascript:void(0)" class="delete" title="Transfer Referral" data-url="{{ route('referral-delete', $r->id) }}" data-rname="{{ isset($r->referred) ? $r->referred->getName() : null }}"><i class="fa fa-trash fa-1x" aria-hidden="true"></i></a>
                            </td>@endrole
                        </tr>
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                    @endforeach
                    @if (!count($reviews))<tr><td colspan="5">No referrals found.</td></tr>@endif
                </table>
                <div class="col-md-12 pagination-wrapper">{{ $reviews->appends(app('request')->query())->links() }}</div>
                @if (count($reviews))<div class="small text-center">Showing {{ $reviews->firstItem() }} - {{ $reviews->lastItem() }} of <strong>{{ $reviews->total() }}</strong></div>@endif
            </div>
        </div>
        <div class="hidden members-select">{{ Form::select('as_member', ($_company->members()->pluck('name', 'id') ? ['0' => 'Please select a member'] +  $_company->members()->pluck('name', 'id')->toArray() : [] ), '', ['class' => 'form-control']) }}</div>
        @include('layouts.modal')
    </div>