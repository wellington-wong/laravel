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
            <div class="text-right col-md-6 compose-message">
                <i class="fa fa-pencil-square-o"></i>
                <a href="/messages/create">Compose a New Message</a>
            </div>
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
    		 </table>
                <div class="text-right">
                    <i class="fa fa-pencil-square-o"></i>
                    <a href="/messages/create">Compose a New Message</a>
                </div>
                 <div class="col-md-12 pagination-wrapper">{{ $threads->links() }}</div>
    	       </div>
    	</div>
    </div>
@stop
