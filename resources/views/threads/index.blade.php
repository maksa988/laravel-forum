@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Forum Threads</div>

                    <div class="card-body">
                        @foreach($threads as $thread)
                            <article>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4>
                                            <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                        </h4>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</a>
                                    </div>
                                </div>

                                <div class="body">{{ $thread->body }}</div>
                            </article>

                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection