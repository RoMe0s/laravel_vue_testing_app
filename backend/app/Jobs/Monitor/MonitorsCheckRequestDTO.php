<?php

namespace App\Jobs\Monitor;

class MonitorsCheckRequestDTO
{
    public bool $checkUptime;
    public bool $checkCertificates;

    public function __construct(bool $checkUptime, bool $checkCertificates)
    {
        $this->checkUptime = $checkUptime;
        $this->checkCertificates = $checkCertificates;
    }
}
