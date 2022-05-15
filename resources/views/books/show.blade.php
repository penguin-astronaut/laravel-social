@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>{{$book->title}}</h3>
                        @if($book->user_id === auth()->id())
                            @if($book->shared)
                                <a href="{{route('books.unshared', $book->id)}}" class="btn btn-warning">Unshared book</a>
                            @else
                                <a href="{{route('books.shared', $book->id)}}" class="btn btn-primary">Shared book</a>
                            @endif
                        @endif
                    </div>
                    <div class="card-body">
                        <p>
                            {{$book->text}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
