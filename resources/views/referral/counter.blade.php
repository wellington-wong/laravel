
        <div class="row">
            <div class="col-md-4 referral-hub">
                <div class="pending-approval">
                    <div class="rh-count">
                        <span><a href="{{ route('referral-history') }}" >
                            {{ isset($pendingReferrals['approval']) ? count($pendingReferrals['approval']) : 0 }}
                        </a></span>
                    </div><hr />
                    <div class="rh-desc">
                        <span>Referrals Pending Approval</span>
                        <i class="fa fa-question-circle-o tooltip-q" aria-hidden="true" data-toggle="tooltip" title="Lorem ipsum dolor sit amet, mea audiam philosophia ne, ex tamquam inimicus eos. Labore contentiones quo ne, quo epicuri voluptua ei"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 referral-hub">
                <div class="pending-reward">
                    <div class="rh-count">
                        <span><a href="{{ route('referral-history') }}" >
                            {{ isset($pendingReferrals['reward']) ? count($pendingReferrals['reward']) : 0 }}
                        </a></span>
                    </div><hr />
                    <div class="rh-desc">
                        <span>Referrals Pending Reward</span>
                        <i class="fa fa-question-circle-o tooltip-q" aria-hidden="true" data-toggle="tooltip" title="Lorem ipsum dolor sit amet, mea audiam philosophia ne, ex tamquam inimicus eos. Labore contentiones quo ne, quo epicuri voluptua ei"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 referral-hub">
                <div class="member-message">
                    <div class="rh-count">
                        <span><a href="{{ route('messages') }}">
                            {{ count(Session::get('messages')) }}
                        </a></span>
                    </div><hr />
                    <div class="rh-desc">
                        <span>Member {{ count(Session::get('messages')) > 1 ? ' Messages' : ' Message' }}</span>
                        <i class="fa fa-question-circle-o tooltip-q" aria-hidden="true" data-toggle="tooltip" title="Lorem ipsum dolor sit amet, mea audiam philosophia ne, ex tamquam inimicus eos. Labore contentiones quo ne, quo epicuri voluptua ei"></i>
                    </div>
                </div>
            </div>
        </div>