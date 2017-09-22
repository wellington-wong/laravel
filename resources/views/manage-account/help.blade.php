@extends('layouts.app')

@section('pageTitle', isset($page->title) ? $page->title : null)

@section('content')
    {!!  isset($page->content) ? $page->content : null !!}
@endsection