<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Carbon\Carbon;

class UpdateEventStatus extends Command
{
    protected $signature = 'events:update-status';
    protected $description = 'Update event status based on current time';

    public function handle()
    {
        $now = Carbon::now('Asia/Jakarta');
        
        // Update upcoming events to ongoing
        $upcomingEvents = Event::where('status', 'upcoming')->get();
        
        foreach ($upcomingEvents as $event) {
            $eventStart = Carbon::parse($event->event_date . ' ' . $event->start_time, 'Asia/Jakarta');
            $eventEnd = Carbon::parse($event->event_date . ' ' . $event->end_time, 'Asia/Jakarta');
            
            if ($now->gte($eventStart) && $now->lt($eventEnd)) {
                $event->update(['status' => 'ongoing']);
                $this->info("Event '{$event->title}' status updated to ongoing");
            }
        }
        
        // Update ongoing events to completed
        $ongoingEvents = Event::where('status', 'ongoing')->get();
        
        foreach ($ongoingEvents as $event) {
            $eventEnd = Carbon::parse($event->event_date . ' ' . $event->end_time, 'Asia/Jakarta');
            
            if ($now->gte($eventEnd)) {
                $event->update(['status' => 'completed']);
                $this->info("Event '{$event->title}' status updated to completed");
            }
        }
        
        $this->info('Event status update completed');
    }
}