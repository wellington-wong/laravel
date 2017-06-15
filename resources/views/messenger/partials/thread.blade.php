<tr>
    <td><a href="{{ route('messages.show', $thread->id) }}">{{ $thread->subject }}</a> ({{ $thread->userUnreadMessagesCount(Auth::id()) }} unread)</td>
    <td>{{ $thread->creator()->name }}</td>
    <td>{{ $thread->participantsString(Auth::id()) }}</td>
</tr>