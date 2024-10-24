<?php

namespace App\Jobs\Services;

use App\Models\Service;
use App\Http\Payloads\CreateService;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateNewService implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly CreateService $payload
    ) {}

    public function handle(DatabaseManager $database): void
    {
        $database->transaction(
            callback: fn() => Service::query()->create(
                attributes: $this->payload->toArray(),
            ),

            attempts: 3,
        );
    }
}
