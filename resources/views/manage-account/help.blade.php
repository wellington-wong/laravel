@extends('layouts.app')

@section('pageTitle', 'Help')

@section('content')
    <div class="container-fluid help-wrapper">
        <div class="row">
           	@include('layouts.page-header', ['header' => 'Need Help?', 'col' => 12])
   		</div>
        <div class="row">
          <div class="col-md-12 no-padding-lr">
            <p>
              If you have any unanswered questions about the All Year Cooling Customer Referral Program, here are some<br /><strong><em>Frequently Asked Questions</em></strong>:
            </p>

            <p><label>How do I submit referral information to All Year Cooling?</label></p>            
            <p>After you have logged into your Cool Cash Rewards account, submit your referrals name and address in the form located in the tab ‘Submit a Referral’. If you prefer to talk to one of our All Year Cooling team members on the phone, simply call us at (888) 576-5692.</p>
            
            <p><label>What happens after I refer a customer to All Year Cooling?</label></p>
            <p>Once you’ve filled out the online form or spoken to a representative on the phone, you will receive an email notifying you that we have successfully received your referral. Once the installation is complete, our team members will finish verifying your referral and you will receive an email if the referral has been approved or denied. After our team has verified the status as complete, your $100 Cash Gift Card will come in the mail within 4-8 weeks.</p>
            
            <p><label>How many referrals can I make?</label></p>
            <p>There is no limit to the number of referrals you can make through the program.</p>
            
            <p><label>Can current customers get referred?</label></p>
            <p>No, the customer that you refer must be a brand-new customer to All Year Cooling in order to receive your referral reward. In addition, the referral must schedule an install date within a two-month time frame. Air conditioning repairs do not apply to this offer.</p>
            
            <p><label>When will I receive the Cash Reward?</label></p>
            <p>The Cash Gift Card Reward will be processed once your referral’s installation is completed and verified. After it’s been verified it usually takes between 4-8 weeks in the mail. </p>
            
            <p><strong><em>If you have any other questions, call us at <a href="tel:1-888-576-5692">(888) 576-5692</a> or email <a href="mailto:referral@allyearac.com">referral@allyearac.com</a></em></strong></p>

          </div>
		</div>
    </div>

@endsection