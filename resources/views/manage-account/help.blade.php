@extends('layouts.app')

@section('pageTitle', 'Help')

@section('content')
    <div class="container-fluid help-wrapper">
        <div class="row">
           	@include('layouts.page-header', ['header' => 'Help', 'col' => 12])
   		</div>
        <div class="row">
          <div class="col-md-12 no-padding-lr">
                      
            Need help?
            If you have any unanswered questions about the All Year Cooling Customer Referral Program, here are some Frequently Asked Questions:
            How do I submit referral information to All Year Cooling?
            After you have logged into your Cool Cash Rewards account, submit your referrals name and address in the form located in the tab ‘Submit a Referral’. If you prefer to talk to one of our All Year Cooling team members on the phone, simply call us at (888) 576-5692.
            What happens after I refer a customer to All Year Cooling?
            Once you’ve filled out the online form or spoken to a representative on the phone, you will receive an email notifying you that we have successfully received your referral. Once the installation is complete, our team members will finish verifying your referral and you will receive an email if the referral has been approved or denied. After our team has verified the status as complete, your $100 Cash Gift Card will come in the mail within 4-8 weeks.
            How many referrals can I make?
            There is no limit to the number of referrals you can make through the program.
            Can current customers get referred?
            No, the customer that you refer must be a brand-new customer to All Year Cooling in order to receive your referral reward. In addition, the referral must schedule an install date within a two-month time frame. Air conditioning repairs do not apply to this offer.
            When will I receive the Cash Reward?
            The Cash Gift Card Reward will be processed once your referral’s installation is completed and verified. After it’s been verified it usually takes between 4-8 weeks in the mail. 
            If you have any other questions, call us at (888) 576-5692 or email referral@allyearac.com

          </div>
		</div>
    </div>

@endsection