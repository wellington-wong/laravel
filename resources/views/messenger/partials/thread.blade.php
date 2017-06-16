<tr>
    <td><a href="{{ route('messages.show', $thread->id) }}">{{ $thread->subject }}</a> ({{ $thread->userUnreadMessagesCount(Auth::id()) }} unread)</td>
    <td>{{ $thread->creator()->name }}</td>
    <td>{{ $thread->participantsString(Auth::id()) }}</td>
    <td><a class="btn btn-primary" href="{{ route('messages.show', ['id' => $thread->id]) }}">view message</a></td>
</tr>