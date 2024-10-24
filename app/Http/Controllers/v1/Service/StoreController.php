<?php

namespace App\Http\Controllers\v1\Service;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\v1\ServiceResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\v1\Services\StoreRequest;
use App\Http\Responses\V1\MessageResponse;
use App\Jobs\Services\CreateNewService;
use GuzzleHttp\Psr7\Message;
use Illuminate\Contracts\Bus\Dispatcher;
use JustSteveKing\Tools\Http\Payload;

class StoreController extends Controller
{
    public function __construct(
        private readonly Dispatcher $bus,
    ) {}
    public function __invoke(StoreRequest $request): MessageResponse
    {
        $this->bus->dispatch(
            command: new CreateNewService(
                payload: $request->payload()
            ),
        );

        return new MessageResponse(
            message: 'Your service will be created in the background.',
            status: Response::HTTP_ACCEPTED,
        );

    }
}
