<?php

namespace App;

use Czim\Paperclip\Contracts\AttachableInterface;
use Czim\Paperclip\Model\PaperclipTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model implements AttachableInterface
{
    use PaperclipTrait;

    protected $fillable = [
        'title',
        'image',
        'meal_type',
        'prep_time',
        'cook_time',
        'total_time',
        'servings',
        'energy',
        'content'
    ];

    /**
     * @return BelongsToMany
     */
    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class,'product_recipe');
    }

    /**
     * @return BelongsToMany
     */
    public function ingredients(): belongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient')
                    ->withPivot('count_metric', 'type_metric','count_imperial','type_imperial');
    }

    /**
     * @return BelongsToMany
     */
    public function nutrients(): belongsToMany
    {
        return $this->belongsToMany(Nutrient::class, 'recipe_nutrient')
            ->withPivot('weight');
    }

    /**
     * @return BelongsToMany
     */
    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class);
    }


    /**
     * @return HasMany
     */
    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }

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
