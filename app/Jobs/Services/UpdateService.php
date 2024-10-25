<?php

namespace App\Jobs\Services;

use App\Http\Payloads\CreateService;
use App\Models\Service;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Queue\Queueable;

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
            callback: fn () => $this->service->update(
                attributes: $this->payload->toArray(),
            ),
            attempts: 3,
        );
    }
}
