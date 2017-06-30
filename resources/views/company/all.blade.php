@extends('layouts.app')

@section('pageTitle', 'All Companies')

@section('content')

    @foreach( $companies as $c )
        {{-- @todo SUBDOMAIN ROUTING :( --}}
        <div><a href="//{{ $c->subdomain }}.{{ config('app.domain') }}/referral/create">{{ $c->company_name }}</a></div>
    @endforeach

@endsection