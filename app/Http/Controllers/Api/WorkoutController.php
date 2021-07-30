<?php

namespace App\Http\Controllers\Api;

use App\Challenge;
use App\Exercise;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserKeyValidate;
use App\Http\Requests\WorkoutEndValidate;
use App\Http\Resources\ChallengeResource;
use App\Http\Resources\WorkoutIndexResource;
use App\Http\Resources\WorkoutResource;
use App\User;
use App\Workout;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    /**
     * @param UserKeyValidate $request
     * @return JsonResponse
     */
    public function index(UserKeyValidate $request): JsonResponse
    {
        $weekly = [];
        $now = Carbon::now();
        $user = User::where('key', $request->get('key'))->first();

        for ($i = 0; $i < 7; $i++) {
            $weekStartDate = $now->startOfWeek();
            $day = $weekStartDate->addDays($i);

            $check = $user->workoutHistories()->where('created_at', 'like', $day->format('Y-m-d') . '%')->count() > 0;
            $weekly[] = [
                'day'  => $day->day,
                'done' => $check
            ];
        }

        return response()->json([
            'user_name'    => $user->name,
            'workout'      => $user->workoutHistories()->count(),
            'kcal'         => $user->workoutHistories()->sum('kcal'),
            'minute'       => $user->workoutHistories()->sum('duration'),
            'challenges'   => ChallengeResource::collection(Challenge::where('is_home', 1)->get()),
            'workouts'     => WorkoutResource::collection(Workout::where('is_home', 1)->get()),
            'weekly_goals' => $weekly,
        ]);
    }

    /**
     * @param Workout $workout
     * @return WorkoutIndexResource
     */
    public function show(Workout $workout)
    {
        return WorkoutIndexResource::make($workout);
    }

    /**
     * @param WorkoutEndValidate $request
     * @param Workout $workout
     * @return JsonResponse
     */
    public function store(WorkoutEndValidate $request, Workout $workout): JsonResponse
    {
        $user = User::where('key', $request->get('key'))->first();

        $user->workoutHistories()->create([
            'workout_id' => $workout->id,
            'duration'   => $request->get('duration'),
            'kcal'       => $request->get('kcal'),
        ]);

        return response()->json([
            'msg' => 'Workout history saved'
        ]);
    }

    /**
     * @param Exercise $exercise
     * @return JsonResponse
     */
    public function preview(Exercise $exercise): JsonResponse
    {
        return response()->json([
            'name'         => $exercise->name,
            'description'  => $exercise->description,
            'video'        => $exercise->video,
            'image_male'   => $exercise->image_male->url(),
            'image_female' => $exercise->image_female->url(),
        ]);
    }
}
