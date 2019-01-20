<div class="card mt-3">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-6">
                <a href="{{ route('profile', $reply->owner) }}">{{ $reply->owner->name }}</a> said
                {{ $reply->created_at->diffForHumans() }}...
            </div>
            <div class="col-lg-6 text-right">
                <form method="post" action="/replies/{{ $reply->id }}/favorites">
                    @csrf
                    <button class="btn btn-primary btn-sm" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>

    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>