<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Gym;
use App\Models\Reservation;
use App\Rules\WithinWorkingHours;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReservationController extends Controller
{
    public function index(int $gymId): JsonResponse|AnonymousResourceCollection
    {
        $reservation = Reservation::where('gym_id', $gymId)->get();

        if($reservation->isEmpty()){
            return response()->json(['message' => 'No reservations found.'], 404);
        }

        return ReservationResource::collection($reservation);
    }

    public function store(CreateReservationRequest $request, int $gymId): JsonResponse|ReservationResource
    {
        $gym = Gym::find($gymId);

        $request->validate([
            'reservation_time' => new WithinWorkingHours($gym->working_hours)
        ]);

        $validatedData = $request->validated();

        $reservationTime = $request->reservation_time;

        $reservation = Reservation::where('gym_id', $gymId)
            ->where('reservation_time', $reservationTime)->first();

        if($reservation){
            return response()->json(['message' => 'The chosen time slot is already reserved.'], 409);
        }

        $reservation = new Reservation();
        $reservation->user_id = $request->user_id;
        $reservation->gym_id = $gymId;
        $reservation->reservation_time = $validatedData['reservation_time'];
        $reservation->save();

        return response()->json([
            'message' => 'Reservation created successfully',
            'reservation' => new ReservationResource($reservation)
        ], 201);
    }

    public function show(int $gymId, int $reservationId): JsonResponse|ReservationResource
    {
        $reservation = Reservation::where('gym_id', $gymId)->where('id', $reservationId)->first();

        if(!$reservation){
            return response()->json(['message' => 'Reservation not found.'], 404);
        }

        return new ReservationResource($reservation);
    }

    public function destroy(int $gymId, int $reservationId): JsonResponse
    {
        $reservation = Reservation::where('gym_id', $gymId)->where('id', $reservationId)->first();

        if(!$reservation){
            return response()->json(['message' => 'Reservation not found.'], 404);
        }

        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}
