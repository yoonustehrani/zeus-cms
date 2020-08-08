<?php

namespace Zeus\Models;

use Illuminate\Database\Eloquent\Model;

class DataType extends Model
{
    protected $hidden = ['generate_permission', 'server_side'];
    public function rows()
    {
        return $this->hasMany(DataRow::class);
    }
    public function columns()
    {
        return $this->hasMany(DataRow::class)->whereBrowse(true)->orderBy('order');
    }
}
