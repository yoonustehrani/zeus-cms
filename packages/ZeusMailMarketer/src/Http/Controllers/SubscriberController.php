<?php

namespace ZeusMailMarketer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZeusMailMarketer\Models\Subscriber;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $subscribers = Subscriber::withCount('messages')->get();
        return view('ZEMMV::pages.subscribers.index', compact('subscribers'));
    }
    public function show(Request $request, $subscriber)
    {
        $subscriber = Subscriber::whereEmail($subscriber)->withCount(['email_lists', 'messages'])->with('segments')->firstOrFail();
        $recent_messages = $subscriber->messages()->with('source.campaign')->orderBy('created_at', 'desc')->limit(5)->get();
        return $recent_messages;
        return view('ZEMMV::pages.subscribers.show', compact('subscriber', 'recent_messages'));
    }
}