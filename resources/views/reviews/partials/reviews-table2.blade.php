        <div class="row reviews-table-container">
            <div class="col-md-12 table-reviews-wrapper table-wrapper">
                <table class="table table-reviews tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th><a href="">Date Submitted <i class="fa" aria-hidden="true"></i></a></th>
                            <th><a href="">Submitted By <i class="fa" aria-hidden="true"></i></a></th>
                            <th><a href="">URL <i class="fa" aria-hidden="true"></i></a></th>
                            <th><a href="">Screenshot <i class="fa" aria-hidden="true"></i></a></th>
                        </tr>
                    </thead> 
                    <tr class="tr-spacer"><td colspan=5 style="border: 0; height:10px;"></td></tr>
                    @foreach($reviews as $r)
                    <tr>
                        <td>{{ date('F d, Y', strtotime($r->created_at)) }}</td>
                        <td><a href="{{ route('view-user', auth()->user()->id) }}" target="_blank">{{ auth()->user()->getDisplayNameAttribute() }}</a></td>
                        <td><a href="{{ preg_replace('/^(?!https?:\/\/)/', 'http://', $r->url) }}" target="_blank">{{ $r->url }}</a></td>
                        <td>                            
                            @if (isset($r->screenshot))
                            <a href="#" class="review-screenshot-thumb" data-screenshoturl="{{ url($r->screenshot) }}"><img width="30" src="{{ url($r->screenshot) }}" /></a>
                            @endif
                        </td>
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