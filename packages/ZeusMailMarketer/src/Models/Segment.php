<?php

namespace ZeusMailMarketer\Models;

class Segment extends Base
{
    public $table = parent::TABLE_PREFIX . 'segments';
    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, parent::TABLE_PREFIX . 'segment_subscriber');
    }
}