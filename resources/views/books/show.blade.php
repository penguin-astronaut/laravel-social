@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-5">
                <div class="card">
                    <div class="card-header"><h3>{{$book->title}}</h3></div>
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
