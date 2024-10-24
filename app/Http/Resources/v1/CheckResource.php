<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

class CheckResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
            'created_at' => new DateResource($this->created_at),
        ];
    }
}
