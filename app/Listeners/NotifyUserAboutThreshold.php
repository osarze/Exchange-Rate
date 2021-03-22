<?php

namespace App\Listeners;

use App\Events\UserCurrencyThresholdExceededEvent;
use App\Mail\UserCurrencyThresholdMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotifyUserAboutThreshold
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
     * @param  UserCurrencyThresholdExceeded  $event
     * @return void
     */
    public function handle(UserCurrencyThresholdExceededEvent $event)
    {
        try {
            Mail::send(new UserCurrencyThresholdMail($event->userCurrencyThreshold));
        }catch(\Exception $e){
            Log::error($e);
        }

    }
}
