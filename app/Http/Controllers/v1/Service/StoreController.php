<?php

namespace App\Http\Controllers\v1\Service;

use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Jobs\Services\CreateNewService;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Http\Responses\V1\MessageResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\v1\Services\WriteRequest;
use Illuminate\Validation\UnauthorizedException;

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
