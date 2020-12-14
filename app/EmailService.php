<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailService extends Model
{
    public function type()
    {
        return $this->belongsTo(EmailServiceType::class);
    }
}
