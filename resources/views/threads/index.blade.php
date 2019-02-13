@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('threads._list')

                <div class="mt-3">
                    {{ $threads->render() }}
                </div>
            </div>

            <div class="col-md-4">
                <form class="input-group mt-3">
                    <input type="text" class="form-control" placeholder="Search for something..." name="q">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>

                @if(count($trending))
                    <div class="card mt-3">
                        <div class="card-header">Trending Threads</div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                            @foreach($trending as $thread)
                                {{--<li class="list-group-item">--}}
                                    <a href="{{ url($thread->path) }}" class="list-group-item">{{ $thread->title }}</a>
                                {{--</li>--}}
                            @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection