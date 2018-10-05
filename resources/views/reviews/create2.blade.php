@extends('layouts.app')

@section('pageTitle', 'Create a Review')

@section('content')

    <div class="container-fluid">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Create a Review', 'col' => 12])
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <label>A listing of reviews from our satisfied customers.</label>
            <div>&nbsp;</div>
            <div class="reviews">      
          <div>&nbsp;</div>
 
            @if (count($reviews))            
              <div id="myCarousel" class="carousel slide reviews-carousel" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">                   
                    @foreach($reviews->chunk(3) as $chunk)
                        <li data-target="#myCarousel" data-slide-to="{{ ($loop->iteration)-1 }}" @if($loop->iteration == 1)class="active"@endif></li>                     
                    @endforeach
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">       
                    @foreach($reviews->chunk(3) as $chunk)
                    <div class="item @if($loop->iteration == 1) active @endif">
                        <div class="carousel-item @if($loop->iteration == 1) active @endif">
                            @foreach($chunk as $review)
                            <!--Grid column-->
                            <div class="col-md-4">
                                <div class="testimonial">
                                    <!--Avatar-->
                                    <div class="avatar">
                                        <img src="{{ isset($review->photo) ? url($review->photo) : '/images/avatar-placeholder.png' }}" class="rounded-circle img-fluid">
                                    </div>
                                    <!--Content-->
                                    <h4>{{ $review->display_name }}</h4>
                                    @if (isset($review->snippet))<p><i class="fa fa-quote-left"></i> {{ $review->snippet }}</p>@endif

                                    <!--Review-->
                                    <input disabled name="rating" value="{{ $review->rating }}" type="number" class="rating" min=0 max=5 step=0.5 data-size="xs" >
                                </div>
                            </div>
                            @endforeach 
                        </div>
                    </div>
                    @endforeach
                           
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
              @else
                <div>No reviews found.</div>
                @endif
       
                <div class="reviews-container">
                    <div class="row">
                      <hr />
                    </div>
                    <div class="row">
                      <div class="col-md-10">
                        <label>Create a review by filling out the form below</label>
                      </div>
                    </div>
                    <div>&nbsp;</div>
                    <div class="row">
                      <div class="col-md-12">
                          {{ Form::open(['url' => route('post-review'), 'class' => 'form', 'files' => true]) }}
                            <!-- Name input-->
                            <div class="form-group">
                              <label class="col-md-3 control-label" for="display-name">Display Name</label>
                              <div class="col-md-9">
                                <input id="display-name" name="display_name" type="text" placeholder="Display Name" value="{{ old('display_name') ?: auth()->user()->getDisplayNameAttribute() }}" class="form-control">
                              </div>
                            </div>

                             <!-- URL input-->
                            <div class="form-group">
                              <label class="col-md-3 control-label" for="review-url">URL</label>
                              <div class="col-md-9">
                                <input id="review-url" name="review_url" type="text" placeholder="URL" value="{{ old('review_url') ?: '' }}"  class="form-control">
                              </div>
                            </div>

                             <!-- Snippet input-->
                            <div class="form-group">
                              <label class="col-md-3 control-label" for="review-snippet">Snippet (optional)</label>
                              <div class="col-md-9">
                                <input id="review-snippet" name="review_snippet" type="text" placeholder="Snippet" value="{{ old('review_snippet') ?: '' }}"  class="form-control">
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

                             <!-- Your photo -->
                            <div class="form-group">
                              <label class="col-md-3 control-label" for="review-photo">Your photo (optional)</label>
                              <div class="col-md-9">         
                              <img class="img-responsive pull-left hidden padding-right review-photo-preview" width="30" src="{{ old('review_photo_blob') ? : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' }}">                     
                                {{ Form::file('review_photo', ['class' => 'form review-photo']) }}
                                {{ Form::hidden('review_photo_blob', null, ['class' => 'review-photo-blob']) }}
                                {{ Form::hidden('review_photo_blob_name', null, ['class' => 'review-photo-blob-name']) }}
                              </div>
                            </div>

                            <!-- Rating -->
                              <div class="form-group">
                                <label class="col-md-3 control-label" for="message">Your rating</label>
                                <div class="col-md-9">
                                  <input name="rating" value="{{ old('rating') ?: 0 }}" type="number" class="rating" min=0 max=5 step=0.5 data-size="xs" >
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-md-12 text-right">
                                  <button type="submit" class="btn btn-primary btn-submit-review">Submit</button>
                                </div>
                              </div>
                            </div>
                          {{ Form::close() }}
                    </div>
                </div>



            </div>
        </div>
    </div>

@endsection