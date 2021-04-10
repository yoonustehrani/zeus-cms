<?php

namespace Zeus\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class File extends Model
{
    use SoftDeletes, SearchableTrait;

    protected $searchable = [
        'columns' => [
            'name' => 10,
            'path' => 8,
            'thumbnail_path' => 4,
        ],
    ];
}