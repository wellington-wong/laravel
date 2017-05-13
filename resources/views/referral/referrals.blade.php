@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12">
                    <h4>Your Submitted Referrals</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-referral">
                    @foreach($referrals as $r)
                        <tr>
                            <td>{{ $r->referred->created_at->format('m/d/y') }}</td>
                            <td>You referred {{ $r->referred->display_name }}</td>
                            <td>{{ \App\Referral::$status[$r->status] }}</td>
                            <td><button class="btn btn-default">view details</button></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


@endsection