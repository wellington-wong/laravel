@if (!isset($company))
<div class="form-group col-md-6">
    {{ Form::text('address', null, ['placeholder' => (isset($address_placeholder) ? $address_placeholder : 'Referral\'s Home Address' ), 'class' => 'form-control' . ($errors->has('address') ? ' has-error' : '')]) }}
</div>

<div class="form-group col-md-6">
    {{ Form::text('address2', null, ['placeholder' => 'Address Line 2', 'class' => 'form-control' . ($errors->has('address2') ? ' has-error' : '')]) }}
</div>

<div class="form-group col-md-4">
    {{ Form::text('city', null, ['placeholder' => 'City', 'class' => 'form-control' . ($errors->has('city') ? ' has-error' : '')]) }}
</div>

<div class="form-group col-md-2">
	@include('forms.states', [])
</div>

<div class="form-group col-md-6">
    {{ Form::text('zip', null, ['placeholder' => 'Zip Code', 'class' => 'form-control' . ($errors->has('zip') ? ' has-error' : '')]) }}
</div>
@else 
<!-- Company Profile -->
<div class="form-group col-md-6">
	<label>Company Address Line 1</label>
    {{ Form::text('address', $address, ['placeholder' => 'Company Address Line 1', 'class' => 'form-control' . ($errors->has('address') ? ' has-error' : '')]) }}
</div>

<div class="form-group col-md-6">
	<label>Address Line 2</label>
    {{ Form::text('address2', $address2, ['placeholder' => 'Line 2', 'class' => 'form-control' . ($errors->has('address2') ? ' has-error' : '')]) }}
</div>

<div class="clearfix"></div>
<div class="form-group col-lg-4">
    <label>City</label>
    {{ Form::text('city', $city, ['placeholder' => 'City', 'class' => 'form-control' . ($errors->has('city') ? ' has-error' : '')]) }}
</div>

<div class="form-group col-lg-2">
	<label>States</label>
	@include('forms.states', ['state' => $state])
</div>

<div class="form-group col-lg-2">
	<label>Zip Code</label>
    {{ Form::text('zip', $zip, ['placeholder' => 'Zip Code', 'class' => 'form-control' . ($errors->has('zip') ? ' has-error' : '')]) }}
</div>

<div class="form-group col-lg-4">
    <label>Country</label>
    @include('forms.countries', [])
</div>
@endif 