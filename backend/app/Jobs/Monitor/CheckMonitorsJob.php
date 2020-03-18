<?php

namespace App\Jobs\Monitor;

use App\Events\Monitor\MonitorsUpdatedEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckMonitorsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var MonitorsCheckRequestDTO
     */
    private MonitorsCheckRequestDTO $requestDTO;

    /**
     * Create a new job instance.
     *
     * @param MonitorsCheckRequestDTO $requestDTO
     */
    public function __construct(MonitorsCheckRequestDTO $requestDTO)
    {
        $this->requestDTO = $requestDTO;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->requestDTO->checkUptime) {
            CheckMonitorsUptimeJob::dispatchNow();
        }
        if ($this->requestDTO->checkCertificates) {
            CheckMonitorsCertificatesJob::dispatchNow();
        }
        MonitorsUpdatedEvent::broadcast();
    }
}
