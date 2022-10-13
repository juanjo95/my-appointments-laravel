<?php

namespace Database\Seeders;

use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = ["Oftalmologia","Odontoliga","Pediatria","Neurologia"];

        foreach ($specialties as $specialtyName) {
            $specialty = Specialty::create([
                'name' => $specialtyName
            ]);
        }

        //Medico test con id 3
        User::find(3)->specialties()->save($specialty);

    }
}
