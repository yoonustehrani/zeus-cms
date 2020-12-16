<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailService extends Model
{
    protected $fillable = ['name', 'details'];
    public function type()
    {
        return $this->belongsTo(EmailServiceType::class);
    }
    public function getDetailsAttribute($details)
    {
        return (array) json_decode(decrypt($details));
    }
}
