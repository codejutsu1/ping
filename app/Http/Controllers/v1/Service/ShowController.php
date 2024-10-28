<?php

namespace App\Http\Controllers\v1\Service;

use App\Enums\CacheKey;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\v1\ServiceResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\UnauthorizedException;

class ShowController extends Controller
{
    public function __invoke(Request $request, string $ulid)
    {
        Cache::forever(
            key: CacheKey::Service->value . '_' . $ulid,
            value: $service = Service::query()->findOrFail(id: $ulid),
        );
        

        if (! Gate::allows('view', $service)) {
            throw new UnauthorizedException(
                message: __('services.v1.show.failure'),
                code: Response::HTTP_FORBIDDEN,
            );
        }

        return new JsonResponse(
            data: new ServiceResource(
                resource: $service
            ),
        );
    }
}
