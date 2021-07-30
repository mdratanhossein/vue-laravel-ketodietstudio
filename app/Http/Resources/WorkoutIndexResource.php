<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'level'          => $this->level,
            'image_male'     => $this->image_male->url(),
            'image_female'   => $this->image_female->url(),
            'duration'       => $this->exercises()->sum('duration'),
            'exercise_count' => $this->exercises()->count(),
            'exercises'      => WorkoutExerciseResource::collection($this->exercises)
        ];
    }
}
