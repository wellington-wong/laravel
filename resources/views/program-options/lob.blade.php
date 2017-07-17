@extends('layouts.app')

@section('pageTitle', 'Referral Program Setings')

@section('content')
    <div class="container-fluid referral-program-settings-wrapper">
        <div class="row">
            @include('layouts.page-header', ['header' => 'Lob API Key', 'col' => 12])
        </div>

        <div class="clearfix"></div>


        @if ( ! $errors->isEmpty())
            <div class="alert alert-warning">{{ $errors->first() }}</div>
        @endif

        @if ( !is_null($l) && true == $l->verified )
            <div class="alert alert-success">Your information is already correct. Do not update it unless you are sure you want to change it.</div>
        @endif

        <form method="POST" action="{{ route('post-program-options-lob') }}" >

            {{ csrf_field() }}

            <div class="form-group" >
                <label >API Key</label>
                <input value="{{ $l->apikey or old('apikey') }}" type="text" name="apikey" class="form-control" placeholder="API Key" >
            </div>

            <button class="btn btn-primary btn-sm" type="submit" >Update</button>

        </form>


    </div>

@endsection