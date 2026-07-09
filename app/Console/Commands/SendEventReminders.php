<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventReminderNotification;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('app:send-event-reminders')]
#[Description('Send event reminders to users')]
class SendEventReminders extends Command
{

    public function handle()
    {
       $events=Event::with('attendees.user')->whereBetween('start_time', [now(), now()->addDay()])->get();
       $eventsCount=$events->count();
        $eventLabel = Str::plural('event', $eventsCount);
       $this->info('Found '.$eventsCount.' '.$eventLabel.' starting within the next 24 hours.');
       foreach ($events as $event) {
           foreach ($event->attendees as $attendee) {
               $attendee->user->notify(new EventReminderNotification($event));
           }
       }

    }
}
