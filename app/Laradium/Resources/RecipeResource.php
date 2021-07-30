<?php

namespace App\Laradium\Resources;

use App\Ingredient;
use App\Models\Notify;
use App\Models\NotifyUser;
use App\Product;
use App\Step;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laradium\Laradium\Base\AbstractResource;
use Laradium\Laradium\Base\FieldSet;
use Laradium\Laradium\Base\Resource;
use Laradium\Laradium\Base\ColumnSet;
use Laradium\Laradium\Base\Table;
use App\Recipe;

class RecipeResource extends AbstractResource
{

    /**
     * @var string
     */
    protected $resource = Recipe::class;

    /**
     * @return Resource
     */
    public function resource()
    {
        $this->layout->assetManager()->js()->beforeCore([
            asset('js/components.js')
        ]);

        return (new Resource)->make(function (FieldSet $set) {
            $set->block()->fields(function (FieldSet $set) {
                $set->text('title')->rules('required|min:3|max:255');

                $set->belongsToManySelect('products')
                    ->columns([
                        'name',
                    ])
                    ->label('Tags')
                    ->title('name')
                    ->autocomplete(true);

                $set->belongsToManySelect('ingredients')
                    ->columns([
                        'name',
                    ])
                    ->label('Ingredients')
                    ->title('name')
                    ->fields(function (FieldSet $set) {
                        $set->number('count_metric')->rules('required|min:1|max:100');
                        $set->number('count_imperial')->rules('required|min:1|max:100');
                        $set->select('type_metric')->options([
                            'grams' => 'Grams',
                            'ml'    => 'ml',
                            'liter' => 'Liter',
                        ])->rules('required|in:gram,ml,l');
                        $set->select('type_imperial')->options([
                            'tablespoons' => 'Table spoon',
                            'teaspoons'   => 'Tea spoon',
                            'ounces'      => 'Ounces',
                            'cups'        => 'Cups',
                            'lb'          => 'Lb',
                            'gallons'     => 'Gallons',
                        ])->rules('required|in:tablespoon,teaspoon,oz,lb,gallon');
                    })
                    ->autocomplete(true)
                    ->col(6);

                $set->belongsToManySelect('nutrients')
                    ->columns([
                        'name',
                    ])
                    ->label('Nutrients')
                    ->title('name')
                    ->fields(function (FieldSet $set) {
                        $set->number('weight')->label('Weight (g)')->rules('required|min:1|max:100000');
                    })
                    ->autocomplete(true)
                    ->col(6);

                $set->number('prep_time')->label('Prepare time')->rules('required|min:1|max:3000')->col(3);
                $set->number('cook_time')->label('Cooking time')->rules('required|min:1|max:3000')->col(3);
                $set->number('total_time')->rules('required|min:1|max:3000')->col(3);
                $set->number('servings')->rules('required|min:1|max:3000')->col(3);

                $set->select('meal_type')->options([
                    0 => 'Breakfast',
                    1 => 'Morning snack',
                    2 => 'Lunch',
                    3 => 'Evening snack',
                    4 => 'Dinner',
                ])->rules('required|in:0,1,2,3,4')->col(6);

                $set->number('energy')->rules('required|min:1|max:10000')->col(6);
                $set->file('image')->rules('image|max:10000');
                $set->wysiwyg('content')->rules('required|min:3|max:10000');

                $set->hasMany('steps')->entryLabel('Step')->fields(function (FieldSet $set) {
                    $set->textarea('content')->rules('required|min:3|max:10000');
                });
            });
        });
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('query', '');
        $results = Product::where(function (Builder $builder) use ($query) {
            return $builder->where('name', explode(' ', $query))
                ->orWhere('name', 'like', '%' . $query . '%');
        })->get(['id', 'name']);

        return response()->json($results);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function searchI(Request $request): JsonResponse
    {
        $query = $request->get('query', '');
        $results = Ingredient::where(function (Builder $builder) use ($query) {
            return $builder->where('name', explode(' ', $query))
                ->orWhere('name', 'like', '%' . $query . '%');
        })->get(['id', 'name']);

        return response()->json($results);
    }

    /**
     * @return Table
     */
    public function table()
    {
        return (new Table)->make(function (ColumnSet $column) {
            $column->add('id', '#ID');
            $column->add('title');
            $column->add('products')->modify(function ($recipe) {
                $products = '';
                $i = 0;
                foreach ($recipe->products as $product) {
                    $products .= $i != 0 ? ',' . $product->name : $product->name;
                    $i++;
                }

                return $products;
            })->notSortable()->notSearchable();
            $column->add('meal_type', 'Time')->modify(function ($recipe) {
                switch ($recipe->meal_type) {
                    case 0:
                        return 'Breakfast';
                        break;
                    case 1:
                        return 'Morning snack';
                        break;
                    case 2:
                        return 'Lunch';
                        break;
                    case 3:
                        return 'Evening snack';
                        break;
                    case 4:
                        return 'Dinner';
                        break;
                }
            });
            $column->add('prep_time', 'Preparation');
            $column->add('energy', 'Energy(KCAL)');
        });
    }
}
