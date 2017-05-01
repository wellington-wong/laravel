<div class="form-group">
    <label><?php echo isset($phone_label) ? $phone_label : 'Phone Number' ?></label>
    {{ Form::hidden('phone_country', 'US') }}
    {{-- Form::select('phone_country', \Propaganistas\LaravelIntl\Facades\Country::all(), 'US' ) --}}
    {{ Form::text('phone', null, ['class'=>'bfh-phone', 'data-format'=>'(ddd) ddd-dddd']) }}
</div>