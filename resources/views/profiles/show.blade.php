@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col border-bottom">
                <avatar-form :user="{{ $profileUser }}"></avatar-form>
            </div>
        </div>

        <div class="mt-5"></div>

        @forelse($activities as $date => $activity)
            <div class="row mt-3">
                <div class="col-12 border-bottom">
                    <h3>{{ $date }}</h3>
                    <h3></h3>
                </div>
                <div class="col-12">
                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                </div>
            </div>
        @empty
            <p>There is no activity for this user yet.</p>
        @endforelse
    </div>
@stop