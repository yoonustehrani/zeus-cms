<?php

namespace Zeus\Models;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function file()
    {
        return $this->belongsTo(File::class);
    }
    public function photoable()
    {
        return $this->morphTo();
    }
}
