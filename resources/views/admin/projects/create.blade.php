@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-5">
            <h2 class="text-center">Add a new project</h2>
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
            {{-- REINDIRIZZA AL CONTROLLORE ProjectController AL METODO store. VIENE PASSATO LO SLUG DELL'ELEMENTO SELEZIONATO --}}
            <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                  <label  class="form-label">Enter Title</label>
                  <input name="title" type="text" class="form-control">
                </div>
                <div class="mb-3">
                    <label  class="form-label">Enter Image</label>
                    <input name="cover_image" type="file" class="form-control @error('cover_image') is-invalid @enderror">
                </div>
                <div class="mb-3">
                    <label  class="form-label">Types</label>
                    <select class="form-control" name="type_id" id="type_id">
                        @foreach ($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label  class="form-label">technologies</label>
                    @foreach ($technologies as $technology)
                    <div class="form-check @error('technology') is-invalid @enderror">
                        <input type="checkbox" value="{{ $technology->id}}" name="technologies[]">
                        <label class="form-check-label">{{ $technology->name }}</label>
                    </div>
                    @endforeach
                    
                </div>

                <div class="mb-3">
                    <label  class="form-label">Enter Description</label>
                    <textarea class="form-control" name="description"  cols="30" rows="10"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection