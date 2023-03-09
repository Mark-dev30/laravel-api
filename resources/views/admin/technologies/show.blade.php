@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center">Technology page</h2>
            <div class="content-project m-5">
                <label><h5>Name:</h5></label>
                <p>{{$technology->name}}</p>

                <label><h5>Slug:</h5></label>
                <p>{{$technology->slug}}</p>
            </div>
        </div>
    </div>
</div>
@endsection