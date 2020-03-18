<?php

namespace App\Services\Monitor;

use Spatie\UptimeMonitor\Models\Monitor;

class MonitorService
{
    public function getPaginated(int $page, int $perPage): PaginatedMonitorsDTO
    {
        $offset = $page > 1 ? ($page - 1) * $perPage : 0;
        $monitors = Monitor::offset($offset)->limit($perPage)->orderBy('created_at', 'desc')->get();
        $total = Monitor::count('id');

        return new PaginatedMonitorsDTO($monitors, $page, $perPage, $total);
    }

    public function create(string $url): Monitor
    {
        return Monitor::create([
            'url' => $url,
            'certificate_check_enabled' => true,
        ]);
    }
}
