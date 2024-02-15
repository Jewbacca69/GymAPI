<?php

namespace Database\Factories;

use App\Models\Gym;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gymIds = Gym::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'gym_id' => $this->faker->randomElement($gymIds),
            'reservation_time' => '2024-02-15 15:00:00',
            // Define other attributes as needed
        ];
    }
}
