@extends('layouts.app')

@section('pageTitle', $company->company_name)

@section('content')

    <div class="container-fluid company-profile-wrapper">

        @include('layouts.page-header', ['header' => ucwords($company->company_name), 'col' => 12])

        <div class="col-md-8 no-padding-lr company-profile-left">
	        {{ Form::open(['route'=>'post-company-update', 'id' => 'update-company-form', 'enctype' => 'multipart/form-data']) }}

	        <div class="col-md-6">
	        	<label>Company Name</label>
	        	{{ Form::text('company_name', (isset($company->company_name) ? $company->company_name : old('company_name')), ['placeholder' => 'Company Name', 'class' => 'form-control' . ($errors->has('company_name') ? ' has-error' : '')]) }}
	        </div>

	        <div class="col-md-6">
	        	<label>Company Number</label>
	        	@include('forms.phone', ['phone_label'=>'Company  Number', 'placeholder' => 'Company Number', 'no_col' => true])
	        </div>

	        <div class="form-group col-md-6" >
	        	<label>Company Email</label>
	        	<i class="fa fa-question-circle-o tooltip-q" aria-hidden="true" data-toggle="tooltip" title="Lorem ipsum dolor sit amet, mea audiam philosophia ne, ex tamquam inimicus eos. Labore contentiones quo ne, quo epicuri voluptua ei"></i>
	            {{ Form::text('company_email', old('company_email'), ['placeholder' => 'Company Email', 'class' => 'form-control company-email' . ($errors->has('company_email') ? ' has-error' : '') ]) }}            
	        </div>

	        <div class="form-group col-md-6" >
	        	<label>Company Website</label>        	
	            {{ Form::text('company_website', old('company_website'), ['placeholder' => 'Company Website', 'class' => 'form-control company-website' . ($errors->has('company_website') ? ' has-error' : '') ]) }}            
	        </div>

	        @include('forms.address', ['company' => true, 'city' => $company->address[0]->city, 'address' => $company->address[0]->address, 'address2' => $company->address[0]->address2, 'zip' => $company->address[0]->zip, 'state' => $company->address[0]->state])

	        <div class="form-group col-md-12 text-right">
	        	{{ Form::button('Update', ['class' => 'btn btn-primary button-responsive-100']) }}
	        </div>

	    	{{ Form::close() }}
    	</div>

        <div class="col-md-4 company-profile-right">
            <div class="company-info text-center">            
                <div class="company-logo">
                    <img alt="{{ $company->company_name }}" src="/{{ isset($company->logo) ? $company->logo : 'images/company-placeholder.png' }}" class="img-responsive col-xs-10 col-xs-offset-1"> 
                </div>
                <div class="clearfix"></div>
                <div class="company-info-name">{{ auth()->user()->companies()->first()->company_name }}</div>
                <div class="membership-role">
                    <h4><strong>Membership Role</strong></h4>
                    <span>{{ auth()->user()->roles->first()->display_name  }}</span>
                </div>
                <div class="program-url">
                    <h5>Program URL</h5>
                    <span><a href="#">{{ auth()->user()->companies()->first()->subdomain }}.businessname.com</a></span>
                </div>
            </div>
        </div>
	
        @include('layouts.page-header', ['header' => 'Plan', 'col' => 12])
        <table class="table table-referral">
        	<tbody>
        		<tr>
        			<td>Basic Plan</td>
        			<td>1 of 2 Admin Accounts Used</td>
        			<td class="col-md-2"><button class="btn btn-primary">upgrade</button></td>
        		</tr>
        	</tbody>
        </table>

        @include('layouts.page-header', ['header' => 'Billing', 'col' => 12])
        <table class="table table-referral">
        	<tbody>
        		<tr>
        			<td>Credit Card</td>
        			<td>Mastercard Ending in 4466</td>
        			<td class="col-md-2"><button class="btn btn-primary">update card</button></td>
        		</tr>
        	</tbody>
        </table>
	</div>
@endsection