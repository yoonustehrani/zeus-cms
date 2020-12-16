<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailServiceType extends Model
{
    protected $fillable = ['name'];
    public function services()
    {
        return $this->hasMany(EmailService::class, 'type_id');
    }
}
