<?php

namespace App\Http\Responses\V1;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class MessageResponse
{
    public function __construct(
        private string $message,
        private int $status = Response::HTTP_OK,
    ) {}

    public function toResponse($request): Response
    {
        return new JsonResponse(
            data: [
                'message' => $this->message,
            ],
            status: $this->status
        );
    }
}
