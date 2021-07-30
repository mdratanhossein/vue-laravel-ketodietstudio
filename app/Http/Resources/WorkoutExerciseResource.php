<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutExerciseResource extends JsonResource
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
            'id'           => $this->id,
            'name'         => $this->exercise->name,
            'duration'     => $this->duration,
            'repetitions'  => $this->repetition,
            'order'        => $this->order,
            'video'        => $this->exercise->video,
            'image_male'   => $this->exercise->image_male->url(),
            'image_female' => $this->exercise->image_female->url(),
        ];
    }
}
