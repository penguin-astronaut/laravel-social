@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2>My books</h2>
                            <a href="{{route('books.create')}}" class="btn btn-info">Add book</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($books as $book)
                                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom">
                                    <p>{{$book->title}}</p>
                                    <div class="d-flex">
                                        <a href="{{route('books.show', [$book->id])}}" class="btn btn-sm btn-primary mr-1">Read</a>
                                        <a href="{{route('books.edit', [$book->id])}}" class="btn btn-sm btn-success mr-1">Edit</a>
                                        <a href="{{route('books.destroy', [$book->id])}}" class="btn btn-sm btn-danger">Delete</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
