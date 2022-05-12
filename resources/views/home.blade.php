@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.secureToken = '{{ csrf_token() }}';
    window.ownerId = {{$owner->id}};
    window.authId = {{auth()->id()}}
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-5">
            <div class="card">
                <div class="card-header">User card</div>
                <div class="card-body">
                    <h5 class="card-title">Name: {{$owner->name}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Email: {{$owner->email}}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Comments board</div>
                <div class="card-body">
                    <div class="comments">
                        @foreach($comments as $comment)
                            <div class="flex-column">
                                <div class="d-flex align-items-center">
                                    <p class="mr-1"><strong>{{$comment->title}}</strong></p>
                                    <p class="text-secondary small mr-1">User: {{$comment->user->email}}</p>
                                    <p class="text-secondary small">Date: {{$comment->created_at->format('d.m.Y H:i')}}</p>
                                </div>

                                <p>{{$comment->text}}</p>
                            </div>
                            @if($comment->user->id == auth()->id() || $owner->id === auth()->id())
                                <a class="btn btn-danger" href="/comment/delete/{{$comment->id}}">Delete</a>
                            @endif
                            <hr>
                        @endforeach

                        @if(count($comments) === 5)
                            <button class="btn btn-info d-block mx-auto text-uppercase m-2 load-comments">
                                load all comments
                            </button>
                        @endif
                    </div>
                    @auth
                        <form method="POST" action="/comment/create">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input id="title" name="title" type="text"
                                       class="form-control @error('title') is-invalid @enderror">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="text">Comment</label>
                                <textarea id="text" name="text"
                                          class="form-control @error('text') is-invalid @enderror"></textarea>
                                @error('text')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                            <input type="hidden" name="recipient_id" value="{{$owner->id}}">
                            <button class="btn btn-primary mt-3">Send</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
