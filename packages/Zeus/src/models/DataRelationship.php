<?php

namespace Zeus\Models;

use Illuminate\Database\Eloquent\Model;

class DataRelationship extends Model
{
    protected $fillable = ['type', 'local_method', 'target_route'];
    public $timestamps = false;
    public function data_row()
    {
        return $this->belongsTo(DataRow::class);
    }
}
