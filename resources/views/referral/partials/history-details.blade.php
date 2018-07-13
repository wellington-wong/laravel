        <div class="row">
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <table class="table table-referral tablesaw tablesaw-stack table-custom" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Details</th>
                        </tr>
                    </thead> 
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                        <tr>
                            <td>{{ isset($referral->created_at) ? $referral->created_at->format('m/d/y') : '' }}</td>
                            <td class="referral-note"></td>
                            <td>{{ isset($referral->referrer) ? $referral->referrer->display_name : null }} referred <em>"{{ isset($referral->referred) ? $referral->referred->display_name : null }}"</em></td>
                        </tr>
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                        @foreach ($referral->revisionHistory as $history)
                        @if ($history->new_value)
                        <tr>
                            <td>{{ $history->created_at->format('m/d/y') }}</td>
                            <td>{{ $history->revisionable_id }}</td>
                            <td>
                                @if (is_numeric($history->new_value))
                                The referral status for <em>"{{ $referral->referred->display_name }}"</em> was changed to {{ \App\Referral::$status[$history->new_value] }}
                                @else
                                {!! $history->new_value !!}
                                @endif 
                            </td>
                        </tr>
                        @endif 
                        <tr class="tr-spacer"><td colspan=5></td></tr>
                        @endforeach
                </table>
            </div>
            <div class="hidden members-select">{{ Form::select('as_member', ($_company->members()->pluck('name', 'id') ? ['0' => 'Please select a member'] +  $_company->members()->pluck('name', 'id')->toArray() : [] ), '', ['class' => 'form-control']) }}</div>
        </div>