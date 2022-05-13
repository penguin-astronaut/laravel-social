@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-5">
            <div class="card">
                <div class="card-header">Users</div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($users as $user)
                            <a href="{{route('profile', [$user->id])}}" class="list-group-item list-group-item-action">
                                {{$user->name}}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
