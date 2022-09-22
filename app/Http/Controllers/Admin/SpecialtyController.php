<?php

namespace App\Http\Controllers\Admin;

use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{

    public function index()
    {
        $specialties = Specialty::all();
        return view('specialties.index',compact('specialties'));
    }

    public function create()
    {
        return view('specialties.create');
    }

    private function performValidation($request)
    {
        $rules = [
            "name" => "required|min:3",
            "description" => "required"
        ];
        $messages = [
            "name.required" => "El nombre es obligatorio",
            "name.min" => "El nombre debe tener al menos 3 caracteres",
            "description.required" => "La descripcion es obligatoria",
        ];
        $this->validate($request,$rules,$messages);
    }

    public function store(Request $request)
    {
        $this->performValidation($request);

        $specialty = new Specialty();
        $specialty->name = $request->name;
        $specialty->description = $request->description;
        $specialty->save(); //INSERT

        $notification = "Especialidad creada correctamente";
        return Redirect::route("specialty.index")->with(compact('notification'));
    }

    public function edit(Specialty $specialty)
    {
        return view('specialties.edit', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty)
    {
        $this->performValidation($request);

        $specialty->name = $request->name;
        $specialty->description = $request->description;
        $specialty->save(); //UPDATE

        $notification = "Especialidad actualizada correctamente";
        return Redirect::route("specialty.index")->with(compact('notification'));
    }

    public function destroy(Specialty $specialty){
        $specialty_name = $specialty->name;
        $specialty->delete();

        $notification = "Especialidad $specialty_name eliminada correctamente";
        return Redirect::route("specialty.index")->with(compact('notification'));
    }

}
