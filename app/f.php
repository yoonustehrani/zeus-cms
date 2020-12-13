<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailServiceType extends Model
{
    public function services()
    {
        return $this->hasMany(EmailService::class);
    }
}
