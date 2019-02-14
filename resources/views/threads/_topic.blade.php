<div class="card" v-if="editing">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12">
                <input type="text" class="form-control" v-model="form.title">
            </div>
        </div>
    </div>

    <div class="card-body">
        <wysiwyg v-model="form.body"></wysiwyg>
    </div>

    <div class="card-footer d-flex">
        <button class="btn btn-primary mr-2 btn-sm" @click="update">Update</button>
        <button class="btn btn-link mr-2 btn-sm" @click="resetForm ">Cancel</button>

        @can('update', $thread)
            <form method="POST" class="ml-auto" action="{{ $thread->path() }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-link btn-sm" type="submit">Delete Thread</button>
            </form>
        @endcan
    </div>
</div>

<div class="card" v-else>
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12">
                <img src="{{ $thread->creator->avatar_path }}" class="mr-2" width="25" height="25" align="{{ $thread->creator->name }}">
                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                <span v-text="title"></span>
            </div>
        </div>
    </div>

    <div class="card-body" v-html="body"></div>

    <div class="card-footer" v-if="authorize('owns', thread)">
        <button class="btn btn-secondary mr-2 btn-sm" @click="editing = true">Edit</button>
    </div>
</div>