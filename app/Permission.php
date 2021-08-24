<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Zeus\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    public function __str()
    {
        return "{$this->key}" . ($this->table_name ? " - {$this->table_name}" : "");
    }
    //
}
