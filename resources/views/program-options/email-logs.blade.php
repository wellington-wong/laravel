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
                            <td>{{ $emailLog->id }}</td>
                            <td>{{ isset($emailLog->created_at) ? $emailLog->created_at->format('m/d/Y') : '' }} </td>
                            <td>{{ $emailLog->sender->email }} </td>
                            <td>{{ $emailLog->recipient->email }}</td>
                            <td>{{ $emailLog->subject }}</td>
                            <td>{{ strip_tags($emailLog->body) }}</td>
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