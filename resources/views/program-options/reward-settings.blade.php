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
      <div class="col-md-6 form-group">
            <label>Reward Title</label>
            <div class="col-md-12 no-padding-lr">
            {{ Form::text('title', old('title') ?: $_company->rewardSettings()->first()->title, ['placeholder' => 'Reward Title', 'class' => 'form-control reward-title' . ($errors->has('title') ? ' has-error' : '')]) }}
            </div>
      </div>
      <div class="col-md-6 form-group">
            <label>What kind of reward will you use?</label>
            <div class="col-md-12 no-padding-lr">
            {{ Form::select('reward_kind', \App\RewardSetting::$rewardSend,  $_company->rewardSettings()->first()->reward_kind, ['class' => 'form-control reward-kind' . ($errors->has('reward_kind') ? ' has-error' : '')]) }}
            </div>
      </div>
      <div class="col-md-6 form-group">
            <label>How will you send the reward?</label>
            <div class="col-md-12 no-padding-lr">
            {{ Form::select('reward_send', \App\RewardSetting::$rewardKind, $_company->rewardSettings()->first()->reward_send, ['class' => 'form-control reward-send' . ($errors->has('reward_send') ? ' has-error' : '')]) }}
            </div>
      </div>
      <div class="col-md-6 form-group">
            <label>Reward Ratio</label>            
            <div class="col-md-12 no-padding-lr">
            {{ Form::text('reward_ratio', $_company->rewardSettings()->first()->reward_ratio, ['placeholder' => 'Reward Ratio', 'value' => $_company->rewardSettings()->first()->reward_ratio, 'class' => 'form-control reward-ratio' . ($errors->has('reward_ratio') ? ' has-error' : '')]) }}
            </div>
      </div>
      <div class="col-md-12 form-group">          
            <div class="col-md-12 no-padding-lr">
            	<label>Would you like to show a leaderboard on your site? <a href="#">What's this?</a></label>
            </div>            
            {{ Form::select('leaderboard', [1 => 'Yes', 0 => 'No'], $_company->rewardSettings()->first()->leaderboard, ['class' => 'form-control leaderboard' . ($errors->has('leaderboard') ? ' has-error' : '')]) }}
      </div>

      <div class="form-group col-md-12 text-right form-group">
      	{{ Form::submit('Update', ['class' => 'btn btn-primary button-responsive-100 submit-profile']) }}
      </div>

      {{ Form::close() }}
    </div>
@endsection