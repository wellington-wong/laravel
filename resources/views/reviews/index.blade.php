@extends('layouts.app')

@section('pageTitle', 'Reviews')

@section('content')

    <div class="container-fluid">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Reviews', 'col' => 12])
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <label>A listing of reviews from our satisfied customers.</label>
            <div>&nbsp;</div>
            <div class="reviews">      
            <div>&nbsp;</div>

              <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                  <li data-target="#myCarousel" data-slide-to="1"></li>
                  <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <div class="item active">
                        <div class="carousel-item active">
                            <!--Grid column-->
                            <div class="col-md-4">

                                <div class="testimonial">
                                    <!--Avatar-->
                                    <div class="avatar">
                                        <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(26).jpg" class="rounded-circle img-fluid">
                                    </div>
                                    <!--Content-->
                                    <h4>Anna Deynah</h4>
                                    <h6 class="blue-text font-bold">Web Designer</h6>
                                    <p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod eos id officiis hic tenetur.</p>

                                    <!--Review-->
                                    <div class="grey-text">
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star-half-full"> </i>
                                    </div>
                                </div>

                            </div>
                            <!--Grid column-->

                            <!--Grid column-->
                            <div class="col-md-4 clearfix d-none d-md-block">
                                <div class="testimonial">
                                    <!--Avatar-->
                                    <div class="avatar">
                                        <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(27).jpg" class="rounded-circle img-fluid">
                                    </div>
                                    <!--Content-->
                                    <h4>John Doe</h4>
                                    <h6 class="blue-text font-bold">Web Developer</h6>
                                    <p><i class="fa fa-quote-left"></i> Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.</p>

                                    <!--Review-->
                                    <div class="grey-text">
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star"> </i>
                                    </div>
                                </div>
                            </div>
                            <!--Grid column-->
                            
                            <!--Grid column-->
                            <div class="col-md-4 clearfix d-none d-md-block">
                                <div class="testimonial">
                                    <!--Avatar-->
                                    <div class="avatar">
                                        <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(31).jpg" class="rounded-circle img-fluid">
                                    </div>
                                    <!--Content-->
                                    <h4>Abbey Clark</h4>
                                    <h6 class="blue-text font-bold">Photographer</h6>
                                    <p><i class="fa fa-quote-left"></i> Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae.</p>
                                    
                                    <!--Review-->
                                    <div class="grey-text">
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star-o"> </i>
                                    </div>
                                </div>
                            </div>
                            <!--Grid column-->

                        </div>
                  </div>

                  <div class="item">
                  <div class="carousel-item">
                                  <!--Grid column-->
                                  <div class="col-md-4">

                                      <div class="testimonial">
                                          <!--Avatar-->
                                          <div class="avatar">
                                              <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(4).jpg" class="rounded-circle img-fluid">
                                          </div>
                                          <!--Content-->
                                          <h4>Blake Dabney</h4>
                                          <h6 class="blue-text font-bold">Web Designer</h6>
                                          <p><i class="fa fa-quote-left"></i> Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis laboriosam.</p>

                                          <!--Review-->
                                          <div class="grey-text">
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star-half-full"> </i>
                                          </div>
                                      </div>

                                  </div>
                                  <!--Grid column-->

                                  <!--Grid column-->
                                  <div class="col-md-4 clearfix d-none d-md-block">
                                      <div class="testimonial">
                                          <!--Avatar-->
                                          <div class="avatar">
                                              <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(6).jpg" class="rounded-circle img-fluid">
                                          </div>
                                          <!--Content-->
                                          <h4>Andrea Clay</h4>
                                          <h6 class="blue-text font-bold">Front-end developer</h6>
                                          <p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod eos id officiis hic tenetur quae.</p>

                                          <!--Review-->
                                          <div class="grey-text">
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                          </div>
                                      </div>
                                  </div>
                                  <!--Grid column-->

                                  <!--Grid column-->
                                  <div class="col-md-4 clearfix d-none d-md-block">
                                      <div class="testimonial">
                                          <!--Avatar-->
                                          <div class="avatar">
                                              <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(7).jpg" class="rounded-circle img-fluid">
                                          </div>
                                          <!--Content-->
                                          <h4>Cami Gosse</h4>
                                          <h6 class="blue-text font-bold">Phtographer</h6>
                                          <p><i class="fa fa-quote-left"></i> At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium.</p>

                                          <!--Review-->
                                          <div class="grey-text">
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star-o"> </i>
                                          </div>
                                      </div>
                                  </div>
                                  <!--Grid column-->

                              </div>
                  </div>

                  <div class="item">
              <div class="carousel-item">
                                  <!--Grid column-->
                                  <div class="col-md-4">

                                      <div class="testimonial">
                                          <!--Avatar-->
                                          <div class="avatar">
                                              <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(8).jpg" class="rounded-circle img-fluid">
                                          </div>
                                          <!--Content-->
                                          <h4>Bobby Haley</h4>
                                          <h6 class="blue-text font-bold">Web Developer</h6>
                                          <p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod eos id officiis hic tenetur quae.</p>

                                          <!--Review-->
                                          <div class="grey-text">
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                          </div>
                                      </div>

                                  </div>
                                  <!--Grid column-->

                                  <!--Grid column-->
                                  <div class="col-md-4 clearfix d-none d-md-block">
                                      <div class="testimonial">
                                          <!--Avatar-->
                                          <div class="avatar">
                                              <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(10).jpg" class="rounded-circle img-fluid">
                                          </div>
                                          <!--Content-->
                                          <h4>Elisa Janson</h4>
                                          <h6 class="blue-text font-bold">Marketer</h6>
                                          <p><i class="fa fa-quote-left"></i> At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium.</p>

                                          <!--Review-->
                                          <div class="grey-text">
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star-half-full"> </i>
                                          </div>
                                      </div>
                                  </div>
                                  <!--Grid column-->

                                  <!--Grid column-->
                                  <div class="col-md-4 clearfix d-none d-md-block">
                                      <div class="testimonial">
                                          <!--Avatar-->
                                          <div class="avatar">
                                              <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(9).jpg" class="rounded-circle img-fluid">
                                          </div>
                                          <!--Content-->
                                          <h4>Robert Jacobs</h4>
                                          <h6 class="blue-text font-bold">Front-end developer</h6>
                                          <p><i class="fa fa-quote-left"></i> Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis laboriosam.</p>

                                          <!--Review-->
                                          <div class="grey-text">
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star"> </i>
                                              <i class="fa fa-star-o"> </i>
                                          </div>
                                      </div>
                                  </div>
                                  <!--Grid column-->

                              </div>
                  </div>
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
       
                <div class="reviews-container">
                    <div class="row">
                      <hr />
                    </div>
                    <div class="row">
                      <div class="col-md-10">
                        <label>Create a review by filling in the form below</label>
                      </div>
                    </div>
                    <div>&nbsp;</div>
                    <div class="row">
                      <div class="col-md-9 col-md-offset-0">
                        <div class="">
                          <form class="form-horizontal" action="send.php" method="post">
                          <fieldset>
                    
                            <!-- Name input-->
                            <div class="form-group">
                              <label class="col-md-3 control-label" for="name">Full Name</label>
                              <div class="col-md-9">
                                <input id="name" name="name" type="text" placeholder="Your name" class="form-control">
                              </div>
                            </div>
                    
                            <!-- Email input-->
                            <div class="form-group">
                              <label class="col-md-3 control-label" for="email">Your E-mail</label>
                              <div class="col-md-9">
                                <input id="email" name="email" type="text" placeholder="Your email" class="form-control">
                              </div>
                            </div>
                    
                            <!-- Message body -->
                            <div class="form-group">
                              <label class="col-md-3 control-label" for="message">Your Review</label>
                              <div class="col-md-9">
                                <textarea class="form-control" id="message" name="message" placeholder="Please enter your feedback here..." rows="5"></textarea>
                              </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="form-group">
                              <label class="col-md-3 control-label" for="message">Your Image</label>
                              <div class="col-md-9">                              
                             {{ Form::file('thefile') }}
                            </div>
                            </div>


                            <!-- Rating -->
                            <div class="form-group">
                              <label class="col-md-3 control-label" for="message">Your rating</label>
                              <div class="col-md-9">
                                <input id="input-21e" value="0" type="number" class="rating" min=0 max=5 step=0.5 data-size="xs" >
                              </div>
                            </div>
                            <!-- Form actions -->
                            <div class="form-group">
                              <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-md">Submit</button>
                                <button type="reset" class="btn btn-default btn-md">Clear</button>
                              </div>
                            </div>
                          </fieldset>
                          </form>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

@endsection