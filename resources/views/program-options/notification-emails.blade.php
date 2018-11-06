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
        <table class="table table-custom table-notification-emails">
            <tbody>
                <tr>
                    <td>
                        <label class="switch">
                          <input name="type" data-value="1" type="checkbox" {{ isset($emailTemplate[1]['status']) ? ($emailTemplate[1]['status'] ? '' : 'checked') : 'checked' }}>
                          <span class="slider round"></span>
                        </label>
                        <span class="status">{{ isset($emailTemplate[1]['status']) ? ($emailTemplate[1]['status'] ? 'Active' : 'Inactive') : 'Inactive' }}</span>
                    </td>
                    <td>{{ \App\EmailTemplate::$labels[1] }}</td>
                    <td><a href="{{ route('program-options-notification-email', 1) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
                <tr class="tr-spacer"><td colspan=5></td></tr>
                <tr>
                    <td>
                        <label class="switch">
                          <input name="type" data-value="2" type="checkbox" {{ isset($emailTemplate[2]['status']) ? ($emailTemplate[2]['status'] ? '' : 'checked') : 'checked' }}>
                          <span class="slider round"></span>
                        </label>
                        <span class="status">{{ isset($emailTemplate[2]['status']) ? ($emailTemplate[2]['status'] ? 'Active' : 'Inactive') : 'Inactive' }}</span>
                    </td>
                    <td>{{ \App\EmailTemplate::$labels[2] }}</td>
                    <td><a href="{{ route('program-options-notification-email', 2) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
                <tr class="tr-spacer"><td colspan=5></td></tr>
                <tr>
                    <td>
                        <label class="switch">
                          <input name="type" data-value="3" type="checkbox" {{ isset($emailTemplate[3]['status']) ? ($emailTemplate[3]['status'] ? '' : 'checked') : 'checked' }}>
                          <span class="slider round"></span>
                        </label>
                        <span class="status">{{ isset($emailTemplate[3]['status']) ? ($emailTemplate[3]['status'] ? 'Active' : 'Inactive') : 'Inactive' }}</span>
                    </td>
                    <td>{{ \App\EmailTemplate::$labels[3] }}</td>
                    <td><a href="{{ route('program-options-notification-email', 3) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
                <tr class="tr-spacer"><td colspan=5></td></tr>
                <tr>
                    <td>
                        <label class="switch">
                          <input name="type" data-value="4" type="checkbox" {{ isset($emailTemplate[4]['status']) ? ($emailTemplate[4]['status'] ? '' : 'checked') : 'checked' }}>
                          <span class="slider round"></span>
                        </label>
                        <span class="status">{{ isset($emailTemplate[4]['status']) ? ($emailTemplate[4]['status'] ? 'Active' : 'Inactive') : 'Inactive' }}</span>
                    </td>
                    <td>{{ \App\EmailTemplate::$labels[4] }}</td>
                    <td><a href="{{ route('program-options-notification-email', 4) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
                <tr class="tr-spacer"><td colspan=5></td></tr>
                <tr>
                    <td>
                        <label class="switch">
                          <input name="type" data-value="5" type="checkbox" {{ isset($emailTemplate[5]['status']) ? ($emailTemplate[5]['status'] ? '' : 'checked') : 'checked' }}>
                          <span class="slider round"></span>
                        </label>
                        <span class="status">{{ isset($emailTemplate[5]['status']) ? ($emailTemplate[5]['status'] ? 'Active' : 'Inactive') : 'Inactive' }}</span>
                    </td>
                    <td>{{ \App\EmailTemplate::$labels[5] }}</td>
                    <td><a href="{{ route('program-options-notification-email', 5) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
                <tr class="tr-spacer"><td colspan=5></td></tr>
                <tr>
                    <td>
                        <label class="switch">
                          <input name="type" data-value="8" type="checkbox" {{ isset($emailTemplate[8]['status']) ? ($emailTemplate[8]['status'] ? '' : 'checked') : 'checked' }}>
                          <span class="slider round"></span>
                        </label>
                        <span class="status">{{ isset($emailTemplate[8]['status']) ? ($emailTemplate[8]['status'] ? 'Active' : 'Inactive') : 'Inactive' }}</span>
                    </td>
                    <td>{{ \App\EmailTemplate::$labels[8] }}</td>
                    <td><a href="{{ route('program-options-notification-email', 8) }}" class="btn btn-primary">view/edit</a></td>
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
        <table class="table table-custom table-notification-emails">
            <tbody>
                <tr>
                    <td>
                        <label class="switch">
                          <input name="type" data-value="6" type="checkbox" {{ isset($emailTemplate[6]['status']) ? ($emailTemplate[6]['status'] ? '' : 'checked') : 'checked' }}>
                          <span class="slider round"></span>
                        </label>
                        <span class="status">{{ isset($emailTemplate[6]['status']) ? ($emailTemplate[6]['status'] ? 'Active' : 'Inactive') : 'Inactive' }}</span>
                    </td>
                    <td>{{ \App\EmailTemplate::$labels[6] }}</td>
                    <td><a href="{{ route('program-options-notification-email', 6) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
                <tr class="tr-spacer"><td colspan=5></td></tr>
                <tr>
                    <td>
                        <label class="switch">
                          <input name="type" data-value="7" type="checkbox" {{ isset($emailTemplate[7]['status']) ? ($emailTemplate[7]['status'] ? '' : 'checked') : 'checked' }}>
                          <span class="slider round"></span>
                        </label>
                        <span class="status">{{ isset($emailTemplate[7]['status']) ? ($emailTemplate[7]['status'] ? 'Active' : 'Inactive') : 'Inactive' }}</span>
                    </td>
                    <td>{{ \App\EmailTemplate::$labels[7] }}</td>
                    <td><a href="{{ route('program-options-notification-email', 7) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
                <tr class="tr-spacer"><td colspan=5></td></tr>
                <tr>
                    <td>
                        <label class="switch">
                          <input name="type" data-value="9" type="checkbox" {{ isset($emailTemplate[9]['status']) ? ($emailTemplate[9]['status'] ? '' : 'checked') : 'checked' }}>
                          <span class="slider round"></span>
                        </label>
                        <span class="status">{{ isset($emailTemplate[9]['status']) ? ($emailTemplate[9]['status'] ? 'Active' : 'Inactive') : 'Inactive' }}</span>
                    </td>
                    <td>{{ \App\EmailTemplate::$labels[9] }}</td>
                    <td><a href="{{ route('program-options-notification-email', 9) }}" class="btn btn-primary">view/edit</a></td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection