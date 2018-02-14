@extends('layouts.app')

@section('pageTitle', 'Reviews')

@section('js')
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/knockout/3.1.0/knockout-min.js"></script>
  <script type="text/javascript" src="https://go.reviewpush.com/go/feedback/js/feedback_embed.js"></script>
  <script type="text/javascript" src="{{ asset('/js/jquery.twbsPagination.min.js') }}"></script>

  <script>
    var api_key = '{{ env("REVIEWPUSH_KEY") }}';
    var default_rating = '5';
    var location_results = 5;
    $(function (){
      $('.review-stars .tooltip').removeClass('tooltip');
      $('.reviewpush-feed > div').eq(0).twbsPagination({
          totalPages: 35,
          visiblePages: 7,
          onPageClick: function (event, page) {
              $('#page-content').text('Page ' + page);
          }
      });
    });
  </script>
@stop

@section('css')
  <link rel="stylesheet" type="text/css" href="//go.reviewpush.com/go/css/reviews.css" />
@stop

@section('content')
    
    <div class="container-fluid">
      <div class="row">
          @include('layouts.page-header', ['header' => 'Reviews', 'col' => 3])
          <div class="col-md-9 text-right"><a href="{{ route('referrals') }}"><small><< Back to Referrals</small></a></div>
      </div>

      <div class="row reviewpush-feed">
        <?php echo file_get_contents('https://go.reviewpush.com/embedded/feed/show/69dcefc73ba84894894d93b7a47e47f9/405?server=true'); ?>
        <div id='powered-by' style='border-top:1px solid #cccccc; padding:5px 0 15px 0; width:100%;'><div style='float:right;'><span style='font-family:arial; font-size:13px; color:#777777;'>powered by</span><a href='http://www.reviewpush.com' title='ReviewPush Online Review Monitoring' style="float:right;"><img alt='ReviewPush Online Review Monitoring' src='https://s3.amazonaws.com/ReviewPush/Public/Media/poweredby.png' style='border:0; vertical-align:middle;'></a></div></div>
      </div>

      <div class="row">
          <!-- Begin ReviewPush Feedback Embed -->
          <h3>Leave Feedback</h3>
          <form method="post" data-bind="visible: showFeedbackForm, submit: save">
            <div style="display: none;" class="location-popup" data-bind="visible: show_location_list">
              <div data-bind="foreach: location_list"></div>
              <a href="#" data-bind="click: hideLocationList">Close</a>
            </div>

            <div style="display: none;" data-bind="visible: has_selected_location">
              <div><a href="#" data-bind="click: toggleLocationList">Wrong Location?</a></div>
              <div>
                <strong>Location:</strong>
                <div>
                  <div data-bind="text: selected_location().name"></div>
                  <div data-bind="text: selected_location().address"></div>
                  <div>
                    <span data-bind="text: selected_location().city"></span>,
                    <span data-bind="text: selected_location().state"></span>
                    <span data-bind="text: selected_location().zip"></span>
                  </div>
                  <div data-bind="text: selected_location().phone"></div>
                </div>
              </div>
            </div>

            <div>
              <a href="#" class="star full" data-bind="click: function(data, event) { setRating(1); }, css: { full: rating() >= 1 }"></a>
              <a href="#" class="star full" data-bind="click: function(data, event) { setRating(2); }, css: { full: rating() >= 2 }"></a>
              <a href="#" class="star full" data-bind="click: function(data, event) { setRating(3); }, css: { full: rating() >= 3 }"></a>
              <a href="#" class="star full" data-bind="click: function(data, event) { setRating(4); }, css: { full: rating() >= 4 }"></a>
              <a href="#" class="star full" data-bind="click: function(data, event) { setRating(5); }, css: { full: rating() == 5 }"></a>
            </div>

            <div>
              <input name="name" id="name" value="" placeholder="Name" data-bind="value: reviewer_name" type="text">
            </div>

            <div>
              <input name="email" id="email" value="" placeholder="Email" data-bind="value: reviewer_email" type="text">
            </div>

            <div>
              <textarea name="message" id="input-message" placeholder="Message" data-bind="value: review_text"></textarea>
            </div>

            <div>
              <input name="submit" data-bind="click: save" id="submit_btn" value="Send Message!" type="submit">
            </div>
          </form>

          <div style="display: none;" data-bind="visible: showThankYouMessage">
            Thank you for your feedback! Please be assured that it will be routed to the right person in our organization. We take all feedback very seriously. 
          </div>
        </div>
      </div>
        <style type="text/css">
          .star {
            background-image:url(http://go.reviewpush.com/img/blue-star-empty.png);
            display:inline-block;
            height:18px;
            width:18px;
          }
          .star.full {
            background-image:url(http://go.reviewpush.com/img/blue-star-full.png);
          }
          .location-popup {
            position: absolute;
            z-index: 99999;
            background-color: white;
            border: 1px solid #aaa;
            padding: 20px;
          }
          .location-row {
            border-bottom: 1px solid #aaa;
            padding-top: 6px;
            padding-bottom: 6px;
            cursor: pointer;
          }
        </style>

        <!-- End ReviewPush Feedback Embed --> 

@endsection