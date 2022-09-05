<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SpecialtyController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $specialties = Specialty::all();
        return view('specialties.index',compact('specialties'));
    }

    public function create()
    {
        return view('specialties.create');
    }

    public function store(Request $request)
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

        $specialty = new Specialty();
        $specialty->name = $request->name;
        $specialty->description = $request->description;
        $specialty->save(); //INSERT

        return Redirect::route("specialty.index");
    }

    public function edit(Specialty $specialty)
    {
        return view('specialties.edit', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty){

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

        $specialty->name = $request->name;
        $specialty->description = $request->description;
        $specialty->save(); //UPDATE

        return Redirect::route("specialty.index");
    }

}
