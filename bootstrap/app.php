<?php

use Illuminate\Http\Request;
use App\Factories\ErrorFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Application;
use App\Http\Middleware\SunsetMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Treblle\SecurityHeaders\Http\Middleware\RemoveHeaders;
use Treblle\SecurityHeaders\Http\Middleware\PermissionsPolicy;
use Treblle\SecurityHeaders\Http\Middleware\SetReferrerPolicy;
use Treblle\SecurityHeaders\Http\Middleware\ContentTypeOptions;
use Treblle\SecurityHeaders\Http\Middleware\StrictTransportSecurity;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Treblle\SecurityHeaders\Http\Middleware\CertificateTransparencyPolicy;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
            RemoveHeaders::class,
            SetReferrerPolicy::class,
            StrictTransportSecurity::class,
            PermissionsPolicy::class,
            ContentTypeOptions::class,
            CertificateTransparencyPolicy::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'sunset' => SunsetMiddleware::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(
            fn (UnprocessableEntityHttpException $exception, Request $request) => new JsonResponse(
                data: $exception->getMessage(),
                status: 422,
            )
        );

        $exceptions->render(
            fn (Throwable $exception, Request $request) => ErrorFactory::create($exception, $request)
        );
    })->create();
