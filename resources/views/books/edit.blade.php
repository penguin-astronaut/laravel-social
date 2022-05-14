@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-5">
                <div class="card">
                    <div class="card-header">Add new book</div>
                    <div class="card-body">
                        <form method="POST" action="{{route('books.update', [$book->id])}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-2">
                                <label for="title">Title</label>
                                <input id="title" name="title" type="text" value="{{$book->title}}"
                                       class="form-control @error('title') is-invalid @enderror">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="text">Text</label>
                                <textarea id="text" name="text" class="form-control
                                    @error('text') is-invalid @enderror">{{$book->text}}</textarea>
                                @error('text')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       value="1" name="shared" id="shared"{{$book->shared ? ' checked="checked"' : ''}}">
                                <label class="form-check-label" for="shared">
                                    Shared book
                                </label>
                            </div>
                            <button class="btn btn-primary mt-3">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

