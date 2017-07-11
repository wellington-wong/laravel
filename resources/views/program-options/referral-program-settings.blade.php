@extends('layouts.app')

@section('pageTitle', 'Referral Program Setings')

@section('content')
    <div class="container-fluid referral-program-settings-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Referral Program Settings', 'col' => 12])
        </div>

        <div class="clearfix"></div>

        <div class="row">      	
            <div class="form-group col-md-6 no-padding-l">
              <label>Form Name:</label>
              {{ Form::text('form_name', isset($companyReferralForm->form_name) ? $companyReferralForm->form_name : '', ['placeholder' => 'Form Name', 'class' => 'form-control']) }}
            </div>
          	<div class="form-group col-md-6 no-padding-r">
          		<label>Templates:</label>
      		    {{ Form::select('referral_template', ['' => 'Select Template', 'defaultFieldsBasic' => 'Basic', 'defaultFieldsComplete' => 'Complete'], isset($state) ? $state : old('state'), ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 table-referral-settings-wrapper table-wrapper">
        		<div class="clearfix"></div>
				<div class="form-generator-wrapper">
				    <div class="form-generator" data-company-id="{{ $_company->id }}">
				        <div id="stage1" class="build-wrap"></div>
				        <form class="render-wrap"></form>
				        <div class="form-actions btn-group custom-btn">
				        	<button class="clear-all-trigger btn btn-danger">Clear</button>
				        	<button class="submit-custom-form btn btn-primary">Save</button>
				        </div>
				        <form id="fb-rerender"></form>
				        <div class="raw-form-json hidden">{{ isset($companyReferralForm->raw_form_json) ? $companyReferralForm->raw_form_json : '' }}</div>
				    </div>
				</div>
            </div>
        </div>
    </div>

@endsection