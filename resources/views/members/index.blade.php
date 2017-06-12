@extends('layouts.app')

@section('pageTitle', 'Members')

@section('content')
    <div class="container-fluid members-wrapper">
        <div class="col-md-12 text-right export-link"><a href="{{ route('referrals-export') . '?' . Request::getQueryString() }}">Export</a></div>

        <div class="row">
            @include('layouts.page-header', ['header' => 'Members', 'col' => 3])

            <div class="col-md-9 page-filters no-padding-lr">
                <div class="row">
                    <div class="col-md-4 filter-item search pull-right">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        {{ Form::text('q', old('q'), ['placeholder' => 'Search', 'class' => 'form-control text', 'data-query' => (isset($param->q) ? $param->q : '')]) }}            
                        {{ Form::submit('Search', ['placeholder' => 'Search', 'class' => 'btn btn-search members']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 table-members-wrapper">
                <table class="table table-members tablesaw tablesaw-stack" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead> 
                    @foreach ($members as $member)
                        <tr>
                            <td>{{ $member->id }}</a></td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                        </tr>
                    @endforeach
                    @if (!count($members))<tr><td colspan="5">No members found.</td></tr>@endif
                </table>
                {{ $members->links() }}
            </div>
        </div>
    </div>

@endsection