@component('profiles.activities.activity')
    @slot('heading')
        <div class="col">
            <a href="{{ route('profile', $activity->subject->creator) }}">{{ $activity->subject->creator->name }}</a> published
            <a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a>
        </div>
        <div class="col text-right">
            {{ $activity->subject->created_at->diffForHumans() }}
        </div>
    @endslot

    @slot('body')
        {!! $activity->subject->body !!}
    @endslot
@endcomponent