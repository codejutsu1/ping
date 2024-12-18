<?php

namespace App\Http\Controllers\v1\Service;

use App\Http\Controllers\Controller;
use App\Http\Responses\V1\MessageResponse;
use App\Jobs\Services\DeleteService;
use App\Models\Service;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class DeleteController extends Controller
{
    public function __construct(
        protected Dispatcher $bus,
    ) {}

    public function __invoke(Service $service): MessageResponse
    {
        if (! Gate::allows('delete', $service)) {
            throw new UnauthorizedException(
                message: __('services.v1.delete.failure'),
                code: Response::HTTP_FORBIDDEN,
            );
        }

        $this->bus->dispatch(
            command: new DeleteService(
                $service
            ),
        );

        return new MessageResponse(
            message: __('services.v1.delete.success'),
            status: Response::HTTP_ACCEPTED,
        );
    }
}
