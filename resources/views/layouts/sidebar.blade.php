
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
                                        <i class="fa fa-address-book" aria-hidden="true"></i><a href="{{ route('referrals') }}">Referrals</a>
                                        <ul>
                                            <li><i class="fa fa-user-plus" aria-hidden="true"></i><a href="{{ route('referral-create') }}">Add Referral</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <i class="fa fa-users" aria-hidden="true"></i><a href="#">Members</a>
                                    </li>
                                    <li>
                                        <i class="fa fa-sliders" aria-hidden="true"></i><a href="#">Program Options</a>
                                        <ul>
                                            <li><i class="fa fa-building" aria-hidden="true"></i><a href="#">Company Profile</a></li>                                            
                                            <li><i class="fa fa-pencil" aria-hidden="true"></i><a href="{{ route('company-create') }}">Create Company</a></li>
                                            <li><i class="fa fa-user-circle" aria-hidden="true"></i><a href="#">Users</a></li>
                                            <li><i class="fa fa-wrench" aria-hidden="true"></i><a href="#">Referral Program Settings</a></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i><a href="#">Reward Settings</a></li>
                                            <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="#">Notification Emails</a></li>
                                        </ul>
                                    </li>
                                    @role(['admin', 'superAdmin', 'globalAdmin'])<li>
                                        <i class="fa fa-cog" aria-hidden="true"></i><a href="#">Global Settings</a>
                                        <ul>
                                            @can('submit-member-referral')<li><i class="fa fa-address-book" aria-hidden="true"></i><a href="{{ route('submit-referral-member') }}">Submit Referrals on Behalf of Member</a></li>@endcan
                                            @can('edit-member-information')<li><i class="fa fa-pencil-square" aria-hidden="true"></i><a href="{{ route('edit-member-information') }}">Edit Member Information</a></li>@endcan
                                            @can('export-member-information')<li><i class="fa fa-share-square" aria-hidden="true"></i><a href="{{ route('export-member-information') }}">Export Member Information</a></li>@endcan
                                            @can('change-referral-statuses')<li><i class="fa fa-random" aria-hidden="true"></i><a href="{{ route('change-referral-status') }}">Change Referral Status</a></li>@endcan
                                            @can('add-delete-admin')<li><i class="fa fa-id-card" aria-hidden="true"></i><a href="{{ route('add-delete-admin') }}">Add/Delete Admin</a></li>@endcan
                                            @can('define-user-roles')<li><i class="fa fa-sitemap" aria-hidden="true"></i><a href="{{ route('define-user-roles') }}">Define User Roles</a></li>@endcan
                                            @can('add-change-billing-information')<li><i class="fa fa-file-text" aria-hidden="true"></i><a href="{{ route('add-change-billing-information') }}">Add/Change Billing Information</a></li>@endcan
                                            @can('login-super-admin-all-accounts')<li><i class="fa fa-universal-access" aria-hidden="true"></i><a href="{{ route('login-super-admin') }}">Login as Super Admin</a></li>@endcan
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
