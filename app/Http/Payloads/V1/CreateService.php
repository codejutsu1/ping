<?php

namespace App\Http\Payloads;

class CreateService
{
    public function __construct(
        private string $name,
        private string $url,
        private string $user,
    ) {}

    /**
     * @return array{
     *    name:string,
     *    url:string,
     *    user_id:string
     * }
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'url' => $this->url,
            'user_id' => $this->user,
        ];
    }
}
