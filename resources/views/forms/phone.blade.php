<div class="form-group referral-phone {{ isset($class) ? $class : '' }}">
    @if (!isset($placeholder)) <label class="{{ isset($class) ? $class : '' }}"><?php echo isset($phone_label) ? $phone_label : 'Phone Number' ?></label> @endif
    {{ Form::hidden('phone_country', 'US') }}
    {{-- Form::select('phone_country', \Propaganistas\LaravelIntl\Facades\Country::all(), 'US' ) --}}
    @if (isset($class)) <div class="{{ isset($class) ? $class : '' }} col-md-12"> @endif
    {{ Form::text('phone', null, ['class'=>'bfh-phone' . (isset($class) ? ' form-control' : '') . (isset($placeholder) ? ' hidden' : ''), 'data-format'=>'(ddd) ddd-dddd']) }}
    @if (isset($placeholder)) {{ Form::text('phone_placeholder', null, ['placeholder' => $placeholder, 'class' => 'phone-placeholder']) }} @endif
    @if (isset($class)) </div> @endif
</div>