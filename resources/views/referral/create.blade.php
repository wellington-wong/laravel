@extends('layouts.app')

@section('pageTitle', 'Create Referral')

@section('content')

    <div class="container-fluid create-referral">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12">
                    <h3><strong>Submit a New Referral</strong></h3>
                </div>
            </div>
        </div>
        @if( !$errors->isEmpty() )
            <div class="alert alert-warning">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif


        @if( isset($form->raw_form_json) )
            {{ Form::open() }}
                <div id="fb-render" >
                </div>
                <button >Submit</button>
            {{ Form::close() }}
        @else
            This company has no referral forms.
        @endif

        @include('layouts.modal')
    </div>

@endsection

@section('js')
    @if( isset($form->raw_form_json) )
    <script type="text/javascript">
        $(document).ready( function() {
             $('#fb-render').formRender({ formData: <? echo json_encode($form->raw_form_json); ?> });
        });
    </script>
    @endif
@endsection
