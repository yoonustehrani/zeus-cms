<?php

namespace ZeusMailMarketer\Models;

class EmailService extends Base
{
    public $table = parent::TABLE_PREFIX . 'email_services';
    protected $fillable = ['name', 'details'];
    public function type()
    {
        return $this->belongsTo(EmailServiceType::class);
    }
    public function getDetailsAttribute($details)
    {
        return json_decode(decrypt($details));
    }
    public function setDetailsAttribute($details)
    {
        $this->attributes['details'] = encrypt($details);
    }
}
