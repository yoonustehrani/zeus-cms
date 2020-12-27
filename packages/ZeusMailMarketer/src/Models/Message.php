<?php

namespace ZeusMailMarketer\Models;

class Message extends Base
{
    public $table = parent::TABLE_PREFIX . 'messages';
    public function source()
    {
        return $this->morphTo();
    }
    public function campaign()
    {
        return $this->morphTo(Campaign::class);
    }
    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
    public function failure()
    {
        return $this->hasOne(MessageFailure::class, 'message_id');
    }
}