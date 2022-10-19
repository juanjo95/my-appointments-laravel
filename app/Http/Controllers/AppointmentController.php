<?php

namespace App\Http\Controllers;

use App\Interfaces\ScheduleServiceInterface;
use App\Models\Appointment;
use App\Models\Specialty;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create(ScheduleServiceInterface $scheduleService){
        $specialties = Specialty::all();

        $specialty_id = old('specialty_id');
        if($specialty_id){
            $specialty = Specialty::find($specialty_id);
            $doctors = $specialty->users;
        }else{
            $doctors = collect();
        }

        $scheduledDate = old('sheduled_date');
        $doctorId = old('doctor_id');
        if($scheduledDate && $doctorId){
            $intervals = $scheduleService->getAvailableIntervals($scheduledDate,$doctorId);
        }else{
            $intervals = null;
        }

        return view('appointments.create',compact('specialties','doctors','intervals'));
    }

    public function store(Request $request){
        $rules = [
            'description' => 'required',
            'specialty_id' => 'exists:specialties,id',
            'doctor_id' => 'exists:users,id',
            'scheduled_time' => 'required'
        ];

        $messages = [
            'scheduled_time.required' => 'Seleccione una hora valida para su cita'
        ];
        $this->validate($request,$rules,$messages);

        $data = $request->only([
            'description',
            'specialty_id',
            'doctor_id',
            'scheduled_date',
            'scheduled_time',
            'type'
        ]);
        $data['patient_id'] =  auth()->id();
        $carbonTime = Carbon::createFromFormat('g:i A',$data['scheduled_time']);
        $data['scheduled_time'] = $carbonTime->format('H:i:s');
        Appointment::create($data);

        $notification = "La cita se ha registrado correctamente.";
        return back()->with(compact('notification'));
        //return redirect(appointmens.index);
    }
}
