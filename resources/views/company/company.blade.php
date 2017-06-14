@extends('layouts.app')

@section('pageTitle', $company->company_name)

@section('content')

    <div class="container-fluid company-profile-wrapper">

        @include('layouts.page-header', ['header' => ucwords($company->company_name), 'col' => 12])

        @if( !$errors->isEmpty() )
            <div class="alert alert-warning col-md-12">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8 no-padding-lr company-profile-left">
    	        {{ Form::open(['route'=>'post-company-update', 'id' => 'update-company-form', 'enctype' => 'multipart/form-data']) }}

    	        <div class="col-md-6">
    	        	<label>Company Name</label>
    	        	{{ Form::text('company_name', (isset($company->company_name) ? $company->company_name : old('company_name')), ['placeholder' => 'Company Name', 'class' => 'form-control' . ($errors->has('company_name') ? ' has-error' : '')]) }}
    	        </div>

    	        <div class="col-md-6">
    	        	<label>Company Number</label>
    	        	@include('forms.phone', ['phone_label'=>'Company  Number', 'placeholder' => 'Company Number', 'no_col' => true, 'value' => isset($company->phone[0]->phone) ? $company->phone[0]->phone : ''])
    	        </div>

    	        <div class="form-group col-md-6" >
    	        	<label>Company Email</label>
    	        	<i class="fa fa-question-circle-o tooltip-q" aria-hidden="true" data-toggle="tooltip" title="Lorem ipsum dolor sit amet, mea audiam philosophia ne, ex tamquam inimicus eos. Labore contentiones quo ne, quo epicuri voluptua ei"></i>
    	            {{ Form::text('email', $company->email, ['placeholder' => 'Company Email', 'class' => 'form-control company-email' . ($errors->has('email') ? ' has-error' : '') ]) }}            
    	        </div>

    	        <div class="form-group col-md-6" >
    	        	<label>Company Website</label>        	
    	            {{ Form::text('website', isset($company->website) ? $company->website : 'http://', ['placeholder' => 'Company Website', 'class' => 'form-control company-website' . ($errors->has('website') ? ' has-error' : '') ]) }}            
    	        </div>

    	        @include('forms.address', ['company' => true, 'city' => $company->address[0]->city, 'address' => $company->address[0]->address, 'address2' => $company->address[0]->address2, 'zip' => $company->address[0]->zip, 'state' => $company->address[0]->state])

                {{ Form::hidden('company_id', (isset($company->id) ? $company->id : null )) }}

    	        <div class="form-group col-md-12 text-right">
    	        	{{ Form::submit('Update', ['class' => 'btn btn-primary button-responsive-100']) }}
    	        </div>

    	    	{{ Form::close() }}
            </div>

            <div class="col-md-4 company-profile-right">
                <div class="company-info text-center">            
                    <div class="company-logo">
                        <img alt="{{ $company->company_name }}" src="/{{ isset($company->logo) ? $company->logo : 'images/company-placeholder.png' }}" class="img-responsive col-xs-10 col-xs-offset-1"> 
                        <div class="logo-pencil ajax-logo"><i class="fa fa-pencil"></i></div>
                        {{ Form::open(['route' => ['post-company-update-logo', auth()->user()->companies()->first()->id], 'id' => 'company-update-logo', 'enctype' => 'multipart/form-data']) }}
                        {{ Form::file('update-logo', ['class' => 'hidden logo-input']) }}
                        {{ Form::close() }}
                        <div class="hidden processing">Processing...</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="company-info-name">{{ auth()->user()->companies()->first()->company_name }}</div>
                    <div class="membership-role">
                        <h4><strong>Membership Role</strong></h4>
                        <span>{{ auth()->user()->roles->first()->display_name  }}</span>
                    </div>
                    <div class="program-url">
                        <h5>Program URL</h5>
                        <span><a href="#">{{ isset($company->subdomain) ? $company->subdomain : 'nosubdomain' }}.businessname.com</a></span>
                    </div>
                </div>
            </div>
        </div>
	
        @include('layouts.page-header', ['header' => 'Plan', 'col' => 12])
        <table class="table table-plan">
        	<tbody>
        		<tr>
        			<td>Basic Plan</td>
        			<td>1 of 2 Admin Accounts Used</td>
        			<td class="col-md-2"><button class="btn btn-primary">upgrade</button></td>
        		</tr>
        	</tbody>
        </table>
        <div class="questions-wrapper"><span class="questions">Questions about your plan?</span> <span class="call-us">Call Us: 000.000.0000</span></div>

        @include('layouts.page-header', ['header' => 'Billing', 'col' => 12])
        <table class="table table-credit-info">
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