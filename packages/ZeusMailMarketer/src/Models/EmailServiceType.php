<?php

namespace ZeusMailMarketer\Models;

class EmailServiceType extends Base
{
    public $table = parent::TABLE_PREFIX . 'email_service_types';
    protected $fillable = ['name'];
    public function services()
    {
        return $this->hasMany(EmailService::class, 'type_id');
    }
}
