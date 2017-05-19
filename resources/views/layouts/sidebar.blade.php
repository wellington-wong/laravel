
            <nav>
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
                                @role(['admin', 'superAdmin', 'globalAdmin'])             
                                <ul class="nav">
                                    <li>
                                        <div class="main-menu-item-wrapper">
                                            <a href="{{ route('referrals') }}">Referrals</a>
                                            <a href="#submenu-referrals" data-toggle="collapse" class="pull-right menu-marker"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                        </div>
                                        <ul id="submenu-referrals" class="collapse in">
                                            <li><a href="{{ route('referral-create') }}">Add Referral</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <div class="main-menu-item-wrapper">
                                            <a href="{{ route('members') }}">Members</a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="main-menu-item-wrapper">
                                            <a href="#program-options" data-toggle="collapse" class="menu-marker">Program Options</a>
                                            <a href="#program-options" data-toggle="collapse" class="pull-right menu-marker"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                        </div>
                                        <ul id="program-options" class="collapse in">
                                            @if( isset(auth()->user()->companies[0]->id) )<li><a href="/company/{{ auth()->user()->companies[0]->id }}">Company Profile</a></li>
                                            @else<li><a href="{{ route('company-create') }}">Create Company</a></li>@endif
                                            <li><a href="{{ route('program-options-users') }}">Users</a></li>
                                            <li><a href="{{ route('program-options-referral-program') }}">Referral Program Settings</a></li>
                                            <li><a href="{{ route('program-options-reward-settings') }}">Reward Settings</a></li>
                                            <li><a href="{{ route('program-options-notification-settings') }}">Notification Settings</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <div class="main-menu-item-wrapper">
                                            <a href="#">Global Settings</a>
                                            <a href="#global-settings" data-toggle="collapse" class="pull-right menu-marker"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                        </div>
                                        <ul id="global-settings" class="collapse in">
                                            @can('submit-member-referral')<li><a href="{{ route('submit-referral-member') }}">Submit Referrals on Behalf of Member</a></li>@endcan
                                            @can('edit-member-information')<li><a href="{{ route('edit-member-information') }}">Edit Member Information</a></li>@endcan
                                            @can('export-member-information')<li><a href="{{ route('export-member-information') }}">Export Member Information</a></li>@endcan                                            
                                            @can('add-delete-admin')<li><a href="{{ route('add-delete-admin') }}">Add/Delete Admin</a></li>@endcan
                                            @can('define-user-roles')<li><a href="{{ route('define-user-roles') }}">Define User Roles</a></li>@endcan
                                            @can('login-super-admin-all-accounts')<li><a href="{{ route('login-super-admin') }}">Login as Super Admin</a></li>@endcan
                                        </ul>
                                    </li>
                                </ul>
                                @endrole
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
