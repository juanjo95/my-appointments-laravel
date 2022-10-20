<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'specialty_id',
        'doctor_id',
        'patient_id',
        'scheduled_date',
        'scheduled_time',
        'type'
    ];

    //Permitir acceder desde un appointment a la especialidad asociada N-appointment --> 1-specialty
    public function specialty(){
        return $this->belongsTo(Specialty::class);
    }

    //N-Appointment->1-doctor
    public function doctor(){
        return $this->belongsTo(User::class);
    }

    //N-Appointment->1-patient
    public function patient(){
        return $this->belongsTo(User::class);
    }

    //Accesor $appointment->scheduled_time_12
    public function getScheduledTime12Attribute()
    {
        $time = new Carbon($this->scheduled_time);
        return $time->format('g:i A');
    }
}
