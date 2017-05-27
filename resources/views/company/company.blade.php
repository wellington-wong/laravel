@extends('layouts.app')

@section('pageTitle', $company->company_name)

@section('content')

    <div class="container-fluid company-profile-wrapper">

        @include('layouts.page-header', ['header' => ucwords($company->company_name), 'col' => 12])

        <div class="col-md-8 no-padding-lr">
	        {{ Form::open(['route'=>'post-company-update', 'id' => 'update-company-form', 'enctype' => 'multipart/form-data']) }}

	        <div class="col-md-6">
	        	<label>Company Name</label>
	        	{{ Form::text('company_name', old('company_name'), ['placeholder' => 'Company Name', 'class' => 'form-control' . ($errors->has('company_name') ? ' has-error' : '')]) }}
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

	        <div class="form-group col-md-6" >
	        	<label>Company Address Line 1</label>        	
	            {{ Form::text('company_address1', old('company_address1'), ['placeholder' => 'Company Address Line 1', 'class' => 'form-control company-address1' . ($errors->has('company_address1') ? ' has-error' : '') ]) }}            
	        </div>

	        <div class="form-group col-md-6" >
	        	<label>Line 2</label>        	
	            {{ Form::text('company_address2', old('company_address2'), ['placeholder' => 'Line 2', 'class' => 'form-control company-address2' . ($errors->has('company_address2') ? ' has-error' : '') ]) }}            
	        </div>

	        @include('forms.address', ['company' => true])

	        <div class="form-group col-md-12 text-right">
	        	{{ Form::button('Update', ['class' => 'btn btn-primary button-responsive-100']) }}
	        </div>

	    	{{ Form::close() }}
    	</div>



		<div class="col-xs-12">      
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title company-title">{{ $company->company_name }}</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-3 col-lg-3 " align="center"> 
							<img alt="{{ $company->company_name }}" src="/{{ isset($company->logo) ? $company->logo : 'images/company-placeholder.png' }}" class="img-responsive"> 
						</div>                

						<div class=" col-md-9 col-lg-9 "> 
							<table class="table table-company-information">
								<tbody>
									<tr>
										<td>Subdomain:</td>
										<td>{{ $company->subdomain }}</td>
									</tr>
									<tr>
										<td>Created at:</td>
										<td>{{ $company->created_at }}</td>
									</tr>
									<tr>
										<td>Updated at: </td>
										<td>{{ $company->updated_at }}</td>
									</tr>                   
									<tr></tr>
									<tr>
										<td>Address</td>
										<td>{{ isset($address->address) ? $address->address :'' }} {{ isset($address->address2) ? $address->address2 :'' }}</td>
									</tr>
									<tr>
										<td>City</td>
										<td>{{ isset($address->city) ? $address->city : '' }}</td>
									</tr>
									<tr>
										<td>State</td>
										<td>{{ isset($address->state) ? $address->state : '' }}</td>
									</tr>
									<tr>
										<td>Zip Code</td>
										<td>{{ isset($address->zip) ? $address->zip : '' }}</td>                           
									</tr>                     
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
@endsection