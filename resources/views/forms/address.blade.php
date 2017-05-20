<div class="form-group">
    {{ Form::text('address', null, ['placeholder' => 'Referral\'s Home Address', 'class' => 'form-control']) }}
    @if ($errors->has('address'))<small class=error>{{ $errors->first('address', ':message') }}</small>@endif
</div>

<div class="form-group">
    {{ Form::text('address2', null, ['placeholder' => 'Address Line 2', 'class' => 'form-control']) }}
    @if ($errors->has('address2'))<small class=error>{{ $errors->first('address2', ':message') }}</small>@endif
</div>

<div class="form-group">
    {{ Form::text('city', null, ['placeholder' => 'City', 'class' => 'form-control']) }}
    @if ($errors->has('city'))<small class=error>{{ $errors->first('city', ':message') }}</small>@endif
</div>

<div class="form-group">
    {{ Form::text('state', null, ['placeholder' => 'State', 'class' => 'form-control']) }}
    @if ($errors->has('state'))<small class=error>{{ $errors->first('state', ':message') }}</small>@endif
</div>

<div class="form-group">
    {{ Form::text('zip', null, ['placeholder' => 'Zip Code', 'class' => 'form-control']) }}
    @if ($errors->has('zip'))<small class=error>{{ $errors->first('zip', ':message') }}</small>@endif
</div>