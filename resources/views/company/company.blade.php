@extends('layouts.app')

@section('pageTitle', $company->company_name)

@section('content')

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
@endsection