<?php

trait HasDetails
{
    public function getDetailsAttribute($details)
    {
        return json_decode($details);
    }
    public function setDetailsAttribute($details)
    {
        $this->attributes['details'] = json_encode(json_decode($details));
    }
}