<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ScheduleServiceInterface;

class ScheduleController extends Controller
{
    public function hours(Request $request, ScheduleServiceInterface $scheduleService)
    {
        $rules = [
            'date' => 'required|date_format:"Y-m-d"',
            'doctor_id' => 'required|exists:users,id' //id que exista dentro de la tabla de usuarios.
        ];
        $this->validate($request, $rules);

        $date = $request->date;
        $doctorId = $request->doctor_id;

        return $scheduleService->getAvailableIntervals($date,$doctorId);
    }
}
