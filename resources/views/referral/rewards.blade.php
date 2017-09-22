@extends('layouts.app')

@section('pageTitle', isset($page->title) ? $page->title : null)

@section('content')
    <div class="row">
        {!!  isset($page->content) ? $page->content : 'Content unavailable.' !!}
    </div>
@endsection