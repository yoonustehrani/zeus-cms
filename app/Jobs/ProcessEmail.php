<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;
use ZeusMailMarketer\Models\Message;
use ZeusMailMarketer\Models\MessageFailure;

class ProcessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $queue = 'zeus-mail-marketer-dispatch';
    public $tries = 3;
    public $maxExceptions = 2;
    public $retryAfter    = 10;
    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;
    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('Email is being sent ...');
    }

    public function failed(Throwable $e)
    {
        \Log::error("message #{$this->message->id} Failed.");
        $this->message->failure()->create((new MessageFailure())->toArray());
        \Log::error($e->__toString());
    }
}

// \App\Jobs\ProcessEmail::dispatchAfterResponse() // dispatches after user recieved data