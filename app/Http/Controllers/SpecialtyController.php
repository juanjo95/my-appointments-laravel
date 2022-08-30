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
        $specialty = new Specialty();
        $specialty->name = $request->name;
        $specialty->description = $request->description;
        $specialty->save(); //INSERT

        return Redirect::route("specialty.index");
    }

}
