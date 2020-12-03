<?php

namespace Zeus\Models;

use Illuminate\Database\Eloquent\Model;

class Extention extends Model
{
    protected $fillable = [];
    public function getDetailsAttribute($details) {
        return json_decode($details);
    }
    public function setDetailsAttribute($details) {
        $this->attributes['details'] = json_encode($details);
    }
}
