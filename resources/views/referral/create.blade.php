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
        
        @if( isset($form->raw_form_json) )
            {{ Form::open() }}
                <div id="fb-render" >
                </div>
                <div class="col-md-12">
                    <div class="form-actions btn-group">
                        <button class="btn btn-primary">Submit Referral</button>
                    </div>
                </div>
            {{ Form::close() }}
        @else
            @role(['member'])
                The {{ $_company->company_name }} referral form is not yet available.                
            @endrole
            @role(['admin', 'superAdmin', 'globalAdmin'])
                The {{ $_company->company_name }} referral form is not yet available, click <a href="{{ route('program-options-referral-program-settings') }}">here</a> to create one.
            @endrole
        @endif

        <div class="old-input hidden">            
            @foreach (session()->getOldInput() as $key => $val)
                <div data-field-name="{{ $key }}" data-value="{{ $val }}"></div>
            @endforeach
        </div>

        @include('layouts.modal')
    </div>

@endsection

@section('js')
    @if( isset($form->raw_form_json) )
    <script type="text/javascript">
        $(document).ready( function() {
             $('#fb-render').formRender({ formData: <? echo json_encode($form->raw_form_json); ?> });

             // Place old value to appropriate input field
             $('.old-input > div').each(function(){
                $('input[name="' + $(this).data('field-name') + '"]').val($(this).data('value'));
             });

             // Make 2 columns for each row
             $('#fb-render > div').addClass('col-md-6');
        });
    </script>
    @endif
@endsection
