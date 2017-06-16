@extends('layouts.app')

@section('pageTitle', 'Referral Program Setings')

@section('content')
    <div class="container-fluid email-logs-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Referral Program Setings', 'col' => 12])
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-members-wrapper table-wrapper">
                <table class="table table-email-logs tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead> 
                    @foreach ($emailLogs as $emailLog)
                        <tr>
                        </tr>
                    @endforeach
                    @if (!count($emailLogs))<tr><td colspan="5">No members found.</td></tr>@endif
                </table>
                <div class="col-md-12 pagination-wrapper">{{ $emailLogs->links() }}</div>
            </div>
        </div>

    </div>

@endsection