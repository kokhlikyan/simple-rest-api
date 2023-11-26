<?php

namespace App\Listeners;

use App\Events\ChangeEmailEvent;
use App\Mail\ChangeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ChangeEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ChangeEmailEvent $event): void
    {
        Mail::to($event->email)->send(new ChangeEmail($event->email, $event->code));
    }
}
