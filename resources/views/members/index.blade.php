@extends('layouts.app')

@section('content')
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
            @foreach ($members as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td class="view-details"><button class="btn btn-default btn-details">view details</button></td>
            </tr>
            @endforeach
    </table>

@endsection