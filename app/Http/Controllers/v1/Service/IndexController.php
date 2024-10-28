<?php

namespace App\Http\Controllers\v1\Service;

use App\Enums\CacheKey;
use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\v1\ServiceResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends Controller
{
    public function __invoke()
    {
        // $services = Service::query()->simplePaginate(config('app.pagination.limit'));
        Cache::forever(
            key: CacheKey::User_servies->value . '_' . Auth::id(),
            value: $cachedServices = Service::where('user_id', Auth::id())->get(),
        );

        $services = QueryBuilder::for(
            subject: $cachedServices,
        )->allowedIncludes(['checks'])
            ->getEloquentBuilder()
            ->allowedFilters([
                'url',
            ])
            ->simplePaginate(config('app.pagination.limit'));

        return new JsonResponse(
            data: ServiceResource::collection(
                $services
            ),
        );
    }
}
