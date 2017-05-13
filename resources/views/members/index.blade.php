@extends('layouts.app')

@section('content')
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
            </tr>
        </thead>
            @foreach ($members as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td></td>
            </tr>
            @endforeach
    </table>

@endsection