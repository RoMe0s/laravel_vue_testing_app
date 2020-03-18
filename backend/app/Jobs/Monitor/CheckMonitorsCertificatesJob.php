<?php

namespace App\Jobs\Monitor;

use App\Events\Monitor\MonitorsCertificatesUpdatedEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\UptimeMonitor\Models\Monitor;
use Spatie\UptimeMonitor\MonitorRepository;

class CheckMonitorsCertificatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        MonitorRepository::getForCertificateCheck()->each(fn(Monitor $monitor) => $monitor->checkCertificate());

        MonitorsCertificatesUpdatedEvent::broadcast();
    }
}
