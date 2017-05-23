@extends('layouts.app')

@section('pageTitle', 'Users')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12">
                    <h4>Users</h4>
                </div>
            </div>
        </div>

        <div class="row bulk-action">
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-addon">Filter</div>
                    <select name="status" class="form-control">
                        <option value="export">Option 1</option>
                        <option value="export">Option 2</option>
                    </select>    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-search"></i> Search</div>
                        <input type="text" name="keyword" value="{{ old('keyword') }}" placeholder="Search members" class="form-control" />
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
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{{ Form::checkbox('check', '', false, array('class' => 'check-all')) }}</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="td-checkbox">{{ Form::checkbox('member_id', $user->id, false, ['class' => 'checkbox-group']) }}</td>
                    <td>{{ $user->name }}</td>
                    <td class="view-details"><button class="btn btn-default btn-details">view details</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row referral-export">            
            <div class="col-md-3 pull-right">
                <button class="btn btn-primary">Export Selected</button>
            </div>
        </div>
    </div>

@endsection