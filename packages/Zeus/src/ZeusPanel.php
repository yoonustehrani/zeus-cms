<?php

namespace Zeus;

class ZeusPanel {
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
