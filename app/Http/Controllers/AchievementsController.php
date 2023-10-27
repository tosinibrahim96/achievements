<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserAchievementResource;
use App\Models\User;
use Illuminate\Http\Response;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        return response()->json(
            [
                'status' => true,
                'message' => "Achievement details retrieved successfully",
                'data' => UserAchievementResource::make($user)
            ],
            Response::HTTP_OK
        );
    }
}
