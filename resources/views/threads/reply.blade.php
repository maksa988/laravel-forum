<reply attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card mt-3">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <a href="{{ route('profile', $reply->owner) }}">{{ $reply->owner->name }}</a> said
                    {{ $reply->created_at->diffForHumans() }}...
                </div>
                <div class="col-lg-6 text-lg-right">
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
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>
        </div>

        @can('update', $reply)
        <div class="card-footer d-flex flex-wrap">
            <button class="btn btn-secondary mr-2 btn-sm" @click="editing = true">Edit</button>

            <form method="post" action="/replies/{{ $reply->id }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">
                    Delete
                </button>
            </form>
        </div>
        @endcan
    </div>
</reply>