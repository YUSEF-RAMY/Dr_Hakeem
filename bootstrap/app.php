<?php

use App\Exceptions\InvalidCredentialsException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Model not found / route not found -> 404
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return App\Http\ApiResponse::error('Resource not found.', [], 404);
            }
        });
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return App\Http\ApiResponse::error('Resource not found.', [], 404);
            }
        });

        // Unauthenticated -> 401
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return App\Http\ApiResponse::error('Unauthenticated.', [], 401);
            }
        });

        // Authorization -> 403
        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return App\Http\ApiResponse::error($e->getMessage() ?: 'This action is unauthorized.', [], 403);
            }
        });

        // Invalid login credentials -> 401
        $exceptions->render(function (InvalidCredentialsException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return App\Http\ApiResponse::error($e->getMessage(), [], 401);
            }
        });

        // Validation -> 422
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return App\Http\ApiResponse::error('The given data was invalid.', $e->errors(), 422);
            }
        });
    })->create();
