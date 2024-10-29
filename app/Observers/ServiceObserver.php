<?php

namespace App\Observers;

use PDO;
use App\Enums\CacheKey;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;

class ServiceObserver
{
    public function created(Service $service): void
    {
        $this->forgetServiceForUser(
            id: $service->user_id
        );
    }

    public function updated(Service $service): void
    {
        $this->forgetServiceForUser(
            id: $service->user_id
        );

        $this->forgetService(
            ulid: $service->id
        );
    }

    public function deleted(Service $service): void
    {
        $this->forgetServiceForUser(
            id: $service->user_id
        );
    }

    protected function forgetServiceForUser(string $id): void
    {
        Cache::forget(
            key: CacheKey::User_servies->value . '_' . $id,
        );
    }

    protected function forgetService(string $ulid): void
    {
        Cache::forget(
            key: CacheKey::Service->value . '_' . $ulid,
        );
    }
}
