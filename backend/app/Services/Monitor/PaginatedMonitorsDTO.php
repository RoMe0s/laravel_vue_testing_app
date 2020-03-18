<?php

namespace App\Services\Monitor;

use Illuminate\Support\Collection;

class PaginatedMonitorsDTO
{
    public Collection $monitors;
    public int $page;
    public int $perPage;
    public int $total;

    public function __construct(Collection $monitors, int $page, int $perPage, int $total)
    {
        $this->monitors = $monitors;
        $this->page = $page;
        $this->perPage = $perPage;
        $this->total = $total;
    }
}
