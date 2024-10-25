<?php

namespace App\Jobs\Services;

use App\Models\Service;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;

class DeleteService implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Service $service,
    )
    {
    }

    public function handle(DatabaseManager $database): void
    {
        $database->transaction(
            callback: fn() => $this->service->delete(),
            attempts: 3,
        );
    }
}
