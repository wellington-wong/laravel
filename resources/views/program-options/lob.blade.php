@extends('layouts.app')

@section('pageTitle', 'Referral Program Settings')

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
            <div class="alert alert-success">Your API Key is correct. Do not update it unless you are sure you want to change it.</div>
        @elseif ( !is_null($l) && false == $l->verified )
            <div class="alert alert-warning">Your API Key does not check out with lob.com.  Please check and re-enter it.</div>
        @endif

        @if ( 0 === $num_bankaccounts )
            <div class="alert alert-warning">Please go to lob.com and add a bank account.</div>
        @endif

        @if ( $num_bankaccounts > 0 && $all_verified == false )
            <div class="alert alert-warning">Please go to lob.com and add <b>verify</b> your bank account.</div>
        @endif

        <form method="POST" action="{{ route('post-program-options-lob') }}" >

            {{ csrf_field() }}

            <div class="form-group" >
                <label >API Key</label>
                <input value="{{ $l->apikey or old('apikey') }}" type="text" name="apikey" class="form-control" placeholder="API Key" >
            </div>

            <button class="btn btn-primary btn-sm" type="submit" >Update</button>

        </form>

        {{-- THIS SECTION BRINGS UP INSTRUCTIONS FOR EACH TYPE OF LOB INCONSISTENCY --}}
        {{-- IF NO LOB KEY OR LOB KEY IS NOT VERIFIED --}}
        @if ( is_null($l) || false == $l->verified )
            @include('lob.getAPIKey')
        {{-- IF LOB HAS NO BANK ACCOUNTS --}}
        @elseif ( 0 === $num_bankaccounts )
            @include('lob.addBankAccount')
        {{-- IF BANK ACCOUNT HAS NOT BEEN VERIFIED --}}
        @elseif ( $num_bankaccounts > 0 && $all_verified == false )
            @include('lob.verifyBankAccount')
        @endif

    </div>

@endsection