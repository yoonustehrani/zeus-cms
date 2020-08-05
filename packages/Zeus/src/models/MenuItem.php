<?php

namespace Zeus\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    public $timestamps = false;

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->with('children')->orderBy('order');
    }
}
