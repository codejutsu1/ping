<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

class ServiceResource extends JsonApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'url' => $this->url,
            'created_at' => new DateResource(
                $this->created_at
            ),
        ];
    }
}
