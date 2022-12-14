@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Nuevo paciente</h3>
            </div>
            <div class="col text-right">
                <a href="{{ route('patients.index') }}" class="btn btn-sm btn-default">Cancelar y volver</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre del paciente</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
                @error('name')
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" class="form-control" value="{{old('email')}}" required>
                @error('email')
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="dni">DNI</label>
                <input type="number" name="dni" class="form-control" value="{{old('dni')}}" required>
                @error('dni')
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" name="address" class="form-control" value="{{old('address')}}" required>
                @error('address')
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="number" name="phone" class="form-control" value="{{old('phone')}}" required>
                @error('phone')
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="text" name="password" class="form-control" value="{{Str::random(12)}}" required>
                @error('password')
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</div>
@endsection
