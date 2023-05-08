<?php

namespace Database\Seeders;

use App\Models\BussinesHour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BussinesHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $days=config('appointment.days');


        foreach($days as $day){
            BussinesHour::query()->updateOrCreate(
                [
                    'day' => $day,
                ],[
                    'from' =>'09:00',
                    'to' =>'17:00',
                    'step'=>30
                ]
            );
        }
    }
}
