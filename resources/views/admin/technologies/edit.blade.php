@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-5">
            <h2 class="text-center">Edit type</h2>
            {{-- MOSTRA GLI ERRORI. COLLEGATO A StoreTechnologyRequest --}}
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
            {{-- REINDIRIZZA AL CONTROLLORE TechnologyController AL METODO UPDATE. VIENE PASSATO LO SLUG DELL'ELEMENTO SELEZIONATO --}}
            <form action="{{ route('admin.technologies.update', $technology->slug) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                  <label  class="form-label">Enter Name</label>
                  {{--IL METODO old() VIENE UTILIZZATO PER RECUPERARE IL VALORE DI UN CAMPO DI INPUT DAL PRECENDENTE INVIO DEL FORM --}}
                    {{-- IN QUESTO CASO MOSTRA IL NOME CHE ABBIAMO INSERITO NEL CREATE --}}
                  <input name="name" type="text" class="form-control" value="{{ old('name') ?? $technology->name }}">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection