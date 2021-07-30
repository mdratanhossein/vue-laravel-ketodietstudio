<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChallengeWorkout extends Model
{
    protected $fillable = [
        'challenge_id',
        'workout_id',
        'week',
        'day',
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
    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }
}
