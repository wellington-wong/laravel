@extends('layouts.app')

@section('pageTitle', 'User View')

@section('content')
    <div class="container-fluid user-wrapper">
   
        <div class="row">
        @include('layouts.page-header', ['header' => $user->name , 'col' => 6])
            <div class="profile-preview text-center col-md-6">
                <img class="img-responsive center-block" height="100" src="{{ isset($user->profile_image) ? '/' . $user->profile_image : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' }}">
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">     

             @if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin']))
            <div class="col-md-12 no-padding-lr">   
                {{ Form::open(['route' => ['update-user', $user->id], 'enctype' => 'multipart/form-data', 'id' => 'update-user-form', 'class' => 'update-form']) }}
                <div class="row">           
                    <div class="form-group col-md-12">
                        <label>Name</label>
                        <input class="form-control" name="name" value="{{ $user->getName() }}">
                    </div>        
                    <!--<div class="form-group col-md-6">
                        <label>Last Name</label>
                        <input class="form-control" name="last_name" value="{{ $user->last_name }}">
                    </div>-->  
                </div>    

                <div class="row">           
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input class="form-control" readonly value="{{ $user->email }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Phone</label>
                        <input class="form-control" name="phone" value="{{ isset($user->phones()->first()->phone) ? $user->phones()->first()->phone : '' }}">
                    </div>
                </div>

                <div class="row">      
                    <div class="form-group col-md-6">
                        <label>Address</label>
                        <input class="form-control" name="address" value="{{ isset($user->addresses()->first()->address) ? $user->addresses()->first()->address : '' }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Line 2</label>
                        <input class="form-control" name="address2" value="{{ isset($user->addresses()->first()->address2) ? $user->addresses()->first()->address2 : '' }}">
                    </div>
                </div>    

                <div class="row">      
                    <div class="form-group col-md-4">
                        <label>City</label>
                        <input class="form-control" name="city" value="{{ isset($user->addresses()->first()->city) ? $user->addresses()->first()->city : '' }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label>State</label>
                        @include('forms.states', ['state' => isset($user->addresses()->first()->state) ? $user->addresses()->first()->state : 'fl'])                        
                    </div>
                    <div class="form-group col-md-6">
                        <label>Zip</label>
                        <input class="form-control" name="zip" maxlength="5" value="{{ isset($user->addresses()->first()->zip) ? strtoupper($user->addresses()->first()->zip) : '' }}">
                    </div>
                </div>    

                <div class="form-group col-md-12 text-right no-padding-lr">
                    {{ Form::submit('Update', ['class' => 'btn btn-primary button-responsive-100 submit-profile']) }}
                </div>
                {{ Form::close() }}
            </div>
            @else
     
            <div class="col-md-12 no-padding-lr">   

                <div class="row">           
                    <div class="form-group col-md-12">
                        <label>Name</label>
                        <div class="form-control">{{ $user->getName() }}</div>
                    </div>        
                    <!--<div class="form-group col-md-6">
                        <label>Last Name</label>
                        <div class="form-control">{{ $user->last_name }}</div>
                    </div>-->
                </div>    

                <div class="row">           
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <div class="form-control">{{ $user->email }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Phone</label>
                        <div class="form-control">{{ isset($user->phones()->first()->phone) ? $user->phones()->first()->phone : '' }}</div>
                    </div>
                </div>

                <div class="row">      
                    <div class="form-group col-md-6">
                        <label>Address</label>
                        <div class="form-control">{{ isset($user->addresses()->first()->address) ? $user->addresses()->first()->address : '' }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Line 2</label>
                        <div class="form-control">{{ isset($user->addresses()->first()->address2) ? $user->addresses()->first()->address2 : '' }}</div>
                    </div>
                </div>    

                <div class="row">      
                    <div class="form-group col-md-4">
                        <label>City</label>
                        <div class="form-control">{{ isset($user->addresses()->first()->city) ? $user->addresses()->first()->city : '' }}</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label>State</label>
                        <div class="form-control">{{ isset($user->addresses()->first()->state) ? strtoupper($user->addresses()->first()->state) : '' }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Zip</label>
                        <div class="form-control">{{ isset($user->addresses()->first()->zip) ? strtoupper($user->addresses()->first()->zip) : '' }}</div>
                    </div>
                </div>    

            </div>

            @endif

        </div>
   
        <div class="row">
        @include('layouts.page-header', ['header' => 'Referrals' , 'col' => 6])
        </div>

        @include('referral.partials.referral-table', ['viewOnly' => true, 'route' => 'view-user', 'args' => $user->id])

    </div>

@endsection