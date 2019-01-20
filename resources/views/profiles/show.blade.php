@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>
                    {{ $profileUser->name }}
                    <small>since {{ $profileUser->created_at->diffForHumans() }}</small>
                </h1>
            </div>
        </div>

        @foreach($threads as $thread)
            <div class="card mt-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <a href="#">{{ $thread->creator->name }}</a> posted:
                            {{ $thread->title }}
                        </div>
                        <div class="col text-right">
                            {{ $thread->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        @endforeach

        <div class="mt-3">
            {{ $threads->links() }}
        </div>
    </div>
@stop