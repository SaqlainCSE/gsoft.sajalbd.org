<?php

namespace App\Providers\App\Listeners;

use App\Providers\App\Events\BranchPaymentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BranchPaymentCreatedNotification
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
     * @param  \App\Providers\App\Events\BranchPaymentCreated  $event
     * @return void
     */
    public function handle(BranchPaymentCreated $event)
    {
        //
    }
}
