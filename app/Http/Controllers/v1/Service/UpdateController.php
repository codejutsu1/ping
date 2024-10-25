<?php

namespace App\Http\Controllers\v1\Service;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ServiceResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\v1\Services\WriteRequest;

class UpdateController extends Controller
{
    public function __invoke(WriteRequest $request, Service $service): Response
    {
        $service->update(
            attributes: $request->payload()->toArray(),
        );

        return new JsonResponse(
            data: new ServiceResource(
                $service->refresh(),
            ),
            status: Response::HTTP_CREATED
        );
    }
}
