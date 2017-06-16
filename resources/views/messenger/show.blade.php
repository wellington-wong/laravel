@extends('layouts.app')

@section('pageTitle', $thread->subject)

@section('content')

    <div class="container-fluid message-wrapper">    
        <div class="row">
            @include('layouts.page-header', ['header' => $thread->subject, 'col' => 6])
		</div>
		@each('messenger.partials.messages', $thread->messages, 'message')
        <div class="row">
        	<div class="col-md-12 no-padding-lr">
			    @include('messenger.partials.form-message')
			</div>
		</div>
	</div>
@stop
