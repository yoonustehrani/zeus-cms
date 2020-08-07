<?php

namespace Zeus\Models;

use Illuminate\Database\Eloquent\Model;

class DataType extends Model
{
    public function rows()
    {
        return $this->hasMany(DataRow::class);
    }
}
