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
                    <div class="form-generator">
                        <div id="stage1" class="build-wrap"></div>
                        <form class="render-wrap"></form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection