<div class="form-group {{ isset($class) ? $class : '' }}">
    <label class="{{ isset($class) ? $class : '' }}"><?php echo isset($phone_label) ? $phone_label : 'Phone Number' ?></label>
    {{ Form::hidden('phone_country', 'US') }}
    {{-- Form::select('phone_country', \Propaganistas\LaravelIntl\Facades\Country::all(), 'US' ) --}}
    @if (isset($class)) <div class="{{ isset($class) ? $class : '' }} col-md-12"> @endif
    {{ Form::text('phone', null, ['class'=>' ' . (isset($class) ? 'form-control' : ''), 'data-format'=>'(ddd) ddd-dddd']) }}
    @if (isset($class)) </div> @endif
</div>