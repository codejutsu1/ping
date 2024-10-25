<?php

namespace App\Jobs\Services;

use App\Models\Service;
use App\Http\Payloads\CreateService;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;

class UpdateService implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly CreateService $payload,
        private readonly Service $service,
    ) {}

    public function handle(DatabaseManager $database): void
    {
        $database->transaction(
            callback: fn() => $this->service->update(
                attributes: $this->payload->toArray(),
            ),
            attempts: 3,
        );
    }
}
