<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function __str()
    {
        return "{$this->key}" . ($this->table_name ? " - {$this->table_name}" : "");
    }
    //
}
