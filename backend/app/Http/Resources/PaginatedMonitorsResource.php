<?php

namespace App\Http\Resources;

use App\Services\Monitor\PaginatedMonitorsDTO;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PaginatedMonitorsDTO
 */
class PaginatedMonitorsResource extends JsonResource
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
            'monitors' => MonitorResource::collection($this->monitors)->toArray($request),
            'page' => $this->page,
            'per_page' => $this->perPage,
            'total' => $this->total,
        ];
    }
}
