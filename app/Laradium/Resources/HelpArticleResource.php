<?php

namespace App\Laradium\Resources;

use Laradium\Laradium\Base\AbstractResource;
use Laradium\Laradium\Base\FieldSet;
use Laradium\Laradium\Base\Resource;
use Laradium\Laradium\Base\ColumnSet;
use Laradium\Laradium\Base\Table;
use App\HelpArticle;

class HelpArticleResource extends AbstractResource
{

    /**
     * @var string
     */
    protected $resource = HelpArticle::class;

    /**
     * @return Resource
     */
    public function resource()
    {
        return (new Resource)->make(function (FieldSet $set) {
            $set->block()->fields(function (FieldSet $set) {
                $set->text('title')->rules('required|min:3');
                $set->wysiwyg('content')->rules('required|min:3|max:10000');
                $set->file('image')->rules('image|max:10000');
            });
        });
    }

     /**
     * @return Table
     */
    public function table()
    {
        return (new Table)->make(function (ColumnSet $column) {
            $column->add('id', '#ID');
            $column->add('title');
            $column->add('content');
        });
    }
}