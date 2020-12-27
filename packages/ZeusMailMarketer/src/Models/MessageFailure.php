<?php

namespace ZeusMailMarketer\Models;

class MessageFailure extends Base
{
    public $table = parent::TABLE_PREFIX . 'message_failures';
    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }
}