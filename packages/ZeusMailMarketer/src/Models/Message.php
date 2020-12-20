<?php

namespace ZeusMailMarketer\Models;

class Message extends Base
{
    public $table = parent::TABLE_PREFIX . 'messages';
    public function source()
    {
        return $this->morphTo();
    }
    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}