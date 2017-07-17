@extends('layouts.app')

@section('pageTitle', 'Notification Emails')

@section('content')
    <div class="container-fluid notification-wrapper">    
        <div class="row">
        @include('layouts.page-header', ['header' => 'Notification Emails', 'col' => 12])
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">        
        <div class="col-md-12">        
            <label>Customer Notification Emails</label>
        </div>
    </div>
    <div class="col-md-12 table-wrapper">        
        <table class="table tablesaw tablesaw-stack table-custom table-notification-emails" data-tablesaw-mode="stack">
            <tbody>
                <tr>
                    <td>
                        <label class="switch">
                          <input type="checkbox" checked>
                          <span class="slider round"></span>
                        </label>
                        <span class="status">Inactive</span>
                    </td>
                    <td>New Member Welcome Email</td>
                    <td><a href="{{ route('program-options-notification-email', 1) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
                <tr>
                    <td>
                        <label class="switch">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>
                        <span class="status">Active</span>
                    </td>
                    <td>Referral Received Email</td>
                    <td><a href="{{ route('program-options-notification-email', 1) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
                <tr>
                    <td>
                        <label class="switch">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>
                        <span class="status">Active</span>
                    </td>
                    <td>Referral Verified Notification Email</td>
                    <td><a href="{{ route('program-options-notification-email', 1) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
                <tr>
                    <td>
                        <label class="switch">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>
                        <span class="status">Active</span>
                    </td>
                    <td>Referral Has Been Sent Email</td>
                    <td><a href="{{ route('program-options-notification-email', 1) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
                <tr>
                    <td>
                        <label class="switch">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>
                        <span class="status">Active</span>
                    </td>
                    <td>Referral Has Been Declined Email</td>
                    <td><a href="{{ route('program-options-notification-email', 1) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row">        
        <div class="col-md-12">        
            <label>Admin Notification Emails</label>
        </div>
    </div>
    <div class="col-md-12 table-wrapper">        
        <table class="table tablesaw tablesaw-stack table-custom table-notification-emails" data-tablesaw-mode="stack">
            <tbody>
                <tr>
                    <td>
                        <label class="switch">
                          <input type="checkbox" checked>
                          <span class="slider round"></span>
                        </label>
                        <span class="status">Inactive</span>
                    </td>
                    <td>New Member Signup</td>
                    <td><a href="{{ route('program-options-notification-email', 1) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
                <tr>
                    <td>
                        <label class="switch">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>
                        <span class="status">Active</span>
                    </td>
                    <td>New Referral</td>
                    <td><a href="{{ route('program-options-notification-email', 1) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection