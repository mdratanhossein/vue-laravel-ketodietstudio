<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserKeyValidate;
use App\Http\Requests\ValidateSettings;
use App\Http\Requests\ValidateWorkoutSettings;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkoutSettingController extends Controller
{
    /**
     * @param UserKeyValidate $request
     * @return JsonResponse
     */
    public function index(UserKeyValidate $request): JsonResponse
    {
        $user = User::where('key', $request->get('key'))->first();

        if (!$user->settings) {
            $user->settings()->create([]);
        }

        return response()->json([
            'training_rest'   => $user->settings()->training_rest,
            'countdown_time'  => $user->settings()->countdown_time,
            'metric_imperial' => $user->settings()->metric_imperial,
        ]);
    }

    /**
     * @param ValidateWorkoutSettings $request
     * @return JsonResponse
     */
    public function update(ValidateWorkoutSettings $request): JsonResponse
    {
        $user = User::where('key', $request->get('key'))->first();

        $user->settings()->update([
            'metric_imperial' => $request->get('metric_imperial'),
            'training_rest'     => $request->get('training_rest'),
            'countdown_time'     => $request->get('countdown_time'),
        ]);

        return response()->json([
            'msg' => 'Settings saved'
        ]);
    }
}
