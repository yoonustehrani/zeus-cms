<?php

namespace ZeusMailMarketer\Models;

class Template extends Base {
    public $table = parent::TABLE_PREFIX . 'templates';
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}