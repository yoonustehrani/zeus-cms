<?php

namespace Zeus\Models;

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
        return $this->hasMany(DataRow::class);
    }
    public function columns()
    {
        return $this->hasMany(DataRow::class)->whereBrowse(true)->orderBy('order');
    }
    public function addRows()
    {
        return $this->hasMany(DataRow::class)->whereAdd(true)->orderBy('order');
    }
    public function getDetailsAttribute($details) {
        return json_decode($details);
    }
    public function setDetailsAttribute($details) {
        $this->attributes['details'] = json_encode($details);
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
            $row->display_name = $request_data["row_{$column}_display_name"]; // 
            $row->details = json_decode($request_data["row_{$column}_details"]) ?: [];
            // $row->details = json_encode($row->details);
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
            $row->display_name = $request_data["row_{$row->field}_display_name"]; // 
            $row->details = json_decode($request_data["row_{$row->field}_details"]) ?: [];
            // $row->details = json_encode($row->details);
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
        foreach ($details as $detaial) {
            $this->details = collect($this->details)->put($detaial, $request_data[$detaial] ?: null);
        }
    }
}
