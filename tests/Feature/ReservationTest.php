<?php

namespace Tests\Feature;

use App\Models\Gym;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    public function test_it_can_show_a_reservation(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->getJson(route('gyms.reservations.show', ['gym' => $reservation->gym_id, 'reservation' => $reservation->id]));

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'id' => $reservation->id,
                'user_id' => $reservation->user_id,
                'gym_id' => $reservation->gym_id,
                'reservation_time' => $reservation->reservation_time,
            ],
        ]);
    }

    public function test_it_cannot_show_a_reservation_that_does_not_exist(): void
    {
        $response = $this->getJson(route('gyms.reservations.show', ['gym' => 1, 'reservation' => 1]));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'Reservation not found.']);
    }

    public function test_it_can_list_all_reservations_for_a_gym(): void
    {
        $gym = Gym::factory()->create();

        Reservation::factory()->count(3)->create([
            'gym_id' => $gym->id,
        ]);

        $response = $this->getJson(route('gyms.reservations.index', ['gym' => $gym->id]));

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');
    }

    public function test_it_can_create_a_reservation(): void
    {
        $gym = Gym::factory()->create();

        $user = User::factory()->create();

        $response = $this->postJson(route('gyms.reservations.store', ['gym' => $gym->id]), [
            'user_id' => $user->id,
            'reservation_time' => '2024-02-15 15:00:00',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'gym_id' => $gym->id,

            'reservation_time' => '2024-02-15 15:00:00',
        ]);
    }
    public function test_it_cannot_create_a_reservation_for_an_already_reserved_time_slot(): void
    {
        $gym = Gym::factory()->create();

        User::factory()->create();

        Reservation::factory()->create([
            'gym_id' => $gym->id,
            'reservation_time' => '2024-02-17 14:00:00',
        ]);

        $response = $this->postJson(route('gyms.reservations.store', ['gym' => $gym->id]), [
            'user_id' => 1,
            'reservation_time' => '2024-02-17 14:00:00',
        ]);

        $response->assertStatus(409);

        $response->assertJson([
            'message' => 'The chosen time slot is already reserved.',
        ]);
    }

    public function test_it_can_delete_a_reservation(): void
    {
        $gym = Gym::factory()->create();

        $user = User::factory()->create();

        $reservation = Reservation::factory()->create([
            'gym_id' => $gym->id,
            'user_id' => $user->id,
        ]);

        $response = $this->deleteJson(route('gyms.reservations.destroy', ['gym' => $gym->id, 'reservation' => $reservation->id]));

        $response->assertJson(['message' => 'Reservation deleted successfully']);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('reservations', [
            'id' => $reservation->id,
        ]);
    }

    public function test_it_cannot_delete_a_reservation_that_does_not_exist(): void
    {
        $gym = Gym::factory()->create();

        $response = $this->deleteJson(route('gyms.reservations.destroy', ['gym' => $gym->id, 'reservation' => 1]));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'Reservation not found.']);
    }
}
