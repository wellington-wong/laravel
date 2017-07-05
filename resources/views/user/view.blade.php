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
            <div class="col-md-12 no-padding-lr">   

                <div class="row">           
                    <div class="form-group col-md-6">
                        <label>Name</label>
                        <div class="form-control">{{ $user->name }}</div>
                    </div>    

                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <div class="form-control">{{ $user->email }}</div>
                    </div>
                </div>    

                <div class="row">           
                    <div class="form-group col-md-6">
                        <label>Phone</label>
                        <div class="form-control">{{ isset($user->phones()->first()->phone) ? $user->phones()->first()->phone : '' }}</div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Address</label>
                        <div class="form-control">{{ isset($user->addresses()->first()->address) ? $user->addresses()->first()->address : '' }}</div>
                    </div>
                </div>    

            </div>

        </div>

    </div>

@endsection