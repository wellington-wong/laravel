@extends('layouts.app')

@section('pageTitle', 'Referral Program Setings')

@section('content')
    <div class="container-fluid referral-program-settings-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Referral Program Setings', 'col' => 12])
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-referral-settings-wrapper table-wrapper">
                <div class="form-generator-wrapper">
                    <div class="form-generator" data-company_id="{{ $_company->id }}">
                        <div id="stage1" class="build-wrap"></div>
                        <form class="render-wrap"></form>
                        <div class="form-actions btn-group">
                        	<button class="clear-all-trigger btn btn-danger">Clear</button>
                        	<button class="submit-custom-form btn btn-primary">Save</button>
                        </div>
                        <form id="fb-rerender"></form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection