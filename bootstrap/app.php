<?php

use App\Http\Middleware\AppAccessMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(append: [
            AppAccessMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (Exception $e) {
            $message = match (App::isProduction()) {
                true => 'Server error',
                default => $e->getMessage(),
            };
            $code = match (App::isProduction()) {
                true => Response::HTTP_INTERNAL_SERVER_ERROR,
                default => !empty((int) $e->getCode())
                    ? (int) $e->getCode()
                    : Response::HTTP_INTERNAL_SERVER_ERROR,
            };

            Log::channel('slack')->error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return new JsonResponse([
                'message' => $message,
                'code' => $code,
            ], $code);
        });
    })->create();
