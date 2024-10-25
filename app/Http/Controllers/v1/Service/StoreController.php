<?php

namespace App\Http\Controllers\v1\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Services\WriteRequest;
use App\Http\Responses\V1\MessageResponse;
use App\Jobs\Services\CreateNewService;
use App\Models\Service;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{
    public function __construct(
        private readonly Dispatcher $bus,
    ) {}

    public function __invoke(WriteRequest $request): MessageResponse
    {
        if (! Gate::allows('create', Service::class)) {
            throw new UnauthorizedException(
                message: 'You must verify your email before creating a new service.',
                code: Response::HTTP_FORBIDDEN,
            );
        }

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
