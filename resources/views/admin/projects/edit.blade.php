@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-5">
            <h2 class="text-center">Edit project</h2>
            {{-- MOSTRA GLI ERRORI. COLLEGATO A StoreProjectRequest --}}
            @if($errors->any())
            <div class="alert alert-info">
                <ul class="list-unstyled">
                    {{-- CICLIAMO GLI ERRORI E LI MOSTRIAMO A FORMA DI LISTA --}}
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            {{-- REINDIRIZZA AL CONTROLLORE ProjectController AL METODO UPDATE. VIENE PASSATO LO SLUG DELL'ELEMENTO SELEZIONATO --}}
            <form action="{{ route('admin.projects.update', $project->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                  <label  class="form-label">Enter Title</label>
                  {{--IL METODO old() VIENE UTILIZZATO PER RECUPERARE IL VALORE DI UN CAMPO DI INPUT DAL PRECENDENTE INVIO DEL FORM --}}
                    {{-- IN QUESTO CASO MOSTRA IL TITOLO CHE ABBIAMO INSERITO NEL CREATE --}}
                  <input name="title" type="text" class="form-control" value="{{ old('title') ?? $project->title }}">
                </div>
                <div class="mb-3">
                    <label  class="form-label">Current Image</label>
                    <img class="w-25 d-block mb-4" src="{{ asset('storage/'.$project->cover_image)}}" alt="{{ $project->title }}">
                    <label  class="form-label">Enter New Image</label>
                    <input name="cover_image" type="file" class="form-control @error('cover_image') is-invalid @enderror">
                </div>
                <div class="mb-3">
                    <label  class="form-label">Enter Type</label>
                    <select class="form-controll" name="type_id" id="type_id">
                        @foreach ($types as $type)
                            <option value="{{$type->id}}" {{$type->id == old('type_id', $project->type_id) ? 'selected' : ''}}> {{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    @foreach ($technologies as $technology)  
                    <div class="form-check @error('technologies') is-invalid @enderror">
                        @if($errors->any())
                        <input type="checkbox" value="{{ $technology->id}}" name="technologies[]" {{ in_array($technology->id, old('technology', [])) ? 'checked' : ''}} class="form-check-input">
                        <label class="form-check-label">{{ $technology->name}}</label>
                        @else
                        <input type="checkbox" class="form-check-input" value="{{ $technology->id}}" name="technologies[]" {{ $project->technologies->contains($technology) ? 'checked' : ''}}>
                        <label class="form-check-label">{{ $technology->name}}</label>
                        @endif
                    </div>
                    @endforeach
                </div>
                <div class="mb-3">
                    <label  class="form-label">Enter Description</label>
                    {{-- IN QUESTO CASO MOSTRA IL CONTENUTO CHE ABBIAMO INSERITO NEL CREATE --}}
                    <textarea class="form-control" name="description"  cols="30" rows="10" >{{ old('content') ?? $project->description }}</textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection