
            <nav class="fill">
                <button type="button" class="navbar-toggle collapsed sidebar-menu" data-toggle="collapse" data-target="#app-sidebar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="panel panel-default fill">
                    <div class="panel-heading"><a class="logo" href="{!! url('/') !!}"></a></div>
                    <div id="app-sidebar-collapse" class=" collapse navbar-collapse">
                        <div class="panel-body">
                            <!-- 
                            <div class="menu-item">
                                <a href="{{ route('company-create') }}">Create Company</a>
                            </div>
                            <div>Referrals</div>
                            <div class="menu-item">
                                <a href="{{ route('referral-create') }}" >Submit a Referral</a>
                            </div>
                            <div class="menu-item">
                                <a href="{{ route('referrals') }}" >Referral History</a>
                            </div>
                            --> 
                            <nav>
                                <ul class="nav">
                                    <li>
                                        <a href="{{ route('referrals') }}">Referrals</a>
                                        <ul>
                                            <li><a href="{{ route('referral-create') }}">Add Referral</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Members</a></li>
                                    <li>
                                        <a href="#">Pogram Options</a>
                                        <ul>
                                            <li><a href="#">Company Profile</a></li>
                                            <li><a href="#">Users</a></li>
                                            <li><a href="#">Referral Program Settings</a></li>
                                            <li><a href="#">Reward Settings</a></li>
                                            <li><a href="#">Notification Emails</a></li>
                                        </ul>
                                    </li>
                                    <li>                                        
                                        <a href="{{ route('company-create') }}">Create Company</a>
                                    </li>
                                    <li>                                        
                                        <a href="#">Global Settings</a>
                                        <ul>
                                            <li><a href="#">Submit Referrals In Behalf Of Member</a></li>
                                            <li><a href="#">Edit Member Information</a></li>
                                            <li><a href="#">Export Member Information</a></li>
                                            <li><a href="#">Change Referral Statuses</a></li>
                                            <li><a href="#">Add/Delete Admin</a></li>
                                            <li><a href="#">Define User Roles</a></li>
                                            <li><a href="#">Add/Change Billing Information</a></li>
                                            <li><a href="#">Login As Super Admin</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>

                        </div>

                        <div class="panel-footer">
                                <div class="menu-separator"></div>

                                <div class="menu-item">
                                    <a href="{{ route('referral-create') }}" >Account Settings</a>
                                </div>
                                <div class="menu-item">
                                    <a href="{{ route('referral-create') }}" >Need Help?</a>
                                </div>                
                        </div>         
                    </div>
                </div>
            </nav>
