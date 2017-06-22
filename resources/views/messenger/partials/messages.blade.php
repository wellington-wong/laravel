                        <tr>
                            @if ($message->user_id == Auth::user()->id)
                            <td>                        
                                <div class="col-md-11 text-right">
                                    <strong>{{ $message->user->name }}</strong>
                                    {!! $message->body !!}
                                    <div class="text-muted">
                                        <small>Posted {{ $message->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>    
                                <div class="col-md-1 no-padding-lr avatar text-center">
                                    @if (isset($message->user->profile_image))
                                    <div class="profile-image">
                                        <img height="20" src="/{{ $message->user->profile_image }}" alt="{{ $message->user->name }}" />
                                    </div>
                                    @else
                                    <i class="fa fa-user-circle"></i>
                                    @endif
                                </div>
                            </td>
                            @else
                            <td>        
                                <div class="col-md-1 no-padding-lr avatar text-center">
                                    @if (isset($message->user->profile_image))
                                    <div class="profile-image">
                                        <img height="20" src="/{{ $message->user->profile_image }}" alt="{{ $message->user->name }}" />
                                    </div>
                                    @else
                                    <i class="fa fa-user-circle"></i>
                                    @endif
                                </div>
                                <div class="col-md-11">
                                    <strong>{{ $message->user->name }}</strong>
                                    {!! $message->body !!}
                                    <div class="text-muted">
                                        <small>Posted {{ $message->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </td>
                            @endif
                        </tr>