<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    /* Una especialidad se asocia con multiples medicos, $specialty->users acceder a la lista de medicos que estan asociados a esta especialidad */
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
