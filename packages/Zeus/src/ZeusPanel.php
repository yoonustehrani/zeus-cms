<?php

namespace Zeus;

use Illuminate\Support\Str;
use Zeus\Models\DataType;

class ZeusPanel {
    protected $models = [
        'DataType' => DataType::class
    ];
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
}
