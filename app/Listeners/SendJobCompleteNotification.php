<?php

namespace App\Listeners;

use App\Events\JobComplete;
use App\Mail\JobCompleteMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendJobCompleteNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
//    public function __construct()
//    {
//        //
//    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\JobComplete  $event
     * @return void
     */
    public function handle(JobComplete $event)
    {
        Mail::to("vestnik700@gmail.com")->send(new JobCompleteMail($event->jobName));
    }
}
