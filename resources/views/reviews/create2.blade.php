@extends('layouts.app')

@section('pageTitle', 'Submit a New Referral')

@section('content')

    <div class="container-fluid create-referral">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12">
                    <h3><strong>Submit a New Review</strong></h3>
                </div>
            </div>
        </div>

        <div class="create-referral-wrapper">

              {{ Form::open(['url' => route('my-review-submit'), 'class' => 'form', 'files' => true]) }}
                @role(['admin', 'superAdmin', 'globalAdmin'])
                <div class="form-group col-md-12">
                    {{ Form::label('as_member', 'Submit as a member') }}                    
                    {{ Form::select('as_member', ($_company->members()->pluck('name', 'id') ? ['0' => 'Please select a member'] +  $_company->members()->pluck('name', 'id')->toArray() : [] ), '', ['class' => 'form-control']) }}
                </div>
                @endrole
                <div class="row">
                  <div class="col-md-12">

                       <!-- URL input-->
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="review-url">URL</label>
                        <div class="col-md-9">
                          <input id="review-url" name="review_url" type="text" placeholder="URL" value="{{ old('review_url') ?: '' }}"  class="form-control">
                        </div>
                      </div>

                       <!-- Screenshot Upload -->
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="review-screenshot">Screenshot of the review</label>
                        <div class="col-md-9">           
                          <img class="img-responsive pull-left hidden padding-right review-screenshot-preview" width="30" src="{{ old('review_screenshot_blob') ? : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' }}">
                          {{ Form::file('review_screenshot', ['class' => 'form review-screenshot']) }}
                          {{ Form::hidden('review_screenshot_blob', null, ['class' => 'review-screenshot-blob']) }}
                          {{ Form::hidden('review_screenshot_blob_name', null, ['class' => 'review-screenshot-blob-name']) }}
                        </div>
                      </div>

                        <div class="form-group">
                          <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-submit-review">Submit Review</button>
                          </div>
                        </div>
                      </div>
                  </div>
            {{ Form::close() }}
            <div class="clearfix"></div>
        </div>
        @include('layouts.modal')
    </div>

@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready( function() {
        });
    </script>
@endsection
