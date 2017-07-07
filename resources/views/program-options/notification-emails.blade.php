@extends('layouts.app')

@section('pageTitle', 'Notification Emails')

@section('content')
    <div class="container-fluid notification-wrapper">    
        <div class="row">
        @include('layouts.page-header', ['header' => 'Notification Emails', 'col' => 12])
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">    	
      <div class="col-md-12 notificaiton-email-wrapper">
        <div class="form-group">
            <label>Preview</label>
            <iframe id="renderer_iframe" class="form-control"></iframe>
        </div>

        <label>HTML Code</label>
        <span id="renderHtml" class="btn btn-link" >Render HTML</span>
        <span id="defaultHtml" class="btn btn-link" >Change to Example HTML (over-writes but doesn't save current HTML)</span>
        {{ Form::open(['route' => 'program-options-post-notification-emails', 'id' => 'create-email-template']) }}
        <div class="form-group">
            <textarea class="form-control" name="email_html" id="email_html"></textarea>
        </div>
        <div class="form-group btn-group pull-right">
            <button class="btn btn-danger">Clear</button>
            <button class="btn btn-primary">Save</button>
        </div>
        {{ Form::close() }}
      </div>
    </div>

@endsection