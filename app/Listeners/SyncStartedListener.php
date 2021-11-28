<?php

namespace App\Listeners;

use App\Events\SyncStartedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SyncStartedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SyncStartedEvent  $event
     * @return void
     */
    public function handle(SyncStartedEvent $event)
    {
        Log::info('Sync started.');
    }
}
