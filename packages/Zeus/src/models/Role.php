<?php

namespace Zeus\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function __str()
    {
        return $this->title;
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
