@extends('layouts.app')

@section('content')



<div class="col-xs-12">   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">{{ $company->company_name }}</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> 
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
                        <td>{{ $address->address }} {{ $address->address2 }}</td>
                      </tr>
                        <tr>
                        <td>City</td>
                        <td>{{ $address->city }}</td>
                      </tr>
                      <tr>
                        <td>State</td>
                        <td>{{ $address->state }}</td>
                      </tr>
                        <tr><td>Zip Code</td>
                        <td>{{ $address->zip }}</td>                           
                      </tr>                     
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            
          </div>
        </div>
@endsection