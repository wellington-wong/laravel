@extends('layouts.app')

@section('pageTitle', $_company->company_name)

@section('content')

    <div class="container-fluid company-profile-wrapper">

        <div class="row">
        @include('layouts.page-header', ['header' => ucwords($_company->company_name), 'col' => 12])
        </div>

        <div class="row">
            <div class="col-md-8 no-padding-lr company-profile-left">
                {{ Form::open(['route'=>'post-company-update', 'id' => 'update-company-form', 'enctype' => 'multipart/form-data']) }}

                <div class="col-md-6">
                    <label>Company Name</label>
                    {{ Form::text('company_name', (isset($_company->company_name) ? $_company->company_name : old('company_name')), ['placeholder' => 'Company Name', 'class' => 'form-control' . ($errors->has('company_name') ? ' has-error' : '')]) }}
                </div>

                <div class="col-md-6">
                    <label>Company Number</label>
                    @include('forms.phone', ['phone_label'=>'Company  Number', 'placeholder' => 'Company Number', 'no_col' => true, 'value' => isset($_company->phone[0]->phone) ? $_company->phone[0]->phone : ''])
                </div>

                <div class="form-group col-md-6" >
                    <label>Company Email</label>
                    <i class="fa fa-question-circle-o tooltip-q" aria-hidden="true" data-toggle="tooltip" title="Lorem ipsum dolor sit amet, mea audiam philosophia ne, ex tamquam inimicus eos. Labore contentiones quo ne, quo epicuri voluptua ei"></i>
                    {{ Form::text('email', $_company->email, ['placeholder' => 'Company Email', 'class' => 'form-control company-email' . ($errors->has('email') ? ' has-error' : '') ]) }}            
                </div>

                <div class="form-group col-md-6" >
                    <label>Company Website</label>          
                    {{ Form::text('website', isset($_company->website) ? $_company->website : '', ['placeholder' => 'Company Website', 'class' => 'form-control company-website' . ($errors->has('website') ? ' has-error' : '') ]) }}            
                </div>

                @include('forms.address', ['company' => true ])

                {{ Form::hidden('company_id', (isset($_company->id) ? $_company->id : null )) }}

                <div class="form-group col-md-12 text-right">
                    {{ Form::submit('Update', ['class' => 'btn btn-primary button-responsive-100']) }}
                </div>

                {{ Form::close() }}
            </div>

            <div class="col-md-4 company-profile-right">
                <div class="company-info text-center">            
                    @include('company.partials.info_inner')
                </div>
            </div>
        </div>
    
        <div class="row">
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
        </div>


        <div class="row">
        @include('layouts.page-header', ['header' => 'Billing', 'col' => 12])
            <table class="table table-credit-info">
                <tbody>
                    <tr>
                        <td>Credit Card</td>
                        <td>
                            @if (isset($_company->card_brand) && isset($_company->card_last_four))
                            {{ isset($_company->card_brand) ? $_company->card_brand : 'Credit card' }} ending in {{ isset($_company->card_last_four) ? $_company->card_last_four : 'N/A' }}
                            @else
                            No credit card saved.
                            @endif
                        </td>
                        <td class="col-md-2"><a href="{{ route('company-update-card') }}" class="btn btn-primary">update card</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection