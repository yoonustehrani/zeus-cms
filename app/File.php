<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function __str()
    {
        return "{$this->name}.{$this->ext}";
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
