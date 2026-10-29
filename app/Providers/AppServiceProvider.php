<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $connections = config('database.connections', []);

        config([
            'database.connections' => array_intersect_key($connections, [
                'mysql' => true,
                'mariadb' => true,
            ]),
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
