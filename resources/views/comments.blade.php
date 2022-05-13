@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-5">
                <div class="card">
                    <div class="card-header">My comments</div>
                    <div class="card-body">
                        <div class="comments">
                            @foreach($comments as $comment)
                                <div class="comment">
                                    <p class="mr-1"><strong>{{$comment->title}}</strong></p>
                                    <p>{{$comment->text}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
