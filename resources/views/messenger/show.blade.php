@extends('layouts.app')

@section('pageTitle', $thread->subject)

@section('content')
    <h1>{{ $thread->subject }}</h1>
    @each('messenger.partials.messages', $thread->messages, 'message')

    @include('messenger.partials.form-message')
@stop
