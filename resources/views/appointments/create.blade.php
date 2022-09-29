@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Registrar nueva cita</h3>
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
                <label for="specialty">Especialidad</label>
                <select name="specialty_id" id="specialty" class="form-control">
                    <option value="-1" selected disabled>Seleccionar especialidad</option>
                    @foreach ($specialties as $specialty)
                        <option value="{{$specialty->id}}">{{$specialty->name}}</option>
                    @endforeach
                </select>
                @error('name')
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Médico</label>
                <select name="doctor_id" id="doctor" class="form-control">

                </select>
                @error('email')
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="dni">Fecha</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    <input class="form-control datepicker" placeholder="Seleccinar fecha" type="text" value="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd" data-date-start-date="{{date('Y-m-d')}}" data-date-end-date="+30d">
                </div>
                @error('dni')
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">Hora atención</label>
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

@section('scripts')
    <script src="{{ asset('/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(function() {
            $("#specialty").change( () => {
                let specialty_id = $("#specialty").val();
                const URL = `/specialties/${specialty_id}/doctors`;
                $.getJSON(URL, doctors => {
                    let htmlOptions = "";
                    doctors.forEach(doctor => {
                        htmlOptions += `<option value="${doctor.id}">${doctor.name}</option>`;
                    });
                    $("#doctor").html(htmlOptions);
                });
            });
        });
    </script>
@endsection
