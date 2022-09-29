<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class ScheduleController extends Controller
{

    private $days = ["Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo"];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $active = $request->active ?: [];
        $morning_start = $request->morning_start;
        $morning_end = $request->morning_end;
        $afternoon_start = $request->afternoon_start;
        $afternoon_end = $request->afternoon_end;

        $errors = array();
        for($i=0; $i<7; ++$i){

            if($morning_start[$i] >= $morning_end[$i]){
                $errors[] = "Las horas del turno mañana son inconsistentes para el dia ".$this->days[$i];
            }
            if($afternoon_start[$i] >= $afternoon_end[$i]){
                $errors[] = "Las horas del turno tarde son inconsistentes para el dia ".$this->days[$i];
            }

            WorkDay::updateOrCreate(
                [
                    'day' => $i,
                    'user_id' => auth()->user()->id
                ],
                [
                    'active' => in_array($i,$active),
                    'morning_start' => $morning_start[$i],
                    'morning_end' => $morning_end[$i],
                    'afternoon_start' => $afternoon_start[$i],
                    'afternoon_end' => $afternoon_end[$i]
                ]
            );
        }

        if(count($errors) > 0){
            return back()->with(compact('errors'));
        }

        $notification = "Los cambios se han guardado correctamente.";
        return back()->with(compact('notification'));
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
    public function edit()
    {
        $workDays = WorkDay::where('user_id',auth()->id())->get();
        $workDays->map(function ($workDay){
            $workDay->morning_start = (new Carbon($workDay->morning_start))->format('g:i A');
            $workDay->morning_end = (new Carbon($workDay->morning_end))->format('g:i A');
            $workDay->afternoon_start = (new Carbon($workDay->afternoon_start))->format('g:i A');
            $workDay->afternoon_end = (new Carbon($workDay->afternoon_end))->format('g:i A');
            return $workDay;
        });

        $days = $this->days;
        return view('schedule', compact('workDays','days'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
