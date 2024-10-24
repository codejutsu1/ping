<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use TiMacDonald\JsonApi\Link;

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

    public function toLinks(Request $request): array
    {
        return [
            Link::self(route('v1:services:show', $this->resource)),
        ];
    }

    public function toRelationships(Request $request): array
    {
        return [
            'checks' => fn () => CheckResource::collection(
                $this->whenLoaded('checks')
            ),

        ];
    }
}
