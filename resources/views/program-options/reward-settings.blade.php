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
            {{ Form::text('title', old('title') ?: (isset($rewardSettings->title) ? $rewardSettings->title : ''), ['placeholder' => 'Reward Title', 'class' => 'form-control reward-title' . ($errors->has('title') ? ' has-error' : '')]) }}
            </div>
      </div>
      <div class="col-md-6 form-group">
            <label>What kind of reward will you use?</label>
            <div class="col-md-12 no-padding-lr">
            {{ Form::select('reward_kind', \App\RewardSetting::$rewardSend,  isset($rewardSettings->reward_kind) ? $rewardSettings->reward_kind : null, ['class' => 'form-control reward-kind' . ($errors->has('reward_kind') ? ' has-error' : '')]) }}
            </div>
      </div>
      <div class="col-md-6 form-group">
            <label>How will you send the reward?</label>
            <div class="col-md-12 no-padding-lr">
            {{ Form::select('reward_send', \App\RewardSetting::$rewardKind, isset($rewardSettings->reward_send) ? $rewardSettings->reward_send : null, ['class' => 'form-control reward-send' . ($errors->has('reward_send') ? ' has-error' : '')]) }}
            </div>
      </div>
      <div class="col-md-6 form-group">
            <label>Reward Ratio</label>       
            <div class="reward-ratio-input">    
              <div class="col-md-3 no-padding-lr">
              {{ Form::number('approved_referral_ratio', isset($rewardSettings->reward_ratio) ? unserialize($rewardSettings->reward_ratio)[0] : null, ['placeholder' => 'Reward Ratio', 'value' => isset($rewardSettings->reward_ratio) ? $rewardSettings->reward_ratio : null, 'class' => 'form-control reward-ratio' . ($errors->has('reward_ratio') ? ' has-error' : '')]) }}
              </div>     
              <div class="col-md-2 no-padding-lr text-center">
                <span>:</span>
              </div>
              <div class="col-md-3 no-padding-lr">
              {{ Form::number('reward_referral_ratio', isset($rewardSettings->reward_ratio) ? unserialize($rewardSettings->reward_ratio)[1] : null, ['placeholder' => 'Reward Ratio', 'value' => isset($rewardSettings->reward_ratio) ? $rewardSettings->reward_ratio : null , 'class' => 'form-control reward-ratio' . ($errors->has('reward_ratio') ? ' has-error' : '')]) }}
              </div>
            </div>
      </div>
      <div class="col-md-12 form-group">          
            <div class="col-md-12 no-padding-lr">
            	<label>Would you like to show a leaderboard on your site? <a href="#">What's this?</a></label>
            </div>            
            {{ Form::select('leaderboard', [1 => 'Yes', 0 => 'No'], isset($rewardSettings->leaderboard) ? $rewardSettings->leaderboard : null, ['class' => 'form-control leaderboard' . ($errors->has('leaderboard') ? ' has-error' : '')]) }}
      </div>

      <div class="form-group col-md-12 text-right form-group">
      	{{ Form::submit('Update', ['class' => 'btn btn-primary button-responsive-100 submit-profile']) }}
      </div>

      {{ Form::close() }}
    </div>
@endsection