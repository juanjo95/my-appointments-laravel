<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = User::doctors()->get();
        return view('doctors.index',compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required',
            'dni' => 'nullable|digits:8',
            'address' => 'nullable|min:5',
            'phone' => 'nullable|min:6'
        ];
        $this->validate($request, $rules);

        //mass assignment, significa asignacion masiva.
        User::create($request->only('name','email','dni','address','phone') + ['role' => 'doctor', 'password' => bcrypt($request->password)]);

        $notification = "Doctor creado correctamente";
        return Redirect::route("doctors.index")->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Busca el medio que tenga este id, y si no lo encuentra devuelve error 404, y hacemos uso del scope doctors que ya habiamos creado en el modelo User
        $doctor = User::doctors()->findOrFail($id);
        return view('doctors.edit',compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'dni' => 'nullable|digits:8',
            'address' => 'nullable|min:5',
            'phone' => 'nullable|min:6'
        ];
        $this->validate($request, $rules);

        $user = User::doctors()->findOrFail($id);
        $data = $request->only('name','email','dni','address','phone');
        $password = $request->password;

        if($password){
            $data['password'] = bcrypt($request->password);
        }

        $user->fill($data);

        $user->save();//UPDATE

        $notification = "Doctor actualizado correctamente";
        return Redirect::route("doctors.index")->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $doctor)
    {
        $nameDoc = $doctor->name;
        $doctor->delete();

        $notification = "El doctor $nameDoc ha sido eliminado correctamente";
        return Redirect::route("doctors.index")->with(compact('notification'));
    }
}
