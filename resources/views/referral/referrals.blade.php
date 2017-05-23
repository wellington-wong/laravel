@extends('layouts.app')

@section('pageTitle', 'Referrals')

@section('content')

    <div class="container-fluid">

        @include('layouts.page-header', ['header' => 'Your Submitted Referrals'])

        <div class="row bulk-action">
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-addon">Status</div>
                    <select name="status" class="form-control">
                        <option value="export">Pending Verification</option>
                        <option value="export">Pending Reward</option>
                    </select>    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-search"></i> Search</div>
                        <input type="text" name="keyword" value="{{ old('keyword') }}" placeholder="Search referrals" class="form-control" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row filter-buttons">    
            <div class="col-md-12">
                <div class="button-container">
                    <button type="submit" class="btn btn-primary btn-md">Apply Filters</button>
                    <a href="/referrals"><button type="button" class="btn btn-warning btn-md">Reset Filters</button></a>
                </div>
            </div>
       </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-referral">
                    <thead>
                        <tr>
                            <th>{{ Form::checkbox('check', '', false, ['class' => 'check-all']) }}</th>
                            <th>Date referred</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @foreach($referrals as $r)
                        <tr>
                            <td class="td-checkbox">{{ Form::checkbox('referral_id', $r->referred->id, false, ['class' => 'checkbox-group']) }}</td>
                            <td>{{ $r->referred->created_at->format('m/d/y') }}</td>
                            <td>You referred {{ $r->referred->display_name }}</td>
                            <td>{{ \App\Referral::$status[$r->status] }}</td>
                            <td class="view-details"><button class="btn btn-default btn-details">view details</button></td>
                        </tr>
                    @endforeach
                </table>
                {{ $referrals->links() }}
            </div>
        </div>

        <div class="row referral-export">            
            <div class="col-md-3 pull-right">
                <button class="btn btn-primary">Export Selected</button>
            </div>
        </div>
    </div>


@endsection