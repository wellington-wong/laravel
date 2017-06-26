@extends('layouts.app')

@section('pageTitle', $thread->subject)

@section('content')

    <div class="container-fluid message-wrapper">    
        <div class="row">
            @include('layouts.page-header', ['header' => $thread->subject, 'col' => 6])
		</div>        
		<div class="row">    
            <div class="col-md-12 table-message-wrapper table-wrapper">
                <table class="table table-message tablesaw tablesaw-stack table-custom">
                    <tbody>
                    @each('messenger.partials.messages', $thread->messages, 'message')
                    </tbody>
                </table>    
            </div>
        </div>
        <div class="row">
        	<div class="col-md-12 no-padding-lr">
			    @include('messenger.partials.form-message')
			</div>
		</div>
	</div>
@stop
