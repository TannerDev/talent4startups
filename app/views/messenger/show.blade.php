@extends('layouts.default')

@section('content')
        <div class="pull-right actions">
           @if($thread->isUnread($currentUserId))<a href="{{ route('messages.markRead', $thread->id) }}" class="btn btn-warning pull-right">Mark Read</a> @endif
           <a href="{{ route('messages.unread', $thread->id) }}" class="btn btn-default pull-right">Mark Unread</a>
        </div>
        <h1>Subject: {{$thread->subject}}</h1>

        <hr />

        @foreach($messages as $message)
            <div class="media">
                @if ($message->type == 'message')
                <div class="pull-left" href="#">
                    <a href="{{ route('profile_path', $message->user->id) }}"><img src="{{ $message->user->profile->avatar() }}?s=64&d=mm" alt="{{ $message->user->profile->first_name }}" class="img-circle" width="64" height="64"></a>
                    <p><a href="{{ route('profile_path', $message->user->id) }}">{{$message->user->profile->first_name}} {{$message->user->profile->last_name}}</a></p>
                </div>
                @endif
                <div class="media-body">
                    @if ($message->type == 'message')
                        <h5 class="media-heading">From: <a href="{{ route('profile_path', $message->user->id) }}">{{$message->user->profile->first_name}} {{$message->user->profile->last_name}}</a></h5>
                    @endif
                    <div class="text-muted"><small>Posted {{$message->created_at->diffForHumans()}}</small></div>
                    <p>{{nl2br($message->linkify())}}</p>
                </div>
            </div>
        @endforeach
        <div class="row">
            <div class="col-sm-12">
                {{ $messages->links() }}
            </div>
        </div>

        @if ($message->type == 'message')
        <h2>Reply</h2>
        {{Form::open(['route' => ['messages.update', $thread->id], 'method' => 'PUT'])}}
        <!-- Message Form Input -->
        <div class="form-group">
            {{ Form::textarea('message', null, ['class' => 'form-control']) }}
        </div>

        @if($users->count() > 0)
        <div class="checkbox">
            @foreach($users as $user)
                <label title="{{$user->profile->first_name}} {{$user->profile->last_name}}"><input type="checkbox" name="recipients[]" value="{{$user->id}}">{{$user->profile->first_name}}</label>
            @endforeach
        </div>
        @endif

        <!-- Submit Form Input -->
        <div class="form-group">
            {{ Form::submit('Submit', ['class' => 'btn btn-primary form-control']) }}
        </div>
        {{Form::close()}}
        @endif
@endsection
