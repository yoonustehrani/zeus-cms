<?php

namespace ZeusMailMarketer\Models;

class Subscriber extends Base
{
    public $table = parent::TABLE_PREFIX . 'subscribers';
    public function email_lists()
    {
        return $this->belongsToMany(EmailList::class, parent::TABLE_PREFIX . 'email_list_subscriber')
                ->wherePivotNull('unsubscribed_at');
    }
    public function segments()
    {
        return $this->belongsToMany(Segment::class, parent::TABLE_PREFIX . 'segment_subscriber');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}