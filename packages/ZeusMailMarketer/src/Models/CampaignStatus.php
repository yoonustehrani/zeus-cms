<?php

namespace ZeusMailMarketer\Models;

class CampaignStatus extends Base
{
    public $table = parent::TABLE_PREFIX . 'campaign_statuses';
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}