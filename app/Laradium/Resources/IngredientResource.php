<?php

namespace App\Laradium\Resources;

use Laradium\Laradium\Base\AbstractResource;
use Laradium\Laradium\Base\FieldSet;
use Laradium\Laradium\Base\Resource;
use Laradium\Laradium\Base\ColumnSet;
use Laradium\Laradium\Base\Table;
use App\Ingredient;

class IngredientResource extends AbstractResource
{

    /**
     * @var string
     */
    protected $resource = Ingredient::class;

    /**
     * @return Resource
     */
    public function resource()
    {
        return (new Resource)->make(function (FieldSet $set) {
            $set->text('name');
        });
    }

     /**
     * @return Table
     */
    public function table()
    {
        return (new Table)->make(function (ColumnSet $column) {
            $column->add('id', '#ID');
            $column->add('name');
        });
    }
}
