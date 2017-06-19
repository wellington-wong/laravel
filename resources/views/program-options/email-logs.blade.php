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
                            <th>From</th>
                            <th>To</th>
                            <th>Subject</th>
                            <th>Message</th>
                        </tr>
                    </thead> 
                    @foreach ($emailLogs as $emailLog)
                        @foreach ($emailLog->messages as $message)
                        <tr>
                            <td>{{ $message->id }}</td>
                            <td>{{ $message->user->name }} </td>
                            <td></td>
                            <td>{{ $emailLog->subject }}</td>
                            <td>{!! $message->body !!}</td>
                        </tr>
                        @endforeach
                    @endforeach
                    @if (!count($emailLogs))<tr><td colspan="5">No email found.</td></tr>@endif
                </table>
                <div class="col-md-12 pagination-wrapper">{{ $emailLogs->links() }}</div>
            </div>
        </div>

    </div>

@endsection