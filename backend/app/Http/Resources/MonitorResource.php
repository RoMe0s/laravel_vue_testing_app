<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\UptimeMonitor\Models\Monitor;

/**
 * @mixin Monitor
 */
class MonitorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => (string)$this->url,
            'last_checked_at' => $this->uptime_last_check_date
                ? $this->uptime_last_check_date->format('Y-m-d H:i:s')
                : null,
            'status' => $this->uptime_status,
            'certificate_status' => $this->certificate_status,
        ];
    }
}
