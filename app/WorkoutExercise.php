<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutExercise extends Model
{
    protected $fillable = [
        'workout_id',
        'exercise_id',
        'duration',
        'repetition',
        'order',
        'is_home',
    ];

    /**
     * @return BelongsTo
     */
    public function workout(): BelongsTo
    {
        return $this->belongsTo(Workout::class);
    }

    /**
     * @return BelongsTo
     */
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
