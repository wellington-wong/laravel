@extends('layouts.app')

@section('pageTitle', 'Login as user')

@section('content')

    <div class="container-fluid members-wrapper">        

        <div class="row">
            @include('layouts.page-header', ['header' => 'Edit Basic Pages', 'col' => 3])
        </div>

        <div class="clearfix"></div>

          {{ Form::open() }}

        <div class="row">
            <div class="form-group">
            {{ Form::label('title', 'Title') }}
            {{ Form::text('title', (isset(\App\BasicPages::$pageTypes[$route]) ? \App\BasicPages::$pageTypes[$route] : old('title')), ['placeholder' => 'Title', 'class' => 'form-control']) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group">
            {{ Form::label('content', 'Content') }}
            {{ Form::textarea('content', old('content'), ['class' => 'form-control tinymce']) }}
            </div>
        </div>
          {{ Form::close() }}
    </div>
@endsection
