@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-8">
                                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                                {{ $thread->title }}
                            </div>
                            <div class="col-lg-4 text-lg-right">
                                @can('update', $thread)
                                <form method="POST" action="{{ $thread->path() }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link" type="submit">Delete Thread</button>
                                </form>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                <div class="mt-3">
                    {{ $replies->links() }}
                </div>

                <div class="mb-3">
                    @if(auth()->check())
                    <form action="{{ $thread->path() . '/replies' }}" method="post" class="mt-3">
                        @csrf
                        <div class="from-group mb-3">
                            <textarea name="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                    @else
                    <p class="text-center mt-3">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        That thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="#">{{ $thread->creator->name }}</a>, and currently has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection