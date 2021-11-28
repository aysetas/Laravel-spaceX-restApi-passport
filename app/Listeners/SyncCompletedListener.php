<?php

namespace App\Listeners;

use App\Events\SyncCompletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SyncCompletedListener
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
     * @param  \App\Events\SyncCompletedEvent  $event
     * @return void
     */
    public function handle(SyncCompletedEvent $event)
    {
        Log::info('Sync completed');
        Log::info(json_encode($event->capsule));
    }
}
