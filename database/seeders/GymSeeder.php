<?php

namespace Database\Seeders;

use App\Models\Gym;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $gyms = [
            [
                'name' => 'Gym 1',
                'working_hours' => '10:00-21:00',
            ],
            [
                'name' => 'Gym 2',
                'working_hours' => '12:00-22:00',
            ],
            [
                'name' => 'Gym 3',
                'working_hours' => '9:00-19:00',
            ],
        ];

        foreach ($gyms as $gym) {
            Gym::create($gym);
        }
    }
}
