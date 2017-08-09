@extends('layouts.app')

@section('pageTitle', 'Notification Emails')

@section('content')
    @include('email-templates.referral-received', ['email_template' => ''])
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
        {{ Form::open() }}
        <div class="referrer-data placeholder-name">
            <label>Available referrer data:</label>
            <ul class="list-inline">
                <li><a href="javascript:void(0);" data-var="referrer_name">&#123; &#123; referrer_name }}</a></li>
                <li><a href="javascript:void(0);" data-var="referrer_email">&#123; &#123; referrer_email }}</a></li>
                <li><a href="javascript:void(0);" data-var="referrer_phone">&#123; &#123; referrer_phone }}</a></li>
                <li><a href="javascript:void(0);" data-var="referrer_address">&#123; &#123; referrer_address }}</a></li>
            </ul>
        </div>
        <div class="referred-data placeholder-name">
            <label>Available referred data:</label>
            <ul class="list-inline">
                <li><a href="javascript:void(0);" data-var="referred_name">&#123; &#123; referred_name }}</a></li>
                <li><a href="javascript:void(0);" data-var="referred_email">&#123; &#123; referred_email }}</a></li>
                <li><a href="javascript:void(0);" data-var="referred_phone">&#123; &#123; referred_phone }}</a></li>
                <li><a href="javascript:void(0);" data-var="referred_address">&#123; &#123; referred_address }}</a></li>
            </ul>
        </div>
        <div class="form-group">
            <textarea class="form-control" name="email_html" id="email_html">
                @if (!empty($emailTemplate->email_html)) 
                    {{ str_replace('{{' , '&#123; &#123;', $emailTemplate->email_html) }}
                @else
                    @include('email-templates.referral-received', ['email_template' => null])
                @endif               
            </textarea>            
        </div>
        {{ Form::hidden('type', isset($emailTemplate->type) ? $emailTemplate->type : $emailTemplateType) }}
        <div class="form-group btn-group pull-right">
            <button class="btn btn-danger btn-reset" type="reset">Reset</button>
            <button class="btn btn-primary">Save</button>
        </div>
        {{ Form::close() }}
      </div>
    </div>

@endsection