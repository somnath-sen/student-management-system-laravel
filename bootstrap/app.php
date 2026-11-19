<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::get('/health-diagnostic', function () {
                $status = [
                    'timestamp' => now()->toISOString(),
                    'app_env' => config('app.env'),
                    'app_debug' => (bool) config('app.debug'),
                    'app_key_configured' => !empty(config('app.key')),
                    'db_default_connection' => config('database.default'),
                    'db_host' => config('database.connections.' . config('database.default') . '.host'),
                    'db_port' => config('database.connections.' . config('database.default') . '.port'),
                    'db_database' => config('database.connections.' . config('database.default') . '.database'),
                    'session_driver' => config('session.driver'),
                    'cache_store' => config('cache.default'),
                    'php_version' => PHP_VERSION,
                    'pdo_drivers_available' => \PDO::getAvailableDrivers(),
                    'db_status' => null,
                    'db_error' => null,
                    'sessions_table' => null,
                    'users_count' => null,
                ];

                try {
                    $pdo = DB::connection()->getPdo();
                    $status['db_status'] = 'connected';
                    $status['db_server_version'] = $pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);

                    try {
                        $count = DB::table('sessions')->count();
                        $status['sessions_table'] = 'ok (count: ' . $count . ')';
                    } catch (\Throwable $e) {
                        $status['sessions_table'] = 'missing or error: ' . $e->getMessage();
                    }

                    try {
                        $users = DB::table('users')->count();
                        $status['users_count'] = $users;
                    } catch (\Throwable $e) {
                        $status['users_count'] = 'error: ' . $e->getMessage();
                    }
                } catch (\Throwable $e) {
                    $status['db_status'] = 'connection_failed';
                    $status['db_error'] = get_class($e) . ': ' . $e->getMessage();
                }

                return response()->json($status);
            });
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\TrackUserActivity::class,
        ]);
        
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // Exempt Telegram webhook from CSRF (Telegram posts without session tokens)
        $middleware->validateCsrfTokens(except: [
            'telegram/webhook',
        ]);
    })


    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

