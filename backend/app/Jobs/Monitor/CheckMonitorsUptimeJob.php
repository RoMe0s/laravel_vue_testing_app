<?php

namespace App\Jobs\Monitor;

use App\Events\Monitor\MonitorsUptimeUpdatedEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\UptimeMonitor\MonitorRepository;

class CheckMonitorsUptimeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        MonitorRepository::getForUptimeCheck()->checkUptime();

        MonitorsUptimeUpdatedEvent::broadcast();
    }
}
