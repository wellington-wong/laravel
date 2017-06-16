        <div class="row">    
            <div class="col-md-12 table-referral-wrapper table-wrapper">
                <table class="table table-message tablesaw tablesaw-stack table-custom">
                    <tbody>
                        <tr>
                            <td class="col-md-1 avatar"><i class="fa fa-user-circle"></i></td>
                            <td class="col-md-11">                                
                                <strong>{{ $message->user->name }}</strong>
                                {!! $message->body !!}
                                <div class="text-muted">
                                    <small>Posted {{ $message->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>    
            </div>
        </div>