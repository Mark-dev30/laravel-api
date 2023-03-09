@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center">Project page</h2>
            <div class="content-project m-5">
                <label><h5>Image:</h5></label>
                <img class="w-25 d-block mb-4" src="{{ asset('storage/'.$project->cover_image )}}" alt="{{ $project->title }}">
                <label><h5>Title:</h5></label>
                {{-- MOSTRO IL TITOLO --}}
                <p>{{$project->title}}</p>
                <label><h5>Types</h5></label>
                <p>{{$project->type ? $project->type->name : 'Uncategorized'}}</p>
                <label><h5>technologies</h5></label>
                <p>
                    @forelse ($project->technologies as $technology)
                        {{ $technology->name }}
                    @empty
                    No technology inserted
                    @endforelse
                </p>
                <label><h5>Content:</h5></label>
                {{-- MOSTRO IL CONTENUTO --}}
                <p>{{$project->description}}</p>
                
            </div>
        </div>
    </div>
</div>
@endsection