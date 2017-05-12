
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
                                        <a href="{{ route('referrals') }}"><i class="fa fa-address-book" aria-hidden="true"></i>&nbsp; Referrals</a>
                                        <ul>
                                            <li>
                                                <a href="{{ route('referral-create') }}"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp; Add Referral</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-users" aria-hidden="true"></i>&nbsp; Members</a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-sliders" aria-hidden="true"></i>&nbsp; Program Options</a>
                                        <ul>
                                            <li>
                                                <a href="#"><i class="fa fa-building" aria-hidden="true"></i>&nbsp; Company Profile</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp; Users</a>
                                            </li>
                                            <li><a href="#"><i class="fa fa-wrench" aria-hidden="true"></i>&nbsp; Referral Program Settings</a></li>
                                            <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i>&nbsp; Reward Settings</a></li>
                                            <li><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; Notification Emails</a></li>
                                        </ul>
                                    </li>
                                    <li>                                        
                                        <a href="{{ route('company-create') }}"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Create Company</a>
                                    </li>
                                    @role(['admin', 'superAdmin', 'globalAdmin'])<li>
                                        <a href="#"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp; Global Settings</a>
                                        <ul>
                                            @can('submit-member-referral')<li><a href="{{ route('submit-referral-member') }}"><i class="fa fa-address-book" aria-hidden="true"></i>&nbsp; Submit Referrals on Behalf of Member</a></li>@endcan
                                            @can('edit-member-information')<li><a href="{{ route('edit-member-information') }}"><i class="fa fa-pencil-square" aria-hidden="true"></i>&nbsp; Edit Member Information</a></li>@endcan
                                            @can('export-member-information')<li><a href="{{ route('export-member-information') }}"><i class="fa fa-share-square" aria-hidden="true"></i>&nbsp; Export Member Information</a></li>@endcan
                                            @can('change-referral-statuses')<li><a href="{{ route('change-referral-status') }}"><i class="fa fa-random" aria-hidden="true"></i>&nbsp; Change Referral Status</a></li>@endcan
                                            @can('add-delete-admin')<li><a href="{{ route('add-delete-admin') }}"><i class="fa fa-id-card" aria-hidden="true"></i>&nbsp; Add/Delete Admin</a></li>@endcan
                                            @can('define-user-roles')<li><a href="{{ route('define-user-roles') }}"><i class="fa fa-sitemap" aria-hidden="true"></i>&nbsp; Define User Roles</a></li>@endcan
                                            @can('add-change-billing-information')<li><a href="{{ route('add-change-billing-information') }}"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp; Add/Change Billing Information</a></li>@endcan
                                            @can('login-super-admin-all-accounts')<li><a href="{{ route('login-super-admin') }}"><i class="fa fa-universal-access" aria-hidden="true"></i>&nbsp; Login as Super Admin</a></li>@endcan
                                        </ul>
                                    @endrole</li>
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
