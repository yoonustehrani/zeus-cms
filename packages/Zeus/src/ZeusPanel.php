<?php

namespace Zeus;

use Illuminate\Support\Str;
use Zeus\Models\DataType;

class ZeusPanel {
    public $extentions = [];
    protected $models = [
        'DataType' => DataType::class
    ];
    public function get_extentions()
    {
        return collect($this->extentions);
    }
    public function load_extentions()
    {
        $extentions = config('ZEC.extentions');
        foreach ($extentions as $ext_name => $ext_class) {
            app($ext_class)->register();
        }
    }
    public function model($name)
    {
        return app($this->models[Str::studly($name)]);
    }
    public function routes()
    {
        require __DIR__ . '/../src/routes/zeus.php';
    }
    protected function getSchema($model)
    {
        return $model->getConnection()->getSchemaBuilder();
    }
    public function getModel($abstract)
    {
        return app($abstract);
    }
    public function getModelColumns($model)
    {
        return $this->getSchema($model)->getTableColumns($model->getTable());
    }
    public function getModelColumnsWithType($model)
    {
        return $this->getSchema($model)->getTableColumns($model->getTable());
    }
    public function register_extention($name, $class, $conf_array)
    {
        $array = collect($this->extentions);
        $array->push(['name' => $name, 'class' => $class, 'routes_file' => $conf_array['routes_file'], 'routes' => $conf_array['route_prefix']]);
        $this->extentions = $array->toArray();
    }
}
