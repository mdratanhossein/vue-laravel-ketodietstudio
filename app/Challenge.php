<?php

namespace App;

use Czim\Paperclip\Contracts\AttachableInterface;
use Czim\Paperclip\Model\PaperclipTrait;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model implements AttachableInterface
{
    use PaperclipTrait;

    protected $fillable = [
        'name',
        'title',
        'description',
        'image_male',
        'image_female',
        'is_home'
    ];

    /**
     * Challenge constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('image_male', [
            'path' => ':attachment/:id/:variant/:hash/:filename',
        ]);

        $this->hasAttachedFile('image_female', [
            'path' => ':attachment/:id/:variant/:hash/:filename',
        ]);

        parent::__construct($attributes);
    }

}
