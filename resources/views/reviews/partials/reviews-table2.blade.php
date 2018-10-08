        <div class="row reviews-table-container">
            <div class="col-md-12 table-reviews-wrapper table-wrapper">
                <table class="table table-reviews tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th><a href="">Date Submitted <i class="fa" aria-hidden="true"></i></a></th>
                            <th><a href="">Submitted By <i class="fa" aria-hidden="true"></i></a></th>
                            <th><a href="">URL <i class="fa" aria-hidden="true"></i></a></th>
                            <th><a href="">Screenshot <i class="fa" aria-hidden="true"></i></a></th>
                            <!--<th><a href="">Status <i class="fa" aria-hidden="true"></i></a></th>-->
                        </tr>
                    </thead> 
                    <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>
                    @foreach($reviews as $r)
                    <tr>
                        <td>{{ date('F d, Y', strtotime($r->created_at)) }}</td>
                        <td><a href="{{ route('view-user', $r->user->id) }}" target="_blank">{{ $r->user->getDisplayNameAttribute() }}</a></td>
                        <td>
                            @if (isset($r->url))
                            <a href="{{ preg_replace('/^(?!https?:\/\/)/', 'http://', $r->url) }}" target="_blank">Link <i aria-hidden="true" class="fa fa-external-link"></i></a>
                            @endif
                        </td>
                        <td>                            
                            @if (isset($r->screenshot))
                            <a href="#" class="review-screenshot-thumb" data-screenshoturl="{{ url($r->screenshot) }}"><img width="40" src="{{ url($r->screenshot) }}" /></a>
                            @endif
                        </td>
                        <!--<td data-id="2162" class="referral-status"><div data-toggle="dropdown" data-status="1" class="form-control current-referral-status" aria-expanded="false">Submitted</div> <ul class="dropdown-menu"><li><a href="javascript:void(0)" data-status="1">Submitted</a></li> <li><a href="javascript:void(0)" data-status="2">Approved</a></li> <li><a href="javascript:void(0)" data-status="3">Reward Sent</a></li> <li><a href="javascript:void(0)" data-status="4">Denied</a></li></ul> <i aria-hidden="true" class="fa fa-angle-down"></i></td>-->
                    </tr>
                    <tr class="tr-spacer"><td colspan=5></td></tr>
                    @endforeach
                    @if (!count($reviews))<tr><td colspan="5">No reviews found.</td></tr>@endif
                </table>      
                <div class="col-md-12 text-right"><a href="{{ route('user-create-review') }}">Create a Review</a></div>
                <div class="col-md-12 pagination-wrapper">{{ $reviews->appends(app('request')->query())->links() }}</div>          
                @if (count($reviews))<div class="small text-center">Showing {{ $reviews->firstItem() }} - {{ $reviews->lastItem() }} of <strong>{{ $reviews->total() }}</strong></div>@endif
            </div>
            @include('layouts.modal')
        </div>
        <div class="hidden members-select">{{ Form::select('as_member', ($_company->members()->pluck('name', 'id') ? ['0' => 'Please select a member'] +  $_company->members()->pluck('name', 'id')->toArray() : [] ), '', ['class' => 'form-control']) }}</div>
    </div>