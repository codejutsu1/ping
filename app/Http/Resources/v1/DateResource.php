<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DateResource extends JsonResource
{
    /**
     * @property CarbonInterface $resource
     */
    public function toArray(Request $request): array
    {
        return [
            'human' => $this->diffForHumans(),
            'string' => $this->toIso8601String(),
            'local' => $this->toDateTimeLocalString(),
            'timestamp' => $this->timestamp,
        ];
    }
}
