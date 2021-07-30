<?php

namespace App\Http\Controller\Api;

use App\Http\Requests\UserKeyValidate;
use App\Http\Requests\ValidateSettings;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    /**
     * @param UserKeyValidate $request
     * @return JsonResponse
     */
    public function index(UserKeyValidate $request): JsonResponse
    {
        $user = User::where('key', $request->get('key'))->first();

        return response()->json([
            'training_days' => $user->training_days,
            'first_day'     => $user->first_day,
        ]);
    }

    /**
     * @param ValidateSettings $request
     * @return JsonResponse
     */
    public function update(ValidateSettings $request): JsonResponse
    {
        $user = User::where('key', $request->get('key'))->first();

        $user->update([
            'training_days' => $request->get('training_days'),
            'first_day'     => $request->get('first_day'),
        ]);

        return response()->json([
            'msg' => 'Settings saved'
        ]);
    }
}
