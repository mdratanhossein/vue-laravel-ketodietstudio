<?php

namespace App;

use Czim\Paperclip\Contracts\AttachableInterface;
use Czim\Paperclip\Model\PaperclipTrait;
use Illuminate\Database\Eloquent\Model;

class HelpArticle extends Model implements AttachableInterface
{
    use PaperclipTrait;

    protected $fillable = [
        'title',
        'image',
        'content'
    ];

    /**
     * Badge constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('image', [
            'path' => ':attachment/:id/:variant/:hash/:filename',
        ]);

        parent::__construct($attributes);
    }
}
