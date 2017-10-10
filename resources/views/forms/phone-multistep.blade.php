<div class="form-group {{ isset($class) ? $class : '' }}">
    {{ Form::hidden('phone_country', 'US') }}
    {{-- Form::select('phone_country', \Propaganistas\LaravelIntl\Facades\Country::all(), 'US' ) --}}
    @if (isset($class)) <div class="{{ isset($class) ? $class : '' }} col-md-12"> @endif
    {{ Form::text(isset($phone_name) ? $phone_name : 'phone', null, ['class'=>'bfh-phone ' . (isset($class) ? 'form-control' : ''), 'data-format'=>'(ddd) ddd-dddd', 'placeholder' => 'Your Number *']) }}
    {{ Form::text('phone_placeholder', null, ['placeholder' => 'Your Number *', 'class' => 'phone-placeholder form-control']) }}
    @if (isset($class)) </div> @endif
</div>