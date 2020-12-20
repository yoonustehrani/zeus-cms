<?php

namespace ZeusMailMarketer\Http\Controllers;

use App\Http\Controllers\Controller;
use ZeusMailMarketer\Models\Subscriber;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::withCount('messages')->all();
    }
}