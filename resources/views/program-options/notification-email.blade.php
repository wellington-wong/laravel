@extends('layouts.app')

@section('pageTitle', 'Notification Emails')

@section('content')
    @include('email-templates.referral-received', ['email_template' => ''])
    <div class="container-fluid notification-wrapper">    
        <div class="row">
        @include('layouts.page-header', ['header' => 'Notification Email', 'col' => 8])
        <div class="col-md-4 text-right"><a href="{{ route('program-options-notification-emails') }}"><small><< Back to Notification Emails</small></a></div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">    	
      <div class="col-md-12 notification-email-wrapper">
        {{ Form::open() }}
        <div class="form-group">
            {{ Form::label('email_subject', 'Subject') }}
            {{ Form::text('email_subject', \Request::get('subject') ?: (isset($emailTemplate->subject) ? $emailTemplate->subject : ''), ['class' => 'form-control', 'placeholder' => 'Subject']) }}
        </div>

        <div class="form-group">
            <label>Preview</label>
            <iframe id="renderer_iframe" class="form-control"></iframe>
        </div>

        <label>HTML Code</label>
        <span id="renderHtml" class="btn btn-link" >Render HTML</span>
        <span id="defaultHtml" class="btn btn-link" >Change to Example HTML (over-writes but doesn't save current HTML)</span>
        
        @if ($emailTemplateType != 1 && $emailTemplateType != 6 && $emailTemplateType != 8)
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
        @else            
            @if ($emailTemplateType != 8)
            <div class="referred-data placeholder-name">
                <label>Available user data:</label>
                <ul class="list-inline">
                    <li><a href="javascript:void(0);" data-var="referred_name">&#123; &#123; name }}</a></li>
                    <li><a href="javascript:void(0);" data-var="referred_email">&#123; &#123; email }}</a></li>
                    <li><a href="javascript:void(0);" data-var="referred_phone">&#123; &#123; phone }}</a></li>
                    <li><a href="javascript:void(0);" data-var="referred_address">&#123; &#123; address }}</a></li>
                    <li><a href="javascript:void(0);" data-var="referred_address">&#123; &#123; password }}</a></li>
                </ul>
            </div>
            @endif
        @endif
        <div class="form-group">
            <textarea class="form-control" name="email_html" id="email_html">
                @if (!empty($emailTemplate->email_html)) 
                    {{ str_replace('{{' , '&#123; &#123;', $emailTemplate->email_html) }}
                @else
                    @include('email-templates.' . $emailBlade[$emailTemplateType], ['email_template' => null])
                @endif               
            </textarea>            
        </div>

        @if (isset($emailTemplate->type) && ($emailTemplate->type == 6 || $emailTemplate->type == 7))
        <div class="form-group email-recipient-wrapper">
            <div class="recipients-label">{{ Form::label('recipients', 'Recipients') }}</div>
            @foreach ($_company->superadmins()->get() as $admin) 
            <label title="" class="recipient-label">{{ Form::checkbox('recipients[' . $admin->id . ']', $admin->email, isset($recipients[$admin->id]), ['class' => 'recipient-checkbox']) }} {{ $admin->email }}</label>
            @endforeach
            @foreach ($_company->admins()->get() as $admin) 
            <label title="" class="recipient-label">{{ Form::checkbox('recipients[' . $admin->id . ']', $admin->email, isset($recipients[$admin->id]), ['class' => 'recipient-checkbox']) }} {{ $admin->email }}</label>
            @endforeach
            <div class="recipients-label">{{ Form::label('custom-recipients', 'Custom Recipients') }}</div>
            {{ Form::text('custom_recipients', isset($customRecipients) ? implode(', ', $customRecipients) : old('custom_recipients'), ['class' => 'form-control']) }}
            <small>* Comma separated</small>
        </div>
        @endif

        {{ Form::hidden('type', isset($emailTemplate->type) ? $emailTemplate->type : $emailTemplateType) }}
        <div class="form-group btn-group pull-right">
            <button class="btn btn-danger btn-reset" type="reset">Reset</button>
            <button class="btn btn-primary">Save</button>
        </div>
        {{ Form::close() }}
      </div>
    </div>

@endsection