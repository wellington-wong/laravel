@extends('layouts.app')

@section('pageTitle', 'Messages')

@section('content')
    @include('messenger.partials.flash')

        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>From</th>
                            <th>To</th>
                        </tr>
                    </thead> 
                    <tbody>
                    	@each('messenger.partials.thread', $threads, 'thread', 'messenger.partials.no-threads')
                    </tbody>   						 
    			</table>
    		</div>
    	</div>
@stop
