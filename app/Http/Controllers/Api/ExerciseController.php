<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkoutExerciseResource;
use App\WorkoutExercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * @param WorkoutExercise $workoutExercise
     * @return WorkoutExerciseResource
     */
    public function show(WorkoutExercise $workoutExercise)
    {
        return WorkoutExerciseResource::make($workoutExercise);
    }
}
