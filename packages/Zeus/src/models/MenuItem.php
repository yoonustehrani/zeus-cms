<?php

namespace Zeus\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'order', 'url', 'target', 'menu_id', 'icon_class', 'parent_id', 'route', 'parameters'];
    
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->with('children')->orderBy('order');
    }
}
