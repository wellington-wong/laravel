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
        <div>
        <iframe src="/contact/lob/postcard/" id="postcard_iframe">
        </iframe>
        </div>

        <label>Postcard HTML</label>
        <span id="renderHtml" class="btn btn-link" >Render HTML</span>
        <span id="defaultHtml" class="btn btn-link" >Change to Example HTML (over-writes but doesn't save current HTML)</span>
        <div>
        <textarea name="postcard_html" id="postcard_html"></textarea>
        </div>
    </div>

@endsection