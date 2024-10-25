<?php

namespace App\Http\Controllers\v1\Service;

use App\Http\Requests\v1\Services\WriteRequest;
use App\Http\Responses\V1\MessageResponse;
use App\Jobs\Services\UpdateService;
use App\Models\Service;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

readonly class UpdateController
{
    public function __construct(
        private Dispatcher $bus,
    ) {}

    public function __invoke(WriteRequest $request, Service $service): MessageResponse
    {
        if (! Gate::allows('update', $service)) {
            throw new UnauthorizedException(
                message: 'You are not authorized to update a service that you do not own.',
                code: Response::HTTP_FORBIDDEN,
            );
        }

        $this->bus->dispatch(
            command: new UpdateService(
                payload: $request->payload(),
                service: $service,
            )
        );

        return new MessageResponse(
            message: 'We will update your service in the background',
            status: Response::HTTP_ACCEPTED,
        );
    }
}
