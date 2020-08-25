<?php

namespace Lit\Crud\Repositories;

use Lit\Crud\CrudValidator;
use Lit\Crud\Fields\Block\Block;
use Lit\Crud\Models\Repeatable;
use Lit\Crud\Requests\CrudReadRequest;
use Lit\Crud\Requests\CrudUpdateRequest;
use Illuminate\Http\Request;

class BlockRepository extends BaseFieldRepository
{
    /**
     * Block field instance.
     *
     * @var Block
     */
    protected $field;

    /**
     * Create new BlockRepository instance.
     */
    public function __construct($config, $controller, $form, Block $field)
    {
        parent::__construct($config, $controller, $form, $field);
    }

    /**
     * Load repeatable.
     *
     * @param  CrudReadRequest $request
     * @param  mixed           $model
     * @return CrudJs
     */
    public function load(CrudReadRequest $request, $model)
    {
        return crud(
            $this->getRepeatable($model, $request->repeatable_id)
        );
    }

    /**
     * Fetch all repeatables.
     *
     * @param  CrudReadRequest $request
     * @param  mixed           $model
     * @return CrudJs
     */
    public function index(CrudReadRequest $request, $model)
    {
        return crud($this->field->getResults($model));
    }

    /**
     * Destroy repeatable.
     *
     * @param  CrudUpdateRequest $request
     * @param  mixed             $model
     * @return void
     */
    public function destroy(CrudUpdateRequest $request, $model)
    {
        $this->getRepeatable($model, $request->repeatable_id ?? 0)->delete();
    }

    /**
     * Update repeatable.
     *
     * @param  CrudUpdateRequest $request
     * @param  mixed             $model
     * @param  object            $payload
     * @return CrudJs
     */
    public function update(CrudUpdateRequest $request, $model, $payload)
    {
        $type = $request->repeatable_type;

        $repeatableModel = $this->getRepeatable($model, $request->repeatable_id ?? 0);

        $repeatable = $this->field->getRepeatable($type) ?:
            abort(404, debug("Repeatable [{$type}] not found for block field [{$this->field->id}]"));

        CrudValidator::validate(
            (array) $payload,
            $repeatable->getForm(),
            CrudValidator::UPDATE
        );

        $attributes = $this->formatAttributes((array) $payload, $repeatable->getRegisteredFields());

        $repeatableModel->update($attributes);

        return crud($repeatable);
    }

    /**
     * Store new repeatable in database.
     *
     * @param  CrudUpdateRequest $request
     * @param  mixed             $model
     * @param  object            $payload
     * @return CrudJs
     */
    public function store(CrudUpdateRequest $request, $model, $payload)
    {
        $type = $payload->repeatable_type ?? null;
        $this->field->hasRepeatable($type)
            ?: abort(404, debug("Repeatable [{$type}] not found on block [{$this->field->id}]"));

        $order_column = $this->getOrderColumnForNewRepeatable($request, $model, $type);

        $block = new Repeatable();
        $block->type = $type;
        $block->model_type = get_class($model);
        $block->model_id = $model->id;
        $block->field_id = $this->field->id;
        $block->config_type = get_class($this->config->getConfig());
        $block->form_type = $request->form_type;
        $block->order_column = $order_column;
        $block->save();

        return crud($block);
    }

    /**
     * Update repeatable order.
     *
     * @param  CrudUpdateRequest $request
     * @param  mixed             $model
     * @param  object            $payload
     * @return mixed
     */
    public function order(CrudUpdateRequest $request, $model, $payload)
    {
        validator()->validate((array) $payload, [
            'ids' => 'required|array',
        ], __lit('validation'));

        $query = $this->field->getRelationQuery($model);

        return $this->orderField($query, $this->field, $payload->ids);
    }

    /**
     * Get child field.
     *
     * @param  Request    $request
     * @param  string     $field_id
     * @return Field|null
     */
    public function getField(Request $request, $field_id)
    {
        if ($repeatable = $this->field->getRepeatable($request->repeatable_type)) {
            if ($field = $repeatable->findField($field_id)) {
                return $field;
            }
        }

        foreach ($this->field->repeatables->repeatables as $repeatable) {
            foreach ($repeatable->getRegisteredFields() as $field) {
                if (! $field instanceof Block) {
                    continue;
                }

                if (! $childRepeatable = $field->getRepeatable($request->repeatable_type)) {
                    continue;
                }

                if ($childField = $repeatable->findField($field_id)) {
                    return $childField;
                }

                if ($childField = $childRepeatable->findField($field_id)) {
                    return $childField;
                }
            }
        }

        abort(404, debug("Missing [{$request->repeatable_type}] repeatable."));
    }

    /**
     * Get repeatable model.
     *
     * @param  Request   $request
     * @param  mixed     $model
     * @return Repeatable
     */
    public function getModel(Request $request, $model, $childRepository)
    {
        if (! $request->child_repeatable_id || $request->child_repeatable_id == $request->repeatable_id) {
            return $this->getRepeatable($model, $request->repeatable_id);
        }

        $childRepeatable = $this->getRepeatable($model, $request->child_repeatable_id);

        if ($childRepository instanceof self) {
            return $childRepeatable;
        }

        // Loading child block for media and relation requests.
        return Repeatable::where('model_type', Repeatable::class)
            ->where('model_id', $childRepeatable->id)
            ->where('id', $request->repeatable_id)->firstOrFail();
    }

    /**
     * Get order column for new repeatable.
     *
     * @param  Request $request
     * @param  mixed   $model
     * @param  string  $type
     * @return int
     */
    protected function getOrderColumnForNewRepeatable(Request $request, $model, $type)
    {
        return Repeatable::where([
            'type'        => $type,
            'model_type'  => get_class($model),
            'model_id'    => $model->id,
            'field_id'    => $this->field->id,
            'config_type' => get_class($this->config->getConfig()),
        ])->count();
    }

    /**
     * Get repeatable.
     *
     * @param  mixed      $model
     * @param  int|string $id
     * @return Repeatable
     */
    protected function getRepeatable($model, $id)
    {
        return $model->{$this->field->id}()->findOrFail($id);
    }
}
