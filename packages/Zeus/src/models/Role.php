<?php

namespace Zeus\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Role extends Model
{
    use SearchableTrait;
    protected $searchable = [
        'columns' => [
            'title' => 10,
            'name' => 8,
        ],
    ];
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
