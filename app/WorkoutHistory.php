<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutHistory extends Model
{
    protected $fillable = [
        'duration',
        'kcal',
        'user_id',
        'workout_id',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function workout(): BelongsTo
    {
        return $this->belongsTo(Workout::class);
    }

}
