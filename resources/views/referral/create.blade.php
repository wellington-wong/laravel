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
             $('#fb-render').formRender({ formData: [{"type":"text","required":true,"label":"First Name","placeholder":"Enter your Friend's first name","className":"form-control","name":"first_name","subtype":"text"},{"type":"text","required":true,"label":"Last Name","placeholder":"Enter your Friend's last name","className":"form-control","name":"last_name","subtype":"text"},{"type":"text","subtype":"email","required":true,"label":"Email","placeholder":"Enter your Friend's email","className":"form-control","name":"email"},{"type":"text","required":true,"label":"Phone","placeholder":"Enter your Friend's phone number","className":"form-control","name":"phone"}] });
            @endif

             // Place old value to appropriate input field
             $('.old-input > div').each(function(){
                $('input[name="' + $(this).data('field-name') + '"]').val($(this).data('value'));
             });

             // Make 2 columns for each row
             $('#fb-render > div').addClass('col-md-6');
        });
    </script>
@endsection
