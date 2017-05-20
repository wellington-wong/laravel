<div class="form-group referral-phone">
    @if (!isset($placeholder)) <label class="{{ isset($class) ? $class : '' }}"><?php echo isset($phone_label) ? $phone_label : 'Phone Number' ?></label> @endif
    {{ Form::hidden('phone_country', 'US') }}
    {{-- Form::select('phone_country', \Propaganistas\LaravelIntl\Facades\Country::all(), 'US' ) --}}
    @if (isset($class)) <div class="{{ isset($class) ? $class : '' }} col-md-12"> @endif
    {{ Form::text('phone', null, ['class'=>'bfh-phone form-control' . (isset($placeholder) ? ' hidden' : ''), 'data-format'=>'(ddd) ddd-dddd']) }}
    @if (isset($placeholder)) {{ Form::text('phone_placeholder', null, ['placeholder' => $placeholder, 'class' => 'phone-placeholder form-control']) }} @endif
    @if ($errors->has('phone'))<small class=error>{{ $errors->first('phone', ':message') }}</small>@endif
    @if (isset($class)) </div> @endif
</div>