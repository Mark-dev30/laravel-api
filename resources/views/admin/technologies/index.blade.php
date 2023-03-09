@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12 mt-2 p-0">
            <h1 class="text-center">TECHNOLOGY LIST</h1>
            <div class="text-center m-5">
                <a href="{{ route('admin.technologies.create')}}" class="btn btn-primary">Add technology!</a>
            </div>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NAME</th>
                        <th scope="col">SLUG</th>
                        <th scope="col">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($technologies as $technology)
                    <tr>
                        <td>{{ $technology->id }}</td>
                        <td>{{ $technology->name }}</td>
                        <td>{{ $technology->slug }}</td>
                        <td>
                            <div class="d-flex">
                                
                                <a class="btn btn-sm btn-info" href="{{ route('admin.technologies.show', $technology->slug) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                
                                <a class="btn btn-sm btn-warning ms-2 me-2" href="{{ route('admin.technologies.edit', $technology->slug) }}">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                
                                <form action="{{ route('admin.technologies.destroy', $technology->slug)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger confirm-delete-button">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>
</div>
@include("admin.types.modal")
@endsection