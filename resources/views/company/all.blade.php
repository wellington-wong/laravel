@extends('layouts.app')

@section('content')

    @foreach( $companies as $c )
        {{-- @todo SUBDOMAIN ROUTING :( --}}
        <div><a href="//{{ $c->subdomain }}.{{ config('app.domain') }}/referral/create">{{ $c->company_name }}</a></div>
    @endforeach

@endsection