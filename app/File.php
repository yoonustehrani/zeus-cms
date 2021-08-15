<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Zeus\Models\File as ZeusFile;

class File extends ZeusFile
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
