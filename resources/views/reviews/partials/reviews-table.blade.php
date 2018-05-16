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
                        <td></td>
                        <td></td>
                        <td>{{ $r->url }}</td>
                        <td></td>
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