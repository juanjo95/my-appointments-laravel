@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Especialidades</h3>
            </div>
            <div class="col text-right">
                <a href="{{ route('specialty.create') }}" class="btn btn-sm btn-success">Nueva especialidad</a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <!-- Specialties -->
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Opciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($specialties as $specialty)
                    <tr>
                        <th scope="row">{{$specialty->name}}</th>
                        <td>{{$specialty->description}}</td>
                        <td>
                            <form action="{{ route('specialty.destroy', $specialty) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('specialty.edit', $specialty) }}" class="btn btn-sm btn-primary">Editar</a>
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
