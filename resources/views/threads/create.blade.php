@extends('layouts.app')

@push('head')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Create a New Thread</div>

                    <div class="card-body">
                        @if(count($errors))
                            <ul class="alert alert-danger pl-5">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="post" action="/threads">
                            @csrf
                            
                            <div class="form-group">
                                <label for="channel">Choose a Channel:</label>
                                <select name="channel_id" id="channel" class="form-control" required>
                                    <option value="">Choose One...</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <wysiwyg name="body"></wysiwyg>
                            </div>

                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{ config('forum.recaptcha.key') }}"></div>
                            </div>

                            <button type="submit" class="btn btn-primary">Publish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection