@extends('layouts.app')

@section('pageTitle', 'Email Logs')

@section('content')
    <div class="container-fluid email-logs-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Email Logs', 'col' => 12])
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-members-wrapper table-wrapper">
                <table class="table table-email-logs tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Subject</th>
                            <th>Message</th>
                        </tr>
                    </thead> 
                    <tr class="tr-spacer"><td colspan=6></td></tr>
                    @foreach ($emailLogs as $emailLog)
                        <tr>
                            <td>{{ isset($emailLog->id) ? $emailLog->id : null }}</td>
                            <td>{{ isset($emailLog->created_at) ? $emailLog->created_at->format('m/d/Y') : '' }} </td>
                            <td>@if (isset($emailLog->sender) && isset($emailLog->recipient)) {{ isset($_company->email) ? $_company->email : isset($_company->company_name) ? $_company->company_name : 'none' }} @else {{ isset($emailLog->sender->email) ? $emailLog->sender->email : null }} @endif</td>
                            <td>{{ isset($emailLog->recipient->email) ? $emailLog->recipient->email : null }}</td>
                            <td>{{ isset($emailLog->subject) ? $emailLog->subject : null }}</td>
                            <td>{{ isset($emailLog->body) ? strip_tags($emailLog->body) : null }}</td>
                        </tr>
                    <tr class="tr-spacer"><td colspan=6></td></tr>
                    @endforeach
                    @if (!count($emailLogs))<tr><td colspan="6">No email found.</td></tr>@endif
                </table>
                <div class="col-md-12 pagination-wrapper">{{ $emailLogs->links() }}</div>
            </div>
        </div>

    </div>

@endsection