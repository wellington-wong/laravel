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
      <div class="col-md-12">
            <label>Reward Title</label>
            {{ Form::text('reward_title', null, ['placeholder' => 'Reward Title', 'value' => old('reward_title'), 'class' => 'reward-title' . ($errors->has('reward_title') ? ' has-error' : '')]) }}
      </div>
      <div class="col-md-12">
            <label>What kind of reward will you use?</label>
            {{ Form::select('reward_kind', ['placeholder' => 'Reward Kind', 'value' => old('reward_kind'), 'class' => 'reward-kind' . ($errors->has('reward_kind') ? ' has-error' : '')]) }}
      </div>
      <div class="col-md-12">
            <label>How will you send the reward?</label>
            {{ Form::select('reward_send', ['placeholder' => 'Reward Send', 'value' => old('reward_send'), 'class' => 'reward-title' . ($errors->has('reward_send') ? ' has-error' : '')]) }}
      </div>
      <div class="col-md-12">
            <label>Would you like to show a leaderboard on your site? <a href="#">What's this?</a></label>
            {{ Form::select('leaderboard', ['placeholder' => 'Leaderboard', 'value' => old('leaderboard'), 'class' => 'leaderboard' . ($errors->has('leaderboard') ? ' has-error' : '')]) }}
      </div>
      <div class="col-md-12">
            <label>Reward Ratio</label>
            {{ Form::text('reward_ratio', null, ['placeholder' => 'Reward Ratio', 'value' => old('reward_ratio'), 'class' => 'reward-ratio' . ($errors->has('reward_ratio') ? ' has-error' : '')]) }}
      </div>
      {{ Form::close() }}
    </div>
@endsection