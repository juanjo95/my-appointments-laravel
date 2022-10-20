<?php

namespace App\Http\Controllers;

use App\Interfaces\ScheduleServiceInterface;
use App\Models\Appointment;
use App\Models\Specialty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function index(){
        $pendingAppointments = Appointment::where('status','Reservada')->where('patient_id',auth()->id())->paginate(10);
        $confirmedAppointments = Appointment::where('status','Confirmada')->where('patient_id',auth()->id())->paginate(10);
        $oldAppointments = Appointment::whereIn('status',['Atendida','Cancelada'])->where('patient_id',auth()->id())->paginate(10);

        return view('appointments.index',compact('pendingAppointments','confirmedAppointments','oldAppointments'));
    }

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

    public function store(Request $request, ScheduleServiceInterface $scheduleService){
        $rules = [
            'description' => 'required',
            'specialty_id' => 'exists:specialties,id',
            'doctor_id' => 'exists:users,id',
            'scheduled_time' => 'required'
        ];

        $messages = [
            'scheduled_time.required' => 'Seleccione una hora valida para su cita'
        ];

        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->after(function($validator) use($request,$scheduleService){
            $date = $request->scheduled_date;
            $doctorId = $request->doctor_id;
            $scheduled_time = $request->scheduled_time;

            if($date && $doctorId && $scheduled_time){
                $start = new Carbon($scheduled_time);
            }else{
                return;
            }

            if(!$scheduleService->isAvailableInterval($date, $doctorId, $start)){
                $validator->errors()->add('available_time','La hora seleccionada ya se encuentra seleccionada por otro paciente');
            }
        });

        if($validator->fails()){
            $notification_error = "La hora seleccionada ya se encuentra seleccionada por otro paciente.";
            return back()->with(compact('notification_error'))->withInput();
            //return back()->withErrors($validator)->withInput();
        }

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
