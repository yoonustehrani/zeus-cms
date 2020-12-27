<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserSubscribed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from('info@elnovel.net')
                ->subject('Welcome to our website')
                ->view('emails.subscribed');
                // ->withSwiftMessage(function ($message) {
                //     $message->getHeaders()->addTextHeader('Return-Path', 'bounces@elnovel.net');
                // });
    }
}
