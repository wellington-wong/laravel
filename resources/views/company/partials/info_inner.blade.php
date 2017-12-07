<div class="company-logo">
    <img alt="{{ isset($_company->company_name) ? $_company->company_name : '' }}" src="/{{ isset($_company->logo) ? $_company->logo : 'images/company-placeholder.png' }}" class="img-responsive col-xs-10 col-xs-offset-1">
    @role(['admin', 'superAdmin', 'globalAdmin'])
    <div class="logo-pencil ajax-logo"><i class="fa fa-pencil"></i></div>
    {{ Form::open(['route' => ['post-company-update-logo', (isset($_company->id) ? $_company->id : '')], 'id' => 'company-update-logo', 'enctype' => 'multipart/form-data']) }}
    {{ Form::file('update-logo', ['class' => 'hidden logo-input']) }}
    {{ Form::close() }}
    <div class="hidden processing">Processing...</div>
    @endrole
</div>
<div class="clearfix"></div>
<div class="company-info-name">{{ isset($_company->company_name) ? $_company->company_name : '' }}</div>
<div class="membership-role">
    <h4><strong>Membership Role</strong></h4>
    <span>{{ isset($user->roles()->orderBy('role_id', 'DESC')->first()->display_name) ? $user->roles()->orderBy('role_id', 'DESC')->first()->display_name : '' }}</span>
</div>
<div class="program-url">
    <h5>Program URL</h5>
    <span><a href="{{ $shareUrl }}">{{ $shareUrl }}</a></span>
</div>