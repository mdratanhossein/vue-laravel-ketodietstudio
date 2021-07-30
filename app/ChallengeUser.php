<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChallengeUser extends Model
{
    protected $fillable = [
        'date',
        'is_done',
        'user_id',
        'challenge_id',
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
    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }

    /**
     * @return BelongsTo
     */
    public function workout(): BelongsTo
    {
        return $this->belongsTo(Workout::class);
    }
}
