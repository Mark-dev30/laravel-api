@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-5">
            <h2 class="text-center">Add a new technology</h2>
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
            {{-- REINDIRIZZA AL CONTROLLORE TechnologyController AL METODO store. VIENE PASSATO LO SLUG DELL'ELEMENTO SELEZIONATO --}}
            <form action="{{ route('admin.technologies.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                  <label  class="form-label">Enter Name</label>
                  <input name="name" type="text" class="form-control">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection