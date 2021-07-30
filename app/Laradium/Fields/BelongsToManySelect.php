<?php

namespace App\Laradium\Fields;

use Illuminate\Database\Eloquent\Model;
use Laradium\Laradium\Base\Field;
use Laradium\Laradium\Base\Fields\BelongsToMany;
use Laradium\Laradium\Base\FieldSet;

class BelongsToManySelect extends BelongsToMany
{
    /**
     * @var string
     */
    private $relationName;

    /**
     * @var string
     */
    private $title = 'name';

    /**
     * @var
     */
    private $items;

    /**
     * @var
     */
    protected $where;

    /**
     * @var FieldSet
     */
    protected $fieldSet;

    /**
     * @var bool
     */
    protected $disabled = false;

    /**
     * @var array
     */
    protected $links = [];

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var bool
     */
    protected $autoComplete = false;

    /**
     * @var string|null
     */
    protected $notSelectedMessage;

    /**
     * @var null|integer
     */
    protected $maxItems;

    /**
     * BelongsToMany constructor.
     * @param $parameters
     * @param Model $model
     */
    public function __construct($parameters, Model $model)
    {
        parent::__construct($parameters, $model);

        $this->relationName = array_first($parameters);
        $this->fieldSet = new FieldSet;
    }

    /**
     * @param array $attributes
     * @return $this|Field
     */
    public function build($attributes = [])
    {
        parent::build($attributes);

        $model = $this->getModel();
        $relationModel = $model->{$this->relationName}()->getModel();
        $items = $relationModel;

        if ($where = $this->getWhere()) {
            $items = $items->where($where);
        }

        $items = $items->get();

        $this->items = $items->map(function ($item) use ($model) {
            $isSelected = false;
            if ($pivot = $model->{$this->relationName}->where('id', $item->id)->first()) {
                $isSelected = true;
            }

            $item = $item->toArray();
            $item['is_selected'] = $isSelected;
            $item['fields'] = $this->getTemplateData($pivot, $item['id'])['fields'];

            return $item;
        });

        $this->validationRules($this->getTemplateData()['validation_rules']);

        return $this;
    }

    /**
     * @return array
     */
    public function formattedResponse(): array
    {
        $data = parent::formattedResponse();
        $data['value'] = BelongsToMany::class;
        $data['items'] = $this->items;
        $data['extended_name'] = 'belongstomany';
        $data['pivot_fields'] = $this->getTemplateData()['fields'];
        $data['config']['title_property'] = $this->title;
        $data['config']['field_col'] = $this->fieldCol;
        $data['config']['disabled'] = $this->disabled;
        $data['config']['links'] = $this->links;
        $data['config']['columns'] = $this->columns;
        $data['config']['auto_complete'] = $this->autoComplete;
        $data['config']['max_items'] = $this->maxItems;
        $data['config']['not_selected_message'] = $this->notSelectedMessage;

        return $data;
    }

    /**
     * @param $value
     * @return $this
     */
    public function title($value): self
    {
        $this->title = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function disabled($value = true): self
    {
        $this->disabled = $value;

        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function links($value): self
    {
        $this->links = $value;

        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function columns($value): self
    {
        $this->columns = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function autoComplete($value = true): self
    {
        $this->autoComplete = $value;

        return $this;
    }

    /**
     * @param $closure
     * @return $this
     */
    public function fields($closure): self
    {
        $fieldSet = $this->fieldSet;
        $fieldSet->model($this->getModel());
        $closure($fieldSet);

        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function maxItems($value): self
    {
        $this->maxItems = $value;

        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function notSelectedMessage($value): self
    {
        $this->notSelectedMessage = $value;

        return $this;
    }

    /**
     * @param null $model
     * @param null $id
     * @return array
     */
    private function getTemplateData($model = null, $id = null): array
    {
        $fields = [];
        $validationRules = [];

        foreach ($this->fieldSet->fields as $temporaryField) {
            $field = clone $temporaryField;

            $field->model($model)
                ->value($model ? $model->pivot->{$field->getFieldName()} : '')
                ->build(array_merge($this->getAttributes(), ['pivot', $id]));

            if ($field->getRules()) {
                $validationRules[$field->getValidationKey()] = $field->getRules();
            }

            $response = $field->formattedResponse();
            $response['field_name'] = $field->getFieldName();

            $fields[] = $response;
        }

        return [
            'fields'           => $fields,
            'validation_rules' => $validationRules
        ];
    }
}
