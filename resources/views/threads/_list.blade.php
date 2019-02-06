@forelse($threads as $thread)
    <div class="card mt-3">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-8">
                    <h4>
                        <a href="{{ $thread->path() }}">
                            @if(Auth::check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>
                                    {{ $thread->title }}
                                </strong>
                            @else
                                {{ $thread->title }}
                            @endif
                        </a>
                    </h4>
                </div>
                <div class="col-lg-4 text-right">
                    <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="body">{{ $thread->body }}</div>
        </div>

        <div class="card-footer text-muted">
            {{ $thread->visits }} Visits
        </div>
    </div>
@empty
    <p class="text-center">There are no relevant results at this time</p>
@endforelse