<?php

namespace App\Jobs\Services;

use App\Http\Payloads\CreateService;
use App\Models\Service;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Queue\Queueable;

class CreateNewService implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly CreateService $payload
    ) {}

    public function handle(DatabaseManager $database): void
    {
        $database->transaction(
            callback: fn () => Service::query()->create(
                attributes: $this->payload->toArray(),
            ),

            attempts: 3,
        );
    }
}
