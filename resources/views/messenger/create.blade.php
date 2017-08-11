@extends('layouts.app')

@section('pageTitle', 'New Message')

@section('content')
    <div class="container-fluid new-message-wrapper">

        <div class="row">
            @include('layouts.page-header', ['header' => 'New Message', 'col' => 6])
        </div>

        <div class="clearfix"></div>

        <div class="row">
                <div class="col-md-12 no-padding-lr">
                    <form action="{{ route('messages.store') }}" method="post">
                        {{ csrf_field() }}
                        <!-- Subject Form Input -->
                        <div class="form-group">
                            <label class="control-label">Subject</label>
                            <input type="text" class="form-control" name="subject" placeholder="Subject"
                                   value="{{ old('subject') }}">
                        </div>

                        <!-- Message Form Input -->
                        <div class="form-group">
                            <label class="control-label">Message</label>
                            <textarea name="message" class="form-control">{{ old('message') }}</textarea>
                        </div>

                        @if(isset($users) && $users->count() > 0)
                            <div><label class="control-label">Recipients</label></div>
                            <div class="checkbox message-checkbox">
                                <select multiple class="form-control">
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{!!$user->name!!}</option>
                                    @endforeach
                                </select>
                                @foreach($users as $user)
                                    <label title="{{ $user->name }}">
                                        <input type="checkbox" name="recipients[]" value="{{ $user->id }}"> {!!$user->name!!}
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        <!-- Submit Form Input -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary form-control">Submit</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
@stop
