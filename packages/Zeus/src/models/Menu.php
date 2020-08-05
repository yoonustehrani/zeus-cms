<?php

namespace Zeus\Models;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }
    public function parent_items()
    {
        return $this->hasMany(MenuItem::class)->orderBy('order')->whereNull('parent_id');
    }

}
