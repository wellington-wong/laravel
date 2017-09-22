@extends('layouts.app')

@section('pageTitle', isset($page->title) ? $page->title : null)

@section('content')
    {!!  isset($page->content) ? $page->content : 'No content found, please add content <a href="'. route('edit-basic-page', 'help') .'">here</a>.' !!}
@endsection