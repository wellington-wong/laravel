@extends('layouts.app')

@section('content')

    <table>
        <thead><tr>
            <th>Name</th>
            <th>Status</th>
        </tr></thead>
        @foreach($referrals as $r)
            <tr>
                <td>{{ $r->referred->display_name }}</td>
                <td>{{ \App\Referral::$status[$r->status] }}</td>
            </tr>
        @endforeach
    </table>


@endsection