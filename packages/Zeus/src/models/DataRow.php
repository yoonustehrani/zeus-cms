<?php

namespace Zeus\Models;

use Illuminate\Database\Eloquent\Model;

class DataRow extends Model
{
    protected $fillable = ['data_type_id', 'field', 'type', 'display_name', 'required', 'browse', 'read', 'edit', 'add', 'order', 'details'];
    public $timestamps = false;
    public function getDetailsAttribute($details) {
        return json_decode($details);
    }
    public function setDetailsAttribute($details) {
        $this->attributes['details'] = json_encode($details);
    }
    public function relationship()
    {
        return $this->hasOne(DataRelationship::class,);
    }
}
