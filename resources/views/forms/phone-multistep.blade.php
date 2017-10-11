<div class="form-group {{ isset($class) ? $class : '' }}">
   	<label class="hidden">{{ (isset($phone_label) ? str_replace('*', '', $phone_label) : 'Number') }}</label>
    @if (isset($class)) <div class="{{ isset($class) ? $class : '' }} col-md-12"> @endif
    {{ Form::text(isset($phone_name) ? $phone_name : 'phone', null, ['class'=>'bfh-phone ' . (isset($class) ? 'form-control' : ''), 'data-format'=>'(ddd) ddd-dddd', 'placeholder' => 'Your Number *']) }}
    {{ Form::text('phone_placeholder', null, ['placeholder' => (isset($phone_label) ? $phone_label : 'Your Number *'), 'class' => 'phone-placeholder form-control']) }}
    @if (isset($class)) </div> @endif
</div>