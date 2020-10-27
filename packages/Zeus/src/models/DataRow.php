<?php

namespace Zeus\Models;

use Illuminate\Database\Eloquent\Model;

class DataRow extends Model
{
    protected $fillable = ['data_type_id', 'field', 'type', 'display_name', 'required', 'browse', 'read', 'edit', 'add', 'order', 'details'];
    public $timestamps = false;
    // public function setDetailsAttribute($details) {
    //     return json_encode($details);
    // }
}
