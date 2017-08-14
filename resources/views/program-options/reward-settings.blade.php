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
      {{ Form::open(['route'=>'program-options-reward-settings', 'enctype' => 'multipart/form-data', 'id' => 'reward-settings-form', 'class' => 'reward-settings-form']) }}
      <div class="col-md-6">
            <label>Reward Title</label>
            <div class="col-md-12 no-padding-lr">
            {{ Form::text('reward_title', null, ['placeholder' => 'Reward Title', 'value' => old('reward_title'), 'class' => 'form-control reward-title' . ($errors->has('reward_title') ? ' has-error' : '')]) }}
            </div>
      </div>
      <div class="col-md-6">
            <label>What kind of reward will you use?</label>
            <div class="col-md-12 no-padding-lr">
            {{ Form::select('reward_kind', ['placeholder' => 'Reward Kind', 'value' => old('reward_kind'), 'class' => 'form-control reward-kind' . ($errors->has('reward_kind') ? ' has-error' : '')]) }}
            </div>
      </div>
      <div class="col-md-6">
            <label>How will you send the reward?</label>
            <div class="col-md-12 no-padding-lr">
            {{ Form::select('reward_send', ['placeholder' => 'Reward Send', 'value' => old('reward_send'), 'class' => 'form-control reward-title' . ($errors->has('reward_send') ? ' has-error' : '')]) }}
            </div>
      </div>
      <div class="col-md-6">
            <label>Would you like to show a leaderboard on your site? <a href="#">What's this?</a></label>            
            <div class="col-md-12 no-padding-lr">
            {{ Form::select('leaderboard', ['placeholder' => 'Leaderboard', 'value' => old('leaderboard'), 'class' => 'form-control leaderboard' . ($errors->has('leaderboard') ? ' has-error' : '')]) }}
            </div>
      </div>
      <div class="col-md-6">
            <label>Reward Ratio</label>            
            <div class="col-md-12 no-padding-lr">
            {{ Form::text('reward_ratio', null, ['placeholder' => 'Reward Ratio', 'value' => old('reward_ratio'), 'class' => 'form-control reward-ratio' . ($errors->has('reward_ratio') ? ' has-error' : '')]) }}
            </div>
      </div>
      {{ Form::close() }}
    </div>
@endsection