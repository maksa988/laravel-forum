@component('profiles.activities.activity')
    @slot('heading')
        <div class="col">
            <a href="{{ route('profile', $activity->subject->owner) }}">{{ $activity->subject->owner->name }}</a> replied to
            "<a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>"
        </div>
        <div class="col text-right">
            {{ $activity->subject->created_at->diffForHumans() }}
        </div>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent