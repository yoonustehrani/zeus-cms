<?php

namespace ZeusMailMarketer\Models;


class EmailList extends Base
{
    public $table = parent::TABLE_PREFIX . 'email_lists';
    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, parent::TABLE_PREFIX . 'email_list_subscriber')
                ->wherePivotNull('unsubscribed_at');
    }
    public function unsubscribers()
    {
        return $this->belongsToMany(Subscriber::class, parent::TABLE_PREFIX . 'email_list_subscriber')
                ->wherePivotNotNull('unsubscribed_at');
    }
}