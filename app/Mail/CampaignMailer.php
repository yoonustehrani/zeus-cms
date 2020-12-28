<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignMailer extends Mailable
{
    use Queueable, SerializesModels;
    public $content;
    public $subject;
    public $custom_from;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content, $subject, $custom_from = null)
    {
        $this->custom_from = $custom_from ?: config('mail.from');
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->custom_from[0], $this->custom_from[1])
                    ->subject($this->subject)
                    ->html($this->content);
    }
}
