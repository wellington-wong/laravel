<h4>Reply</h4>
<form action="{{ route('messages.update', $thread->id) }}" method="post">
    {{ method_field('put') }}
    {{ csrf_field() }}
        
    <!-- Message Form Input -->
    <div class="form-group">
        <textarea name="message" class="form-control">{{ old('message') }}</textarea>
    </div>

    @if($members->count() > 0)
        <div class="checkbox message-checkbox">
            <h5>Include as Recipients:</h5>
            @foreach($members as $member)
                <label title="{{ $member->name }}">
                    <input type="checkbox" name="recipients[]" value="{{ $member->id }}">{{ isset($member->name) ? $member->name : $member->first_name . ' ' . $member->last_name }}
                </label>
            @endforeach
        </div>
    @endif

    <!-- Submit Form Input -->
    <div class="form-group">
        <button type="submit" class="btn btn-primary form-control">Submit</button>
    </div>
</form>