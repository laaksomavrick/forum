@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="#">
                        {{ $thread->creator->name }}
                    </a>
                    posted: 
                    {{ $thread->title }}
                </div>
                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach($thread->replies as $reply)
                @include ('threads.reply') 
            @endforeach
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (auth()->check())
                <form method="POST" action="{{ $thread->path() . '/replies' }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <textarea name="body" id="body" rows="5" class="form-control" placeholder="Reply here"></textarea>
                        <button type="submit" class="btn btn-default">Post</button>
                    </div>
                </form>
            @else
                <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to add replies</p>
            @endif
        </div>
    </div>

</div>
@endsection