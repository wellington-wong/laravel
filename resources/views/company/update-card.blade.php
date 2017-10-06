@extends('layouts.app')

@section('pageTitle', ucwords($_company->company_name) . ' Credit Card')

@section('content')

    <div class="container-fluid company-profile-wrapper">

        <div class="row">
        @include('layouts.page-header', ['header' => ucwords($_company->company_name) . ' Credit Card', 'col' => 12])
        </div>

        <div class="row">
            <div class="col-md-8 no-padding-lr company-profile-left">
                {{ Form::open(['route'=>'post-company-update', 'id' => 'update-company-form', 'enctype' => 'multipart/form-data']) }}

                <div class="col-md-6">
                    <label>Company Name</label>
                    {{ Form::text('company_name') }}
                </div>




                <div class="form-group col-md-12 text-right">
                    {{ Form::submit('Update', ['class' => 'btn btn-primary button-responsive-100']) }}
                </div>

                {{ Form::close() }}
            </div>

        </div>
    </div>
@endsection