<reply attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card mt-3">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <a href="{{ route('profile', $reply->owner) }}">{{ $reply->owner->username }}</a> said
                    {{ $reply->created_at->diffForHumans() }}...
                </div>
                <div class="col-lg-6 text-lg-right">
                    @if(Auth::check())
                    <favorite :reply="{{ $reply }}"></favorite>
                    @endif
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
            <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
        </div>
        @endcan
    </div>
</reply>