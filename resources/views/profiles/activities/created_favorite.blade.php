@component('profiles.activities.activity')
    @slot('heading')
        <div class="col">
            <a href="{{ $activity->subject->favorited->path() }}">
                {{ $profileUser->username }} favorited a reply...
            </a>
        </div>
        <div class="col text-right">
            {{ $activity->subject->created_at->diffForHumans() }}
        </div>
    @endslot

    @slot('body')
        {!! $activity->subject->favorited->body !!}
    @endslot
@endcomponent