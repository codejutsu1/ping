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
                message: __('services.v1.update.failure'),
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
            message: __('services.v1.update.success'),
            status: Response::HTTP_ACCEPTED,
        );
    }
}
