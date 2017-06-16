@extends('layouts.app')

@section('pageTitle', 'Messages')

@section('content')
    <div class="container-fluid messages-wrapper">
        
        <div class="row">
            @if( !$errors->isEmpty() )
                <div class="alert alert-warning">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif
            @include('layouts.page-header', ['header' => 'Messages', 'col' => 6])
        </div>

        <div class="clearfix"></div>

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
                    <tfoot>
                    	<tr>
                    		<td colspan="3" class="">
                    			<a href="/messages/create">New Message</a>
                    		</td>
                    	</tr>
                    </tfoot>	 
    		  </table>
                 <div class="col-md-12 pagination-wrapper">{{ $threads->links() }}</div>
    	       </div>
    	</div>
    </div>
@stop
