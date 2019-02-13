@extends('layouts.app')

@section('content')
    <div class="container">
        <ais-index
            app-id="{{ config('scout.algolia.id') }}"
            api-key="{{ config('scout.algolia.key') }}"
            index-name="threads"
            query="{{ request('q') }}"
            class="row"
        >
            <div class="col-md-8">
                <ais-results>
                    <template scope="{ result }">
                        <li>
                            <a :href="result.path">
                                <ais-highlight :result="result" attribute-name="title" :autofocus="true"></ais-highlight>
                            </a>
                        </li>
                    </template>
                </ais-results>
            </div>

            <div class="col-md-4">
                <div class="card mt-3">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <ais-search-box>
                            <ais-input placeholder="Search something..." :autofocus="true" class="form-control"></ais-input>
                        </ais-search-box>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">Channels</div>
                    <div class="card-body">
                        <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
                    </div>
                </div>

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
        </ais-index>
    </div>
@endsection