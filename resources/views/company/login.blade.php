@section('pageTitle', $_company->company_name . ' Referral Program')

@section('content')

    <div class="container-fluid company-login-wrapper">

        <div class="row">
        @include('layouts.page-header', ['header' => ucwords($_company->company_name) . ' Referral Program', 'col' => 12])
        </div>

        <div class="row">
        </div>
    </div>
@endsection