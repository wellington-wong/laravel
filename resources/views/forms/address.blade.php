<div class="form-group col-md-6">
    {{ Form::text('address', null, ['placeholder' => 'Referral\'s Home Address', 'class' => 'form-control' . ($errors->has('address') ? ' has-error' : '')]) }}
</div>

<div class="form-group col-md-6">
    {{ Form::text('address2', null, ['placeholder' => 'Address Line 2', 'class' => 'form-control' . ($errors->has('address2') ? ' has-error' : '')]) }}
</div>

<div class="form-group col-md-4">
    {{ Form::text('city', null, ['placeholder' => 'City', 'class' => 'form-control' . ($errors->has('city') ? ' has-error' : '')]) }}
</div>

<div class="form-group col-md-2">
	@include('forms.states', ['add_referral' => (!$company_address ? true : false)])
</div>

<div class="form-group col-md-6">
    {{ Form::text('zip', null, ['placeholder' => 'Zip Code', 'class' => 'form-control' . ($errors->has('zip') ? ' has-error' : '')]) }}
</div>