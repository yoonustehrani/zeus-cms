<?php

namespace ZeusMailMarketer\Models;

class Campaign extends Base
{
    public $table = parent::TABLE_PREFIX . 'campaigns';
    public function status()
    {
        return $this->belongsTo(CampaignStatus::class, 'status_id');
    }
    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }
    public function messages()
    {
        return $this->morphMany(Message::class, 'source');
    }
    public function opens()
    {
        return $this->messages()->whereNotNull('opened_at');
    }
    public function clicks()
    {
        return $this->messages()->whereNotNull('clicked_at');
    }
    public function urls()
    {
        return $this->morphMany(MessageUrl::class, 'source');
    }
}