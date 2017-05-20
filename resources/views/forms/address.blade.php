<div class="form-group">
    {{ Form::text('address', null, ['placeholder' => 'Referral\'s Home Address', 'class' => 'form-control' . ($errors->has('address') ? ' has-error' : '')]) }}
</div>

<div class="form-group">
    {{ Form::text('address2', null, ['placeholder' => 'Address Line 2', 'class' => 'form-control' . ($errors->has('address2') ? ' has-error' : '')]) }}
</div>

<div class="form-group">
    {{ Form::text('city', null, ['placeholder' => 'City', 'class' => 'form-control' . ($errors->has('city') ? ' has-error' : '')]) }}
</div>

<div class="form-group">
    {{ Form::text('state', null, ['placeholder' => 'State', 'class' => 'form-control' . ($errors->has('state') ? ' has-error' : '')]) }}
</div>

<div class="form-group">
    {{ Form::text('zip', null, ['placeholder' => 'Zip Code', 'class' => 'form-control' . ($errors->has('zip') ? ' has-error' : '')]) }}
</div>