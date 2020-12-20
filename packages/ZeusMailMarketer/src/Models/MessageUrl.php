<?php

namespace ZeusMailMarketer\Models;

class MessageUrl extends Base
{
    public $table = parent::TABLE_PREFIX . 'message_urls';
    public function source()
    {
        return $this->morphTo();
    }
}