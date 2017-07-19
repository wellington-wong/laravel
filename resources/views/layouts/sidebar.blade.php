
            <nav>
                <button type="button" class="navbar-toggle collapsed sidebar-menu" data-toggle="collapse" data-target="#app-sidebar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="panel panel-default fill">
                    <div class="panel-heading"><a class="logo" style="background-image: url('/{{ isset($_company->logo) ? $_company->logo : 'images/logo.png' }}')" href="{!! url('/') !!}"></a></div>
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

                            {{-- SHOW ALL THE CURRENT USER'S ADMINISTRATIVE COMPANIES (SUBDOMAINS) --}}
                            @if ( auth()->user()->getRoleCompanies(['admin', 'superadmin'])->count() > 1 ||
                                (0 == config('company_id') && auth()->user()->getRoleCompanies(['admin', 'superadmin'])->count() > 0 ) )
                                <ul class="nav">
                                    <li>
                                        <div class="main-menu-item-wrapper">
                                            <a href="#administer-companies" data-toggle="collapse" class="menu-marker">I Administer These Companies:</a>
                                        </div>
                                        <ul id="administer-companies" class="collapse in">
                                            @foreach( auth()->user()->getRoleCompanies(['admin', 'superadmin']) as $c )
                                                {{-- ONLY DISPLAY A LINK TO ANOTHER SUBDOMAIN IF IT IS NOT THIS DOMAIN --}}
                                                @if( $c->subdomain != $_company->subdomain )
                                                    <li><a href="//{{ $c->subdomain }}.{{ config('app.domain') }}">{{ $c->company_name }}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            @endif

                            {{-- IF THE USER IS AT THE app.perxi.com PAGE SHOW THE USER'S MEMBER ACCOUNTS --}}
                            @if ( auth()->user()->getRoleCompanies(['member'])->count() > 1 || 0 == config('company_id') )
                                <ul class="nav">
                                    <li>
                                        <div class="main-menu-item-wrapper">
                                            <a href="#companies" data-toggle="collapse" class="menu-marker">Companies</a>
                                        </div>
                                        <ul id="administer-companies" class="collapse in">
                                        @foreach( auth()->user()->getRoleCompanies(['member']) as $c )
                                            {{-- ONLY DISPLAY A LINK TO ANOTHER SUBDOMAIN IF IT IS NOT THIS DOMAIN --}}
                                            @if( $c->subdomain != $_company->subdomain )
                                                <li><a href="//{{ $c->subdomain }}.{{ config('app.domain') }}">{{ $c->company_name }}</a></li>
                                            @endif
                                        @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            @endif

                            @if (0 == config('company_id'))
                            <ul class="nav" >
                                <div class="main-menu-item-wrapper">
                                <li class="{{ Request::is('company/create') ? 'active' : '' }}"><a href="{{ route('company-create') }}">Create Company</a></li>
                                    </div>
                            </ul>
                            @endif


                            @if (0 != config('company_id'))
                                <ul class="nav">
                                    <li class="{{ Request::path() == 'referrals' ? 'active' : '' }}">
                                        <div class="main-menu-item-wrapper">
                                            <a href="{{ route('referrals') }}">My Referrals</a>
                                            <a href="#submenu-referrals" data-toggle="collapse" class="pull-right menu-marker"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                        </div>
                                        <ul id="submenu-referrals" class="collapse in">
                                            <li class="{{ Request::path() == 'referral-create' ? 'active' : '' }}"><a href="{{ route('referral-create') }}">Submit a Referral</a></li>
                                         </ul>
                                    </li>
                                    @role(['member'])
                                    <li class="{{ Request::path() == 'referral-create' ? 'active' : '' }}">
                                        <div class="main-menu-item-wrapper">
                                            <a href="{{ route('referral-rewards') }}">Rewards</a>
                                        </div>
                                    </li>
                                    <li class="{{ Request::path() == 'referral-create' ? 'active' : '' }}">
                                        <div class="main-menu-item-wrapper">
                                            <a href="{{ route('how-this-works') }}">How This Works</a>
                                        </div>
                                    </li>
                                    <li class="{{ Request::path() == 'referral-create' ? 'active' : '' }}">
                                        <div class="main-menu-item-wrapper">
                                            <a href="{{ route('how-to-get-more-referrals') }}">How to Get More Referrals</a>
                                        </div>
                                    </li>
                                    @endrole
                                    @role(['admin', 'superAdmin', 'globalAdmin'])
                                    <li>
                                        <div class="main-menu-item-wrapper">
                                            <a href="{{ route('program-options') }}">Program Options</a>
                                            <a href="#program-options" data-toggle="collapse" class="pull-right menu-marker"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                        </div>
                                        <ul id="program-options" class="collapse in">
                                            <li class="{{ Request::is('company/referrals') ? 'active' : '' }}"><a href="{{ route('company-referrals') }}">Company Referrals</a></li>
                                            <li class="{{ (Request::is('company/*') && !Request::is('company/create') && !Request::is('company/referrals')) ? 'active' : '' }}"><a href="{{ route('get-company', $_company->id ) }}">Company Profile</a></li>
                                            <li class="{{ Request::is('members') ? 'active' : '' }}"><a href="{{ route('members') }}">Users</a></li>
                                            <li class="{{ Request::is('program-options/referral-program-settings') ? 'active' : '' }}"><a href="{{ route('program-options-referral-program-settings') }}">Referral Program Settings</a></li>
                                            <li class="{{ Request::is('program-options/reward-settings') ? 'active' : '' }}"><a href="{{ route('program-options-reward-settings') }}">Reward Settings</a></li>
                                            <li class="{{ Request::is('program-options/notification-emails') ? 'active' : '' }}"><a href="{{ route('program-options-notification-emails') }}">Notification Emails</a></li>
                                            <li class="{{ Request::is('program-options/email-logs') ? 'active' : '' }}"><a href="{{ route('program-options-email-logs') }}">Email Logs</a></li>
                                            <li class="{{ Request::is('program-options/lob') ? 'active' : '' }}"><a href="{{ route('program-options-lob') }}">Bank Account</a></li>
                                        </ul>
                                    </li>
                                    @endrole
                                </ul>
                            @endif

                            @if (auth()->user()->hasRole(['globalAdmin']) || Session::get('currentUserId'))
                            <ul class="nav" >
                                <li class="">
                                    <div class="main-menu-item-wrapper">
                                        <a href="#global-settings" data-toggle="collapse" class="menu-marker">Global Settings</a>
                                        <a href="#global-settings" data-toggle="collapse" class="pull-right menu-marker"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                    </div>
                                    <ul id="global-settings" class="collapse in">
                                        @can('submit-member-referral')<li class="hidden {{ Request::is('global-settings/submit-referral-member') ? 'active' : '' }}"><a href="{{ route('submit-referral-member') }}">Submit Referrals on Behalf of Member</a></li>@endcan
                                        @can('edit-member-information')<li class="hidden {{ Request::is('global-settings/edit-member-information') ? 'active' : '' }}"><a href="{{ route('edit-member-information') }}">Edit Member Information</a></li>@endcan
                                        @can('export-member-information')<li class="hidden {{ Request::is('global-settings/export-member-information') ? 'active' : '' }}"><a href="{{ route('export-member-information') }}">Export Member Information</a></li>@endcan
                                        @can('add-delete-admin')<li class="hidden {{ Request::is('global-settings/add-delete-admin') ? 'active' : '' }}"><a href="{{ route('add-delete-admin') }}">Add/Delete Admin</a></li>@endcan
                                        @can('define-user-roles')<li class="hidden {{ Request::is('global-settings/define-user-roles') ? 'active' : '' }}"><a href="{{ route('define-user-roles') }}">Define User Roles</a></li>@endcan
                                        @can('login-super-admin-all-accounts')<li class="hidden {{ Request::is('global-settings/login-super-admin') ? 'active' : '' }}"><a href="{{ route('login-super-admin') }}">Login as Super Admin</a></li>@endcan
                                        @can('login-as-user') @if (!Session::get('currentUserId'))<li class="{{ Request::is('global-settings/login-as-user') ? 'active' : '' }}"><a href="{{ route('login-as-user') }}">Login as User</a></li>@endif @endcan                                        
                                        @if (Session::get('currentUserId')) 
                                            <li class="{{ Request::is('login-as-origin') ? 'active' : '' }}"><a href="{{ route('login-as-origin') }}">Login as original</a></li>      
                                        @endif 
                                    </ul>
                                </li>
                            </ul>
                            @endif


                        </div>

                        <div class="panel-footer">
                                <div class="menu-separator"></div>

                                <div class="menu-item">
                                    <a href="{{ route('manage-account') }}" >Account Settings</a>
                                </div>
                                <div class="menu-item">
                                    <a href="{{ route('help') }}" >Need Help?</a>
                                </div>                
                        </div>         
                    </div>
                </div>
            </nav>
