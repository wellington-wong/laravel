                                <form id="register-form-multistep" method="POST" action="{{ route('post_register_simple') }}">
                                {{ csrf_field() }}
                                    <div>
                                        <h3>Your Info</h3>

                                        <!-- Step 1 -->
                                        <section>
                                            <div class="form-group-wrapper">
                                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} col-md-6">
                                                    <label class="hidden">First Name</label>
                                                    <div class="col-md-12">
                                                        <input id="first-name" type="text" class="form-control" name="first_name" required autofocus placeholder="First Name *">
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }} col-md-6">
                                                    <label class="hidden">Last Name</label>
                                                    <div class="col-md-12">
                                                        <input id="last-name" type="text" class="form-control" name="last_name" required placeholder="Last Name *">
                                                    </div>
                                                </div>

                                                @include('forms.phone-multistep', ['phone_label'=>"Phone Number *", 'class'=>'col-md-6'])

                                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-6">
                                                    <label class="hidden">Email</label>
                                                    <div class="col-md-12">
                                                        <input id="email" type="email" class="form-control" name="email" required placeholder="Your E-Mail *">
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-6">
                                                    <label class="hidden">Password</label>
                                                    <div class="col-md-12">
                                                        <input id="password" type="password" class="form-control" name="password" required placeholder="Password *">
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <div class="col-md-12">
                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password *">
                                                    </div>
                                                 </div>   
                                                 <div class="form-group col-md-12 no-margin">
                                                    <label class="col-md-12 control-label password-note">*Password must be 8 characters and contain a number and a special character.</label>                                               
                                                 </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </section>
                                        <!-- Step 1 End -->

                                        <!-- Step 2 -->
                                        <h3>Company Info</h3>
                                        <section>

                                            <div class="form-group-wrapper">
                                                <div class="form-group col-md-6">
                                                    <label class="hidden">Your Company's Name</label>
                                                    <div class="col-md-12">                                                    
                                                    {{ Form::text('company_name', '', array('class' => 'form-control', 'placeholder' => 'Your Company\'s Name *')) }}
                                                    </div>                                                
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="hidden">Your Company's Subdomain</label>
                                                    <div class="col-md-12">                                                    
                                                    {{ Form::text('subdomain', '', array('class' => 'form-control', 'placeholder' => 'Your Company\'s Subdomain *')) }}
                                                    </div>                                                
                                                </div>
                                                    
                                                @include('forms.phone-multistep', ['phone_label'=>"Your Company's Number *", 'class'=>'col-md-6', 'label_class'=>'col-md-12', 'phone_name' => 'company_phone'])
                                                  
                                                <div class="form-group col-md-6">
                                                    <label class="hidden">Your Company's Email</label>
                                                    <div class="col-md-12">
                                                        {{ Form::text('company_email', '', array('class' => 'form-control', 'placeholder' => 'Your Company\'s Email *')) }}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label class="hidden">Business Type</label>
                                                    <div class="col-md-12">
                                                        {{ Form::select('business_type', ['' => 'Type of Business *'] + \App\Company::$businessType, '', array('class' => 'form-control')) }}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label class="hidden">Your Company's Address</label>
                                                    <div class="col-md-12">
                                                        {{ Form::text('company_address_1', '', array('class' => 'form-control', 'placeholder' => 'Your Company\'s Address *')) }}
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="hidden">Your Company's Address Line 2</label>
                                                    <div class="col-md-12">
                                                        {{ Form::text('company_address_2', '', array('class' => 'form-control', 'placeholder' => 'Line 2')) }}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label class="hidden">City</label>
                                                    <div class="col-md-12">
                                                        {{ Form::text('company_city', '', array('class' => 'form-control', 'placeholder' => 'City *')) }}
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="hidden">City</label>
                                                    <div class="col-md-12">
                                                        @include('forms.states', ['state' => 'fl', 'placeholder' => 'State *'])                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label class="hidden">Zip</label>
                                                    <div class="col-md-12">
                                                        {{ Form::text('company_zip', '', array('class' => 'form-control', 'placeholder' => 'Zip *')) }}
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </section>
                                        <!-- Step 2 End -->

                                        <!-- Step 3 -->
                                        <h3>Billing Information</h3>
                                        <section class="billing-information">

                                            <!--<div class="form-group col-md-12">
                                                <div class="col-md-12">
                                                    <label>Credit Card Number</label>
                                                    {{ Form::text('cc_num', '', array('class' => 'form-control')) }}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-6">
                                                    <label>Expiration Date</label>
                                                    {{ Form::text('exp_date', '', array('class' => 'form-control', 'placeholder' => 'MM/YY')) }}
                                                </div>
                                                <div class="col-md-6">
                                                    <label>CSV</label>
                                                    {{ Form::text('csv', '', array('class' => 'form-control')) }}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-12">
                                                    <label>Select Your Plan</label>
                                                    {{ Form::select('bus_plan', array('999' => 'Basic Plan - $999 a month'), 999, ['class' => 'form-control']) }}
                                                </div>
                                            </div>-->

                                              <div class="form-group col-md-12">
                                                  <div class="col-md-12">
                                                    <div id="card-element"></div>
                                                    <div id="card-errors" class="hidden" role="alert"></div>
                                                  </div>
                                              </div>

                                                <div class="form-group col-md-12">
                                                    <label class="hidden">Package Type</label>
                                                    <div class="col-md-12">
                                                        {{ Form::select('bus_plan', array('' => 'Select Your Package *', '999' => 'Basic Package - $999 a month'), null, ['class' => 'form-control']) }}
                                                    </div>
                                                </div>

                                              <div class="form-group col-md-12">
                                                <div class="col-md-12 accept-billing-terms">
                                                    <label>
                                                      <input type="checkbox" name="cc_accept_terms" class="accept-terms">
                                                      <span>I have read and accept the <a href="javascript:void(0)" id="billing-terms">billing terms and conditions.</a></span>
                                                    </label>
                                                  </div>
                                              </div>
                                            {{ Form::hidden('stripe_id', '') }}
                                            <div class="form-group hidden"><label>Credit Card Brand</label>{{ Form::hidden('card_brand', '') }}</div>
                                            <div class="form-group hidden"><label>Credit Card Last Four Digits</label>{{ Form::hidden('card_last_four', '') }}</div>
                                        </section>
                                        <!-- Step 3 End -->

                                        <!-- Step 4 -->
                                        <h3>Form Builder</h3>
                                        <section class="form-builder">
                                            {{ Form::hidden('referral_form_json', '') }}
                                        </section>
                                        <!-- Step 4 End -->

                                        <!-- Step 5 -->
                                        <h3>Reward Info</h3>
                                        <section>
                                            <div class="form-group-wrapper">
                                                <div class="form-group{{ $errors->has('reward_title') ? ' has-error' : '' }} col-md-12">
                                                    <label class="hidden">Reward Title</label>
                                                    <div class="col-md-12">
                                                        <input id="reward-title" type="text" class="form-control" name="reward_title" placeholder="Reward Title *" required>
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('send_reward') ? ' has-error' : '' }} col-md-12">
                                                    <label class="hidden">Reward Kind</label>
                                                    <div class="col-md-12">
                                                        {{ Form::select('reward_kind', ['' => 'What kind of reward will you use? *'] + \App\RewardSetting::$rewardKind, '', array('class' => 'form-control')) }}
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('send_reward') ? ' has-error' : '' }} col-md-12">
                                                    <label class="hidden">How will you send the reward?</label>
                                                    <div class="col-md-12">
                                                        {{ Form::select('reward_send', ['' => 'How will you send the reward? *'] + \App\RewardSetting::$rewardSend, '', array('class' => 'form-control')) }}
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('leader_board') ? ' has-error' : '' }} col-md-12">
                                                    <label class="hidden">Would you like to show a leaderboard</label>
                                                    <!--<div class="col-md-12">
                                                        <label> <a href="#">What's this?</a> *</label>
                                                    </div>-->
                                                    <div class="col-md-12">
                                                        {{ Form::select('leader_board', ['' => 'Would you like to show a leaderboard on your site?', '1' => 'Yes', '0' => 'No'], '', array('class' => 'form-control')) }}
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-11 reward-ratio-wrapper">
                                                    <div class="col-md-12">
                                                        <h4 class="text-center"><strong>Your Reward Ratio *</strong></h4>
                                                    </div>
                                                    <div class="col-md-12 reward-ratio">
                                                        <div class="col-md-6 col-md-offset-3">
                                                            <label class="hidden">Reward Ratio</label>
                                                            <input value="1" name="approved_referral_ratio" class="text-center">
                                                            <span class="reward-equals">=</span>
                                                            <input value="1" name="reward_referral_ratio" class="text-center">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 reward-ratio-desc">
                                                        <div class="col-md-6 col-md-offset-3">
                                                            <span>Approved Referral</span>
                                                            <span class="reward-equals-desc"></span>
                                                            <span class="reward-kind">$100 Gift Card</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 rewards-bottom">
                                                        <span>Want to use a point system? <a href="{{ route('contact') }}">Ask Us About A Custom Option</a></span>
                                                    </div>
                                                </div>

                                                <div class="clearfix"></div>
                                            </div>
                                        </section>
                                        <!-- Step 5 End -->

                                        <!-- Step 6 -->
                                        <h3>Review</h3>
                                        <section class="review-form"></section>
                                        <!-- Step 6 End -->

                                    </div>
                                </form>
                                <div class="form-generator-wrapper">
                                    <div class="form-generator">
                                        <div id="stage1" class="build-wrap"></div>
                                        <form class="render-wrap"></form>
                                    </div>
                                </div>

                                <div id="multi-step-modal">
                                @include('layouts.modal')
                                </div>
                                <div class="hidden">
                                    <div class="billing-terms-title">{{ isset($billingTerms->title) ? $billingTerms->title : 'null' }}</div>
                                    <div class="billing-terms-content">{!! isset($billingTerms->content) ? $billingTerms->content : 'null' !!}</div>
                                </div>
