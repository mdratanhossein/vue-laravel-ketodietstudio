<?php

namespace App;

use Czim\Paperclip\Contracts\AttachableInterface;
use Czim\Paperclip\Model\PaperclipTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workout extends Model implements AttachableInterface
{
    use PaperclipTrait;

    protected $fillable = [
        'name',
        'level',
        'duration',
        'icon',
        'image_male',
        'image_female',
        'is_home'
    ];

    /**
     * @return HasMany
     */
    public function exercises(): HasMany
    {
        return $this->hasMany(WorkoutExercise::class);
    }

    /**
     * @return HasMany
     */
    public function histories(): HasMany
    {
        return $this->hasMany(WorkoutHistory::class);
    }

    /**
     * Workout constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('icon', [
            'path' => ':attachment/:id/:variant/:hash/:filename',
        ]);

        $this->hasAttachedFile('image_male', [
            'path' => ':attachment/:id/:variant/:hash/:filename',
        ]);

        $this->hasAttachedFile('image_female', [
            'path' => ':attachment/:id/:variant/:hash/:filename',
        ]);

        parent::__construct($attributes);
    }
}
