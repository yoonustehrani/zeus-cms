<?php

namespace Zeus\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Zeus\Database\Schema\ZeusSchemaManager;

class DataType extends Model
{
    // protected $hidden = ['generate_permission', 'server_side'];
    protected $fillable = [
        'name',
        'slug',
        'display_name_singular',
        'display_name_plural',
        'icon',
        'model_name',
        'policy_name',
        'controller',
        'description',
        'generate_permission',
        'server_side',
        'order_column',
        'order_direction',
        'default_search_key',
        'scope',
        'details',
    ];
    public $visibility = [
        'browse' => 'field will show up when you browse the current data',
        'read' => 'field will show when you click to view the current data',
        'edit' => 'field will be visible and allow you to edit the data',
        'add'  => 'field will be visible when you choose to create a new data type'
    ];
    public function rows()
    {
        return $this->hasMany(DataRow::class)->with('relationship');
    }
    public function columns()
    {
        return $this->rows()->whereBrowse(true)->orderBy('order');
    }
    public function add_rows()
    {
        return $this->rows()->whereAdd(true)->orderBy('order');
    }
    public function edit_rows()
    {
        return $this->rows()->whereEdit(true)->orderBy('order');
    }
    public function getDetailsAttribute($details)
    {
        // $details = $this->excludeFromDetails(collect(json_decode($details)));
        return json_decode($details);
    }
    public function setDetailsAttribute($details)
    {
        $this->attributes['details'] = json_encode(json_decode($details));
    }
    public function createDataRows($request_data)
    {
        $order = 0;
        foreach ($this->getColumns() as $column) {
            $row = new DataRow();
            $row->required = isset($request_data["row_{$column}_required"]) ? true : false; 
            $row->type = $request_data["row_{$column}_type"];
            $row->field = $column;
            $row->order = $order;
            $row->display_name = $request_data["row_{$column}_display_name"];
            $row->details = json_decode($request_data["row_{$column}_details"]) ?: [];
            foreach ($this->visibility as $visibility => $description) {
                $row->{$visibility} = isset($request_data["row_{$column}_{$visibility}"]) ? true : false;
            }
            $this->rows()->create($row->toArray());
            $order++;
        }
    }
    public function updateDataRows($request_data)
    {
        foreach ($this->rows as $row) {
            $row->type = $request_data["row_{$row->field}_type"];
            $row->display_name = $request_data["row_{$row->field}_display_name"];
            $row->details = json_decode($request_data["row_{$row->field}_details"]) ?: [];
            foreach ($this->visibility as $visibility => $description) {
                $row->{$visibility} = isset($request_data["row_{$row->field}_{$visibility}"]) ? true : false;
            }
            $row->save();
        }
    }
    public function getColumns()
    {
        return ZeusSchemaManager::listTableColumnNames($this->slug);
    }
    public function pushToDetails($request_data)
    {
        $details = ['order_column','order_direction','default_search_key','scope'];
        foreach ($details as $detail) {
            $assigned = $request_data[$detail] ?: null;
            $this->details = collect($this->details)->put($detail, $assigned);
        }
    }
    public function excludeFromDetails($details_array)
    {
        $detail_keys = ['order_column','order_direction','default_search_key','scope'];
        foreach ($detail_keys as $detail_key) {
            $details_array->pull($detail_key);
        }
        return $details_array;
    }
    public function validation_rules($rows)
    {
        $validation = collect([]);
        foreach ($rows as $row) {
            $rules = [];
            $should_be_added = false;
            if ($row->required) {
                array_push($rules, 'required');
                $should_be_added = true;
            }
            if ($row->type == 'password') {
                array_push($rules, 'confirmed');
            }
            $key_value_rules = ['min', 'max'];
            foreach ($key_value_rules as $rule) {
                if ($row->details && isset($row->details->validation) && isset($row->details->validation->{$rule})) {
                    $value = $row->details->validation->{$rule};
                    array_push($rules, "{$rule}:{$value}");
                    $should_be_added = true;
                }
            }
            if ($should_be_added) {
                $validation->put($row->field, implode('|', $rules));
            }
        }
        return $validation->toArray();
    }
    public function assign_value_to_instance($model, $rows, $request)
    {
        foreach ($rows as $row) {
            if ($request->{$row->field}) {
                switch ($row->type) {
                    case 'checkbox':
                        $model->{$row->field} = !! $request->{$row->field};
                        break;
                    case 'datetime':
                        $date = (new Carbon(
                            ((int) $request->{$row->field}) / 1000
                        ))->timezone(config('ZEC.package.timezone'));
                        $model->{$row->field} = $date->format(config('ZEC.database.date_format'));
                        break;
                    case 'selectbox':
                        if ($row->relationship) {
                            $target = \Zeus::getModel($row->details->target_model)::whereId($request->{$row->field})->firstOrFail();
                            $model->{$row->details->target_method}()->associate($target);
                        }
                        break;
                    default:
                        if (! $row->relationship) {
                            $model->{$row->field} = $request->{$row->field};
                        }
                        break;
                }
            }
        }
        return $model;
    }
    public function assign_relationships($model, $rows, $request)
    {
        foreach ($rows as $row) {
            if ($request->{$row->field} && $row->relationship && !$row->relationship->dynamic) {
                switch ($row->type) {
                    case 'relationship__belongsToMany':
                        $model->{$row->details->target_method}()->sync($request->input($row->field));
                        break;
                    case 'relationship__morphToMany':
                        $items = collect([]);
                        foreach ($request->input($row->field) as $item) {
                            $items->put($item, [
                                // 'alt' => \Illuminate\Support\Str::random(rand(5,20)),
                                // 'title' => \Illuminate\Support\Str::random(rand(3, 8))
                            ]);
                        }
                        $model->{$row->details->target_method}()->withTimestamps()->sync($items->toArray());
                        break;
                }
            }
        }
        return true;
    }
}
