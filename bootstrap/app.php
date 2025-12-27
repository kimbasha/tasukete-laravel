<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // データベースエラーのハンドリング
        $exceptions->render(function (\Illuminate\Database\QueryException $e) {
            \Illuminate\Support\Facades\Log::error('Database error: ' . $e->getMessage());

            return \Inertia\Inertia::render('Errors/ServerError', [
                'status' => 500,
                'message' => 'データベース接続エラーが発生しました',
            ])->toResponse(request())->setStatusCode(500);
        });

        // HTTPレスポンスのカスタマイズ
        $exceptions->respond(function (\Illuminate\Http\Response $response) {
            if ($response->status() === 404) {
                return \Inertia\Inertia::render('Errors/NotFound')
                    ->toResponse(request())
                    ->setStatusCode(404);
            }

            if ($response->status() === 500) {
                return \Inertia\Inertia::render('Errors/ServerError', [
                    'status' => 500,
                    'message' => 'サーバーエラーが発生しました',
                ])->toResponse(request())->setStatusCode(500);
            }

            if ($response->status() === 503) {
                return \Inertia\Inertia::render('Errors/ServerError', [
                    'status' => 503,
                    'message' => 'サービスが一時的に利用できません',
                ])->toResponse(request())->setStatusCode(503);
            }

            return $response;
        });
    })->create();
