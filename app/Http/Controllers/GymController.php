<?php

namespace App\Http\Controllers;

use App\Http\Resources\GymResource;
use App\Models\Gym;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GymController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $gyms = Gym::all();

        return GymResource::collection($gyms);
    }

    public function show(int $id): GymResource
    {
        $gym = Gym::find($id);

        return new GymResource($gym);
    }
}
