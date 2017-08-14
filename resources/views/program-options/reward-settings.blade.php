@extends('layouts.app')

@section('pageTitle', 'Reward Settings')

@section('content')
    <div class="container-fluid reward-settings-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Reward Settings', 'col' => 12])
        </div>
    </div>

    <div class="clearfix"></div>


    <div class="row">    	
      {{ Form::open(['route'=>'reward-settings', 'enctype' => 'multipart/form-data', 'id' => 'reward-settings-form', 'class' => 'reward-settings-form']) }}
      <div class="col-md-12">
            <label>Foreground Color</label>
            <div><input type="text" name="foreground_color" value="{{ isset($_company->foreground_color) ? $_company->foreground_color : '#333333' }}" class="form-control render-spectrum"></div>
      </div>
      {{ Form::close() }}
    </div>
@endsection