@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Pacientes</h3>
            </div>
            <div class="col text-right">
                <a href="{{ route('patients.create') }}" class="btn btn-sm btn-success">Nuevo paciente</a>
            </div>
        </div>
    </div>
    @if(session('notification'))
        <div class="card-body">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('notification')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
    <div class="table-responsive">
        <!-- Specialties -->
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">E-mail</th>
                <th scope="col">DNI</th>
                <th scope="col">Opciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                    <tr>
                        <th scope="row">{{$patient->name}}</th>
                        <td>{{$patient->email}}</td>
                        <td>{{$patient->dni}}</td>
                        <td>
                            <form action="{{ route('patients.destroy', $patient) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-primary">Editar</a>
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-body">
        {{ $patients->links() }}
    </div>
</div>
@endsection
