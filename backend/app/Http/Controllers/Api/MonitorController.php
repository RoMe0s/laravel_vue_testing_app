<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Monitor\MonitorRequest;
use App\Http\Requests\Monitor\StoreMonitorRequest;
use App\Http\Resources\MonitorResource;
use App\Http\Resources\PaginatedMonitorsResource;
use App\Jobs\Monitor\CheckMonitorsJob;
use App\Services\Monitor\MonitorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\UptimeMonitor\Models\Monitor;

class MonitorController
{
    public function index(Request $request, MonitorService $monitorService): array
    {
        $paginated = $monitorService->getPaginated(
            $request->get('page', 1),
            $request->get('per_page', 10)
        );

        return PaginatedMonitorsResource::make($paginated)->toArray($request);
    }

    public function store(StoreMonitorRequest $request, MonitorService $monitorService): array
    {
        $monitor = $monitorService->create($request->url);
        return MonitorResource::make($monitor)->toArray($request);
    }

    public function destroy(Monitor $monitor): JsonResponse
    {
        $monitor->delete();
        return new JsonResponse();
    }

    public function check(MonitorRequest $request): JsonResponse
    {
        CheckMonitorsJob::dispatch($request->getDTO());
        return new JsonResponse();
    }
}
