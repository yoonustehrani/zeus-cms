<?php

namespace Zeus\Models;

use Illuminate\Database\Eloquent\Model;

class DataRow extends Model
{
    protected $hidden = ['data_type_id','order'];
}
