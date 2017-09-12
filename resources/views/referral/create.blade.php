@extends('layouts.app')

@section('pageTitle', 'Submit a New Referral')

@section('content')

    <div class="container-fluid create-referral">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12">
                    <h3><strong>Submit a New Referral</strong></h3>
                </div>
            </div>
        </div>

        <div class="create-referral-wrapper">
            {{ Form::open() }}
                <div id="fb-render" >
                </div>
                <div class="col-md-12">
                    <div class="form-actions btn-group">
                        <button class="btn btn-primary">Submit Referral</button>
                    </div>
                </div>
            {{ Form::close() }}
        {{--@if( isset($form->raw_form_json) )
        @else
            @role(['member'])
                The {{ $_company->company_name }} referral form is not yet available.                
            @endrole
            @role(['admin', 'superAdmin', 'globalAdmin'])
                The {{ $_company->company_name }} referral form is not yet available, click <a href="{{ route('program-options-referral-program-settings') }}">here</a> to create one.
            @endrole
        @endif--}}
        <div class="clearfix"></div>
        </div>
        <div class="old-input hidden">            
            @foreach (session()->getOldInput() as $key => $val)
                <div data-field-name="{{ $key }}" data-value="{{ $val }}"></div>
            @endforeach
        </div>

        @include('layouts.modal')
    </div>

@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready( function() {
            @if( isset($form->raw_form_json) )
             $('#fb-render').formRender({ formData: <? echo json_encode($form->raw_form_json); ?> });
            @else
             $('#fb-render').formRender({ formData: [{"type":"text","required":true,"label":"First Name","placeholder":"Enter your Friend's first name","className":"form-control","name":"first_name","subtype":"text"},{"type":"text","required":true,"label":"Last Name","placeholder":"Enter your Friend's last name","className":"form-control","name":"last_name","subtype":"text"},{"type":"text","subtype":"email","required":true,"label":"Email","placeholder":"Enter your Friend's email","className":"form-control","name":"email"},{"type":"text","required":true,"label":"Phone","placeholder":"Enter your Friend's phone number","className":"form-control phone-custom","name":"phone","subtype":"text"},{"type":"text","required":true,"label":"Address","placeholder":"Enter your Friend's address","className":"form-control address-group","name":"address","subtype":"text"},{"type":"text","required":false,"label":"Line 2","placeholder":"Enter your Friend's address line 2","className":"form-control address-group","name":"address2","subtype":"text"},{"type":"text","required":true,"label":"City","placeholder":"Enter your Friend's city","className":"form-control address-group","name":"city","subtype":"text"},{"type":"select","required":true,"label":"State","className":"form-control address-group","name":"state","values":[{"label":"AL","value":"al"},{"label":"AK","value":"ak"},{"label":"AZ","value":"az"},{"label":"AR","value":"ar"},{"label":"CA","value":"ca"},{"label":"CO","value":"co"},{"label":"CT","value":"ct"},{"label":"DE","value":"de"},{"label":"FL","value":"fl","selected":true},{"label":"GA","value":"ga"},{"label":"HI","value":"hi"},{"label":"ID","value":"id"},{"label":"IL","value":"il"},{"label":"IN","value":"in"},{"label":"IA","value":"ia"},{"label":"KS","value":"ks"},{"label":"KY","value":"ky"},{"label":"LA","value":"la"},{"label":"ME","value":"me"},{"label":"MD","value":"md"},{"label":"MA","value":"ma"},{"label":"MI","value":"mi"},{"label":"MN","value":"mn"},{"label":"MS","value":"ms"},{"label":"MO","value":"mo"},{"label":"MT","value":"mt"},{"label":"NE","value":"ne"},{"label":"NV","value":"nv"},{"label":"NH","value":"nh"},{"label":"NJ","value":"nj"},{"label":"NM","value":"nm"},{"label":"NY","value":"ny"},{"label":"NC","value":"nc"},{"label":"ND","value":"nd"},{"label":"OH","value":"oh"},{"label":"OK","value":"ok"},{"label":"OR","value":"or"},{"label":"PA","value":"pa"},{"label":"RI","value":"ri"},{"label":"SC","value":"sc"},{"label":"SD","value":"sd"},{"label":"TN","value":"tn"},{"label":"TX","value":"tx"},{"label":"UT","value":"ut"},{"label":"VT","value":"vt"},{"label":"VA","value":"va"},{"label":"WA","value":"wa"},{"label":"WV","value":"wv"},{"label":"WI","value":"wi"},{"label":"WY","value":"wy"}]},{"type":"text","required":true,"label":"Zip","placeholder":"Enter your Friend's zip","className":"form-control address-group","name":"zip"}] });
            @endif

             // Place old value to appropriate input field
             $('.old-input > div').each(function(){
                $('input[name="' + $(this).data('field-name') + '"]').val($(this).data('value'));
             });

             $('.phone-custom, .phone-field').each(function (){
                $(this).data('format', '(ddd) ddd-dddd');
                $(this).bfhphone($(this).data());
             });

             // Make 2 columns for each row
             $('#fb-render > div').addClass('col-md-6');
        });
    </script>
@endsection
