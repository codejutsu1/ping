<?php

namespace App\Http\Controllers\v1\Service;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ServiceResource;
use App\Models\Service;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends Controller
{
    public function __invoke()
    {
        // $services = Service::query()->simplePaginate(config('app.pagination.limit'));

        $services = QueryBuilder::for(Service::class)->allowedIncludes(['checks'])
            ->getEloquentBuilder()
            ->allowedFilters([
                'url'
            ])
            ->simplePaginate(config('app.pagination.limit'));

        return new JsonResponse(
            data: ServiceResource::collection(
                $services
            ),
        );
    }
}
