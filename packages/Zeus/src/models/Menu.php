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
    public function generate_order()
    {
        $last_item = $this->parent_items()->orderBy('order', 'desc')->limit(1)->first();
        return isset($last_item[0]) ? $last_item->order + 1 : 0;
    }
}
