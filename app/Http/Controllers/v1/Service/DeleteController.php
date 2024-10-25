<?php

namespace App\Http\Controllers\v1\Service;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\V1\MessageResponse;
use App\Jobs\Services\DeleteService;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\UnauthorizedException;

class DeleteController extends Controller
{
    public function __construct(
        protected Dispatcher $bus,
    ) {}

    public function __invoke(Request $request, Service $service): MessageResponse
    {
        if (! Gate::allows('delete', $service)) {
            throw new UnauthorizedException(
                message: 'You are not authorized to delete a service that you do not own.',
                code: Response::HTTP_FORBIDDEN,
            );
        }

        $this->bus->dispatch(
            command: new DeleteService(
                $service
            ),
        );

        return new MessageResponse(
            message: "Your service will be deleted in the background.",
            status: Response::HTTP_ACCEPTED,
        );
    }
}
